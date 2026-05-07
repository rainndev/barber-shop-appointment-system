<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <flux:card class="space-y-6 max-w-md mx-auto">
        <div>
            <flux:heading size="lg">
                Log in to your account
            </flux:heading>

            <flux:text class="mt-2">
                Welcome back!
            </flux:text>
        </div>

        <form
            method="POST"
            action="{{ route('login') }}"
            class="space-y-6"
        >
            @csrf

            <!-- Email -->
            <flux:field>
                <flux:label>Email</flux:label>

                <flux:input
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    placeholder="Your email address"
                    required
                    autofocus
                    autocomplete="username"
                />

                <flux:error name="email" />
            </flux:field>

            <!-- Password -->
            <flux:field>
                <div class="mb-2 flex items-center justify-between">
                    <flux:label>Password</flux:label>

                    @if (Route::has('password.request'))
                        <flux:link
                            href="{{ route('password.request') }}"
                            variant="subtle"
                            class="text-sm"
                        >
                            Forgot password?
                        </flux:link>
                    @endif
                </div>

                <flux:input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Your password"
                    required
                    autocomplete="current-password"
                />

                <flux:error name="password" />
            </flux:field>

            <!-- Remember Me -->
            <label class="flex items-center gap-2">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-zinc-300"
                >

                <span class="text-sm text-zinc-600">
                    Remember me
                </span>
            </label>

            <!-- Buttons -->
            <div class="space-y-2">
                <flux:button
                    type="submit"
                    variant="primary"
                    class="w-full"
                >
                    Log in
                </flux:button>

                <flux:button
                    href="{{ route('register') }}"
                    variant="ghost"
                    class="w-full"
                >
                    Sign up for a new account
                </flux:button>
            </div>
        </form>
    </flux:card>
</x-guest-layout>