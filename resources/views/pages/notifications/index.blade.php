<x-layouts::app.sidebar :title="__('Notifikasi')">
    <flux:main class="min-h-full bg-background px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-5xl space-y-6">
            <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-medium text-accent">Notification center</p>
                    <flux:heading size="xl" class="mt-1">Notifikasi</flux:heading>
                    <p class="mt-2 max-w-2xl text-sm text-muted-foreground">Perubahan pekerjaan, SLA, invoice, dan akses organisasi yang perlu kamu ketahui.</p>
                </div>
                @if($unreadCount > 0)
                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        <flux:button type="submit" variant="outline" icon="check-circle" class="min-h-11">Tandai semua dibaca</flux:button>
                    </form>
                @endif
            </header>

            <nav class="flex flex-wrap items-center gap-2" aria-label="Filter notifikasi">
                <a href="{{ route('notifications.index') }}" class="inline-flex min-h-11 items-center rounded-control px-3 text-sm font-semibold transition {{ ! $unreadOnly ? 'bg-accent text-white' : 'border border-border text-foreground hover:bg-surface-subtle' }}">Semua</a>
                <a href="{{ route('notifications.index', ['unread' => 1]) }}" class="inline-flex min-h-11 items-center gap-2 rounded-control px-3 text-sm font-semibold transition {{ $unreadOnly ? 'bg-accent text-white' : 'border border-border text-foreground hover:bg-surface-subtle' }}">Belum dibaca @if($unreadCount > 0)<span class="rounded-full bg-white/20 px-2 py-0.5 text-xs">{{ $unreadCount }}</span>@endif</a>
                <a href="{{ route('notifications.preferences.edit') }}" class="ms-auto inline-flex min-h-11 items-center gap-2 text-sm font-semibold text-accent hover:underline"><flux:icon.cog-6-tooth class="size-4" />Preferensi</a>
            </nav>

            <section class="lk-panel overflow-hidden" aria-labelledby="notifications-list-title">
                <h2 id="notifications-list-title" class="sr-only">Daftar notifikasi</h2>
                @forelse($notifications as $notification)
                    @php($data = $notification->data)
                    @php($isUnread = $notification->read_at === null)
                    @php($severity = $data['severity'] ?? 'info')
                    <article class="flex flex-col gap-4 border-b border-border px-5 py-5 last:border-b-0 sm:flex-row sm:items-start sm:justify-between sm:px-6 {{ $isUnread ? 'bg-accent-soft/30' : 'bg-surface' }}">
                        <div class="flex min-w-0 items-start gap-3">
                            <span class="mt-0.5 inline-flex size-9 shrink-0 items-center justify-center rounded-full {{ $severity === 'danger' ? 'bg-danger-soft text-danger' : ($severity === 'warning' ? 'bg-warning-soft text-warning' : ($severity === 'success' ? 'bg-success-soft text-success' : 'bg-accent-soft text-accent')) }}" aria-hidden="true">
                                <flux:icon.bell class="size-4" />
                            </span>
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-semibold text-foreground">{{ $data['title'] ?? 'Notifikasi' }}</h3>
                                    @if($isUnread)<span class="rounded-full bg-accent px-2 py-0.5 text-[11px] font-semibold text-white">Baru</span>@endif
                                </div>
                                <p class="mt-1 text-sm leading-6 text-muted-foreground">{{ $data['body'] ?? '' }}</p>
                                <p class="mt-2 text-xs text-muted-foreground">{{ $data['event_label'] ?? 'Aktivitas' }} · {{ $notification->created_at?->locale('id')->isoFormat('D MMM YYYY HH:mm') }}</p>
                            </div>
                        </div>
                        <div class="flex shrink-0 items-center gap-2 sm:pt-1">
                            @if(!empty($data['route']))<a href="{{ $data['route'] }}" class="inline-flex min-h-11 items-center rounded-control border border-border px-3 text-sm font-semibold text-foreground transition hover:bg-surface-subtle">Buka detail</a>@endif
                            @if($isUnread)
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex min-h-11 items-center rounded-control px-3 text-sm font-semibold text-accent transition hover:bg-accent-soft">Tandai dibaca</button>
                                </form>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="px-6 py-14 text-center"><x-lk-empty-state icon="bell" title="Belum ada notifikasi" description="Perubahan penting akan muncul di sini setelah aktivitas operasional berjalan." /></div>
                @endforelse
            </section>

            @if($notifications->hasPages())
                <div>{{ $notifications->links() }}</div>
            @endif
        </div>
    </flux:main>
</x-layouts::app.sidebar>