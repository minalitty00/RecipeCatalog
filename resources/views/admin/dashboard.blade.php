<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-speedometer2" style="color: #ff9a9e;"></i> Админ-панель</h2>
        </div>

        <!-- Статистика -->
        <div class="row g-4 mb-4">
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card" style="border-radius: 20px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Пользователей</p>
                                <h3 class="fw-bold mb-0">{{ $stats['totalUsers'] }}</h3>
                            </div>
                            <i class="bi bi-people-fill" style="font-size: 2.5rem; color: #0d6efd;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card" style="border-radius: 20px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Рецептов</p>
                                <h3 class="fw-bold mb-0">{{ $stats['totalRecipes'] }}</h3>
                                <small class="text-muted">Опубликовано: {{ $stats['publishedRecipes'] }}</small>
                            </div>
                            <i class="bi bi-book-fill" style="font-size: 2.5rem; color: #198754;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card" style="border-radius: 20px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Комментариев</p>
                                <h3 class="fw-bold mb-0">{{ $stats['totalComments'] }}</h3>
                            </div>
                            <i class="bi bi-chat-dots-fill" style="font-size: 2.5rem; color: #6f42c1;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card" style="border-radius: 20px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Средний рейтинг</p>
                                <h3 class="fw-bold mb-0">{{ $stats['averageRating'] }}</h3>
                            </div>
                            <i class="bi bi-star-fill" style="font-size: 2.5rem; color: #ffc107;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Быстрые ссылки -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <div class="card text-center h-100" style="border-radius: 20px; transition: 0.3s;">
                        <div class="card-body">
                            <i class="bi bi-people-fill mb-3" style="font-size: 3rem; color: #0d6efd;"></i>
                            <h5 class="card-title">Пользователи</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.recipes.index') }}" class="text-decoration-none">
                    <div class="card text-center h-100" style="border-radius: 20px; transition: 0.3s;">
                        <div class="card-body">
                            <i class="bi bi-book-fill mb-3" style="font-size: 3rem; color: #198754;"></i>
                            <h5 class="card-title">Рецепты</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.comments.index') }}" class="text-decoration-none">
                    <div class="card text-center h-100" style="border-radius: 20px; transition: 0.3s;">
                        <div class="card-body">
                            <i class="bi bi-chat-dots-fill mb-3" style="font-size: 3rem; color: #6f42c1;"></i>
                            <h5 class="card-title">Комментарии</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.ingredients.index') }}" class="text-decoration-none">
                    <div class="card text-center h-100" style="border-radius: 20px; transition: 0.3s;">
                        <div class="card-body">
                            <i class="bi bi-basket-fill mb-3" style="font-size: 3rem; color: #fd7e14;"></i>
                            <h5 class="card-title">Ингредиенты</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Последние рецепты -->
        <div class="card mb-4" style="border-radius: 20px;">
            <div class="card-body">
                <h5 class="card-title mb-4"><i class="bi bi-clock-history" style="color: #ff9a9e;"></i> Последние рецепты</h5>
                <div class="list-group list-group-flush">
                    @foreach($latestRecipes as $recipe)
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 border-bottom">
                        <div>
                            <a href="{{ route('recipes.show', $recipe->slug) }}" class="fw-semibold text-decoration-none">
                                {{ $recipe->title }}
                            </a>
                            <p class="text-muted small mb-0">Автор: {{ $recipe->author->name }}</p>
                        </div>
                        <span class="badge {{ $recipe->is_published ? 'bg-success' : 'bg-secondary' }}">
                            {{ $recipe->is_published ? 'Опубликован' : 'Черновик' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Последние пользователи -->
        <div class="card" style="border-radius: 20px;">
            <div class="card-body">
                <h5 class="card-title mb-4"><i class="bi bi-person-plus" style="color: #ff9a9e;"></i> Последние пользователи</h5>
                <div class="list-group list-group-flush">
                    @foreach($latestUsers as $user)
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 border-bottom">
                        <div>
                            <p class="fw-semibold mb-0">{{ $user->name }}</p>
                            <p class="text-muted small mb-0">{{ $user->email }}</p>
                        </div>
                        <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                            {{ $user->role === 'admin' ? 'Админ' : 'Пользователь' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
