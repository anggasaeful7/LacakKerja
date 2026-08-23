<?php

namespace App\Http\Controllers;

use App\Enums\ChecklistInputType;
use App\Enums\ChecklistStatus;
use App\Models\ChecklistTemplate;
use App\Models\Organization;
use App\Models\Service;
use App\Services\CurrentOrganization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ChecklistTemplateController extends Controller
{
    public function index(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('viewAny', [ChecklistTemplate::class, $organization]);
        $search = trim((string) $request->string('q'));
        $query = ChecklistTemplate::query()->forOrganization($organization)->with('service')->withCount('items');
        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('template_key', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }
        $templates = $query->orderBy('name')->orderByDesc('version')->paginate(15)->withQueryString();

        return view('pages.checklists.index', compact('templates', 'organization', 'search'));
    }

    public function create(Request $request): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [ChecklistTemplate::class, $organization]);

        return view('pages.checklists.form', [
            'template' => new ChecklistTemplate(['status' => ChecklistStatus::Draft]),
            'services' => Service::query()->forOrganization($organization)->where('is_active', true)->orderBy('name')->get(),
            'organization' => $organization,
            'items' => collect(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [ChecklistTemplate::class, $organization]);
        $validated = $this->validated($request);
        $service = $this->resolveService($organization, $validated['service_id'] ?? null);
        $template = DB::transaction(function () use ($organization, $validated, $service): ChecklistTemplate {
            $template = $organization->checklistTemplates()->create([
                'service_id' => $service?->id,
                'template_key' => $validated['template_key'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'version' => 1,
                'status' => ChecklistStatus::Draft,
                'is_current' => true,
            ]);
            $this->syncItems($template, $validated['items'] ?? []);

            return $template;
        });

        return redirect()->route('checklists.show', $template)->with('status', 'Checklist template berhasil dibuat sebagai draft.');
    }

    public function show(Request $request, ChecklistTemplate $template): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('view', $template);
        abort_unless($template->organization_id === $organization->id, 404);
        $template->load(['service', 'items']);

        return view('pages.checklists.show', compact('template', 'organization'));
    }

    public function edit(Request $request, ChecklistTemplate $template): View
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $template);
        abort_unless($template->organization_id === $organization->id, 404);
        abort_if($template->status === ChecklistStatus::Published, 422, 'Buat versi baru untuk mengubah checklist yang sudah dipublish.');
        $template->load('items');

        return view('pages.checklists.form', [
            'template' => $template,
            'services' => Service::query()->forOrganization($organization)->orderBy('name')->get(),
            'organization' => $organization,
            'items' => $template->items,
        ]);
    }

    public function update(Request $request, ChecklistTemplate $template): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $template);
        abort_unless($template->organization_id === $organization->id, 404);
        abort_if($template->status === ChecklistStatus::Published, 422, 'Buat versi baru untuk mengubah checklist yang sudah dipublish.');
        $validated = $this->validated($request);
        $service = $this->resolveService($organization, $validated['service_id'] ?? null);
        DB::transaction(function () use ($template, $validated, $service): void {
            $template->update([
                'service_id' => $service?->id,
                'template_key' => $validated['template_key'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);
            $this->syncItems($template, $validated['items'] ?? []);
        });

        return redirect()->route('checklists.show', $template)->with('status', 'Draft checklist berhasil diperbarui.');
    }

    public function newVersion(Request $request, ChecklistTemplate $template): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('create', [ChecklistTemplate::class, $organization]);
        abort_unless($template->organization_id === $organization->id, 404);
        $template->load(['items', 'service']);
        $version = ((int) ChecklistTemplate::query()->forOrganization($organization)->where('template_key', $template->template_key)->max('version')) + 1;

        $newTemplate = DB::transaction(function () use ($organization, $template, $version): ChecklistTemplate {
            $newTemplate = $organization->checklistTemplates()->create([
                'service_id' => $template->service_id,
                'template_key' => $template->template_key,
                'name' => $template->name,
                'description' => $template->description,
                'version' => $version,
                'status' => ChecklistStatus::Draft,
                'is_current' => false,
            ]);
            $this->syncItems($newTemplate, $template->snapshotPayload());

            return $newTemplate;
        });

        return redirect()->route('checklists.edit', $newTemplate)->with('status', "Versi {$version} dibuat sebagai draft.");
    }

    public function publish(Request $request, ChecklistTemplate $template): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('update', $template);
        abort_unless($template->organization_id === $organization->id, 404);
        abort_if($template->status === ChecklistStatus::Published, 422, 'Checklist ini sudah dipublish.');

        DB::transaction(function () use ($organization, $template): void {
            ChecklistTemplate::query()->forOrganization($organization)
                ->where('template_key', $template->template_key)
                ->where('id', '!=', $template->id)
                ->update(['is_current' => false]);
            $template->load('items');
            $template->publishSnapshot();
        });

        return redirect()->route('checklists.show', $template)->with('status', 'Checklist dipublish dan snapshot versi tersimpan.');
    }

    public function destroy(Request $request, ChecklistTemplate $template): RedirectResponse
    {
        $organization = app(CurrentOrganization::class)->require($request->user());
        Gate::forUser($request->user())->authorize('delete', $template);
        abort_unless($template->organization_id === $organization->id, 404);
        $template->delete();

        return redirect()->route('checklists.index')->with('status', 'Checklist diarsipkan.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        return $request->validate([
            'service_id' => ['nullable', 'integer'],
            'template_key' => ['required', 'string', 'max:64', 'regex:/^[A-Za-z0-9._-]+$/'],
            'name' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:5000'],
            'items' => ['nullable', 'array', 'max:100'],
            'items.*.label' => ['required', 'string', 'max:240'],
            'items.*.input_type' => ['required', Rule::enum(ChecklistInputType::class)],
            'items.*.is_required' => ['nullable', 'boolean'],
            'items.*.photo_required' => ['nullable', 'boolean'],
            'items.*.options' => ['nullable', 'string', 'max:2000'],
            'items.*.help_text' => ['nullable', 'string', 'max:500'],
        ]);
    }

    private function resolveService(Organization $organization, mixed $serviceId): ?Service
    {
        return $serviceId ? Service::query()->forOrganization($organization)->whereKey((int) $serviceId)->firstOrFail() : null;
    }

    /** @param array<int, array<string, mixed>> $items */
    private function syncItems(ChecklistTemplate $template, array $items): void
    {
        $template->items()->delete();
        foreach (array_values($items) as $index => $item) {
            $options = $item['options'] ?? null;
            if (is_string($options)) {
                $options = preg_split('/[\r\n,]+/', $options, -1, PREG_SPLIT_NO_EMPTY) ?: [];
            }
            $template->items()->create([
                'position' => $index + 1,
                'label' => $item['label'],
                'input_type' => $item['input_type'],
                'is_required' => (bool) ($item['is_required'] ?? false),
                'photo_required' => (bool) ($item['photo_required'] ?? false),
                'options' => is_array($options) ? array_values(array_filter(array_map('trim', $options))) : null,
                'help_text' => $item['help_text'] ?? null,
            ]);
        }
    }
}
