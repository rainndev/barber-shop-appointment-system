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
                                @php
                                    $bookingFormId = 'booking-form-'.$loop->index;
                                    $bookingModalName = 'booking-modal-'.$loop->index;
                                @endphp
                                <div class="space-y-0">
                                    <form
                                        id="{{ $bookingFormId }}"
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

                                            <flux:heading
                                                size="sm"
                                                class="mt-2"
                                            >
                                                {{ \Carbon\Carbon::parse($slot)->format('g:i A') }}
                                            </flux:heading>

                                            <flux:text
                                                class="text-sm text-zinc-500"
                                            >
                                                {{ \Carbon\Carbon::parse($slot)->format('M d, Y') }}
                                            </flux:text>

                                            <flux:modal.trigger
                                                name="{{ $bookingModalName }}"
                                            >
                                                <flux:button
                                                    type="button"
                                                    variant="primary"
                                                    class="mt-4 w-full cursor-pointer"
                                                >
                                                    Book this slot
                                                </flux:button>
                                            </flux:modal.trigger>
                                        </flux:card>
                                    </form>

                                    <flux:modal
                                        name="{{ $bookingModalName }}"
                                        class="md:w-lg"
                                    >
                                        <div class="space-y-6 p-2">
                                            <div>
                                                <flux:heading size="xl">
                                                    Confirm your booking
                                                </flux:heading>

                                                <flux:text
                                                    class="mt-1 text-zinc-300"
                                                >
                                                    Please review the details
                                                    before we create your
                                                    appointment.
                                                </flux:text>
                                            </div>

                                            <div
                                                class="space-y-8 rounded-2xl p-4"
                                            >
                                                <div
                                                    class="flex items-center gap-4"
                                                >
                                                    <div
                                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-icon lucide-user-round">
                                                            <circle cx="12" cy="8" r="5" />
                                                            <path d="M20 21a8 8 0 0 0-16 0" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <flux:heading
                                                            size="xs"
                                                            class="text-xs text-zinc-500 uppercase tracking-[0.2em]"
                                                        >
                                                            Customer
                                                        </flux:heading>

                                                        <flux:text
                                                            class="mt-1 text-zinc-300"
                                                        >
                                                            {{ auth()->user()->name }}
                                                        </flux:text>
                                                    </div>
                                                </div>

                                                <div
                                                    class="flex items-center gap-4"
                                                >
                                                    <div
                                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scissors-icon lucide-scissors">
                                                            <circle cx="6" cy="6" r="3" />
                                                            <path d="M8.12 8.12 12 12" />
                                                            <path d="M20 4 8.12 15.88" />
                                                            <circle cx="6" cy="18" r="3" />
                                                            <path d="M14.8 14.8 20 20" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <flux:heading
                                                            size="xs"
                                                            class="text-xs text-zinc-500 uppercase tracking-[0.2em]"
                                                        >
                                                            Service
                                                        </flux:heading>

                                                        <flux:text
                                                            class="mt-1 text-zinc-300"
                                                        >
                                                            {{ optional($selectedService)->name ?? 'Selected service' }}
                                                        </flux:text>
                                                    </div>
                                                </div>

                                                <div
                                                    class="flex items-center gap-4"
                                                >
                                                    <div
                                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-check-icon lucide-user-round-check">
                                                            <path d="M2 21a8 8 0 0 1 13.292-6" />
                                                            <circle cx="10" cy="8" r="5" />
                                                            <path d="m16 19 2 2 4-4" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <flux:heading
                                                            size="xs"
                                                            class="text-xs text-zinc-500 uppercase tracking-[0.2em]"
                                                        >
                                                            Barber
                                                        </flux:heading>

                                                        <flux:text
                                                            class="mt-1 text-zinc-300"
                                                        >
                                                            {{ optional($selectedBarber)->name ?? 'Any available barber' }}
                                                        </flux:text>
                                                    </div>
                                                </div>

                                                <div
                                                    class="flex items-center gap-4"
                                                >
                                                    <div
                                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar">
                                                            <path d="M8 2v4" />
                                                            <path d="M16 2v4" />
                                                            <rect width="18" height="18" x="3" y="4" rx="2" />
                                                            <path d="M3 10h18" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <flux:heading
                                                            size="xs"
                                                            class="text-xs text-zinc-500 uppercase tracking-[0.2em]"
                                                        >
                                                            Date and time
                                                        </flux:heading>

                                                        <flux:text
                                                            class="mt-1 text-zinc-300"
                                                        >
                                                            {{ \Carbon\Carbon::parse($slot)->format('M d, Y g:i A') }}
                                                        </flux:text>
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"
                                            >
                                                <flux:modal.close>
                                                    <flux:button
                                                        type="button"
                                                        variant="ghost"
                                                        class="w-full sm:w-auto"
                                                    >
                                                        Cancel
                                                    </flux:button>
                                                </flux:modal.close>

                                                <flux:modal.close>
                                                    <flux:button
                                                        type="submit"
                                                        form="{{ $bookingFormId }}"
                                                        variant="primary"
                                                        class="w-full sm:w-auto"
                                                    >
                                                        Confirm booking
                                                    </flux:button>
                                                </flux:modal.close>
                                            </div>
                                        </div>
                                    </flux:modal>
                                </div>

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
