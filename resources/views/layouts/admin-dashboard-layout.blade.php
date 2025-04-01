<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PowerSync') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-10 w-64 bg-white dark:bg-gray-800 shadow-md transform transition-transform duration-150 ease-in-out md:translate-x-0"
            id="sidebar" x-data="{ open: true }" :class="{ 'translate-x-0': open, '-translate-x-full': !open }">
            <div class="flex items-center justify-between h-16 px-4 border-b dark:border-gray-700">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-gray-800 dark:text-white">PowerSync</span>
                </div>
                <button @click="open = !open" class="md:hidden">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <nav class="px-2 py-4">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.quizzes.index') }}"
                            class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.quizzes.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                            Quizzes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.results.index') }}"
                            class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.results.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Results & Analytics
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="md:pl-64">
            <!-- Top Navigation -->
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="flex items-center justify-between h-16 px-4">
                    <button @click="open = !open" class="md:hidden">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="flex items-center ml-auto">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center text-gray-700 dark:text-gray-300 focus:outline-none">
                                <span class="mr-2">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
