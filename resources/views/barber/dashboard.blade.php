<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <flux:heading size="xl"> Barber Dashboard </flux:heading>

                <flux:text class="mt-1">
                    Review pending appointment requests and manage your
                    schedule.
                </flux:text>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <flux:badge color="emerald" class="px-4 py-2">
                    {{ session('status') }}
                </flux:badge>
            @endif

            @if (session('error'))
                <flux:badge color="red" class="px-4 py-2">
                    {{ session('error') }}
                </flux:badge>
            @endif

            <!-- Stats -->
            <flux:card class="rounded-3xl p-6 shadow-sm">
                <flux:text>Confirmed appointments</flux:text>

                <flux:heading size="xl" class="mt-2">
                    {{ $appointments->count() }}
                </flux:heading>
            </flux:card>

            <!-- Calendar -->
            <flux:card class="rounded-3xl p-6 shadow-sm space-y-6">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <flux:heading size="lg">
                            Confirmed appointment calendar
                        </flux:heading>

                        <flux:text class="mt-1">
                            Calendar view of your confirmed bookings
                        </flux:text>
                    </div>

                    <flux:badge variant="subtle"> Month view </flux:badge>
                </div>

                <div class="overflow-hidden rounded-3xl">
                    <livewire:appointment-calendar
                        :day-click-enabled="false"
                        :event-click-enabled="false"
                        :drag-and-drop-enabled="false"
                    />
                </div>
            </flux:card>

            <!-- Pending Appointments -->
            <flux:card class="rounded-3xl p-6 shadow-sm space-y-6">
                <div class="flex items-center justify-between gap-3">
                    <flux:heading size="lg">
                        Pending appointments
                    </flux:heading>

                    <flux:badge rounded color="amber">
                        {{ $appointments->where('status', 'pending')->count() }} Pending
                    </flux:badge>
                </div>

                <flux:table>
                    <!-- Columns -->
                    <flux:table.columns>
                        <flux:table.column>Customer</flux:table.column>
                        <flux:table.column>Service</flux:table.column>
                        <flux:table.column>Schedule</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column>Notes</flux:table.column>
                        <flux:table.column>Action</flux:table.column>
                    </flux:table.columns>

                    <!-- Rows -->
                    <flux:table.rows>
                        @forelse ($appointments as $appointment)
                            <flux:table.row>
                                <!-- Customer -->
                                <flux:table.cell>
                                    <flux:text class="font-semibold">
                                        {{ $appointment->customer->name }}
                                    </flux:text>
                                </flux:table.cell>

                                <!-- Service -->
                                <flux:table.cell>
                                    {{ $appointment->service->name }}
                                </flux:table.cell>

                                <!-- Schedule -->
                                <flux:table.cell>
                                    {{ $appointment->scheduled_at->format('M d, Y g:i A') }}
                                </flux:table.cell>

                                <!-- Status -->
                                <flux:table.cell>
                                    @if ($appointment->status === 'pending')
                                        <flux:badge color="amber" size="sm"
                                            >Pending</flux:badge
                                        >

                                    @elseif ($appointment->status === 'confirmed')
                                        <flux:badge color="emerald" size="sm"
                                            >Confirmed</flux:badge
                                        >

                                    @elseif ($appointment->status === 'cancelled')
                                        <flux:badge color="red" size="sm"
                                            >Cancelled</flux:badge
                                        >
                                    @endif
                                </flux:table.cell>

                                <!-- Notes -->
                                <flux:table.cell>
                                    <flux:text class="text-sm text-zinc-400">
                                        {{ $appointment->notes ?? '—' }}
                                    </flux:text>
                                </flux:table.cell>

                                <!-- Action -->
                                <flux:table.cell>
                                    @if ($appointment->status === 'pending')
                                        <div class="flex gap-2">
                                            <form
                                                action="{{ route('appointments.accept', $appointment) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                <flux:button
                                                    type="submit"
                                                    size="sm"
                                                    variant="primary"
                                                >
                                                    Confirm
                                                </flux:button>
                                            </form>

                                            <form
                                                action="{{ route('appointments.decline', $appointment) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                <flux:button
                                                    type="submit"
                                                    size="sm"
                                                    variant="filled"
                                                >
                                                    Cancel
                                                </flux:button>
                                            </form>
                                        </div>

                                    @else
                                        <flux:text
                                            class="text-sm text-zinc-400"
                                        >
                                            No actions available
                                        </flux:text>
                                    @endif
                                </flux:table.cell>
                            </flux:table.row>

                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="6">
                                    <flux:text
                                        class="text-center text-zinc-500"
                                    >
                                        No customer appointments found for your
                                        account yet.
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
