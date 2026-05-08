<flux:card class="space-y-6">
    <div>
        <flux:heading size="lg"> {{ __('Update Password') }} </flux:heading>

        <flux:text class="mt-2">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </flux:text>
    </div>

    <form
        method="POST"
        action="{{ route('password.update') }}"
        class="space-y-6"
    >
        @csrf
        @method ('PUT')

        <!-- Current Password -->
        <flux:field>
            <flux:label for="update_password_current_password">
                {{ __('Current Password') }}
            </flux:label>

            <flux:input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
            />

            <flux:error name="current_password" />
        </flux:field>

        <!-- New Password -->
        <flux:field>
            <flux:label for="update_password_password">
                {{ __('New Password') }}
            </flux:label>

            <flux:input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
            />

            <flux:error name="password" />
        </flux:field>

        <!-- Confirm Password -->
        <flux:field>
            <flux:label for="update_password_password_confirmation">
                {{ __('Confirm Password') }}
            </flux:label>

            <flux:input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
            />

            <flux:error name="password_confirmation" />
        </flux:field>

        <!-- Actions -->
        <div class="flex items-center gap-4">
            <flux:button type="submit" variant="primary">
                {{ __('Save') }}
            </flux:button>

            @if (session('status') === 'password-updated')
                <flux:text
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => (show = false), 2000)"
                >
                    {{ __('Saved.') }}
                </flux:text>
            @endif
        </div>
    </form>
</flux:card>
