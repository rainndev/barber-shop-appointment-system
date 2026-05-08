<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <flux:heading size="xl"> Appointment Details </flux:heading>

                <flux:text class="mt-1">
                    Review, reschedule, cancel, or export this booking.
                </flux:text>
            </div>

            <flux:button
                href="{{ route('appointments.index') }}"
                variant="filled"
                class="rounded-full"
            >
                Back to appointments
            </flux:button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <!-- Status -->
            @if (session('status'))
                <flux:badge color="emerald" class="px-4 py-2">
                    {{ session('status') }}
                </flux:badge>
            @endif

            <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                <!-- LEFT: Appointment Info -->
                <flux:card class="p-10 rounded-3xl">
                    <flux:heading size="lg">
                        {{ $appointment->service->name }}
                    </flux:heading>

                    <dl class="mt-6 grid gap-5 text-sm sm:grid-cols-2">
                        <div>
                            <flux:heading size="lg">Customer</flux:heading>
                            <flux:text
                                class="mt-1"
                                >{{ $appointment->customer->name }}</flux:text
                            >
                        </div>

                        <div>
                            <flux:heading size="lg">Barber</flux:heading>
                            <flux:text class="mt-1">
                                {{ $appointment->barber?->name ?? 'To be assigned' }}
                            </flux:text>
                        </div>

                        <div>
                            <flux:heading size="lg">Scheduled at</flux:heading>
                            <flux:text class="mt-1">
                                {{ $appointment->scheduled_at->format('M d, Y g:i A') }}
                            </flux:text>
                        </div>

                        <div>
                            <flux:heading size="lg">Ends at</flux:heading>
                            <flux:text class="mt-1">
                                {{ $appointment->ends_at->format('M d, Y g:i A') }}
                            </flux:text>
                        </div>

                        <div>
                            <flux:heading size="lg">Status</flux:heading>
                            <flux:text class="mt-1">
                                {{ ucfirst($appointment->status) }}
                            </flux:text>
                        </div>

                        <div>
                            <flux:heading size="lg">Notes</flux:heading>
                            <flux:text class="mt-1">
                                {{ $appointment->notes ?: 'No notes added.' }}
                            </flux:text>
                        </div>
                    </dl>
                </flux:card>

                <!-- RIGHT SIDE -->
                <div class="space-y-6">
                    <!-- Calendar Integration -->
                    <flux:card class="p-6 rounded-3xl">
                        <flux:heading size="lg">
                            Calendar integration
                        </flux:heading>

                        <div class="mt-4 space-y-3">
                            <flux:button
                                href="{{ $calendarUrl }}"
                                target="_blank"
                                variant="primary"
                                class="w-full"
                            >
                                Open in Google Calendar
                            </flux:button>

                            <flux:button
                                href="{{ route('appointments.ics', $appointment) }}"
                                variant="ghost"
                                class="w-full"
                            >
                                Download ICS file
                            </flux:button>
                        </div>
                    </flux:card>

                    <!-- Edit -->
                    <flux:card class="p-6 rounded-3xl">
                        <flux:heading size="lg">
                            Edit appointment
                        </flux:heading>

                        <form
                            method="POST"
                            action="{{ route('appointments.update', $appointment) }}"
                            class="mt-4 space-y-4"
                        >
                            @csrf
                            @method ('PUT')

                            <div>
                                <flux:label class="mb-3">Date</flux:label>

                                <flux:input
                                    type="datetime-local"
                                    name="scheduled_at"
                                    value="{{ $appointment->scheduled_at->format('Y-m-d\TH:i') }}"
                                />
                            </div>

                            <div>
                                <flux:label>Notes</flux:label>

                                <flux:textarea name="notes" rows="4">
                                    {{ $appointment->notes }}
                                </flux:textarea>
                            </div>

                            <flux:button
                                type="submit"
                                variant="primary"
                                class="w-full"
                            >
                                Save changes
                            </flux:button>
                        </form>
                    </flux:card>

                    <!-- Cancel -->
                    <flux:card class="p-6 rounded-3xl">
                        <flux:heading size="lg">
                            Cancel appointment
                        </flux:heading>

                        <form
                            method="POST"
                            action="{{ route('appointments.destroy', $appointment) }}"
                            class="mt-4"
                        >
                            @csrf
                            @method ('DELETE')

                            <flux:button
                                type="submit"
                                variant="filled"
                                class="w-full"
                            >
                                Cancel booking
                            </flux:button>
                        </form>
                    </flux:card>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
