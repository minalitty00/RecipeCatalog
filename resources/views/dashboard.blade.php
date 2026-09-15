<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card" style="border-radius: 20px;">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-house-heart" style="font-size: 4rem; color: #ff9a9e;"></i>
                        <h2 class="mt-3">Добро пожаловать!</h2>
                        <p class="text-muted mb-4">Вы успешно вошли в систему</p>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="{{ route('recipes.index') }}" class="btn btn-outline-pink w-100">
                                    <i class="bi bi-book"></i><br>
                                    <small>Каталог рецептов</small>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('recipes.create') }}" class="btn btn-pink w-100">
                                    <i class="bi bi-plus-circle"></i><br>
                                    <small>Создать рецепт</small>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('my-recipes.index') }}" class="btn btn-outline-pink w-100">
                                    <i class="bi bi-journal"></i><br>
                                    <small>Мои рецепты</small>
                                </a>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <a href="{{ route('favorites.index') }}" class="btn btn-outline-pink w-100">
                                    <i class="bi bi-heart"></i><br>
                                    <small>Избранное</small>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-pink w-100">
                                    <i class="bi bi-person-circle"></i><br>
                                    <small>Профиль</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
