<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Appointments') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">{{ __('Choose a service, pick an open slot, and keep your bookings organized.') }}</p>
            </div>

            <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-full bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">
                {{ __('Back to dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Book an appointment') }}</h3>
                            <p class="text-sm text-gray-500">{{ __('Pick a date and choose from the available slots below.') }}</p>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('appointments.index') }}" class="mt-6 grid gap-4 lg:grid-cols-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('Service') }}</label>
                            <select name="service_id" class="mt-1 w-full rounded-xl border-gray-300">
                                @forelse ($services as $service)
                                    <option value="{{ $service->id }}" @selected(optional($selectedService)->id === $service->id)>{{ $service->name }} ({{ $service->duration_minutes }} min)</option>
                                @empty
                                    <option value="">{{ __('No services available') }}</option>
                                @endforelse
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('Barber') }}</label>
                            <select name="barber_id" class="mt-1 w-full rounded-xl border-gray-300">
                                <option value="">{{ __('Any available barber') }}</option>
                                @foreach ($barbers as $barber)
                                    <option value="{{ $barber->id }}" @selected(optional($selectedBarber)->id === $barber->id)>{{ $barber->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('Date') }}</label>
                            <input type="date" name="date" value="{{ $selectedDate }}" class="mt-1 w-full rounded-xl border-gray-300">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full rounded-full bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
                                {{ __('Refresh availability') }}
                            </button>
                        </div>
                    </form>

                    <div class="mt-6">
                        <h4 class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">{{ __('Available slots') }}</h4>
                        <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                            @forelse ($availableSlots as $slot)
                                <form method="POST" action="{{ route('appointments.store') }}" class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ optional($selectedService)->id }}">
                                    <input type="hidden" name="scheduled_at" value="{{ $slot }}">
                                    <input type="hidden" name="barber_id" value="{{ optional($selectedBarber)->id }}">
                                    <label class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">{{ __('Slot') }}</label>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($slot)->format('g:i A') }}</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($slot)->format('M d, Y') }}</p>
                                    <button type="submit" class="mt-4 w-full rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-gray-950 transition hover:bg-amber-300">
                                        {{ __('Book this slot') }}
                                    </button>
                                </form>
                            @empty
                                <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-500 sm:col-span-2 xl:col-span-3">
                                    {{ __('No open slots were found for the selected service and date. Add yourself to the waiting list by trying again later or choose another day.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Your appointments') }}</h3>
                        <div class="mt-4 space-y-3">
                            @forelse ($appointments as $appointment)
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $appointment->service->name }}</p>
                                            <p class="mt-1">{{ $appointment->scheduled_at->format('M d, Y g:i A') }}</p>
                                            <p>{{ __('Barber:') }} {{ $appointment->barber?->name ?? __('To be assigned') }}</p>
                                        </div>
                                        <a href="{{ route('appointments.show', $appointment) }}" class="font-semibold text-gray-700 hover:text-gray-900">{{ __('View') }}</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">{{ __('You have not booked anything yet.') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Waiting list entries') }}</h3>
                        <div class="mt-4 space-y-3">
                            @forelse ($waitlistEntries as $entry)
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
                                    <p class="font-semibold text-gray-900">{{ $entry->service->name }}</p>
                                    <p class="mt-1">{{ __('Status:') }} {{ ucfirst($entry->status) }}</p>
                                    <p>{{ __('Preferred:') }} {{ $entry->preferred_date?->format('M d, Y') ?? __('Any time') }} {{ $entry->preferred_time ? \Carbon\Carbon::parse($entry->preferred_time)->format('g:i A') : '' }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">{{ __('Your waiting list is empty.') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
