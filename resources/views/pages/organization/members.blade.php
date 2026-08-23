<x-layouts::app.sidebar :title="__('Anggota organisasi')">
    <flux:main>
        <div class="mx-auto w-full max-w-6xl space-y-8 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <flux:heading size="xl">Anggota organisasi</flux:heading>
                    <flux:subheading>{{ $organization->name }} · atur akses untuk tim operasional.</flux:subheading>
                </div>
                <flux:button href="{{ route('organization.settings') }}" variant="outline" icon="cog-6-tooth" wire:navigate>Pengaturan organisasi</flux:button>
            </div>

            @if (session('status'))
                <div class="lk-card border-success/30 bg-success-soft p-4 text-sm text-success-content">{{ session('status') }}</div>
            @endif

            @if (session('invitation_url'))
                <div class="lk-card border-info/30 bg-info-soft p-4">
                    <p class="text-sm font-semibold text-info-content">Link undangan siap dibagikan</p>
                    <div class="mt-3 flex flex-col gap-2 sm:flex-row">
                        <input readonly value="{{ session('invitation_url') }}" class="min-w-0 flex-1 rounded-control border border-border bg-surface px-3 py-2 text-sm text-foreground" />
                        <flux:button type="button" variant="outline" x-data x-on:click="navigator.clipboard.writeText($el.previousElementSibling.value)" icon="clipboard-document-list">Salin link</flux:button>
                    </div>
                    <p class="mt-2 text-xs text-info-content/80">Berlaku selama 7 hari. Untuk produksi, link ini nantinya dikirim melalui email notification.</p>
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem]">
                <section class="lk-card overflow-hidden">
                    <div class="border-b border-border px-5 py-4 sm:px-6">
                        <flux:heading size="lg">Daftar anggota</flux:heading>
                    </div>
                    <div class="divide-y divide-border">
                        @forelse ($memberships as $membership)
                            <div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                                <div class="flex min-w-0 items-center gap-3">
                                    <flux:avatar :name="$membership->user->name" :initials="$membership->user->initials()" />
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-foreground">{{ $membership->user->name }}</p>
                                        <p class="truncate text-xs text-muted-foreground">{{ $membership->user->email }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                                    <x-lk-status-badge :status="$membership->status->value" />
                                    <form method="POST" action="{{ route('organization.members.update', $membership) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label class="sr-only" for="role-{{ $membership->id }}">Role {{ $membership->user->name }}</label>
                                        <select id="role-{{ $membership->id }}" name="role" class="h-9 rounded-control border border-border bg-surface px-2 text-xs text-foreground">
                                            @foreach (\App\Enums\OrganizationRole::cases() as $role)
                                                <option value="{{ $role->value }}" @selected($membership->role === $role)>{{ $role->label() }}</option>
                                            @endforeach
                                        </select>
                                        <label class="sr-only" for="status-{{ $membership->id }}">Status {{ $membership->user->name }}</label>
                                        <select id="status-{{ $membership->id }}" name="status" class="h-9 rounded-control border border-border bg-surface px-2 text-xs text-foreground">
                                            @foreach (\App\Enums\MembershipStatus::cases() as $status)
                                                <option value="{{ $status->value }}" @selected($membership->status === $status)>{{ $status->label() }}</option>
                                            @endforeach
                                        </select>
                                        <flux:button type="submit" size="sm" variant="outline">Simpan</flux:button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-8"><x-lk-empty-state icon="users" title="Belum ada anggota" description="Undang tim pertama untuk mulai bekerja bersama." /></div>
                        @endforelse
                    </div>
                    @if ($memberships->hasPages())
                        <div class="border-t border-border px-5 py-4 sm:px-6">{{ $memberships->links() }}</div>
                    @endif
                </section>

                <aside class="space-y-6">
                    <section class="lk-card p-5 sm:p-6">
                        <flux:heading size="lg">Undang anggota</flux:heading>
                        <flux:subheading class="mt-1">Berikan akses sesuai tanggung jawabnya.</flux:subheading>
                        <form method="POST" action="{{ route('organization.invitations.store') }}" class="mt-5 space-y-4">
                            @csrf
                            <flux:input name="email" type="email" :label="__('Email anggota')" placeholder="nama@perusahaan.com" value="{{ old('email') }}" required />
                            <div>
                                <label for="invite-role" class="mb-2 block text-sm font-medium text-foreground">Role awal</label>
                                <select id="invite-role" name="role" class="h-10 w-full rounded-control border border-border bg-surface px-3 text-sm text-foreground">
                                    @foreach ([\App\Enums\OrganizationRole::Admin, \App\Enums\OrganizationRole::Dispatcher, \App\Enums\OrganizationRole::Technician] as $role)
                                        <option value="{{ $role->value }}" @selected(old('role', 'technician') === $role->value)>{{ $role->label() }}</option>
                                    @endforeach
                                </select>
                                @error('role') <flux:error>{{ $message }}</flux:error> @enderror
                            </div>
                            @error('email') <flux:error>{{ $message }}</flux:error> @enderror
                            <flux:button variant="primary" type="submit" icon="paper-airplane" class="w-full">Buat undangan</flux:button>
                        </form>
                    </section>

                    <section class="lk-card p-5 sm:p-6">
                        <flux:heading size="lg">Undangan aktif</flux:heading>
                        <div class="mt-4 space-y-3">
                            @forelse ($invitations as $invitation)
                                <div class="rounded-control border border-border bg-background p-3">
                                    <p class="truncate text-sm font-medium text-foreground">{{ $invitation->email }}</p>
                                    <p class="mt-1 text-xs text-muted-foreground">{{ $invitation->role->label() }} · berakhir {{ $invitation->expires_at->format('d M Y') }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-muted-foreground">Tidak ada undangan aktif.</p>
                            @endforelse
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </flux:main>
</x-layouts::app.sidebar>

