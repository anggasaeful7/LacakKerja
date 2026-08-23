<x-layouts::app.sidebar :title="__('Preferensi notifikasi')">
    <flux:main class="min-h-full bg-background px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl space-y-6">
            <header>
                <p class="text-sm font-medium text-accent">Pengaturan akun</p>
                <flux:heading size="xl" class="mt-1">Preferensi notifikasi</flux:heading>
                <p class="mt-2 max-w-2xl text-sm text-muted-foreground">Pilih channel yang aktif untuk setiap jenis perubahan di {{ $organization->name }}.</p>
            </header>

            <form method="POST" action="{{ route('notifications.preferences.update') }}" class="space-y-5">
                @csrf
                @method('PUT')
                <section class="lk-panel overflow-hidden" aria-labelledby="preference-title">
                    <div class="border-b border-border px-5 py-5 sm:px-6"><h2 id="preference-title" class="font-semibold text-foreground">Channel per event</h2><p class="mt-1 text-sm text-muted-foreground">Notifikasi in-app selalu tersimpan di center. Email diproses lewat queue.</p></div>
                    <div class="divide-y divide-border">
                        @foreach($preferences as $preference)
                            @php($event = $preference->event)
                            <div class="grid gap-4 px-5 py-5 sm:grid-cols-[minmax(0,1fr)_auto_auto] sm:items-center sm:px-6">
                                <div><p class="font-medium text-foreground">{{ $event->label() }}</p><p class="mt-1 text-sm text-muted-foreground">{{ str($event->value)->replace('.', ' · ')->replace('_', ' ')->ucfirst() }}</p></div>
                                <label class="flex min-h-11 items-center gap-2 text-sm text-foreground"><input type="checkbox" name="preferences[{{ $event->value }}][in_app]" value="1" @checked($preference->in_app) class="size-5 rounded border-border text-accent focus:ring-ring/40">In-app</label>
                                <label class="flex min-h-11 items-center gap-2 text-sm text-foreground"><input type="checkbox" name="preferences[{{ $event->value }}][email]" value="1" @checked($preference->email) class="size-5 rounded border-border text-accent focus:ring-ring/40">Email</label>
                            </div>
                        @endforeach
                    </div>
                </section>
                <div class="flex flex-wrap justify-end gap-3"><a href="{{ route('notifications.index') }}" class="inline-flex min-h-11 items-center rounded-control border border-border px-4 text-sm font-semibold text-foreground">Batal</a><flux:button type="submit" variant="primary" icon="check">Simpan preferensi</flux:button></div>
            </form>
        </div>
    </flux:main>
</x-layouts::app.sidebar>