<nav x-data="{ open: false }" class="border-b border-zinc-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img
                            src="{{ asset('images/logo-with-white.png') }}"
                            class="w-9 object-contain"
                            alt="Logo"
                        />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')"
                    >
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (Auth::user()->isAdmin())
                        <x-nav-link
                            :href="route('admin.barbers.index')"
                            :active="request()->routeIs('admin.barbers.index')"
                        >
                            {{ __('Barbers') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->isCustomer())
                        <x-nav-link
                            :href="route('appointments.index')"
                            :active="request()->routeIs('appointments.*')"
                        >
                            {{ __('Appointments') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-4">
                <flux:dropdown position="bottom" align="end">
                    <!-- Trigger (profile button) -->
                    <flux:profile
                        avatar="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                        name="{{ Auth::user()->name }}"
                    />

                    <!-- Menu -->
                    <flux:navmenu>
                        <flux:navmenu.item
                            href="{{ route('profile.edit') }}"
                            icon="user"
                        >
                            Account
                        </flux:navmenu.item>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <flux:navmenu.item
                                as="button"
                                icon="arrow-right-start-on-rectangle"
                                onclick="
                                    event.preventDefault();
                                    this.closest('form').submit();
                                "
                            >
                                Logout
                            </flux:navmenu.item>
                        </form>
                    </flux:navmenu>
                </flux:dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path
                            :class="{
                                hidden: open,
                                'inline-flex': !open,
                            }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{
                                hidden: !open,
                                'inline-flex': open,
                            }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ block: open, hidden: !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')"
            >
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if (Auth::user()->isCustomer())
                <x-responsive-nav-link
                    :href="route('appointments.index')"
                    :active="request()->routeIs('appointments.*')"
                >
                    {{ __('Appointments') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link
                        href="#"
                        onclick="
                            event.preventDefault();
                            this.closest('form').submit();
                        "
                    >
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
