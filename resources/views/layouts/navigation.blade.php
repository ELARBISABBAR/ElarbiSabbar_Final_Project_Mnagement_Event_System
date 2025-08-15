<nav x-data="{ open: false }" class="bg-white shadow-soft border-b border-secondary-200 sticky top-0 z-50">
    <div class="container-custom">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="logo-container group">
                    <div class="logo-icon">
                        <div class="logo-geometric group-hover:scale-105 transition-transform duration-300"></div>
                        <span class="logo-letter-sm">E</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="logo-text logo-text-sm leading-none">EvenXt</span>
                        <span class="text-xs text-secondary-500 font-medium tracking-wide">EVENTS</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}"
                   class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : 'nav-link-inactive' }}">
                    Home
                </a>
                <a href="{{ route('contact') }}"
                   class="nav-link {{ request()->routeIs('contact') ? 'nav-link-active' : 'nav-link-inactive' }}">
                    Contact
                </a>
                <a href="{{ route('about') }}"
                   class="nav-link {{ request()->routeIs('about') ? 'nav-link-active' : 'nav-link-inactive' }}">
                    About
                </a>
                <a href="{{ route('blogs') }}"
                   class="nav-link {{ request()->routeIs('blogs') ? 'nav-link-active' : 'nav-link-inactive' }}">
                    Blog
                </a>
            </div>

            <!-- User Menu -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm font-medium text-secondary-700 hover:bg-secondary-100 transition-colors duration-200">
                                <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-secondary-200">
                                <p class="text-sm font-medium text-secondary-900">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-secondary-500">{{ Auth::user()->email }}</p>
                            </div>

                            <x-dropdown-link :href="route('myorder.index')" class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span>My Orders</span>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profile</span>
                            </x-dropdown-link>

                            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'organizer')
                                <div class="border-t border-secondary-200 my-1"></div>
                                <x-dropdown-link :href="route('event.index')" class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <span>Create Event</span>
                                </x-dropdown-link>

                                @if (Auth::user()->role === 'admin')
                                    <x-dropdown-link :href="route('users.index')" class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        <span>Manage Users</span>
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('event_admin.index')" class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Manage Events</span>
                                    </x-dropdown-link>
                                @endif
                            @endif

                            <div class="border-t border-secondary-200 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center space-x-2 text-danger-600 hover:bg-danger-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Log Out</span>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="btn-outline-primary">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary">
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="open = !open"
                    class="p-2 rounded-lg text-secondary-600 hover:bg-secondary-100 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" x-transition class="md:hidden border-t border-secondary-200 bg-white">
        <div class="px-4 py-2 space-y-1">
            <a href="{{ route('home') }}"
               class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'bg-primary-100 text-primary-700' : 'text-secondary-600 hover:bg-secondary-100' }}">
                Home
            </a>
            <a href="{{ route('contact') }}"
               class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('contact') ? 'bg-primary-100 text-primary-700' : 'text-secondary-600 hover:bg-secondary-100' }}">
                Contact
            </a>
            <a href="{{ route('about') }}"
               class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('about') ? 'bg-primary-100 text-primary-700' : 'text-secondary-600 hover:bg-secondary-100' }}">
                About
            </a>
            <a href="{{ route('blogs') }}"
               class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('blogs') ? 'bg-primary-100 text-primary-700' : 'text-secondary-600 hover:bg-secondary-100' }}">
                Blog
            </a>
        </div>

        @auth
            <div class="border-t border-secondary-200 px-4 py-3">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-secondary-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-secondary-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('myorder.index') }}" class="block px-3 py-2 rounded-lg text-sm text-secondary-600 hover:bg-secondary-100">
                        My Orders
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm text-secondary-600 hover:bg-secondary-100">
                        Profile
                    </a>

                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'organizer')
                        <div class="border-t border-secondary-200 my-2"></div>
                        <a href="{{ route('event.index') }}" class="block px-3 py-2 rounded-lg text-sm text-secondary-600 hover:bg-secondary-100">
                            Create Event
                        </a>

                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded-lg text-sm text-secondary-600 hover:bg-secondary-100">
                                Manage Users
                            </a>
                            <a href="{{ route('event_admin.index') }}" class="block px-3 py-2 rounded-lg text-sm text-secondary-600 hover:bg-secondary-100">
                                Manage Events
                            </a>
                        @endif
                    @endif

                    <div class="border-t border-secondary-200 my-2"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg text-sm text-danger-600 hover:bg-danger-50">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="border-t border-secondary-200 px-4 py-3 space-y-2">
                <a href="{{ route('login') }}" class="block w-full text-center btn-outline-primary">
                    Log In
                </a>
                <a href="{{ route('register') }}" class="block w-full text-center btn-primary">
                    Sign Up
                </a>
            </div>
        @endauth
    </div>
</nav>
