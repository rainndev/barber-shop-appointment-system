<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <flux:heading size="xl"> Appointments </flux:heading>

                <flux:text class="mt-1">
                    Choose a service, pick an open slot, and keep your bookings
                    organized.
                </flux:text>
            </div>

            <flux:button
                href="{{ route('dashboard') }}"
                variant="filled"
                class="rounded-full"
            >
                Back to dashboard
            </flux:button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <flux:badge color="emerald" class="px-4 py-2">
                    {{ session('status') }}
                </flux:badge>
            @endif

            <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
                <!-- LEFT: Booking Panel -->
                <flux:card class="p-6 rounded-3xl">
                    <div
                        class="flex flex-wrap items-center justify-between gap-3"
                    >
                        <div>
                            <flux:heading size="lg">
                                Book an appointment
                            </flux:heading>

                            <flux:text class="mt-1">
                                Pick a date and choose from the available slots
                                below.
                            </flux:text>
                        </div>
                    </div>

                    <!-- Filters -->
                    <form
                        method="GET"
                        action="{{ route('appointments.index') }}"
                        class="mt-6 grid gap-4 lg:grid-cols-4"
                    >
                        <!-- Service -->
                        <div>
                            <flux:select
                                size="lg"
                                name="service_id"
                                label="Service"
                            >
                                @forelse ($services as $service)
                                    <flux:select.option
                                        value="{{ $service->id }}"
                                    >
                                        {{ $service->name }} ({{ $service->duration_minutes }} min)
                                    </flux:select.option>
                                @empty
                                    <flux:select.option value="">
                                        No services available
                                    </flux:select.option>
                                @endforelse
                            </flux:select>
                        </div>

                        <!-- Barber -->
                        <div>
                            <flux:select name="barber_id" label="Barber">
                                <flux:select.option value="">
                                    Any available barber
                                </flux:select.option>

                                @foreach ($barbers as $barber)
                                    <flux:select.option
                                        value="{{ $barber->id }}"
                                    >
                                        {{ $barber->name }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>

                        <!-- Date -->
                        <div>
                            <flux:label class="mb-3">Date</flux:label>

                            <flux:input
                                type="date"
                                name="date"
                                value="{{ $selectedDate }}"
                            />
                        </div>

                        <!-- Button -->
                        <div class="flex items-end">
                            <flux:button
                                type="submit"
                                variant="primary"
                                class="w-full"
                            >
                                Refresh availability
                            </flux:button>
                        </div>
                    </form>

                    <!-- Slots -->
                    <div class="mt-6">
                        <flux:text
                            class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500"
                        >
                            Available slots
                        </flux:text>

                        <div
                            class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-3"
                        >
                            @forelse ($availableSlots as $slot)
                                <form
                                    method="POST"
                                    action="{{ route('appointments.store', ['barber_id' => optional($selectedBarber)->id]) }}"
                                >
                                    @csrf

                                    <input
                                        type="hidden"
                                        name="service_id"
                                        value="{{ optional($selectedService)->id }}"
                                    />
                                    <input
                                        type="hidden"
                                        name="scheduled_at"
                                        value="{{ $slot }}"
                                    />
                                    <input
                                        type="hidden"
                                        name="barber_id"
                                        value="{{ optional($selectedBarber)->id }}"
                                    />

                                    <flux:card class="p-4">
                                        <flux:text
                                            class="text-xs font-semibold uppercase tracking-wider text-zinc-500"
                                        >
                                            Slot
                                        </flux:text>

                                        <flux:heading size="sm" class="mt-2">
                                            {{ \Carbon\Carbon::parse($slot)->format('g:i A') }}
                                        </flux:heading>

                                        <flux:text
                                            class="text-sm text-zinc-500"
                                        >
                                            {{ \Carbon\Carbon::parse($slot)->format('M d, Y') }}
                                        </flux:text>

                                        <flux:button
                                            type="submit"
                                            variant="primary"
                                            class="mt-4 w-full"
                                        >
                                            Book this slot
                                        </flux:button>
                                    </flux:card>
                                </form>

                            @empty
                                <div class="col-span-3">
                                    <flux:card
                                        class="p-6 text-sm text-zinc-500"
                                    >
                                        No open slots were found for the
                                        selected service and date.
                                    </flux:card>
                                </div>

                            @endforelse
                        </div>
                    </div>
                </flux:card>

                <!-- RIGHT SIDE -->
                <div class="space-y-6">
                    <!-- My Appointments -->
                    <flux:card class="p-6 rounded-3xl">
                        <flux:heading size="lg">
                            Your appointments
                        </flux:heading>

                        <div class="mt-4 space-y-3">
                            @forelse ($appointments as $appointment)
                                <flux:card class="p-4">
                                    <flux:text class="font-semibold">
                                        {{ $appointment->service->name }}
                                    </flux:text>

                                    <flux:text class="text-sm mt-1">
                                        {{ $appointment->scheduled_at->format('M d, Y g:i A') }}
                                    </flux:text>

                                    <flux:text class="text-sm text-zinc-500">
                                        Barber: {{ $appointment->barber?->name ?? 'To be assigned' }}
                                    </flux:text>

                                    <flux:link
                                        href="{{ route('appointments.show', $appointment) }}"
                                        class="mt-2 block"
                                    >
                                        View
                                    </flux:link>
                                </flux:card>

                            @empty
                                <flux:text class="text-sm text-zinc-500">
                                    You have not booked anything yet.
                                </flux:text>
                            @endforelse
                        </div>
                    </flux:card>

                    <!-- Waiting List -->
                    <flux:card class="p-6 rounded-3xl">
                        <flux:heading size="lg">
                            Waiting list entries
                        </flux:heading>

                        <div class="mt-4 space-y-3">
                            @forelse ($waitlistEntries as $entry)
                                <flux:card class="p-4">
                                    <flux:text class="font-semibold">
                                        {{ $entry->service->name }}
                                    </flux:text>

                                    <flux:text class="text-sm mt-1">
                                        Status: {{ ucfirst($entry->status) }}
                                    </flux:text>

                                    <flux:text class="text-sm text-zinc-500">
                                        Preferred: {{ $entry->preferred_date?->format('M d, Y') ?? 'Any time' }} {{ $entry->preferred_time ? \Carbon\Carbon::parse($entry->preferred_time)->format('g:i A') : '' }}
                                    </flux:text>
                                </flux:card>

                            @empty
                                <flux:text class="text-sm text-zinc-500">
                                    Your waiting list is empty.
                                </flux:text>
                            @endforelse
                        </div>
                    </flux:card>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
