<x-app-layout>
    <div class="container py-5">
        <h2 class="mb-4">
            <i class="bi bi-person-circle" style="color: #ff9a9e;"></i> Личный кабинет
        </h2>

        <!-- Информация профиля -->
        <div class="card mb-4" style="border-radius: 20px;">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">
                    <i class="bi bi-info-circle"></i> Информация профиля
                </h5>
                <p class="text-muted small mb-4">Обновите информацию вашего аккаунта</p>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Имя</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="alert alert-warning mt-2">
                                <small>Ваш email не подтверждён.</small>
                                <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link btn-sm p-0">
                                        Отправить письмо повторно
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-pink">
                        <i class="bi bi-save"></i> Сохранить
                    </button>

                    @if (session('status') === 'profile-updated')
                        <span class="text-success ms-2">
                            <i class="bi bi-check-circle"></i> Сохранено!
                        </span>
                    @endif
                </form>
            </div>
        </div>

        <!-- Смена пароля -->
        <div class="card mb-4" style="border-radius: 20px;">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">
                    <i class="bi bi-key"></i> Смена пароля
                </h5>
                <p class="text-muted small mb-4">Убедитесь, что ваш пароль надёжный</p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Текущий пароль</label>
                        <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Новый пароль</label>
                        <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-pink">
                        <i class="bi bi-key"></i> Обновить пароль
                    </button>

                    @if (session('status') === 'password-updated')
                        <span class="text-success ms-2">
                            <i class="bi bi-check-circle"></i> Пароль обновлён!
                        </span>
                    @endif
                </form>
            </div>
        </div>

        <!-- Удаление аккаунта -->
        <div class="card" style="border-radius: 20px; border: 2px solid #dc3545;">
            <div class="card-body p-4">
                <h5 class="card-title mb-3 text-danger">
                    <i class="bi bi-exclamation-triangle"></i> Удаление аккаунта
                </h5>
                <p class="text-muted small mb-4">
                    После удаления аккаунта все данные будут безвозвратно удалены.
                </p>

                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="bi bi-trash"></i> Удалить аккаунт
                </button>
            </div>
        </div>
    </div>

    <!-- Modal для удаления аккаунта -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h5 class="modal-title">Удалить аккаунт?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    
                    <div class="modal-body">
                        <p>Вы уверены, что хотите удалить свой аккаунт? Все данные будут безвозвратно удалены.</p>
                        
                        <div class="mb-3">
                            <label for="password_delete" class="form-label">Введите пароль для подтверждения:</label>
                            <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                   id="password_delete" name="password" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-danger">Удалить аккаунт</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
