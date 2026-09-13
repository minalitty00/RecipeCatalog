@extends('layouts.app')

@section('title', 'Каталог рецептов')

@section('content')
    <div class="row g-4">

        <div class="col-lg-3">
            <div class="filter-sidebar">
                <h5 class="mb-3"><i class="bi bi-funnel-fill" style="color:#ff9a9e;"></i> Фильтры</h5>

                <form method="GET" action="{{ route('recipes.index') }}">
                    <div class="mb-3">
                        <label for="search" class="form-label">🔍 Поиск</label>
                        <input type="text" name="search" id="search" class="form-control"
                               placeholder="Название или ингредиент..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">🏷️ Категория</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">Все категории</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sort" class="form-label">📊 Сортировать</label>
                        <select name="sort" id="sort" class="form-select">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>🆕 Сначала новые</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>📅 Сначала старые</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>⭐ По рейтингу</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-pink btn-search">
                        <i class="bi bi-search"></i> Применить
                    </button>

                    <a href="{{ route('recipes.index') }}" class="btn btn-outline-pink btn-search mt-2 d-block text-center">
                        <i class="bi bi-arrow-counterclockwise"></i> Сбросить
                    </a>
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h4 style="color:#2d2d2d;">
                    <i class="bi bi-grid-3x3-gap-fill" style="color:#ff9a9e;"></i>
                    Рецепты <span class="badge bg-secondary rounded-pill" style="background:#f0e6e6!important; color:#7a4a5a;">{{ $recipes->total() }}</span>
                </h4>
                <span style="color:#999; font-size:0.9rem;">
                Показано {{ $recipes->firstItem() ?? 0 }}–{{ $recipes->lastItem() ?? 0 }} из {{ $recipes->total() }}
            </span>
            </div>

            @if($recipes->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-emoji-frown"></i>
                    <h4>Ничего не найдено 😢</h4>
                    <p>Попробуйте изменить фильтры или поиск</p>
                    <a href="{{ route('recipes.index') }}" class="btn btn-pink">Показать все</a>
                </div>
            @else
                <div class="row g-4">
                    @foreach($recipes as $recipe)
                        @include('recipes.card', ['recipe' => $recipe])
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $recipes->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
