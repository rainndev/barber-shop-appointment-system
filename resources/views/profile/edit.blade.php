<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl"> {{ __('Profile') }} </flux:heading>

                <flux:text class="mt-1">
                    Manage your account settings and preferences.
                </flux:text>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">
                <div>
                    @include ('profile.partials.update-profile-information-form')
                </div>

                <div>
                    @include ('profile.partials.update-password-form')
                </div>

                <div>
                    @include ('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
