<x-layouts::app.sidebar :title="__('Pengaturan organisasi')">
    <flux:main>
        <div class="mx-auto w-full max-w-3xl space-y-8 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <flux:heading size="xl">Pengaturan organisasi</flux:heading>
                    <flux:subheading>Kelola identitas workspace dan preferensi regional.</flux:subheading>
                </div>
                <flux:button href="{{ route('organization.members') }}" variant="outline" icon="users" wire:navigate>Kelola anggota</flux:button>
            </div>

            @if (session('status'))
                <div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('organization.settings.update') }}" class="lk-card space-y-6 p-5 sm:p-6">
                @csrf
                @method('PUT')
                <flux:input name="name" :label="__('Nama organisasi')" value="{{ old('name', $organization->name) }}" required />
                <flux:input name="slug" :label="__('Slug')" value="{{ old('slug', $organization->slug) }}" required />

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="timezone" class="mb-2 block text-sm font-medium text-foreground">Zona waktu</label>
                        <select id="timezone" name="timezone" required class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                            @foreach (timezone_identifiers_list() as $timezone)
                                <option value="{{ $timezone }}" @selected(old('timezone', $organization->timezone) === $timezone)>{{ $timezone }}</option>
                            @endforeach
                        </select>
                        @error('timezone') <flux:error>{{ $message }}</flux:error> @enderror
                    </div>
                    <div>
                        <label for="currency" class="mb-2 block text-sm font-medium text-foreground">Mata uang</label>
                        <select id="currency" name="currency" required class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                            @foreach (['IDR' => 'IDR · Rupiah', 'USD' => 'USD · Dollar', 'SGD' => 'SGD · Dollar Singapura'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('currency', $organization->currency) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('currency') <flux:error>{{ $message }}</flux:error> @enderror
                    </div>
                </div>

                @error('name') <flux:error>{{ $message }}</flux:error> @enderror
                @error('slug') <flux:error>{{ $message }}</flux:error> @enderror

                <div class="flex justify-end">
                    <flux:button variant="primary" type="submit">Simpan perubahan</flux:button>
                </div>
            </form>
        </div>
    </flux:main>
</x-layouts::app.sidebar>
