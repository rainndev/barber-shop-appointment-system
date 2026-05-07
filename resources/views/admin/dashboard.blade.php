<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Admin Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">{{ __('Monitor bookings, block slots, and track shop demand.') }}</p>
            </div>

            
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm text-gray-500">{{ __('Total bookings') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalBookings }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm text-gray-500">{{ __('Cancelled bookings') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $cancelledBookings }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm text-gray-500">{{ __('Waiting list') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $waitingListCount }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm text-gray-500">{{ __('Peak hour') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $peakHour !== null ? sprintf('%02d:00', $peakHour) : __('N/A') }}</p>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Block time slots') }}</h3>
                    <form method="POST" action="{{ route('admin.availability-blocks.store') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                        @csrf
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('Barber') }}</label>
                            <select name="barber_id" class="mt-1 w-full rounded-xl border-gray-300">
                                <option value="">{{ __('Whole shop') }}</option>
                                @foreach ($barbers as $barber)
                                    <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('Reason') }}</label>
                            <input type="text" name="reason" class="mt-1 w-full rounded-xl border-gray-300" placeholder="{{ __('Lunch break, holiday, maintenance') }}">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('Starts at') }}</label>
                            <input type="datetime-local" name="starts_at" class="mt-1 w-full rounded-xl border-gray-300" required>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">{{ __('Ends at') }}</label>
                            <input type="datetime-local" name="ends_at" class="mt-1 w-full rounded-xl border-gray-300" required>
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-full bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
                                {{ __('Save block') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Analytics snapshot') }}</h3>
                    <div class="mt-4 space-y-3 text-sm text-gray-700">
                        <p>{{ __('Active services:') }} {{ $services->count() }}</p>
                        <p>{{ __('Active barbers:') }} {{ $barbers->count() }}</p>
                        <p>{{ __('Upcoming appointments:') }} {{ $upcomingAppointments->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Upcoming appointments') }}</h3>
                    <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-left text-gray-500">
                                <tr>
                                    <th class="px-4 py-3 font-medium">{{ __('When') }}</th>
                                    <th class="px-4 py-3 font-medium">{{ __('Customer') }}</th>
                                    <th class="px-4 py-3 font-medium">{{ __('Service') }}</th>
                                    <th class="px-4 py-3 font-medium">{{ __('Barber') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($upcomingAppointments as $appointment)
                                    <tr>
                                        <td class="px-4 py-3 text-gray-900">{{ $appointment->scheduled_at->format('M d, Y g:i A') }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $appointment->customer->name }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $appointment->service->name }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $appointment->barber?->name ?? __('Unassigned') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">{{ __('No upcoming appointments yet.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Blocked slots') }}</h3>
                    <div class="mt-4 space-y-3">
                        @forelse ($blocks as $block)
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
                                <p class="font-semibold text-gray-900">{{ $block->starts_at->format('M d, Y g:i A') }} - {{ $block->ends_at->format('g:i A') }}</p>
                                <p class="mt-1">{{ $block->barber?->name ?? __('Whole shop') }} · {{ $block->reason ?? __('No reason provided') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">{{ __('No blocks have been created yet.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>