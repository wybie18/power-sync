@extends('layouts.admin-dashboard-layout')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">User Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Edit User
                </a>
                @if(Auth::id() !== $user->id)
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirm('Are you sure you want to delete this user?')">
                            Delete User
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-6 border-b dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">User Information</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->email }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</h3>
                        <p class="mt-1">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Joined</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->updated_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-6 border-b dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Quiz Results</h2>
                </div>
                <div class="p-6">
                    @if($user->quizResults && $user->quizResults->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quiz</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Alignment</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($user->quizResults as $result)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $result->quiz->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $result->total_score }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $result->alignment === 'hero' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                {{ ucfirst($result->alignment) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $result->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500 dark:text-gray-400">This user hasn't taken any quizzes yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">&larr; Back to Users</a>
    </div>
@endsection