<x-layouts::auth.simple :title="__('Buat organisasi')">
    <div class="space-y-6">
        <div class="space-y-2 text-center">
            <flux:heading size="xl">Mulai workspace LacakKerja</flux:heading>
            <flux:subheading>Siapkan organisasi pertama untuk mengelola pelanggan, teknisi, dan work order.</flux:subheading>
        </div>

        <form method="POST" action="{{ route('onboarding.organization.store') }}" class="space-y-5">
            @csrf
            <flux:input name="name" :label="__('Nama organisasi')" placeholder="Contoh: Prima Teknik Sejahtera" value="{{ old('name') }}" required autofocus />

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="timezone" class="mb-2 block text-sm font-medium text-foreground">Zona waktu</label>
                    <select id="timezone" name="timezone" required class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        @foreach (['Asia/Jakarta' => 'WIB · Asia/Jakarta', 'Asia/Makassar' => 'WITA · Asia/Makassar', 'Asia/Jayapura' => 'WIT · Asia/Jayapura'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('timezone', 'Asia/Jakarta') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('timezone') <flux:error>{{ $message }}</flux:error> @enderror
                </div>
                <div>
                    <label for="currency" class="mb-2 block text-sm font-medium text-foreground">Mata uang</label>
                    <select id="currency" name="currency" required class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30">
                        <option value="IDR" @selected(old('currency', 'IDR') === 'IDR')>IDR · Rupiah</option>
                        <option value="USD" @selected(old('currency') === 'USD')>USD · Dollar</option>
                    </select>
                    @error('currency') <flux:error>{{ $message }}</flux:error> @enderror
                </div>
            </div>

            @error('name') <flux:error>{{ $message }}</flux:error> @enderror

            <flux:button variant="primary" type="submit" class="w-full">Buat organisasi</flux:button>
        </form>

        <p class="text-center text-xs text-muted-foreground">Kamu dapat mengundang anggota dan mengatur role setelah workspace dibuat.</p>
    </div>
</x-layouts::auth.simple>
