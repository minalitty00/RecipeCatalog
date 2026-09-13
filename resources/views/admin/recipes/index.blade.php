<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Управление рецептами
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Автор</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Категория</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Рейтинг</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Комментарии</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recipes as $recipe)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($recipe->image)
                                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="w-12 h-12 object-cover rounded mr-3">
                                            @else
                                            <div class="w-12 h-12 bg-gray-200 rounded mr-3"></div>
                                            @endif
                                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($recipe->title, 40) }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $recipe->author->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $recipe->category->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($recipe->rating, 1) }} ⭐</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $recipe->comments_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('admin.recipes.toggle-publish', $recipe) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 text-xs font-semibold rounded-full {{ $recipe->is_published ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                                {{ $recipe->is_published ? 'Опубликован' : 'Скрыт' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('recipes.show', $recipe->slug) }}" class="text-blue-600 hover:text-blue-900 mr-3" target="_blank">Открыть</a>
                                        <form action="{{ route('admin.recipes.destroy', $recipe) }}" method="POST" class="inline" onsubmit="return confirm('Вы уверены?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $recipes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
