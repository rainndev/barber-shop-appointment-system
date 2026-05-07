<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Barber Approval Management') }}
        </h2>
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

            <!-- Pending Approvals -->
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('Pending Barber Applications') }} ({{ $pendingBarbers->count() }})</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('Review and approve new barber registrations.') }}</p>

                @if ($pendingBarbers->isEmpty())
                    <div class="mt-6 rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-500">
                        {{ __('No pending barber applications.') }}
                    </div>
                @else
                    <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-left text-gray-500">
                                <tr>
                                    <th class="px-6 py-3 font-medium">{{ __('Name') }}</th>
                                    <th class="px-6 py-3 font-medium">{{ __('Email') }}</th>
                                    <th class="px-6 py-3 font-medium">{{ __('Applied') }}</th>
                                    <th class="px-6 py-3 font-medium text-right">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($pendingBarbers as $barber)
                                    <tr>
                                        <td class="px-6 py-3 text-gray-900 font-medium">{{ $barber->name }}</td>
                                        <td class="px-6 py-3 text-gray-600">{{ $barber->email }}</td>
                                        <td class="px-6 py-3 text-gray-600">{{ $barber->created_at->format('M d, Y g:i A') }}</td>
                                        <td class="px-6 py-3 text-right space-x-3">
                                            <form method="POST" action="{{ route('admin.barbers.approve', $barber) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="font-semibold text-emerald-600 hover:text-emerald-900">{{ __('Approve') }}</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.barbers.reject', $barber) }}" class="inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-semibold text-red-600 hover:text-red-900">{{ __('Reject') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Approved Barbers -->
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('Approved Barbers') }} ({{ $approvedBarbers->count() }})</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('All approved barbers in the system.') }}</p>

                @if ($approvedBarbers->isEmpty())
                    <div class="mt-6 rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-500">
                        {{ __('No approved barbers yet.') }}
                    </div>
                @else
                    <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-left text-gray-500">
                                <tr>
                                    <th class="px-6 py-3 font-medium">{{ __('Name') }}</th>
                                    <th class="px-6 py-3 font-medium">{{ __('Email') }}</th>
                                    <th class="px-6 py-3 font-medium">{{ __('Joined') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($approvedBarbers as $barber)
                                    <tr>
                                        <td class="px-6 py-3 text-gray-900 font-medium">{{ $barber->name }}</td>
                                        <td class="px-6 py-3 text-gray-600">{{ $barber->email }}</td>
                                        <td class="px-6 py-3 text-gray-600">{{ $barber->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
