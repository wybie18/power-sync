<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PowerSync') }} - Discover Your Alignment</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 fixed w-full z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">PowerSync</span>
                    </div>
                </div>
                <div class="flex items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium">Log in</a>
                        <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm font-medium">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-24 pb-16 md:pt-32 md:pb-24 bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-800 text-white">
        <div class="absolute inset-0 bg-[url('/img/grid-pattern.svg')] opacity-20"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-4">Discover Your True Alignment</h1>
                    <p class="text-xl md:text-2xl text-blue-200 mb-8">Are you a hero or villain at heart? Take our quizzes to reveal your inner nature.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-white text-blue-900 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900 text-center font-medium">Go to Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-blue-900 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900 text-center font-medium">Get Started</a>
                            <a href="{{ route('login') }}" class="px-6 py-3 border border-white text-white rounded-lg hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900 text-center font-medium">Log In</a>
                        @endauth
                    </div>
                </div>
                <div class="hidden md:block">
                    <img src="{{ asset('img/hero-villain.svg') }}" alt="Hero vs Villain Illustration" class="w-full max-w-md mx-auto">
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full h-auto">
                <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,149.3C960,160,1056,160,1152,138.7C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">How It Works</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">Our quiz system uses advanced algorithms to determine your moral alignment based on your choices.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Take a Quiz</h3>
                    <p class="text-gray-600 dark:text-gray-400">Choose from our selection of personality and scenario-based quizzes designed to test your moral compass.</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-8 text-center">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Answer Questions</h3>
                    <p class="text-gray-600 dark:text-gray-400">Each answer reveals something about your character. Choose wisely - your alignment depends on it!</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Discover Your Alignment</h3>
                    <p class="text-gray-600 dark:text-gray-400">Get your results instantly and see where you fall on the hero-villain spectrum. Share with friends!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Quizzes Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Featured Quizzes</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">Explore our most popular quizzes and discover your true alignment.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Quiz Card 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Moral Dilemmas</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Face challenging ethical scenarios and discover how your choices reveal your true character.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">15 questions</span>
                            <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm font-medium">Take Quiz</a>
                        </div>
                    </div>
                </div>
                
                <!-- Quiz Card 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-red-500 to-orange-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Power & Responsibility</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">What would you do with great power? This quiz explores how you would wield influence.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">12 questions</span>
                            <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm font-medium">Take Quiz</a>
                        </div>
                    </div>
                </div>
                
                <!-- Quiz Card 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-green-500 to-teal-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Justice & Mercy</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Explore the balance between justice and mercy in your decision-making process.</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">10 questions</span>
                            <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm font-medium">Take Quiz</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-12">
                <a href="#" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center font-medium">View All Quizzes</a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">1,000+</div>
                    <div class="text-gray-600 dark:text-gray-400">Quizzes Taken</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">20+</div>
                    <div class="text-gray-600 dark:text-gray-400">Unique Quizzes</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">55%</div>
                    <div class="text-gray-600 dark:text-gray-400">Heroes</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-600 dark:text-red-400 mb-2">45%</div>
                    <div class="text-gray-600 dark:text-gray-400">Villains</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">What Our Users Say</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">Discover how PowerSync has helped people understand themselves better.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                            <span class="text-blue-600 dark:text-blue-400 font-bold">JD</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">John Doe</h3>
                            <div class="flex text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400">"I was surprised to discover I'm more of a hero than I thought! The questions really made me think about my values and how I approach difficult situations."</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center mr-4">
                            <span class="text-purple-600 dark:text-purple-400 font-bold">JS</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Jane Smith</h3>
                            <div class="flex text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400">"The villain result was spot on! I've always been drawn to the complexity of antagonists, and this quiz helped me understand why. Great conversation starter with friends!"</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                            <span class="text-green-600 dark:text-green-400 font-bold">RJ</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Robert Johnson</h3>
                            <div class="flex text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400">"I've taken all the quizzes multiple times and love seeing how my alignment shifts based on my mood and recent experiences. It's like a moral compass check-in!"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Discover Your Alignment?</h2>
            <p class="text-xl text-blue-200 mb-8 max-w-3xl mx-auto">Join thousands of others who have uncovered their true nature through our engaging quizzes.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-white text-blue-900 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900 text-center font-medium">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-blue-900 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900 text-center font-medium">Create Account</a>
                    <a href="{{ route('login') }}" class="px-6 py-3 border border-white text-white rounded-lg hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900 text-center font-medium">Log In</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="text-2xl font-bold text-white mb-4">PowerSync</div>
                    <p class="mb-4">Discover your true alignment through our engaging quizzes and challenges. Are you a hero or villain at heart?</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white">Quizzes</a></li>
                        <li><a href="#" class="hover:text-white">Blog</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                        <li><a href="#" class="hover:text-white">Support</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white">About</a></li>
                        <li><a href="#" class="hover:text-white">Careers</a></li>
                        <li><a href="#" class="hover:text-white">Privacy</a></li>
                        <li><a href="#" class="hover:text-white">Terms</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-sm">
                <p>&copy; {{ date('Y') }} PowerSync. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Dark Mode Toggle Script -->
    <script>
        // Check for dark mode preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</body>
</html>
