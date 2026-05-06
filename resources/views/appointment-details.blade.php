<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Appointment Details') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">{{ __('Review, reschedule, cancel, or export this booking.') }}</p>
            </div>

            <a href="{{ route('appointments.index') }}" class="inline-flex items-center rounded-full bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">
                {{ __('Back to appointments') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $appointment->service->name }}</h3>
                    <dl class="mt-6 grid gap-4 text-sm text-gray-700 sm:grid-cols-2">
                        <div>
                            <dt class="font-semibold text-gray-900">{{ __('Customer') }}</dt>
                            <dd class="mt-1">{{ $appointment->customer->name }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-900">{{ __('Barber') }}</dt>
                            <dd class="mt-1">{{ $appointment->barber?->name ?? __('To be assigned') }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-900">{{ __('Scheduled at') }}</dt>
                            <dd class="mt-1">{{ $appointment->scheduled_at->format('M d, Y g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-900">{{ __('Ends at') }}</dt>
                            <dd class="mt-1">{{ $appointment->ends_at->format('M d, Y g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-900">{{ __('Status') }}</dt>
                            <dd class="mt-1">{{ ucfirst($appointment->status) }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-900">{{ __('Notes') }}</dt>
                            <dd class="mt-1">{{ $appointment->notes ?: __('No notes added.') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="space-y-6">
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Calendar integration') }}</h3>
                        <div class="mt-4 space-y-3 text-sm text-gray-700">
                            <a href="{{ $calendarUrl }}" target="_blank" class="block rounded-2xl bg-gray-900 px-4 py-3 text-center font-semibold text-white transition hover:bg-gray-700">
                                {{ __('Open in Google Calendar') }}
                            </a>
                            <a href="{{ route('appointments.ics', $appointment) }}" class="block rounded-2xl border border-gray-300 px-4 py-3 text-center font-semibold text-gray-700 transition hover:bg-gray-50">
                                {{ __('Download ICS file') }}
                            </a>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Edit appointment') }}</h3>
                        <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="mt-4 space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="text-sm font-medium text-gray-700">{{ __('Reschedule to') }}</label>
                                <input type="datetime-local" name="scheduled_at" value="{{ $appointment->scheduled_at->format('Y-m-d\TH:i') }}" class="mt-1 w-full rounded-xl border-gray-300">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700">{{ __('Notes') }}</label>
                                <textarea name="notes" rows="4" class="mt-1 w-full rounded-xl border-gray-300">{{ $appointment->notes }}</textarea>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <button type="submit" class="rounded-full bg-amber-400 px-5 py-2.5 text-sm font-semibold text-gray-950 transition hover:bg-amber-300">
                                    {{ __('Save changes') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Cancel appointment') }}</h3>
                        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-500">
                                {{ __('Cancel booking') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>