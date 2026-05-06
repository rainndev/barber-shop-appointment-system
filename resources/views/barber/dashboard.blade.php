<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Barber Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">{{ __('Review pending appointment requests and manage your schedule.') }}</p>
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

            @if (session('error'))
                <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid gap-4 md:grid-cols-1">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm text-gray-500">{{ __('Pending appointments') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-amber-600">{{ $pendingAppointments->count() }}</p>
                </div>
            </div>

            <div class="grid gap-4">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h3 class="mb-6 text-lg font-semibold text-gray-900">
                        <span class="inline-flex items-center justify-center rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-800">
                            {{ $pendingAppointments->count() }} {{ __('Pending') }}
                        </span>
                    </h3>
                    <div class="space-y-4">
                        @forelse ($pendingAppointments as $appointment)
                            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4">
                                <div class="mb-3">
                                    <p class="font-semibold text-gray-900">{{ $appointment->customer->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $appointment->service->name }} · {{ $appointment->scheduled_at->format('M d, Y g:i A') }}</p>
                                    @if ($appointment->notes)
                                        <p class="mt-2 text-sm text-gray-700">{{ __('Notes:') }} {{ $appointment->notes }}</p>
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('appointments.accept', $appointment) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                            {{ __('Confirm') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('appointments.decline', $appointment) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-red-700">
                                            {{ __('Cancel') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border-2 border-dashed border-gray-300 p-8 text-center">
                                <p class="text-gray-500">{{ __('No pending appointment requests at this time.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>