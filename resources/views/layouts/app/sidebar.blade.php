<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen overflow-x-hidden bg-background text-foreground antialiased">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-white/10 bg-primary text-white">
            <flux:sidebar.header class="border-b border-white/10 px-4 py-4">
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            @php
                $sidebarOrganization = request()->attributes->get('currentOrganization') ?? app(\App\Services\CurrentOrganization::class)->resolve(auth()->user());
                $sidebarMemberships = auth()->user()->activeMemberships()->with('organization')->get();
            @endphp
            @if ($sidebarMemberships->isNotEmpty())
                <div class="border-b border-white/10 px-3 py-3">
                    <flux:dropdown position="bottom" align="start" class="w-full">
                        <button type="button" class="flex min-h-11 w-full items-center gap-3 rounded-control px-3 text-start transition hover:bg-white/10" aria-label="{{ __('Ganti organisasi') }}">
                            <span class="flex size-8 shrink-0 items-center justify-center rounded-control bg-accent text-white"><flux:icon.building-office-2 class="size-4" /></span>
                            <span class="min-w-0 flex-1">
                                <span class="block truncate text-sm font-semibold text-white">{{ $sidebarOrganization?->name ?? 'Pilih organisasi' }}</span>
                                <span class="block truncate text-xs text-white/60">{{ $sidebarOrganization?->slug ?? 'Belum dipilih' }}</span>
                            </span>
                            <flux:icon.chevrons-up-down class="size-4 shrink-0 text-white/60" />
                        </button>
                        <flux:menu class="min-w-64">
                            @foreach ($sidebarMemberships as $sidebarMembership)
                                <form method="POST" action="{{ route('organization.switch') }}">
                                    @csrf
                                    <input type="hidden" name="organization_id" value="{{ $sidebarMembership->organization_id }}" />
                                    <flux:menu.item as="button" type="submit" class="w-full" :icon="$sidebarMembership->organization_id === $sidebarOrganization?->id ? 'check' : 'building-office-2'">
                                        <span class="flex min-w-0 flex-col"><span class="truncate">{{ $sidebarMembership->organization->name }}</span><span class="text-xs text-muted-foreground">{{ $sidebarMembership->role->label() }}</span></span>
                                    </flux:menu.item>
                                </form>
                            @endforeach
                        </flux:menu>
                    </flux:dropdown>
                </div>
            @endif

            <flux:sidebar.nav class="px-3 py-4">
                <flux:sidebar.group :heading="__('Operasional')" class="grid gap-1">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="calendar-days" :href="route('dispatch.index')" :current="request()->routeIs('dispatch.*')" wire:navigate>
                        {{ __('Dispatch Board') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="clipboard-document-list" :href="route('work-orders.index')" :current="request()->routeIs('work-orders.*')" wire:navigate>
                        {{ __('Work Orders') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Data')" class="mt-6 grid gap-1">
                    <flux:sidebar.item icon="users" :href="route('customers.index')" :current="request()->routeIs('customers.*')" wire:navigate>
                        {{ __('Pelanggan') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="users" :href="route('organization.members')" :current="request()->routeIs('organization.members')" wire:navigate>
                        {{ __('Anggota tim') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="wrench-screwdriver" :href="route('assets.index')" :current="request()->routeIs('assets.*', 'services.*')" wire:navigate>
                        {{ __('Aset & Layanan') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Keuangan & Insight')" class="mt-6 grid gap-1">
                    @if ($sidebarOrganization && (auth()->user()->membershipFor($sidebarOrganization)?->role->canManageMasterData() ?? false))
                        <flux:sidebar.item icon="banknotes" :href="route('invoices.index')" :current="request()->routeIs('invoices.*')" wire:navigate>
                            {{ __('Invoice') }}
                        </flux:sidebar.item>
                    @else
                        <flux:sidebar.item icon="banknotes" href="#" aria-disabled="true" class="pointer-events-none opacity-60">
                            {{ __('Invoice') }}
                            <span class="ms-auto text-[10px] uppercase tracking-wider text-white/50">Restricted</span>
                        </flux:sidebar.item>
                    @endif
                    @if ($sidebarOrganization && (auth()->user()->membershipFor($sidebarOrganization)?->role->canManageMasterData() ?? false))
                        <flux:sidebar.item icon="chart-bar" :href="route('reports.operations')" :current="request()->routeIs('reports.*')" wire:navigate>
                            {{ __('Laporan') }}
                        </flux:sidebar.item>
                    @else
                        <flux:sidebar.item icon="chart-bar" href="#" aria-disabled="true" class="pointer-events-none opacity-60">
                            {{ __('Laporan') }}
                            <span class="ms-auto text-[10px] uppercase tracking-wider text-white/50">Restricted</span>
                        </flux:sidebar.item>
                    @endif
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav class="px-3 pb-4">
                <flux:sidebar.item icon="cog-6-tooth" href="{{ route('profile.edit') }}" wire:navigate>
                    {{ __('Pengaturan akun') }}
                </flux:sidebar.item>
                @if ($sidebarOrganization)
                    <flux:sidebar.item icon="building-office-2" :href="route('organization.settings')" :current="request()->routeIs('organization.settings')" wire:navigate>
                        {{ __('Pengaturan organisasi') }}
                    </flux:sidebar.item>                    @if (auth()->user()->membershipFor($sidebarOrganization)?->role->canManageOrganization() ?? false)
                        <flux:sidebar.item icon="shield-check" :href="route('audit.index')" :current="request()->routeIs('audit.*')" wire:navigate>
                            {{ __('Audit log') }}
                        </flux:sidebar.item>
                    @endif
                @endif
                <flux:sidebar.item icon="question-mark-circle" href="#" aria-disabled="true" class="pointer-events-none opacity-60">
                    {{ __('Bantuan') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block border-t border-white/10" :name="auth()->user()->name" />
        </flux:sidebar>

        <flux:header class="border-b border-border bg-surface px-4 sm:px-6">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <x-app-logo class="lg:hidden" href="{{ route('dashboard') }}" wire:navigate />

            <div class="hidden min-w-0 flex-1 lg:flex">
                <label for="global-search" class="sr-only">{{ __('Cari work order, teknisi, atau pelanggan') }}</label>
                <div class="relative w-full max-w-xl">
                    <flux:icon.magnifying-glass class="pointer-events-none absolute start-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                    <input id="global-search" type="search" placeholder="{{ __('Cari work order, teknisi, atau pelanggan') }}" class="h-10 w-full rounded-control border border-border bg-background ps-10 pe-4 text-sm text-foreground placeholder:text-muted-foreground transition focus:border-ring focus:outline-none focus:ring-2 focus:ring-ring/30" />
                </div>
            </div>

            <flux:spacer />

            <div class="flex items-center gap-2 sm:gap-3">
                <x-lk-sync-badge status="synced" class="hidden sm:inline-flex" />
                @php
                    $notificationOrganization = $sidebarOrganization;
                    $unreadNotificationCount = $notificationOrganization
                        ? auth()->user()->notifications()->whereNull('read_at')->whereJsonContains('data->organization_id', $notificationOrganization->id)->count()
                        : 0;
                @endphp
                <flux:tooltip :content="__('Notifikasi')" position="bottom">
                    <a href="{{ route('notifications.index') }}" aria-label="{{ __('Notifikasi') }}{{ $unreadNotificationCount > 0 ? ' · '.$unreadNotificationCount.' belum dibaca' : '' }}" class="relative inline-flex min-h-11 min-w-11 cursor-pointer items-center justify-center rounded-control text-muted-foreground transition hover:bg-surface-subtle hover:text-foreground" wire:navigate>
                        <flux:icon.bell class="size-5" />
                        @if($unreadNotificationCount > 0)<span class="absolute end-2 top-2 inline-flex min-w-4 items-center justify-center rounded-full bg-danger px-1 text-[10px] font-bold leading-4 text-white ring-2 ring-surface" aria-hidden="true">{{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}</span>@endif
                    </a>
                </flux:tooltip>

                <flux:dropdown position="bottom" align="end">
                    <button type="button" aria-label="{{ __('Buka menu pengguna') }}" class="inline-flex min-h-11 items-center gap-2 rounded-control px-1.5 text-start transition hover:bg-surface-subtle">
                        <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />
                        <span class="hidden max-w-32 truncate text-sm font-medium text-foreground sm:block">{{ auth()->user()->name }}</span>
                        <flux:icon.chevron-down class="hidden size-4 text-muted-foreground sm:block" />
                    </button>

                    <flux:menu>
                        <div class="px-3 py-2">
                            <p class="truncate text-sm font-semibold text-foreground">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-muted-foreground">{{ auth()->user()->email }}</p>
                        </div>
                        <flux:menu.separator />
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Pengaturan akun') }}
                        </flux:menu.item>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">
                                {{ __('Keluar') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>





