<x-layouts::auth.card :title="__('Undangan LacakKerja')">
    @if (! $invitation)
        <div class="space-y-4 text-center">
            <flux:icon.x-circle class="mx-auto size-10 text-warning" />
            <flux:heading size="lg">Undangan tidak ditemukan</flux:heading>
            <flux:subheading>Link mungkin salah atau sudah tidak tersedia.</flux:subheading>
            <flux:button href="{{ route('home') }}" variant="outline" class="w-full">Kembali ke beranda</flux:button>
        </div>
    @elseif (! $invitation->isPending())
        <div class="space-y-4 text-center">
            <flux:icon.clock class="mx-auto size-10 text-warning" />
            <flux:heading size="lg">Undangan sudah tidak aktif</flux:heading>
            <flux:subheading>Undangan untuk {{ $invitation->organization->name }} sudah digunakan, ditolak, atau kedaluwarsa.</flux:subheading>
        </div>
    @else
        <div class="space-y-6">
            <div class="space-y-2 text-center">
                <flux:icon.building-office-2 class="mx-auto size-10 text-accent" />
                <flux:heading size="xl">Gabung ke {{ $invitation->organization->name }}</flux:heading>
                <flux:subheading>{{ $invitation->email }} diundang sebagai {{ $invitation->role->label() }}.</flux:subheading>
            </div>

            @auth
                <p class="rounded-control bg-info-soft p-3 text-center text-sm text-info-content">Masuk sebagai <strong>{{ auth()->user()->email }}</strong>.</p>
                <div class="grid gap-3 sm:grid-cols-2">
                    <form method="POST" action="{{ route('invitations.accept', $token) }}">@csrf<flux:button type="submit" variant="primary" class="w-full">Terima undangan</flux:button></form>
                    <form method="POST" action="{{ route('invitations.decline', $token) }}">@csrf<flux:button type="submit" variant="outline" class="w-full">Tolak</flux:button></form>
                </div>
            @else
                <div class="space-y-3">
                    <flux:button href="{{ route('login', ['intended' => request()->fullUrl()]) }}" variant="primary" class="w-full">Masuk untuk menerima</flux:button>
                    <flux:button href="{{ route('register', ['intended' => request()->fullUrl()]) }}" variant="outline" class="w-full">Buat akun baru</flux:button>
                </div>
            @endauth
        </div>
    @endif
</x-layouts::auth.card>
