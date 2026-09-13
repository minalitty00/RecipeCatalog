<div class="col-md-6 col-xl-4">
    <div class="card card-recipe h-100">
        @if($recipe->image)
            <img src="{{ $recipe->image }}" class="card-img-top" alt="{{ $recipe->title }}">
        @else
            <img src="https://via.placeholder.com/600x400/fecfef/ff9a9e?text=🍳+Recipe" class="card-img-top" alt="placeholder">
        @endif

        <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge badge-category">{{ $recipe->category->name ?? 'Без категории' }}</span>
                <span class="recipe-meta">
                    <i class="bi bi-clock"></i> {{ $recipe->cooking_time }} мин
                </span>
            </div>

            <h5 class="card-title">{{ $recipe->title }}</h5>

            <p class="recipe-meta mb-2">
                <i class="bi bi-person"></i> {{ $recipe->author->name ?? 'Автор' }}
            </p>

            <!-- Рейтинг звёздами -->
            <div class="mb-2">
                @php
                    $rating = $recipe->rating ?? 0;
                    $full = floor($rating);
                    $half = $rating - $full >= 0.5 ? 1 : 0;
                    $empty = 5 - $full - $half;
                @endphp

                <span class="stars">
                    @for($i = 0; $i < $full; $i++) <i class="bi bi-star-fill"></i> @endfor
                    @if($half) <i class="bi bi-star-half"></i> @endif
                    @for($i = 0; $i < $empty; $i++) <i class="bi bi-star"></i> @endfor
                </span>
                <span style="font-size:0.8rem; color:#999;">
                    {{ number_format($rating, 1) }} ({{ $recipe->rating_count ?? 0 }})
                </span>
            </div>

            <div class="mt-auto pt-2">
                <a href="{{ route('recipes.show', $recipe->slug) }}" class="btn btn-pink w-100">
                    <i class="bi bi-eye"></i> Смотреть рецепт
                </a>
            </div>
        </div>
    </div>
</div>
