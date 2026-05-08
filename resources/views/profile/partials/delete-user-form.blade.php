<flux:card class="space-y-6">
    <div>
        <flux:heading size="lg" class="text-red-400">
            {{ __('Delete Account') }}
        </flux:heading>

        <flux:text class="mt-2">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </flux:text>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <flux:button variant="primary">
            {{ __('Delete Account') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" class="md:w-96">
        <form
            method="POST"
            action="{{ route('profile.destroy') }}"
            class="space-y-6"
        >
            @csrf
            @method ('DELETE')

            <div>
                <flux:heading size="lg">
                    {{ __('Are you sure you want to delete your account?') }}
                </flux:heading>

                <flux:text class="mt-2">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.') }}
                </flux:text>
            </div>

            <!-- Password -->
            <flux:field>
                <flux:label for="password"> {{ __('Password') }} </flux:label>

                <flux:input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="{{ __('Password') }}"
                />

                <flux:error name="password" />
            </flux:field>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <flux:button
                    class="cursor-pointer"
                    type="button"
                    variant="ghost"
                    x-on:click="$dispatch('close')"
                >
                    {{ __('Cancel') }}
                </flux:button>

                <flux:button
                    class="cursor-pointer"
                    type="submit"
                    variant="primary"
                >
                    {{ __('Delete Account') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</flux:card>
