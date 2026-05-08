<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <flux:heading size="xl"> Customer Dashboard </flux:heading>

                <flux:text class="mt-1">
                    Book, manage, and track your barber appointments in one
                    place.
                </flux:text>
            </div>

            <flux:button
                href="{{ route('appointments.index') }}"
                variant="primary"
                class="rounded-full"
            >
                Manage appointments
            </flux:button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div
                    class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800"
                >
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-4 md:grid-cols-3">
                <!-- Confirmed Appointments -->
                <flux:card
                    size="sm"
                    class="rounded-2xl p-6 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-800"
                >
                    <flux:text>Confirmed appointments</flux:text>

                    <flux:heading
                        size="xl"
                        class="mt-2 flex items-center gap-2"
                    >
                        {{ $upcomingAppointments->count() }}
                    </flux:heading>
                </flux:card>

                <!-- Waiting List -->
                <flux:card
                    size="sm"
                    class="rounded-2xl p-6 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-800"
                >
                    <flux:text>Waiting list entries</flux:text>

                    <flux:heading
                        size="xl"
                        class="mt-2 flex items-center gap-2"
                    >
                        {{ $waitingListEntries->count() }}
                    </flux:heading>
                </flux:card>

                <!-- Services -->
                <flux:card
                    size="sm"
                    class="rounded-2xl p-6 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-800"
                >
                    <flux:text>Services available</flux:text>

                    <flux:heading
                        size="xl"
                        class="mt-2 flex items-center gap-2"
                    >
                        {{ $services->count() }}
                    </flux:heading>
                </flux:card>
            </div>

            <div class="grid gap-6">
                <flux:card class="rounded-3xl p-6 shadow-sm space-y-6">
                    <!-- Header -->
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

                    <!-- Calendar -->
                    <div class="overflow-hidden rounded-3xl">
                        <livewire:appointment-calendar
                            :day-click-enabled="false"
                            :event-click-enabled="false"
                            :drag-and-drop-enabled="false"
                        />
                    </div>

                    <!-- Table Header -->
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <flux:heading size="lg">
                                Confirmed visits
                            </flux:heading>

                            <flux:text class="mt-1">
                                Review the bookings the barber has already
                                confirmed.
                            </flux:text>
                        </div>

                        <flux:button
                            variant="primary"
                            href="{{ route('appointments.index') }}"
                        >
                            Open scheduler
                        </flux:button>
                    </div>

                    <!-- Table -->
                    <flux:table>
                        <!-- Columns -->
                        <flux:table.columns>
                            <flux:table.column>When</flux:table.column>
                            <flux:table.column>Service</flux:table.column>
                            <flux:table.column>Barber</flux:table.column>
                            <flux:table.column>Status</flux:table.column>
                            <flux:table.column>Action</flux:table.column>
                        </flux:table.columns>

                        <!-- Rows -->
                        <flux:table.rows>
                            @forelse ($upcomingAppointments as $appointment)
                                <flux:table.row>
                                    <flux:table.cell>
                                        {{ $appointment->scheduled_at->format('M d, Y g:i A') }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ $appointment->service->name }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ $appointment->barber?->name ?? 'To be assigned' }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        @if ($appointment->status === 'pending')
                                            <flux:badge color="amber" size="sm"
                                                >Pending</flux:badge
                                            >

                                        @elseif ($appointment->status === 'confirmed')
                                            <flux:badge
                                                color="emerald"
                                                size="sm"
                                                >Confirmed</flux:badge
                                            >

                                        @elseif ($appointment->status === 'cancelled')
                                            <flux:badge color="red" size="sm"
                                                >Cancelled</flux:badge
                                            >
                                        @endif
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        <flux:link
                                            href="{{ route('appointments.show', $appointment) }}"
                                        >
                                            View
                                        </flux:link>
                                    </flux:table.cell>
                                </flux:table.row>

                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="5">
                                        No upcoming appointments yet.
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforelse
                        </flux:table.rows>
                    </flux:table>
                </flux:card>

                <!-- Waiting List -->
                <div class="space-y-6">
                    <flux:card class="rounded-3xl p-6 shadow-sm">
                        <!-- Header -->
                        <flux:heading size="lg"> Waiting list </flux:heading>

                        <div class="mt-4 space-y-3">
                            @forelse ($waitingListEntries as $entry)
                                <flux:card class="p-4 rounded-2xl">
                                    <flux:text class="font-semibold">
                                        {{ $entry->service->name }}
                                    </flux:text>

                                    <flux:text class="mt-1">
                                        Status: {{ ucfirst($entry->status) }}
                                    </flux:text>

                                    <flux:text>
                                        Preferred date: {{ $entry->preferred_date?->format('M d, Y') ?? 'Any' }}
                                    </flux:text>
                                </flux:card>

                            @empty
                                <flux:text class="text-zinc-500">
                                    You do not have any waiting list entries.
                                </flux:text>

                            @endforelse
                        </div>
                    </flux:card>
                </div>
</x-app-layout>
