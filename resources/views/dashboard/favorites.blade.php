<x-app-layout>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="bi bi-heart-fill" style="color: #ff9a9e;"></i> Избранные рецепты
            </h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($favorites->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($favorites as $favorite)
                    <div class="col">
                        <div class="card h-100 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                            <a href="{{ route('recipes.show', $favorite->recipe->slug) }}" class="text-decoration-none">
                                @if($favorite->recipe->image)
                                    @if(str_starts_with($favorite->recipe->image, 'http'))
                                        <img src="{{ $favorite->recipe->image }}" 
                                             alt="{{ $favorite->recipe->title }}" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('storage/' . $favorite->recipe->image) }}" 
                                             alt="{{ $favorite->recipe->title }}" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover;">
                                    @endif
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                                    </div>
                                @endif
                            </a>
                            
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('recipes.show', $favorite->recipe->slug) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $favorite->recipe->title }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted small">
                                    {{ Str::limit($favorite->recipe->description, 100) }}
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-secondary">
                                        {{ $favorite->recipe->category->name ?? 'Без категории' }}
                                    </span>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-star-fill"></i> 
                                        {{ number_format($favorite->recipe->ratings->avg('rating') ?? 0, 1) }}
                                    </span>
                                </div>
                                
                                <form action="{{ route('favorites.toggle', $favorite->recipe->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="bi bi-heart-fill"></i> Удалить из избранного
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4 d-flex justify-content-center">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="card text-center" style="border-radius: 20px; padding: 3rem;">
                <div class="card-body">
                    <i class="bi bi-heart" style="font-size: 4rem; color: #aaa;"></i>
                    <h4 class="mt-3">У вас пока нет избранных рецептов</h4>
                    <p class="text-muted">Добавьте понравившиеся рецепты в избранное!</p>
                    <a href="{{ route('recipes.index') }}" class="btn btn-pink mt-3">
                        <i class="bi bi-book"></i> Посмотреть рецепты
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
