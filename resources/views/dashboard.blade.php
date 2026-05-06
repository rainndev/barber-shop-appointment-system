<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Customer Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">{{ __('Book, manage, and track your barber appointments in one place.') }}</p>
            </div>

            <a href="{{ route('appointments.index') }}" class="inline-flex items-center rounded-full bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">
                {{ __('Manage appointments') }}
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

            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm text-gray-500">{{ __('Upcoming appointments') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $upcomingAppointments->count() }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm text-gray-500">{{ __('Waiting list entries') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $waitingListEntries->count() }}</p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm text-gray-500">{{ __('Services available') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $services->count() }}</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ __('Upcoming visits') }}</h3>
                            <p class="text-sm text-gray-500">{{ __('Review the bookings you already have on the books.') }}</p>
                        </div>
                        <a href="{{ route('appointments.index') }}" class="text-sm font-semibold text-gray-700 hover:text-gray-900">{{ __('Open scheduler') }}</a>
                    </div>

                    <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-left text-gray-500">
                                <tr>
                                    <th class="px-4 py-3 font-medium">{{ __('When') }}</th>
                                    <th class="px-4 py-3 font-medium">{{ __('Service') }}</th>
                                    <th class="px-4 py-3 font-medium">{{ __('Barber') }}</th>
                                    <th class="px-4 py-3 font-medium">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($upcomingAppointments as $appointment)
                                    <tr>
                                        <td class="px-4 py-3 text-gray-900">{{ $appointment->scheduled_at->format('M d, Y g:i A') }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $appointment->service->name }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $appointment->barber?->name ?? __('To be assigned') }}</td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('appointments.show', $appointment) }}" class="font-semibold text-gray-700 hover:text-gray-900">{{ __('View') }}</a>
                                        </td>
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

                <div class="space-y-6">
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Notifications') }}</h3>
                        <div class="mt-4 space-y-3">
                            @forelse ($notifications as $notification)
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
                                    <p class="font-semibold text-gray-900">{{ data_get($notification->data, 'title', __('Update')) }}</p>
                                    <p class="mt-1">{{ data_get($notification->data, 'message') }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">{{ __('You are all caught up.') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Waiting list') }}</h3>
                        <div class="mt-4 space-y-3">
                            @forelse ($waitingListEntries as $entry)
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
                                    <p class="font-semibold text-gray-900">{{ $entry->service->name }}</p>
                                    <p class="mt-1">{{ __('Status:') }} {{ ucfirst($entry->status) }}</p>
                                    <p>{{ __('Preferred date:') }} {{ $entry->preferred_date?->format('M d, Y') ?? __('Any') }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">{{ __('You do not have any waiting list entries.') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
