<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <flux:heading size="xl">
                    Barber Approval Management
                </flux:heading>

                <flux:text class="mt-1">
                    Review, approve, or reject barber applications in the
                    system.
                </flux:text>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4">
                    <flux:badge color="emerald" class="px-4 py-2">
                        {{ session('status') }} SSD
                    </flux:badge>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4">
                    <flux:badge color="red" class="px-4 py-2">
                        {{ session('error') }}
                    </flux:badge>
                </div>
            @endif

            <!-- Pending Approvals -->
            <flux:card class="rounded-3xl p-6 shadow-sm space-y-4">
                <div>
                    <flux:heading size="lg">
                        Pending Barber Applications
                        <flux:badge color="amber" class="ml-2">
                            {{ $pendingBarbers->count() }}
                        </flux:badge>
                    </flux:heading>

                    <flux:text class="mt-1">
                        Review and approve new barber registrations.
                    </flux:text>
                </div>

                @if ($pendingBarbers->isEmpty())
                    <flux:text class="text-zinc-500">
                        No pending barber applications.
                    </flux:text>

                @else
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>Name</flux:table.column>
                            <flux:table.column>Email</flux:table.column>
                            <flux:table.column>Applied</flux:table.column>
                            <flux:table.column>Actions</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            @foreach ($pendingBarbers as $barber)
                                <flux:table.row>
                                    <flux:table.cell>
                                        <flux:text class="font-semibold">
                                            {{ $barber->name }}
                                        </flux:text>
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ $barber->email }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ $barber->created_at->format('M d, Y g:i A') }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        <div class="flex gap-3">
                                            <form
                                                method="POST"
                                                action="{{ route('admin.barbers.approve', $barber) }}"
                                            >
                                                @csrf
                                                @method ('PATCH')

                                                <flux:button
                                                    size="sm"
                                                    variant="primary"
                                                    type="submit"
                                                >
                                                    Approve
                                                </flux:button>
                                            </form>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.barbers.reject', $barber) }}"
                                                onsubmit="
                                                    return confirm(
                                                        'Are you sure?',
                                                    );
                                                "
                                            >
                                                @csrf
                                                @method ('DELETE')

                                                <flux:button
                                                    size="sm"
                                                    variant="filled"
                                                    type="submit"
                                                >
                                                    Reject
                                                </flux:button>
                                            </form>
                                        </div>
                                    </flux:table.cell>
                                </flux:table.row>

                            @endforeach
                        </flux:table.rows>
                    </flux:table>

                @endif
            </flux:card>

            <!-- Approved Barbers -->
            <flux:card class="rounded-3xl p-6 shadow-sm space-y-4">
                <div>
                    <flux:heading size="lg">
                        Approved Barbers
                        <flux:badge color="emerald" class="ml-2">
                            {{ $approvedBarbers->count() }}
                        </flux:badge>
                    </flux:heading>

                    <flux:text class="mt-1">
                        All approved barbers in the system.
                    </flux:text>
                </div>

                @if ($approvedBarbers->isEmpty())
                    <flux:text class="text-zinc-500">
                        No approved barbers yet.
                    </flux:text>

                @else
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>Name</flux:table.column>
                            <flux:table.column>Email</flux:table.column>
                            <flux:table.column>Joined</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            @foreach ($approvedBarbers as $barber)
                                <flux:table.row>
                                    <flux:table.cell>
                                        <flux:text class="font-semibold">
                                            {{ $barber->name }}
                                        </flux:text>
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ $barber->email }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ $barber->created_at->format('M d, Y') }}
                                    </flux:table.cell>
                                </flux:table.row>

                            @endforeach
                        </flux:table.rows>
                    </flux:table>

                @endif
            </flux:card>
        </div>
    </div>
</x-app-layout>
