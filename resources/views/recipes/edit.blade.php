<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h2 class="mb-4">
                            <i class="bi bi-pencil" style="color: #ff9a9e;"></i> Редактировать рецепт
                        </h2>

                        <form action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Название рецепта *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" value="{{ old('title', $recipe->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Описание *</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="4" required>{{ old('description', $recipe->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Категория *</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                                id="category_id" name="category_id" required>
                                            <option value="">Выберите категорию</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $recipe->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="difficulty" class="form-label">Сложность *</label>
                                        <select class="form-select @error('difficulty') is-invalid @enderror" 
                                                id="difficulty" name="difficulty" required>
                                            <option value="">Выберите сложность</option>
                                            <option value="easy" {{ old('difficulty', $recipe->difficulty) == 'easy' ? 'selected' : '' }}>Легко</option>
                                            <option value="medium" {{ old('difficulty', $recipe->difficulty) == 'medium' ? 'selected' : '' }}>Средне</option>
                                            <option value="hard" {{ old('difficulty', $recipe->difficulty) == 'hard' ? 'selected' : '' }}>Сложно</option>
                                        </select>
                                        @error('difficulty')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="cooking_time" class="form-label">Время (мин) *</label>
                                        <input type="number" class="form-control @error('cooking_time') is-invalid @enderror" 
                                               id="cooking_time" name="cooking_time" value="{{ old('cooking_time', $recipe->cooking_time) }}" min="1" required>
                                        @error('cooking_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="servings" class="form-label">Порций *</label>
                                        <input type="number" class="form-control @error('servings') is-invalid @enderror" 
                                               id="servings" name="servings" value="{{ old('servings', $recipe->servings) }}" min="1" required>
                                        @error('servings')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="image_url" class="form-label">URL изображения</label>
                                        
                                        @if($recipe->image)
                                            <div class="mb-2">
                                                <small class="text-muted">Текущее изображение:</small><br>
                                                @if(str_starts_with($recipe->image, 'http'))
                                                    <img src="{{ $recipe->image }}" class="img-thumbnail" style="max-height: 150px;" alt="Текущее изображение">
                                                @else
                                                    <img src="{{ asset('storage/' . $recipe->image) }}" class="img-thumbnail" style="max-height: 150px;" alt="Текущее изображение">
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                                               id="image_url" name="image_url" 
                                               value="{{ old('image_url', str_starts_with($recipe->image ?? '', 'http') ? $recipe->image : '') }}" 
                                               placeholder="https://example.com/image.jpg">
                                        <small class="text-muted">Введите ссылку на изображение или оставьте пустым</small>
                                        @error('image_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h4 class="mb-3"><i class="bi bi-egg" style="color: #ff9a9e;"></i> Ингредиенты</h4>
                            <div id="ingredients-container">
                                @foreach($recipe->ingredients as $index => $ingredient)
                                <div class="ingredient-row mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <select class="form-select" name="ingredients[{{ $index }}][ingredient_id]" required>
                                                <option value="">Выберите ингредиент</option>
                                                @foreach($ingredients as $ing)
                                                    <option value="{{ $ing->id }}" {{ $ingredient->id == $ing->id ? 'selected' : '' }}>
                                                        {{ $ing->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" step="0.01" class="form-control" 
                                                   name="ingredients[{{ $index }}][quantity]" 
                                                   value="{{ $ingredient->pivot->quantity }}" 
                                                   placeholder="Количество" required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" 
                                                   name="ingredients[{{ $index }}][unit]" 
                                                   value="{{ $ingredient->pivot->unit }}" 
                                                   placeholder="Ед. измерения" required>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm remove-ingredient">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-pink mt-2" id="add-ingredient">
                                <i class="bi bi-plus"></i> Добавить ингредиент
                            </button>

                            <hr class="my-4">

                            <h4 class="mb-3"><i class="bi bi-list-ol" style="color: #ff9a9e;"></i> Шаги приготовления</h4>
                            <div id="steps-container">
                                @foreach($recipe->steps as $index => $step)
                                <div class="step-row mb-3">
                                    <label class="form-label">Шаг {{ $index + 1 }}</label>
                                    <div class="d-flex gap-2">
                                        <textarea class="form-control" name="steps[{{ $index }}][description]" rows="2" required>{{ $step->description }}</textarea>
                                        <button type="button" class="btn btn-danger btn-sm remove-step">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-pink mt-2" id="add-step">
                                <i class="bi bi-plus"></i> Добавить шаг
                            </button>

                            <hr class="my-4">

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-pink">
                                    <i class="bi bi-check-circle"></i> Сохранить изменения
                                </button>
                                <a href="{{ route('my-recipes.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Отмена
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let ingredientIndex = {{ count($recipe->ingredients) }};
        let stepIndex = {{ count($recipe->steps) + 1 }};

        document.getElementById('add-ingredient').addEventListener('click', function() {
            const container = document.getElementById('ingredients-container');
            const newRow = document.createElement('div');
            newRow.className = 'ingredient-row mb-2';
            newRow.innerHTML = `
                <div class="row">
                    <div class="col-md-5">
                        <select class="form-select" name="ingredients[${ingredientIndex}][ingredient_id]" required>
                            <option value="">Выберите ингредиент</option>
                            @foreach($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" class="form-control" name="ingredients[${ingredientIndex}][quantity]" 
                               placeholder="Количество" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="ingredients[${ingredientIndex}][unit]" 
                               placeholder="Ед. измерения" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-ingredient">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(newRow);
            ingredientIndex++;
            updateRemoveButtons();
        });

        document.getElementById('add-step').addEventListener('click', function() {
            const container = document.getElementById('steps-container');
            const newRow = document.createElement('div');
            newRow.className = 'step-row mb-3';
            newRow.innerHTML = `
                <label class="form-label">Шаг ${stepIndex}</label>
                <div class="d-flex gap-2">
                    <textarea class="form-control" name="steps[${stepIndex - 1}][description]" rows="2" required></textarea>
                    <button type="button" class="btn btn-danger btn-sm remove-step">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
            stepIndex++;
            updateRemoveButtons();
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-ingredient')) {
                e.target.closest('.ingredient-row').remove();
                updateRemoveButtons();
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-step')) {
                e.target.closest('.step-row').remove();
                updateStepNumbers();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const ingredientRows = document.querySelectorAll('.ingredient-row');
            const stepRows = document.querySelectorAll('.step-row');
            
            ingredientRows.forEach((row, index) => {
                const btn = row.querySelector('.remove-ingredient');
                btn.disabled = ingredientRows.length === 1;
            });

            stepRows.forEach((row, index) => {
                const btn = row.querySelector('.remove-step');
                btn.disabled = stepRows.length === 1;
            });
        }

        function updateStepNumbers() {
            const stepRows = document.querySelectorAll('.step-row');
            stepRows.forEach((row, index) => {
                row.querySelector('label').textContent = `Шаг ${index + 1}`;
            });
            stepIndex = stepRows.length + 1;
        }

        updateRemoveButtons();
    </script>
    @endpush
</x-app-layout>
