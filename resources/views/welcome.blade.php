<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Barber Shop Appointment System') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 font-sans">
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-24 left-[-10rem] h-80 w-80 rounded-full bg-amber-500/20 blur-3xl"></div>
        <div class="absolute top-40 right-[-8rem] h-96 w-96 rounded-full bg-cyan-500/20 blur-3xl"></div>
    </div>

    <main class="mx-auto flex min-h-screen max-w-6xl items-center px-6 py-12">
        <section class="grid w-full gap-8 lg:grid-cols-[1.3fr_0.9fr] lg:items-center">
            <div class="space-y-6">
                <span class="inline-flex rounded-full border border-white/15 bg-white/5 px-4 py-1 text-sm text-amber-200">
                    Laravel Breeze auth for customers, barbers, and admins
                </span>

                <div class="space-y-4">
                    <h1 class="max-w-2xl text-5xl font-semibold tracking-tight text-white sm:text-6xl">
                        A clean booking system with separate access for every role.
                    </h1>
                    <p class="max-w-xl text-lg leading-8 text-slate-300">
                        Customers can book appointments, barbers can manage their schedules, and admins can oversee the shop from role-aware dashboards.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3 text-sm text-slate-200">
                    <span class="rounded-full bg-white/10 px-4 py-2">Customer</span>
                    <span class="rounded-full bg-white/10 px-4 py-2">Barber</span>
                    <span class="rounded-full bg-white/10 px-4 py-2">Admin</span>
                </div>

                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('login') }}" class="rounded-full bg-amber-400 px-6 py-3 font-semibold text-slate-950 transition hover:bg-amber-300">
                        Sign in
                    </a>
                    <a href="{{ route('register') }}" class="rounded-full border border-white/15 bg-white/5 px-6 py-3 font-semibold text-white transition hover:bg-white/10">
                        Create customer account
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur">
                <h2 class="text-xl font-semibold text-white">Seeded demo accounts</h2>
                <p class="mt-2 text-sm text-slate-300">All seeded accounts use the password <strong>password</strong>.</p>

                <div class="mt-6 space-y-4">
                    <div class="rounded-2xl border border-white/10 bg-slate-900/60 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-amber-300">Admin</p>
                        <p class="mt-1 font-medium text-white">admin@barbershop.test</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-slate-900/60 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-300">Barber</p>
                        <p class="mt-1 font-medium text-white">barber@barbershop.test</p>
                        <p class="text-sm text-slate-400">and barber2@barbershop.test</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-slate-900/60 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-300">Customer</p>
                        <p class="mt-1 font-medium text-white">Created through registration or seeding</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>