<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <flux:card class="space-y-6 max-w-md mx-auto">
        <div>
            <flux:heading size="lg"> Log in to your account </flux:heading>

            <flux:text class="mt-2"> Welcome back! </flux:text>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
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
            <flux:field variant="inline">
                <div class="flex items-center gap-2">
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="size-[1.125rem] rounded-[.3rem] border border-zinc-300 bg-white text-[var(--color-accent)] shadow-xs accent-[var(--color-accent)] focus:ring-2 focus:ring-[var(--color-accent)]/20 dark:border-white/10 dark:bg-white/10"
                    />

                    <label
                        for="remember"
                        class="cursor-pointer text-sm text-zinc-700 dark:text-zinc-300"
                    >
                        Remember me
                    </label>
                </div>
                <flux:error name="remember" />
            </flux:field>

            <!-- Buttons -->
            <div class="space-y-2">
                <flux:button type="submit" variant="primary" class="w-full">
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
