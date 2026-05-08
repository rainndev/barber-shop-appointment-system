<flux:card class="space-y-6">
    <div>
        <flux:heading size="lg"> {{ __('Profile Information') }} </flux:heading>

        <flux:text class="mt-2">
            {{ __("Update your account's profile information and email address.") }}
        </flux:text>
    </div>

    <form
        id="send-verification"
        method="POST"
        action="{{ route('verification.send') }}"
    >
        @csrf
    </form>

    <form
        method="POST"
        action="{{ route('profile.update') }}"
        class="space-y-6"
    >
        @csrf
        @method ('PATCH')

        <!-- Name -->
        <flux:field>
            <flux:label>{{ __('Name') }}</flux:label>

            <flux:input
                id="name"
                name="name"
                type="text"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />

            <flux:error name="name" />
        </flux:field>

        <!-- Email -->
        <flux:field>
            <flux:label>{{ __('Email') }}</flux:label>

            <flux:input
                id="email"
                name="email"
                type="email"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />

            <flux:error name="email" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 space-y-2">
                    <flux:text>
                        {{ __('Your email address is unverified.') }}
                    </flux:text>

                    <flux:link
                        form="send-verification"
                        as="button"
                        type="submit"
                        variant="subtle"
                    >
                        {{ __('Click here to re-send the verification email.') }}
                    </flux:link>

                    @if (session('status') === 'verification-link-sent')
                        <flux:badge color="emerald">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </flux:badge>
                    @endif
                </div>
            @endif
        </flux:field>

        <!-- Actions -->
        <div class="flex items-center gap-4">
            <flux:button type="submit" variant="primary">
                {{ __('Save') }}
            </flux:button>

            @if (session('status') === 'profile-updated')
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
