<x-guest-layout>
    <flux:card class="max-w-md mx-auto space-y-6">
        <div>
            <flux:heading size="lg"> Create an account </flux:heading>

            <flux:text class="mt-2">
                Join and start booking appointments.
            </flux:text>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <flux:field>
                <flux:label>Name</flux:label>

                <flux:input
                    id="name"
                    type="text"
                    name="name"
                    :value="old('name')"
                    placeholder="Your full name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <flux:error name="name" />
            </flux:field>

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
                    autocomplete="username"
                />

                <flux:error name="email" />
            </flux:field>

            <!-- Role -->
            <flux:field>
                <flux:label>I am a</flux:label>

                <flux:select id="role" name="role" required>
                    <option value="">Select an option</option>

                    <option
                        value="customer"
                        @selected (old('role') === 'customer')
                    >
                        Customer
                    </option>

                    <option value="barber" @selected (old('role') === 'barber')>
                        Barber (requires approval)
                    </option>
                </flux:select>

                <flux:error name="role" />
            </flux:field>

            <!-- Password -->
            <flux:field>
                <flux:label>Password</flux:label>

                <flux:input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Create a password"
                    required
                    autocomplete="new-password"
                />

                <flux:error name="password" />
            </flux:field>

            <!-- Confirm Password -->
            <flux:field>
                <flux:label>Confirm Password</flux:label>

                <flux:input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm your password"
                    required
                    autocomplete="new-password"
                />

                <flux:error name="password_confirmation" />
            </flux:field>

            <!-- Buttons -->
            <div class="space-y-2">
                <flux:button type="submit" variant="primary" class="w-full">
                    Register
                </flux:button>

                <flux:button
                    href="{{ route('login') }}"
                    variant="ghost"
                    class="w-full"
                >
                    Already registered?
                </flux:button>
            </div>
        </form>
    </flux:card>
</x-guest-layout>
