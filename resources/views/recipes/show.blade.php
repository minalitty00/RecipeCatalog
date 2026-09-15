@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
    <div class="row g-4">
        <!-- Основная колонка -->
        <div class="col-lg-8">
            <!-- ЗАГОЛОВОК РЕЦЕПТА -->
            <h1 class="display-4 fw-bold mb-3" style="color: #2d2d2d;">
                {{ $recipe->title }}
            </h1>

            <!-- Картинка -->
            @if($recipe->image)
                @if(str_starts_with($recipe->image, 'http'))
                    <img src="{{ $recipe->image }}" class="img-fluid rounded-4 w-100 mb-4" alt="{{ $recipe->title }}" style="max-height: 400px; object-fit: cover;">
                @else
                    <img src="{{ asset('storage/' . $recipe->image) }}" class="img-fluid rounded-4 w-100 mb-4" alt="{{ $recipe->title }}" style="max-height: 400px; object-fit: cover;">
                @endif
            @else
                <img src="https://via.placeholder.com/800x400/fecfef/ff9a9e?text=🍳+{{ $recipe->title }}" class="img-fluid rounded-4 w-100 mb-4" alt="{{ $recipe->title }}" style="max-height: 400px; object-fit: cover;">
            @endif

            <!-- Категория и мета -->
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge badge-category">{{ $recipe->category->name ?? 'Без категории' }}</span>
                <span class="badge bg-secondary" style="background: #f0e6e6!important; color:#7a4a5a;">
                <i class="bi bi-clock"></i> {{ $recipe->cooking_time }} мин
            </span>
                <span class="badge bg-secondary" style="background: #f0e6e6!important; color:#7a4a5a;">
                <i class="bi bi-people"></i> {{ $recipe->servings }} порций
            </span>
                <span class="badge bg-secondary" style="background: #f0e6e6!important; color:#7a4a5a;">
                <i class="bi bi-person"></i> {{ $recipe->author->name ?? 'Автор' }}
            </span>
            </div>

            <!-- Сложность -->
            <div class="mb-3">
            <span class="badge bg-{{ $recipe->difficulty === 'легко' ? 'success' : ($recipe->difficulty === 'средне' ? 'warning' : 'danger') }}" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                <i class="bi bi-{{ $recipe->difficulty === 'легко' ? 'emoji-smile' : ($recipe->difficulty === 'средне' ? 'emoji-neutral' : 'emoji-frown') }}"></i>
                Сложность: {{ ucfirst($recipe->difficulty) }}
            </span>
            </div>

            <!-- Описание -->
            <h4>📖 Описание</h4>
            <p class="text-muted" style="font-size: 1.05rem; line-height: 1.8;">{{ $recipe->description }}</p>

            <!-- Ингредиенты -->
            <h4 class="mt-4">🛒 Ингредиенты</h4>
            <div class="table-responsive">
                <table class="table table-bordered" style="border-radius: 16px; overflow: hidden;">
                    <thead style="background: #fecfef;">
                    <tr>
                        <th>Ингредиент</th>
                        <th>Количество</th>
                        <th>Единица</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($recipe->ingredients as $ingredient)
                        <tr>
                            <td>{{ $ingredient->name }}</td>
                            <td>{{ $ingredient->pivot->quantity ?? '—' }}</td>
                            <td>{{ $ingredient->pivot->unit ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted">Ингредиенты не добавлены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Шаги приготовления -->
            <h4 class="mt-4">👨‍🍳 Шаги приготовления</h4>
            <ol class="list-group list-group-numbered" style="border-radius: 16px; overflow: hidden;">
                @forelse($recipe->steps as $step)
                    <li class="list-group-item" style="border: none; border-bottom: 1px solid #f0e6e6; padding: 0.8rem 1.2rem;">
                        {{ $step->description ?? 'Шаг ' . $loop->iteration }}
                    </li>
                @empty
                    <li class="list-group-item text-muted" style="border: none;">Шаги не добавлены</li>
                @endforelse
            </ol>

            <!-- Комментарии -->
            <h4 class="mt-5">💬 Комментарии ({{ $recipe->comments->count() }})</h4>
            
            @auth
                <div class="card mb-4" style="border-radius: 20px;">
                    <div class="card-body">
                        <form action="{{ route('recipes.comment', $recipe->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="comment" class="form-label fw-bold">Оставить комментарий:</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" 
                                          placeholder="Поделитесь своим мнением о рецепте..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-pink">
                                <i class="bi bi-send"></i> Отправить
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info mb-4" style="border-radius: 16px;">
                    <a href="{{ route('login') }}" class="alert-link">Войдите</a>, чтобы оставить комментарий
                </div>
            @endauth

            <!-- Список комментариев -->
            @forelse($recipe->comments()->with('user')->latest()->get() as $comment)
                <div class="card mb-3" style="border-radius: 16px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong>{{ $comment->user->name }}</strong>
                                <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->isAdmin()))
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" 
                                      onsubmit="return confirm('Удалить комментарий?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <p class="mb-0">{{ $comment->body }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-chat-dots" style="font-size: 3rem;"></i>
                    <p class="mt-2">Пока нет комментариев. Будьте первым!</p>
                </div>
            @endforelse
        </div>

        <!-- Правая колонка — рейтинг и действия -->
        <div class="col-lg-4">
            <div class="filter-sidebar">
                <!-- Рейтинг -->
                <h5>⭐ Рейтинг</h5>
                <div class="display-4 fw-bold" style="color: #2d2d2d;">
                    {{ number_format($recipe->rating ?? 0, 1) }}
                </div>
                <div class="stars fs-3">
                    @php
                        $rating = $recipe->rating ?? 0;
                        $full = floor($rating);
                        $half = $rating - $full >= 0.5 ? 1 : 0;
                        $empty = 5 - $full - $half;
                    @endphp
                    @for($i = 0; $i < $full; $i++) <i class="bi bi-star-fill"></i> @endfor
                    @if($half) <i class="bi bi-star-half"></i> @endif
                    @for($i = 0; $i < $empty; $i++) <i class="bi bi-star"></i> @endfor
                </div>
                <div class="text-muted">{{ $recipe->rating_count ?? 0 }} оценок</div>

                <hr>

                <!-- Кнопки действий -->
                @auth
                    <!-- Форма оценки -->
                    <form action="{{ route('recipes.rate', $recipe->id) }}" method="POST" class="mb-3">
                        @csrf
                        <label class="form-label fw-bold">Ваша оценка:</label>
                        <div class="d-flex gap-2 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" class="btn-check" name="rating" id="rating{{ $i }}" value="{{ $i }}" required>
                                <label class="btn btn-outline-warning" for="rating{{ $i }}" style="border-radius: 50%; width: 45px; height: 45px; padding: 0; font-size: 1.2rem;">
                                    {{ $i }}⭐
                                </label>
                            @endfor
                        </div>
                        <button type="submit" class="btn btn-pink w-100">
                            <i class="bi bi-star"></i> Оценить
                        </button>
                    </form>

                    <!-- Избранное -->
                    <form action="{{ route('favorites.toggle', $recipe->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-pink w-100 mb-2">
                            <i class="bi bi-heart"></i> В избранное
                        </button>
                    </form>
                @else
                    <div class="alert alert-info" style="border-radius: 16px;">
                        <a href="{{ route('login') }}" class="alert-link">Войдите</a>, чтобы оценить или добавить в избранное
                    </div>
                @endauth

                @can('update', $recipe)
                    <hr>
                    <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="bi bi-pencil"></i> Редактировать
                    </a>
                    <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Удалить рецепт?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash"></i> Удалить
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
@endsection
