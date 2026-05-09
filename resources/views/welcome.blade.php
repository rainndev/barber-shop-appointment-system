<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/logo-with-white.png') }}"
    />
    <title>{{ config('app.name', 'Barber Shop Appointment System') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap"
        rel="stylesheet"
    />

    @vite (['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-zinc-900 text-zinc-100 font-sans">
    <!-- Background Glow -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div
            class="absolute -top-24 left-[-10rem] h-80 w-80 rounded-full bg-amber-500/20 blur-3xl"
        ></div>
        <div
            class="absolute top-40 right-[-8rem] h-96 w-96 rounded-full bg-cyan-500/20 blur-3xl"
        ></div>
    </div>

    <main class="mx-auto flex min-h-screen max-w-7xl items-center px-6 py-12">
        <section
            class="grid w-full gap-8 lg:grid-cols-[1.3fr_0.9fr] lg:items-center"
        >
            <!-- Left Content -->
            <div class="space-y-8">
                <div class="space-y-4">
                    <flux:heading size="xl" class="max-w-3xl tracking-tight">
                        A clean booking system with separate access for every
                        role.
                    </flux:heading>

                    <flux:text
                        class="max-w-2xl text-base text-zinc-400 leading-8"
                    >
                        Customers can book appointments, barbers can manage
                        their schedules, and admins can oversee the shop from
                        role-aware dashboards.
                    </flux:text>
                </div>

                <!-- Roles -->
                <div class="flex flex-wrap gap-3">
                    <flux:badge variant="subtle"> Customer </flux:badge>

                    <flux:badge variant="subtle"> Barber </flux:badge>

                    <flux:badge variant="subtle"> Admin </flux:badge>
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap gap-4 pt-2">
                    <flux:button
                        href="{{ route('login') }}"
                        variant="primary"
                        class="rounded-full"
                    >
                        Sign in
                    </flux:button>

                    <flux:button
                        class="text-zinc-300"
                        href="{{ route('register') }}"
                        variant="filled"
                        class="rounded-full"
                    >
                        Create customer account
                    </flux:button>
                </div>
            </div>

            <!-- Right Card -->
            <flux:card
                class="rounded-3xl border border-zinc-800 bg-zinc-900/70 p-6 backdrop-blur shadow-2xl"
            >
                <flux:heading size="lg"> Seeded demo accounts </flux:heading>

                <flux:text class="mt-2 text-zinc-400">
                    All seeded accounts use the password
                    <span class="font-semibold text-zinc-200">password</span>.
                </flux:text>

                <div class="mt-6 space-y-4">
                    <!-- Admin -->
                    <flux:card
                        class="rounded-2xl p-4 bg-zinc-950 border border-zinc-800"
                    >
                        <flux:badge color="amber" size="sm"> Admin </flux:badge>

                        <flux:text class="mt-2 font-medium text-zinc-100">
                            admin@barbershop.test
                        </flux:text>
                    </flux:card>

                    <!-- Barber -->
                    <flux:card
                        class="rounded-2xl p-4 bg-zinc-950 border border-zinc-800"
                    >
                        <flux:badge color="cyan" size="sm"> Barber </flux:badge>

                        <flux:text class="mt-2 font-medium text-zinc-100">
                            barber@barbershop.test
                        </flux:text>

                        <flux:text class="text-sm text-zinc-500">
                            barber2@barbershop.test
                        </flux:text>
                    </flux:card>

                    <!-- Customer -->
                    <flux:card
                        class="rounded-2xl p-4 bg-zinc-950 border border-zinc-800"
                    >
                        <flux:badge color="emerald" size="sm">
                            Customer
                        </flux:badge>

                        <flux:text class="mt-2 font-medium text-zinc-100">
                            Created through registration or seeding
                        </flux:text>
                    </flux:card>
                </div>
            </flux:card>
        </section>
    </main>
</body>
</html>
