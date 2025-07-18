<nav x-data="{
    open: false,
    scrolled: false,
    init() {
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 20;
        });
    }
}" x-init="init()"
    :class="scrolled ? 'bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg border-gray-200/50 dark:border-gray-700/50 shadow-lg' :
        'bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-gray-200/30 dark:border-gray-700/30'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <!-- Logo with animation -->
                <div class="shrink-0 flex items-center group">
                    <a href="{{ route('dashboard') }}"
                        class="transform transition-transform duration-200 hover:scale-105">
                        <div class="flex items-center space-x-2">
                            <x-application-mark class="block h-8 w-auto text-indigo-600 dark:text-indigo-400" />
                            <span
                                class="hidden sm:block font-bold text-xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                SuperMVP
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links - Only show for authenticated users -->
                @auth
                    <div class="hidden lg:flex items-center space-x-1">
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span>Dashboard</span>
                            </div>
                        </x-nav-link>

                        @if (Auth::user()->is_admin)
                            <div class="relative group">
                                <button
                                    class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Admin</span>
                                    <svg class="w-3 h-3 transition-transform group-hover:rotate-180" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div
                                    class="absolute left-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-1 group-hover:translate-y-0">
                                    <div class="p-2">
                                        <a href="{{ route('admin.categories') }}"
                                            class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <span>Categories</span>
                                        </a>
                                        <a href="{{ route('admin.form-fields') }}"
                                            class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>Form Fields</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <x-nav-link href="{{ route('user.documents') }}" :active="request()->routeIs('user.documents')"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Documents</span>
                            </div>
                        </x-nav-link>

                        <x-nav-link href="{{ route('companies.index') }}" :active="request()->routeIs('companies.index')"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span>Companies</span>
                            </div>
                        </x-nav-link>
                    </div>
                @endauth
            </div>

            <!-- Right side content -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Notifications (optional) -->
                    <button
                        class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-5 5v-5zM10.07 2.82L10 3a6 6 0 106 6l-.18-.07M10 3l4 4-4 4" />
                        </svg>
                        <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- User Profile Dropdown -->
                    <div class="relative group">
                        <button
                            class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <img class="h-8 w-8 rounded-full object-cover ring-2 ring-indigo-500/20"
                                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            @else
                                <div
                                    class="h-8 w-8 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-medium">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="hidden md:block text-left">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div
                            class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-1 group-hover:translate-y-0">
                            <div class="p-2">
                                <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-700">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                                </div>

                                <div class="py-2">
                                    <a href="{{ route('profile.show') }}"
                                        class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>Profile</span>
                                    </a>

                                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                        <a href="{{ route('api-tokens.index') }}"
                                            class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                            <span>API Tokens</span>
                                        </a>
                                    @endif
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-700 pt-2">
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center space-x-2 w-full px-3 py-2 rounded-lg text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span>Sign Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Guest User Actions -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Sign Up
                        </a>
                    </div>
                @endauth

                <!-- Mobile menu button -->
                <button @click="open = !open"
                    class="lg:hidden p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                    <svg class="w-6 h-6" :class="{ 'hidden': open, 'block': !open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="w-6 h-6" :class="{ 'block': open, 'hidden': !open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="lg:hidden bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg border-t border-gray-200/50 dark:border-gray-700/50"
        style="display: none;" @click.away="open = false">

        @auth
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('user.documents') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->routeIs('user.documents') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Documents</span>
                </a>

                <a href="{{ route('companies.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->routeIs('companies.index') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Companies</span>
                </a>

                @if (Auth::user()->is_admin)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                        <div class="px-4 py-2">
                            <span
                                class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Admin</span>
                        </div>
                        <a href="{{ route('admin.categories') }}"
                            class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <span>Categories</span>
                        </a>
                        <a href="{{ route('admin.form-fields') }}"
                            class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Form Fields</span>
                        </a>
                    </div>
                @endif

                <!-- User Profile Section Mobile -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                    <div class="flex items-center space-x-3 px-4 py-3">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}" />
                        @else
                            <div
                                class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-medium">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="space-y-1 px-4">
                        <a href="{{ route('profile.show') }}"
                            class="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Profile</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit"
                                class="flex items-center space-x-3 w-full px-3 py-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <!-- Guest Mobile Menu -->
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span class="font-medium">AI Chat</span>
                </a>

                <!-- Features info for guests -->
                <div
                    class="px-4 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg border border-indigo-200 dark:border-indigo-700">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Guest Mode</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">You're using basic chat. Sign up for
                                advanced features like document analysis and conversation history.</p>
                        </div>
                    </div>
                </div>

                <!-- Features list -->
                <div class="px-4 py-3 space-y-2">
                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Get More
                        With Account</div>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Save conversation history</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Upload & analyze documents</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Advanced AI features</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Company management</span>
                        </div>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4 space-y-3">
                    <a href="{{ route('register') }}"
                        class="flex items-center justify-center w-full px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span class="font-medium">Sign Up Free</span>
                        </div>
                    </a>

                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center w-full px-4 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-medium">Sign In</span>
                        </div>
                    </a>
                </div>

                <!-- Footer info -->
                <div class="px-4 py-3 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Free to try • No credit card required
                    </p>
                </div>
            </div>
        @endauth
    </div>
</nav>
