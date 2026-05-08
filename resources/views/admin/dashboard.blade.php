<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <flux:heading size="xl"> Admin Dashboard </flux:heading>

                <flux:text class="mt-1">
                    Monitor bookings, block slots, and track shop demand.
                </flux:text>
            </div>
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

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <!-- Total Bookings -->
                <flux:card
                    size="sm"
                    class="rounded-2xl p-6 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-800"
                >
                    <flux:text>Total bookings</flux:text>

                    <flux:heading size="xl" class="mt-2">
                        {{ $totalBookings }}
                    </flux:heading>
                </flux:card>

                <!-- Cancelled Bookings -->
                <flux:card
                    size="sm"
                    class="rounded-2xl p-6 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-800"
                >
                    <flux:text>Cancelled bookings</flux:text>

                    <flux:heading size="xl" class="mt-2">
                        {{ $cancelledBookings }}
                    </flux:heading>
                </flux:card>

                <!-- Waiting List -->
                <flux:card
                    size="sm"
                    class="rounded-2xl p-6 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-800"
                >
                    <flux:text>Waiting list</flux:text>

                    <flux:heading size="xl" class="mt-2">
                        {{ $waitingListCount }}
                    </flux:heading>
                </flux:card>

                <!-- Peak Hour -->
                <flux:card
                    size="sm"
                    class="rounded-2xl p-6 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-800"
                >
                    <flux:text>Peak hour</flux:text>

                    <flux:heading size="xl" class="mt-2">
                        {{ $peakHour !== null ? sprintf('%02d:00', $peakHour) : 'N/A' }}
                    </flux:heading>
                </flux:card>
            </div>

            <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
                <!-- Block Time Slots -->
                <flux:card class="rounded-3xl p-6 shadow-sm space-y-6">
                    <flux:heading size="lg"> Block time slots </flux:heading>

                    <form
                        method="POST"
                        action="{{ route('admin.availability-blocks.store') }}"
                        class="grid gap-4 md:grid-cols-2"
                    >
                        @csrf

                        <!-- Barber -->
                        <div class="md:col-span-2">
                            <flux:select name="barber_id" label="Barber">
                                <flux:select.option value="">
                                    Whole shop</flux:select.option
                                >

                                @foreach ($barbers as $barber)
                                    <flux:select.option
                                        value="{{ $barber->id }}"
                                    >
                                        {{ $barber->name }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>

                        <!-- Reason -->
                        <div class="md:col-span-2">
                            <flux:input
                                name="reason"
                                label="Reason"
                                placeholder="Lunch break, holiday, maintenance"
                            />
                        </div>

                        <!-- Starts At -->
                        <div>
                            <flux:input
                                type="datetime-local"
                                name="starts_at"
                                label="Starts at"
                                required
                            />
                        </div>

                        <!-- Ends At -->
                        <div>
                            <flux:input
                                type="datetime-local"
                                name="ends_at"
                                label="Ends at"
                                required
                            />
                        </div>

                        <!-- Submit -->
                        <div class="md:col-span-2">
                            <flux:button
                                type="submit"
                                variant="primary"
                                class="w-full"
                            >
                                Save block
                            </flux:button>
                        </div>
                    </form>
                </flux:card>

                <!-- Analytics -->
                <flux:card class="rounded-3xl p-6 shadow-sm space-y-4">
                    <flux:heading size="lg"> Analytics snapshot </flux:heading>

                    <div
                        class="space-y-3 text-sm text-zinc-700 dark:text-zinc-300"
                    >
                        <div class="flex justify-between">
                            <span>Active services</span>
                            <span
                                class="font-semibold"
                                >{{ $services->count() }}</span
                            >
                        </div>

                        <div class="flex justify-between">
                            <span>Active barbers</span>
                            <span
                                class="font-semibold"
                                >{{ $barbers->count() }}</span
                            >
                        </div>

                        <div class="flex justify-between">
                            <span>Upcoming appointments</span>
                            <span
                                class="font-semibold"
                                >{{ $upcomingAppointments->count() }}</span
                            >
                        </div>
                    </div>
                </flux:card>
            </div>
            <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
                <!-- Upcoming Appointments -->
                <flux:card class="rounded-3xl p-6 shadow-sm space-y-4">
                    <flux:heading size="lg">
                        Upcoming appointments
                    </flux:heading>

                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>When</flux:table.column>
                            <flux:table.column>Customer</flux:table.column>
                            <flux:table.column>Service</flux:table.column>
                            <flux:table.column>Barber</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            @forelse ($upcomingAppointments as $appointment)
                                <flux:table.row>
                                    <flux:table.cell>
                                        {{ $appointment->scheduled_at->format('M d, Y g:i A') }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ $appointment->customer->name }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ $appointment->service->name }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ $appointment->barber?->name ?? 'Unassigned' }}
                                    </flux:table.cell>
                                </flux:table.row>

                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="4">
                                        <flux:text
                                            class="text-center text-zinc-500"
                                        >
                                            No upcoming appointments yet.
                                        </flux:text>
                                    </flux:table.cell>
                                </flux:table.row>

                            @endforelse
                        </flux:table.rows>
                    </flux:table>
                </flux:card>

                <!-- Blocked Slots -->
                <flux:card class="rounded-3xl p-6 shadow-sm space-y-4">
                    <flux:heading size="lg"> Blocked slots </flux:heading>

                    <div class="space-y-3">
                        @forelse ($blocks as $block)
                            <flux:card class="p-4 rounded-2xl">
                                <flux:text class="font-semibold">
                                    {{ $block->starts_at->format('M d, Y g:i A') }} - {{ $block->ends_at->format('g:i A') }}
                                </flux:text>

                                <flux:text class="mt-1">
                                    {{ $block->barber?->name ?? 'Whole shop' }} · {{ $block->reason ?? 'No reason provided' }}
                                </flux:text>
                            </flux:card>

                        @empty
                            <flux:text class="text-zinc-500">
                                No blocks have been created yet.
                            </flux:text>

                        @endforelse
                    </div>
                </flux:card>
            </div>
        </div>
    </div>
</x-app-layout>
