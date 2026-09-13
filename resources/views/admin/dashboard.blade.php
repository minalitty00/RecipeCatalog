<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🛠️ Админ-панель
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Статистика -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Пользователей</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['totalUsers'] }}</p>
                            </div>
                            <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Рецептов</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['totalRecipes'] }}</p>
                                <p class="text-xs text-gray-500">Опубликовано: {{ $stats['publishedRecipes'] }}</p>
                            </div>
                            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Комментариев</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['totalComments'] }}</p>
                            </div>
                            <svg class="w-12 h-12 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Средний рейтинг</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['averageRating'] }}</p>
                            </div>
                            <svg class="w-12 h-12 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Быстрые ссылки -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <a href="{{ route('admin.users.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">Пользователи</h3>
                    </div>
                </a>

                <a href="{{ route('admin.recipes.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">Рецепты</h3>
                    </div>
                </a>

                <a href="{{ route('admin.comments.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">Комментарии</h3>
                    </div>
                </a>

                <a href="{{ route('admin.ingredients.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">Ингредиенты</h3>
                    </div>
                </a>
            </div>

            <!-- Последние рецепты -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Последние рецепты</h3>
                    <div class="space-y-3">
                        @foreach($latestRecipes as $recipe)
                        <div class="flex items-center justify-between border-b pb-3">
                            <div>
                                <a href="{{ route('recipes.show', $recipe->slug) }}" class="font-semibold text-gray-900 hover:text-blue-600">
                                    {{ $recipe->title }}
                                </a>
                                <p class="text-sm text-gray-600">Автор: {{ $recipe->author->name }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $recipe->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $recipe->is_published ? 'Опубликован' : 'Черновик' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Последние пользователи -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Последние пользователи</h3>
                    <div class="space-y-3">
                        @foreach($latestUsers as $user)
                        <div class="flex items-center justify-between border-b pb-3">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $user->role === 'admin' ? 'Админ' : 'Пользователь' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
