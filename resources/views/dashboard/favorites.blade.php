<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Избранные рецепты
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($favorites->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($favorites as $favorite)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <a href="{{ route('recipes.show', $favorite->recipe->slug) }}">
                        @if($favorite->recipe->image)
                        <img src="{{ asset('storage/' . $favorite->recipe->image) }}" alt="{{ $favorite->recipe->title }}" class="w-full h-48 object-cover">
                        @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif
                    </a>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            <a href="{{ route('recipes.show', $favorite->recipe->slug) }}" class="hover:text-blue-600">
                                {{ $favorite->recipe->title }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($favorite->recipe->description, 100) }}</p>
                        
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                            <span>{{ $favorite->recipe->category->name ?? 'Без категории' }}</span>
                            <span>⭐ {{ number_format($favorite->recipe->rating, 1) }}</span>
                        </div>
                        
                        <form action="{{ route('favorites.toggle', $favorite->recipe->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition">
                                ❤️ Удалить из избранного
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $favorites->links() }}
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                    <p class="text-gray-600 text-lg mb-4">У вас пока нет избранных рецептов</p>
                    <a href="{{ route('recipes.index') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded">
                        Посмотреть рецепты
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
