<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <flux:heading size="xl"> User management </flux:heading>

                <flux:text class="mt-1">
                    Review every account in the system and keep customer,
                    barber, and admin access organized.
                </flux:text>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
                <flux:card class="rounded-2xl p-5 shadow-sm">
                    <flux:text>Total users</flux:text>
                    <flux:heading
                        size="xl"
                        class="mt-2"
                        >{{ $totalUsers }}</flux:heading
                    >
                </flux:card>

                <flux:card class="rounded-2xl p-5 shadow-sm">
                    <flux:text>Admins</flux:text>
                    <flux:heading
                        size="xl"
                        class="mt-2"
                        >{{ $adminUsers }}</flux:heading
                    >
                </flux:card>

                <flux:card class="rounded-2xl p-5 shadow-sm">
                    <flux:text>Barbers</flux:text>
                    <flux:heading
                        size="xl"
                        class="mt-2"
                        >{{ $barberUsers }}</flux:heading
                    >
                </flux:card>

                <flux:card class="rounded-2xl p-5 shadow-sm">
                    <flux:text>Customers</flux:text>
                    <flux:heading
                        size="xl"
                        class="mt-2"
                        >{{ $customerUsers }}</flux:heading
                    >
                </flux:card>

                <flux:card class="rounded-2xl p-5 shadow-sm">
                    <flux:text>Approved barbers</flux:text>
                    <flux:heading
                        size="xl"
                        class="mt-2"
                        >{{ $approvedBarbers }}</flux:heading
                    >
                </flux:card>

                <flux:card class="rounded-2xl p-5 shadow-sm">
                    <flux:text>Pending barbers</flux:text>
                    <flux:heading
                        size="xl"
                        class="mt-2"
                        >{{ $pendingBarbers }}</flux:heading
                    >
                </flux:card>
            </div>

            <flux:card class="rounded-3xl p-6 shadow-sm space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <flux:heading size="lg">All users</flux:heading>
                        <flux:text class="mt-1 text-zinc-500">
                            Current role and approval status for each account.
                        </flux:text>
                    </div>
                </div>

                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Name</flux:table.column>
                        <flux:table.column>Email</flux:table.column>
                        <flux:table.column>Role</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column>Joined</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse ($users as $user)
                            <flux:table.row>
                                <flux:table.cell>
                                    <div
                                        class="font-medium text-zinc-900 dark:text-zinc-100"
                                    >
                                        {{ $user->name }}
                                    </div>
                                </flux:table.cell>

                                <flux:table.cell>
                                    {{ $user->email }}
                                </flux:table.cell>

                                <flux:table.cell>
                                    <span
                                        class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium uppercase tracking-[0.18em] text-zinc-600 dark:text-zinc-300"
                                    >
                                        {{ $user->role }}
                                    </span>
                                </flux:table.cell>

                                <flux:table.cell>
                                    @if ($user->role === 'barber')
                                        <span
                                            class="rounded-full px-3 py-1 text-xs font-medium {{ $user->is_approved ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300' : 'bg-amber-500/10 text-amber-600 dark:text-amber-300' }}"
                                        >
                                            {{ $user->is_approved ? 'Approved' : 'Pending approval' }}
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full px-3 py-1 text-xs font-medium bg-slate-500/10 text-slate-600 dark:text-slate-300"
                                        >
                                            Active
                                        </span>
                                    @endif
                                </flux:table.cell>

                                <flux:table.cell>
                                    {{ $user->created_at->format('M d, Y') }}
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="5">
                                    <flux:text
                                        class="text-center text-zinc-500"
                                    >
                                        No users found.
                                    </flux:text>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>
    </div>
</x-app-layout>
