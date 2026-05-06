<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Barber Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">{{ __('Review today’s cuts, appointments, and blocked time slots.') }}</p>
            </div>

            <a href="{{ route('appointments.index') }}" class="inline-flex items-center rounded-full bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">
                {{ __('Open schedule') }}
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

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm text-gray-500">{{ __('Today’s appointments') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $todayAppointments->count() }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm text-gray-500">{{ __('Upcoming bookings') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $upcomingAppointments->count() }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm text-gray-500">{{ __('Active blocks') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $blocks->count() }}</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Today') }}</h3>
                    <div class="mt-6 space-y-4">
                        @forelse ($todayAppointments as $appointment)
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $appointment->customer->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $appointment->service->name }} · {{ $appointment->scheduled_at->format('g:i A') }}</p>
                                    </div>
                                    <a href="{{ route('appointments.show', $appointment) }}" class="text-sm font-semibold text-gray-700 hover:text-gray-900">{{ __('View') }}</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">{{ __('Nothing booked for today.') }}</p>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Upcoming schedule') }}</h3>
                        <div class="mt-4 space-y-3">
                            @forelse ($upcomingAppointments as $appointment)
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
                                    <p class="font-semibold text-gray-900">{{ $appointment->scheduled_at->format('M d, Y g:i A') }}</p>
                                    <p class="mt-1">{{ $appointment->customer->name }} · {{ $appointment->service->name }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">{{ __('No upcoming bookings yet.') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Blocked time slots') }}</h3>
                        <div class="mt-4 space-y-3">
                            @forelse ($blocks as $block)
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
                                    <p class="font-semibold text-gray-900">{{ $block->starts_at->format('M d, Y g:i A') }} - {{ $block->ends_at->format('g:i A') }}</p>
                                    <p class="mt-1">{{ $block->reason ?? __('No reason provided') }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">{{ __('No blocked slots have been added yet.') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>