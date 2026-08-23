<?php

namespace App\Services;

use App\Enums\ChecklistInputType;
use App\Enums\WorkOrderNoteVisibility;
use App\Models\Organization;
use App\Models\SyncOperation;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderChecklistItem;
use App\Models\WorkOrderNote;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TechnicianSyncService
{
    public const MAX_BATCH_SIZE = 50;

    /**
     * @param  array<int, array<string, mixed>>  $operations
     * @return array{results: array<int, array<string, mixed>>, counts: array{synced: int, conflict: int, failed: int}}
     */
    public function synchronize(Organization $organization, User $user, array $operations): array
    {
        $results = [];

        foreach ($operations as $operation) {
            $results[] = $this->processOperation($organization, $user, $operation);
        }

        $counts = [
            'synced' => count(array_filter($results, fn (array $result): bool => $result['state'] === 'synced')),
            'conflict' => count(array_filter($results, fn (array $result): bool => $result['state'] === 'conflict')),
            'failed' => count(array_filter($results, fn (array $result): bool => $result['state'] === 'failed')),
        ];

        return compact('results', 'counts');
    }

    /**
     * @param  array<string, mixed>  $operation
     * @return array<string, mixed>
     */
    private function processOperation(Organization $organization, User $user, array $operation): array
    {
        $clientOperationId = (string) ($operation['client_operation_id'] ?? Str::uuid());
        $type = (string) ($operation['type'] ?? '');
        $workOrderId = (int) ($operation['work_order_id'] ?? 0);
        $baseVersion = (int) ($operation['base_version'] ?? 0);
        $payload = is_array($operation['payload'] ?? null) ? $operation['payload'] : [];
        $payloadHash = hash('sha256', json_encode($operation, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $existing = SyncOperation::query()
            ->forOrganization($organization)
            ->where('user_id', $user->id)
            ->where('client_operation_id', $clientOperationId)
            ->first();

        if ($existing !== null) {
            if (! hash_equals($existing->payload_hash, $payloadHash)) {
                return [
                    'client_operation_id' => $clientOperationId,
                    'state' => 'failed',
                    'code' => 'idempotency_mismatch',
                    'message' => 'ID operasi sudah pernah dipakai dengan payload berbeda.',
                ];
            }

            return $existing->response ?? [
                'client_operation_id' => $clientOperationId,
                'state' => $existing->state,
                'message' => 'Operasi sudah diproses sebelumnya.',
            ];
        }

        return DB::transaction(function () use ($organization, $user, $clientOperationId, $type, $workOrderId, $baseVersion, $payload, $payloadHash): array {
            $existing = SyncOperation::query()
                ->forOrganization($organization)
                ->where('user_id', $user->id)
                ->where('client_operation_id', $clientOperationId)
                ->lockForUpdate()
                ->first();

            if ($existing !== null) {
                if (! hash_equals($existing->payload_hash, $payloadHash)) {
                    return [
                        'client_operation_id' => $clientOperationId,
                        'state' => 'failed',
                        'code' => 'idempotency_mismatch',
                        'message' => 'ID operasi sudah pernah dipakai dengan payload berbeda.',
                    ];
                }

                return $existing->response ?? [
                    'client_operation_id' => $clientOperationId,
                    'state' => $existing->state,
                    'message' => 'Operasi sudah diproses sebelumnya.',
                ];
            }

            $workOrder = $this->assignedWorkOrder($organization, $user, $workOrderId);
            if ($workOrder === null) {
                return $this->persistResult(
                    $organization,
                    $user,
                    $clientOperationId,
                    $type,
                    $workOrderId,
                    $baseVersion,
                    $payloadHash,
                    $payload,
                    [
                        'client_operation_id' => $clientOperationId,
                        'state' => 'failed',
                        'code' => 'not_found',
                        'message' => 'Pekerjaan tidak ditemukan atau bukan tugas teknisi ini.',
                    ],
                );
            }

            if ($baseVersion !== $workOrder->lock_version) {
                return $this->persistResult(
                    $organization,
                    $user,
                    $clientOperationId,
                    $type,
                    $workOrderId,
                    $baseVersion,
                    $payloadHash,
                    $payload,
                    [
                        'client_operation_id' => $clientOperationId,
                        'state' => 'conflict',
                        'code' => 'version_conflict',
                        'message' => 'Pekerjaan berubah di server. Pilih apakah perubahan lokal akan dicoba lagi.',
                        'work_order_id' => $workOrder->id,
                        'server_version' => $workOrder->lock_version,
                        'server' => $this->workOrderPayload($workOrder),
                    ],
                );
            }

            try {
                $result = match ($type) {
                    'checklist.update' => $this->applyChecklist($workOrder, $user, $payload),
                    'note.create' => $this->applyNote($workOrder, $user, $payload),
                    default => throw ValidationException::withMessages(['type' => 'Jenis operasi offline tidak didukung.']),
                };
            } catch (AuthorizationException) {
                $result = [
                    'state' => 'failed',
                    'code' => 'forbidden',
                    'message' => 'Kamu tidak memiliki izin untuk mengubah pekerjaan ini.',
                ];
            } catch (ValidationException $exception) {
                $result = [
                    'state' => 'failed',
                    'code' => 'validation',
                    'message' => $exception->validator->errors()->first() ?: 'Data operasi tidak valid.',
                ];
            }

            return $this->persistResult(
                $organization,
                $user,
                $clientOperationId,
                $type,
                $workOrderId,
                $baseVersion,
                $payloadHash,
                $payload,
                array_merge($result, [
                    'client_operation_id' => $clientOperationId,
                    'work_order_id' => $workOrder->id,
                    'server_version' => $workOrder->lock_version,
                ]),
            );
        });
    }

    private function assignedWorkOrder(Organization $organization, User $user, int $workOrderId): ?WorkOrder
    {
        if ($workOrderId < 1) {
            return null;
        }

        return WorkOrder::query()
            ->forOrganization($organization)
            ->whereKey($workOrderId)
            ->whereHas('assignments', fn (Builder $assignment): Builder => $assignment->where('user_id', $user->id))
            ->with(['organization', 'customer', 'site', 'checklistItems', 'notes.author'])
            ->lockForUpdate()
            ->first();
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array{state: string, entity: array<string, mixed>}
     */
    private function applyChecklist(WorkOrder $workOrder, User $user, array $payload): array
    {
        Gate::forUser($user)->authorize('updateChecklist', $workOrder);

        $itemId = (int) ($payload['item_id'] ?? 0);
        $item = $workOrder->checklistItems->first(fn (WorkOrderChecklistItem $candidate): bool => $candidate->id === $itemId);
        if ($item === null) {
            throw ValidationException::withMessages(['item_id' => 'Item checklist tidak ditemukan pada pekerjaan ini.']);
        }

        $rules = match ($item->input_type) {
            ChecklistInputType::Checkbox => ['value' => ['nullable', 'boolean']],
            ChecklistInputType::Number => ['value' => ['nullable', 'numeric', 'max:999999999']],
            ChecklistInputType::Choice => ['value' => ['nullable', 'string', Rule::in($item->options ?? [])]],
            ChecklistInputType::Text => ['value' => ['nullable', 'string', 'max:5000']],
        };
        $validated = Validator::make($payload, $rules)->validate();
        $rawValue = $validated['value'] ?? null;
        $value = match ($item->input_type) {
            ChecklistInputType::Checkbox => filter_var($rawValue, FILTER_VALIDATE_BOOLEAN) ? true : null,
            default => filled($rawValue) ? $rawValue : null,
        };

        $item->update([
            'value' => $value === null ? null : ['value' => $value],
            'completed_by' => $value === null ? null : $user->id,
            'completed_at' => $value === null ? null : now(),
        ]);
        $this->bumpVersion($workOrder);

        return [
            'state' => 'synced',
            'entity' => [
                'type' => 'checklist',
                'id' => $item->id,
                'value' => $value,
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array{state: string, entity: array<string, mixed>}
     */
    private function applyNote(WorkOrder $workOrder, User $user, array $payload): array
    {
        Gate::forUser($user)->authorize('addNote', $workOrder);
        $validated = Validator::make($payload, [
            'body' => ['required', 'string', 'max:10000'],
            'visibility' => ['required', Rule::enum(WorkOrderNoteVisibility::class)],
        ])->validate();

        $note = $workOrder->notes()->create([
            'user_id' => $user->id,
            'visibility' => $validated['visibility'],
            'body' => $validated['body'],
        ]);
        $this->bumpVersion($workOrder);

        return [
            'state' => 'synced',
            'entity' => [
                'type' => 'note',
                'id' => $note->id,
                'body' => $note->body,
            ],
        ];
    }

    private function bumpVersion(WorkOrder $workOrder): void
    {
        $workOrder->forceFill(['lock_version' => $workOrder->lock_version + 1])->save();
    }

    /**
     * @param  array<string, mixed>  $payload
     * @param  array<string, mixed>  $response
     * @return array<string, mixed>
     */
    private function persistResult(Organization $organization, User $user, string $clientOperationId, string $type, int $workOrderId, int $baseVersion, string $payloadHash, array $payload, array $response): array
    {
        SyncOperation::create([
            'organization_id' => $organization->id,
            'user_id' => $user->id,
            'client_operation_id' => $clientOperationId,
            'type' => $type,
            'work_order_id' => $workOrderId > 0 ? $workOrderId : null,
            'base_version' => $baseVersion,
            'payload_hash' => $payloadHash,
            'payload' => $payload,
            'state' => $response['state'],
            'response' => $response,
            'processed_at' => now(),
        ]);

        return $response;
    }

    /** @return array<string, mixed> */
    public function workOrderPayload(WorkOrder $workOrder): array
    {
        $workOrder->loadMissing(['customer', 'site', 'checklistItems', 'notes.author']);

        return [
            'id' => $workOrder->id,
            'number' => $workOrder->number,
            'title' => $workOrder->title,
            'status' => $workOrder->status->value,
            'priority' => $workOrder->priority->value,
            'lock_version' => $workOrder->lock_version,
            'scheduled_start' => $workOrder->scheduled_start?->toIso8601String(),
            'scheduled_end' => $workOrder->scheduled_end?->toIso8601String(),
            'customer' => ['name' => $workOrder->customer->name],
            'site' => [
                'name' => $workOrder->site->name,
                'address' => $workOrder->site->fullAddress(),
                'phone' => $workOrder->site->contact_phone,
                'latitude' => $workOrder->site->latitude,
                'longitude' => $workOrder->site->longitude,
            ],
            'checklist_items' => $workOrder->checklistItems->map(fn (WorkOrderChecklistItem $item): array => [
                'id' => $item->id,
                'label' => $item->label,
                'input_type' => $item->input_type->value,
                'is_required' => $item->is_required,
                'photo_required' => $item->photo_required,
                'options' => $item->options ?? [],
                'value' => data_get($item->value, 'value'),
            ])->values()->all(),
            'notes' => $workOrder->notes->take(5)->map(fn (WorkOrderNote $note): array => [
                'id' => $note->id,
                'body' => $note->body,
                'visibility' => $note->visibility->value,
                'author' => $note->author?->name,
                'created_at' => $note->created_at->toIso8601String(),
            ])->values()->all(),
        ];
    }
}
