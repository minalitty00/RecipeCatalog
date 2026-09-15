<x-app-layout>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="bi bi-journal-text" style="color: #ff9a9e;"></i> Мои рецепты
            </h2>
            <a href="{{ route('recipes.create') }}" class="btn btn-pink">
                <i class="bi bi-plus-circle"></i> Создать рецепт
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($recipes->count() > 0)
            <div class="card" style="border-radius: 20px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Рецепт</th>
                                    <th>Категория</th>
                                    <th>Рейтинг</th>
                                    <th>Комментарии</th>
                                    <th>Статус</th>
                                    <th>Дата</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recipes as $recipe)
                                    <tr>
                                        <td>
                                            <strong>{{ $recipe->title }}</strong>
                                            @if($recipe->image)
                                                <br><small class="text-muted"><i class="bi bi-image"></i> Есть фото</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $recipe->category->name ?? 'Без категории' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-star-fill"></i> {{ number_format($recipe->ratings->avg('rating') ?? 0, 1) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $recipe->comments->count() }}</span>
                                        </td>
                                        <td>
                                            @if($recipe->is_published)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> Опубликован
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bi bi-hourglass-split"></i> На модерации
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $recipe->created_at->format('d.m.Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('recipes.show', $recipe->slug) }}" class="btn btn-sm btn-outline-info" target="_blank">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Удалить рецепт?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 d-flex justify-content-center">
                {{ $recipes->links() }}
            </div>
        @else
            <div class="card text-center" style="border-radius: 20px; padding: 3rem;">
                <div class="card-body">
                    <i class="bi bi-journal-x" style="font-size: 4rem; color: #aaa;"></i>
                    <h4 class="mt-3">У вас пока нет рецептов</h4>
                    <p class="text-muted">Создайте свой первый рецепт и поделитесь им с другими!</p>
                    <a href="{{ route('recipes.create') }}" class="btn btn-pink mt-3">
                        <i class="bi bi-plus-circle"></i> Создать рецепт
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
