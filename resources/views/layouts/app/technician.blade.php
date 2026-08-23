<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-background text-foreground antialiased">
        <header class="sticky top-0 z-10 border-b border-border bg-surface/95 backdrop-blur">
            <div class="mx-auto flex min-h-16 max-w-2xl items-center gap-3 px-4 sm:px-6">
                <x-app-logo href="{{ route('dashboard') }}" wire:navigate />
                <div class="ms-auto flex items-center gap-2">
                    <x-lk-sync-badge status="synced" data-sync-badge aria-live="polite" />
                    <flux:tooltip :content="__('Notifikasi')" position="bottom">
                        <button type="button" aria-label="{{ __('Notifikasi') }}" class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-control text-on-surface-variant transition hover:bg-surface-subtle hover:text-on-surface">
                            <flux:icon.bell class="size-5" />
                        </button>
                    </flux:tooltip>
                    <flux:dropdown position="bottom" align="end">
                        <button type="button" aria-label="{{ __('Buka menu akun') }}" class="inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-full transition hover:bg-surface-subtle">
                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />
                        </button>
                        <flux:menu>
                            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Akun & pengaturan') }}</flux:menu.item>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">{{ __('Keluar') }}</flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                </div>
            </div>
        </header>

        <main id="main-content" class="mx-auto min-h-[calc(100dvh-8rem)] max-w-2xl px-4 pb-28 pt-6 sm:px-6">
            {{ $slot }}
        </main>

        <nav aria-label="{{ __('Navigasi teknisi') }}" class="fixed inset-x-0 bottom-0 z-20 border-t border-border bg-surface/95 backdrop-blur lk-safe-bottom">
            <div class="mx-auto grid max-w-2xl grid-cols-4 gap-1 px-3 pt-2">
                <a href="{{ route('technician.today') }}" aria-current="{{ request()->routeIs('technician.today') ? 'page' : 'false' }}" class="flex min-h-12 cursor-pointer flex-col items-center justify-center gap-1 rounded-control px-2 text-xs font-semibold transition {{ request()->routeIs('technician.today') ? 'bg-accent-soft text-accent' : 'text-muted-foreground hover:bg-surface-subtle hover:text-on-surface' }}" wire:navigate>
                    <flux:icon.calendar class="size-5" />
                    <span>{{ __('Hari Ini') }}</span>
                </a>
                <a href="{{ route('technician.tasks') }}" aria-current="{{ request()->routeIs('technician.tasks') ? 'page' : 'false' }}" class="flex min-h-12 cursor-pointer flex-col items-center justify-center gap-1 rounded-control px-2 text-xs font-medium transition {{ request()->routeIs('technician.tasks') ? 'bg-accent-soft text-accent' : 'text-muted-foreground hover:bg-surface-subtle hover:text-on-surface' }}" wire:navigate>
                    <flux:icon.clipboard-document-list class="size-5" />
                    <span>{{ __('Tugas') }}</span>
                </a>
                <a href="{{ route('technician.sync.center') }}" aria-current="{{ request()->routeIs('technician.sync.*') ? 'page' : 'false' }}" class="flex min-h-12 cursor-pointer flex-col items-center justify-center gap-1 rounded-control px-2 text-xs font-medium transition {{ request()->routeIs('technician.sync.*') ? 'bg-accent-soft text-accent' : 'text-muted-foreground hover:bg-surface-subtle hover:text-on-surface' }}" wire:navigate>
                    <flux:icon.cloud-arrow-up class="size-5" />
                    <span>{{ __('Sinkronisasi') }}</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex min-h-12 cursor-pointer flex-col items-center justify-center gap-1 rounded-control px-2 text-xs font-medium text-muted-foreground transition hover:bg-surface-subtle hover:text-on-surface">
                    <flux:icon.user class="size-5" />
                    <span>{{ __('Akun') }}</span>
                </a>
            </div>
        </nav>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>