@extends('layouts.user-dashboard-layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Leaderboard</h1>
        <p class="text-gray-600 dark:text-gray-400">See how you rank against other users</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
        <div class="p-4 border-b dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">Filter Leaderboard</h2>
        </div>
        <div class="p-4">
            <form action="{{ route('user.leaderboard') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="quiz_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quiz</label>
                    <select name="quiz_id" id="quiz_id"
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Quizzes</option>
                        @foreach ($quizzes as $quiz)
                            <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                                {{ $quiz->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="element"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Element</label>
                    <select name="element" id="element"
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Elements</option>
                        <option value="air" {{ request('element') == 'air' ? 'selected' : '' }}>Air</option>
                        <option value="fire" {{ request('element') == 'fire' ? 'selected' : '' }}>Fire</option>
                        <option value="water" {{ request('element') == 'water' ? 'selected' : '' }}>Water</option>
                        <option value="earth" {{ request('element') == 'earth' ? 'selected' : '' }}>Earth</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="time_period" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Time
                        Period</label>
                    <select name="time_period" id="time_period"
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Time</option>
                        <option value="this_week" {{ request('time_period') == 'this_week' ? 'selected' : '' }}>This Week
                        </option>
                        <option value="this_month" {{ request('time_period') == 'this_month' ? 'selected' : '' }}>This Month
                        </option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Filter
                    </button>
                    @if (request()->hasAny(['quiz_id', 'element', 'time_period']))
                        <a href="{{ route('user.leaderboard') }}"
                            class="ml-2 px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Leaderboard Tabs -->
    <div x-data="{ activeTab: 'all' }" class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="border-b dark:border-gray-700">
            <nav class="flex -mb-px">
                <button @click="activeTab = 'all'"
                    :class="{ 'border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'all', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': activeTab !== 'all' }"
                    class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                    All Elements
                </button>
                <button @click="activeTab = 'air'"
                    :class="{ 'border-blue-500 text-blue-600 dark:text-blue-400': activeTab === 'air', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': activeTab !== 'air' }"
                    class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                    Air
                </button>
                <button @click="activeTab = 'fire'"
                    :class="{ 'border-red-500 text-red-600 dark:text-red-400': activeTab === 'fire', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': activeTab !== 'fire' }"
                    class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                    Fire
                </button>
                <button @click="activeTab = 'water'"
                    :class="{ 'border-cyan-500 text-cyan-600 dark:text-cyan-400': activeTab === 'water', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': activeTab !== 'water' }"
                    class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                    Water
                </button>
                <button @click="activeTab = 'earth'"
                    :class="{ 'border-green-500 text-green-600 dark:text-green-400': activeTab === 'earth', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600': activeTab !== 'earth' }"
                    class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                    Earth
                </button>
            </nav>
        </div>

        <!-- All Users Tab -->
        <div x-show="activeTab === 'all'" class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Top Benders</h3>
            @if (count($allUsers) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Rank</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    User</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Quizzes</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Power</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Experience</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($allUsers as $index => $user)
                                <tr class="{{ $user->id === Auth::id() ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                        @if ($user->id === Auth::id())
                                            <span class="ml-2 text-xs text-blue-600 dark:text-blue-400">(You)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->quizzes_taken }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if ($user->power === 'air') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                            @elseif($user->power === 'fire')
                                                bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @elseif($user->power === 'water')
                                                bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-200
                                            @elseif($user->power === 'earth')
                                                bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @else
                                                bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                            {{ ucfirst($user->power ?? 'Unknown') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->exp ?? 0 }} XP
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No data available.</p>
            @endif
        </div>

        <!-- Air Users Tab -->
        <div x-show="activeTab === 'air'" class="p-6">
            <h3 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-4">Top Air Benders</h3>
            @if (count($airUsers) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Rank</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    User</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Quizzes</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Experience</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($airUsers as $index => $user)
                                <tr class="{{ $user->id === Auth::id() ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                        @if ($user->id === Auth::id())
                                            <span class="ml-2 text-xs text-blue-600 dark:text-blue-400">(You)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->quizzes_taken }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->exp ?? 0 }} XP
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No Air Benders found.</p>
            @endif
        </div>

        <!-- Fire Users Tab -->
        <div x-show="activeTab === 'fire'" class="p-6">
            <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-4">Top Fire Benders</h3>
            @if (count($fireUsers) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Rank</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    User</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Quizzes</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Experience</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($fireUsers as $index => $user)
                                <tr class="{{ $user->id === Auth::id() ? 'bg-red-50 dark:bg-red-900/20' : '' }}">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                        @if ($user->id === Auth::id())
                                            <span class="ml-2 text-xs text-red-600 dark:text-red-400">(You)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->quizzes_taken }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->exp ?? 0 }} XP
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No Fire Benders found.</p>
            @endif
        </div>

        <!-- Water Users Tab -->
        <div x-show="activeTab === 'water'" class="p-6">
            <h3 class="text-lg font-semibold text-cyan-600 dark:text-cyan-400 mb-4">Top Water Benders</h3>
            @if (count($waterUsers) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Rank</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    User</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Quizzes</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Experience</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($waterUsers as $index => $user)
                                <tr class="{{ $user->id === Auth::id() ? 'bg-cyan-50 dark:bg-cyan-900/20' : '' }}">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                        @if ($user->id === Auth::id())
                                            <span class="ml-2 text-xs text-cyan-600 dark:text-cyan-400">(You)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->quizzes_taken }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->exp ?? 0 }} XP
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No Water Benders found.</p>
            @endif
        </div>

        <!-- Earth Users Tab -->
        <div x-show="activeTab === 'earth'" class="p-6">
            <h3 class="text-lg font-semibold text-green-600 dark:text-green-400 mb-4">Top Earth Benders</h3>
            @if (count($earthUsers) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Rank</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    User</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Quizzes</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Experience</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($earthUsers as $index => $user)
                                <tr class="{{ $user->id === Auth::id() ? 'bg-green-50 dark:bg-green-900/20' : '' }}">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                        @if ($user->id === Auth::id())
                                            <span class="ml-2 text-xs text-green-600 dark:text-green-400">(You)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->quizzes_taken }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->exp ?? 0 }} XP
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No Earth Benders found.</p>
            @endif
        </div>
    </div>
@endsection
