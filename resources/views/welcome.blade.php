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
    <!-- Navigation -->
    <nav
        class="fixed top-0 w-full z-50 backdrop-blur-md bg-zinc-900/80 border-b border-zinc-800/50"
    >
        <div
            class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between"
        >
            <div
                class="text-2xl font-bold tracking-tighter flex items-center gap-2"
            >
                <img
                    src="{{ asset('images/logo-no-white.png') }}"
                    class="w-10 inline-block object-contain"
                    alt="Photo"
                />
            </div>
            <div class="flex gap-4">
                <flux:button
                    href="{{ route('login') }}"
                    variant="subtle"
                    size="sm"
                >
                    Sign in
                </flux:button>
                <flux:button
                    href="{{ route('register') }}"
                    variant="primary"
                    size="sm"
                    class="rounded-full"
                >
                    Book Now
                </flux:button>
            </div>
        </div>
    </nav>

    <!-- Background Accent Glow -->
    <div class="absolute inset-0 -z-10 overflow-hidden pointer-events-none">
        <div
            class="absolute top-0 left-1/4 h-96 w-96 rounded-full bg-red-500/5 blur-3xl"
        ></div>
        <div
            class="absolute bottom-0 right-1/4 h-96 w-96 rounded-full bg-red-500/5 blur-3xl"
        ></div>
    </div>

    <main>
        <!-- Hero Section -->
        <section
            class="min-h-[100dvh] flex items-center justify-center px-6 pt-32 pb-20"
        >
            <div class="max-w-5xl mx-auto text-center space-y-8">
                <div class="inline-block">
                    <div
                        class="px-4 py-2 rounded-full bg-red-500/10 border border-red-500/20 mb-6"
                    >
                        <p class="text-sm font-medium text-red-400">Premium Grooming Experience</p>
                    </div>
                </div>

                <h1
                    class="text-6xl md:text-7xl font-bold tracking-tighter leading-tight"
                >
                    Crafted for the
                    <span class="block text-red-500">Distinguished</span>
                </h1>

                <p class="text-xl md:text-2xl text-zinc-400 max-w-2xl mx-auto leading-relaxed">Where precision meets artistry. Every cut, every detail, every moment is about excellence.</p>

                <div
                    class="flex flex-col sm:flex-row gap-4 justify-center pt-8"
                >
                    <flux:button
                        href="{{ route('register') }}"
                        variant="primary"
                        class="rounded-full text-base"
                    >
                        Book Appointment
                    </flux:button>
                    <flux:button
                        href="#services"
                        class="rounded-full text-base"
                    >
                        Explore Services
                    </flux:button>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-24 px-6 border-t border-zinc-800">
            <div class="max-w-6xl mx-auto">
                <div class="mb-16 text-center space-y-4">
                    <h2 class="text-5xl md:text-6xl font-bold tracking-tighter">
                        Our Services
                    </h2>
                    <p class="text-xl text-zinc-400">Crafted with precision and care</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Service Card 1 -->
                    <div
                        class="group rounded-2xl border border-zinc-800 bg-zinc-800/30 p-8 hover:border-red-500/30 hover:bg-zinc-800/50 transition-all duration-300"
                    >
                        <div
                            class="h-12 w-12 rounded-lg bg-red-500/10 flex items-center justify-center mb-6 group-hover:bg-red-500/20 transition-colors"
                        >
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Classic Haircut</h3>
                        <p class="text-zinc-400 mb-6">Timeless precision cuts tailored to your style and face shape.</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-bold">$35</span>
                            <span class="text-zinc-500">60 mins</span>
                        </div>
                    </div>

                    <!-- Service Card 2 -->
                    <div
                        class="group rounded-2xl border border-zinc-800 bg-zinc-800/30 p-8 hover:border-red-500/30 hover:bg-zinc-800/50 transition-all duration-300"
                    >
                        <div
                            class="h-12 w-12 rounded-lg bg-red-500/10 flex items-center justify-center mb-6 group-hover:bg-red-500/20 transition-colors"
                        >
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Beard Grooming</h3>
                        <p class="text-zinc-400 mb-6">Expert beard sculpting, shaping, and finishing for ultimate definition.</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-bold">$25</span>
                            <span class="text-zinc-500">30 mins</span>
                        </div>
                    </div>

                    <!-- Service Card 3 -->
                    <div
                        class="group rounded-2xl border border-zinc-800 bg-zinc-800/30 p-8 hover:border-red-500/30 hover:bg-zinc-800/50 transition-all duration-300"
                    >
                        <div
                            class="h-12 w-12 rounded-lg bg-red-500/10 flex items-center justify-center mb-6 group-hover:bg-red-500/20 transition-colors"
                        >
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Complete Package</h3>
                        <p class="text-zinc-400 mb-6">Full haircut with beard grooming and finishing touches.</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-bold">$55</span>
                            <span class="text-zinc-500">90 mins</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Us Section -->
        <section class="py-24 px-6 border-t border-zinc-800">
            <div class="max-w-6xl mx-auto">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center"
                >
                    <div class="space-y-8">
                        <h2
                            class="text-5xl md:text-6xl font-bold tracking-tighter"
                        >
                            Why Choose Us
                        </h2>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-8 w-8 rounded-lg bg-red-500/10 flex items-center justify-center"
                                    >
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold mb-2">
                                        Master Barbers
                                    </h3>
                                    <p class="text-zinc-400">Certified professionals with 10+ years of experience</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-8 w-8 rounded-lg bg-red-500/10 flex items-center justify-center"
                                    >
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold mb-2">
                                        Premium Products
                                    </h3>
                                    <p class="text-zinc-400">Only the finest grooming products used on every client</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-8 w-8 rounded-lg bg-red-500/10 flex items-center justify-center"
                                    >
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold mb-2">
                                        Easy Booking
                                    </h3>
                                    <p class="text-zinc-400">Seamless online scheduling at your convenience</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-8 w-8 rounded-lg bg-red-500/10 flex items-center justify-center"
                                    >
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold mb-2">
                                        Relaxing Atmosphere
                                    </h3>
                                    <p class="text-zinc-400">Luxurious space designed for comfort and style</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="rounded-2xl bg-gradient-to-br from-red-500/20 to-red-500/5 border border-red-500/20 aspect-square flex items-center justify-center"
                    >
                        <div class="text-center">
                            <div class="text-6xl font-bold text-red-500 mb-2">
                                500+
                            </div>
                            <p class="text-zinc-400">Happy Customers</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24 px-6 border-t border-zinc-800">
            <div class="max-w-4xl mx-auto text-center space-y-8">
                <h2 class="text-5xl md:text-6xl font-bold tracking-tighter">
                    Ready for a fresh look?
                </h2>
                <p class="text-xl text-zinc-400 max-w-2xl mx-auto">Book your appointment today and experience the difference precision and care can make.</p>
                <flux:button
                    href="{{ route('register') }}"
                    variant="primary"
                    class="rounded-full text-base inline-block"
                >
                    Schedule Your Appointment
                </flux:button>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-zinc-800 bg-zinc-900/50 backdrop-blur">
            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <img
                            src="{{ asset('images/logo-no-white.png') }}"
                            class="w-12 inline-block object-contain mb-4"
                            alt="Photo"
                        />
                        <p class="text-zinc-400">Premium grooming experience for the distinguished.</p>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Services</h4>
                        <ul class="space-y-2 text-zinc-400">
                            <li>
                                <a
                                    href="#services"
                                    class="hover:text-red-500 transition"
                                    >Haircuts</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#services"
                                    class="hover:text-red-500 transition"
                                    >Beard Grooming</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#services"
                                    class="hover:text-red-500 transition"
                                    >Complete Packages</a
                                >
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Hours</h4>
                        <ul class="space-y-2 text-zinc-400 text-sm">
                            <li>Mon - Fri: 9AM - 9PM</li>
                            <li>Sat: 10AM - 8PM</li>
                            <li>Sun: 12PM - 6PM</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Contact</h4>
                        <ul class="space-y-2 text-zinc-400 text-sm">
                            <li>(555) 123-4567</li>
                            <li>hello@cuts.local</li>
                            <li>123 Main St, City</li>
                        </ul>
                    </div>
                </div>
                <div
                    class="border-t border-zinc-800 pt-8 flex flex-col md:flex-row justify-between items-center text-zinc-500 text-sm"
                >
                    <p>&copy; 2026 CUTS. All rights reserved.</p>
                    <div class="flex gap-6 mt-4 md:mt-0">
                        <a href="#" class="hover:text-red-500 transition"
                            >Privacy</a
                        >
                        <a href="#" class="hover:text-red-500 transition"
                            >Terms</a
                        >
                        <a href="#" class="hover:text-red-500 transition"
                            >Sitemap</a
                        >
                    </div>
                </div>
            </div>
        </footer>
    </main>
</body>
</html>
