<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Рецептики'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Милые кастомные стили поверх Breeze */
        body {
            background: #fdf8f4;
            font-family: 'Figtree', sans-serif;
        }

        /* Стили для навбара Breeze — делаем розовым */
        .navbar-custom {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%) !important;
            box-shadow: 0 4px 15px rgba(255, 154, 158, 0.3) !important;
        }

        .navbar-custom .navbar-brand {
            font-weight: 700;
            color: #fff !important;
            font-size: 1.6rem;
        }

        .navbar-custom .navbar-brand i {
            color: #fff;
            margin-right: 8px;
        }

        .navbar-custom .nav-link {
            color: #fff !important;
            font-weight: 500;
            transition: 0.3s;
            padding: 0.5rem 1rem;
            border-radius: 10px;
        }

        .navbar-custom .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
            text-shadow: 0 2px 10px rgba(255,255,255,0.4);
        }

        .navbar-custom .nav-link.active {
            background: rgba(255, 255, 255, 0.3);
            font-weight: 700;
        }

        .navbar-custom .dropdown-menu {
            background: #fff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        .navbar-custom .dropdown-item:hover {
            background: #fecfef;
            color: #7a4a5a;
            border-radius: 8px;
        }

        /* Карточки рецептов */
        .card-recipe {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: 0.4s;
            background: #fff;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        }

        .card-recipe:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 50px rgba(255, 154, 158, 0.2);
        }

        .card-recipe .card-img-top {
            height: 220px;
            object-fit: cover;
        }

        .card-recipe .card-body {
            padding: 1.5rem;
        }

        .card-recipe .card-title {
            font-weight: 700;
            font-size: 1.15rem;
            color: #2d2d2d;
        }

        .badge-category {
            background: #fecfef;
            color: #7a4a5a;
            font-weight: 600;
            padding: 0.4rem 1rem;
            border-radius: 30px;
        }

        /* Звёзды */
        .stars {
            color: #ffc107;
            font-size: 0.9rem;
            letter-spacing: 2px;
        }

        .stars .bi-star {
            color: #e4e5e9;
        }

        .recipe-meta {
            color: #999;
            font-size: 0.85rem;
        }

        .recipe-meta i {
            margin-right: 4px;
        }

        /* Кнопки в навбаре */
        .navbar-custom .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.5);
            color: #fff;
            font-weight: 600;
        }

        .navbar-custom .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: #fff;
            color: #fff;
        }

        .navbar-custom .btn-light {
            background: #fff;
            color: #ff9a9e;
            font-weight: 600;
            border: none;
        }

        .navbar-custom .btn-light:hover {
            background: #fff;
            color: #f58086;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.4);
        }

        /* Кнопка розовая */
        .btn-pink {
            background: #ff9a9e;
            color: #fff;
            border: none;
            transition: 0.3s;
            border-radius: 30px;
            padding: 0.6rem 1.5rem;
        }

        .btn-pink:hover {
            background: #f58086;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 154, 158, 0.4);
        }

        .btn-outline-pink {
            border: 2px solid #ff9a9e;
            color: #ff9a9e;
            background: transparent;
            border-radius: 30px;
            padding: 0.6rem 1.5rem;
            transition: 0.3s;
        }

        .btn-outline-pink:hover {
            background: #ff9a9e;
            color: #fff;
            transform: translateY(-2px);
        }

        /* Пагинация */
        .pagination .page-link {
            color: #ff9a9e;
            border-radius: 30px;
            border: none;
            margin: 0 4px;
            padding: 0.5rem 1rem;
        }

        .pagination .page-item.active .page-link {
            background: #ff9a9e;
            color: #fff;
        }

        .pagination .page-link:hover {
            background: #fecfef;
            color: #7a4a5a;
        }

        /* Фильтры */
        .filter-sidebar {
            background: #fff;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.04);
            position: sticky;
            top: 20px;
        }

        .filter-sidebar .form-label {
            font-weight: 600;
            color: #2d2d2d;
        }

        .filter-sidebar .form-select,
        .filter-sidebar .form-control {
            border-radius: 30px;
            border: 2px solid #f0e6e6;
            padding: 0.6rem 1.2rem;
        }

        .filter-sidebar .form-select:focus,
        .filter-sidebar .form-control:focus {
            border-color: #ff9a9e;
            box-shadow: 0 0 0 0.25rem rgba(255, 154, 158, 0.2);
        }

        .filter-sidebar .btn-search {
            border-radius: 30px;
            padding: 0.6rem 2rem;
            width: 100%;
        }

        /* Пустое состояние */
        .empty-state {
            text-align: center;
            padding: 4rem 0;
        }

        .empty-state i {
            font-size: 4rem;
            color: #fecfef;
        }

        .empty-state h4 {
            color: #2d2d2d;
            margin-top: 1rem;
        }

        .empty-state p {
            color: #999;
        }

        /* Адаптация Breeze под розовую тему */
        .bg-gray-100 {
            background: #fdf8f4 !important;
        }

        .bg-white {
            background: #fff !important;
        }

        /* Исправляем стандартные кнопки Breeze */
        .btn-primary {
            background: #ff9a9e !important;
            border-color: #ff9a9e !important;
            border-radius: 30px !important;
            padding: 0.6rem 1.5rem !important;
        }

        .btn-primary:hover {
            background: #f58086 !important;
            border-color: #f58086 !important;
        }

        .btn-secondary {
            border-radius: 30px !important;
        }

        /* Формы */
        .form-control:focus, .form-select:focus {
            border-color: #ff9a9e !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 154, 158, 0.2) !important;
        }

        /* Аватарка в навбаре */
        .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ff9a9e;
            font-weight: 700;
            font-size: 1rem;
        }

        /* Медиа для мобилок */
        @media (max-width: 768px) {
            .filter-sidebar {
                position: relative;
                top: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    <!-- Навбар с милым дизайном -->
    <nav class="navbar-custom" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 2rem;">
        <div style="display: flex; align-items: center; gap: 2rem;">
            <a class="navbar-brand" href="{{ route('recipes.index') }}" style="text-decoration: none; margin: 0;">
                <i class="bi bi-heart-fill"></i> Рецептики
            </a>
            
            <div style="display: flex; gap: 1rem;">
                <a class="nav-link {{ request()->routeIs('recipes.index') ? 'active' : '' }}" href="{{ route('recipes.index') }}">
                    <i class="bi bi-house"></i> Каталог
                </a>

                @auth
                    <a class="nav-link {{ request()->routeIs('recipes.create') ? 'active' : '' }}" href="{{ route('recipes.create') }}">
                        <i class="bi bi-plus-circle"></i> Создать рецепт
                    </a>
                    <a class="nav-link {{ request()->routeIs('my-recipes.*') ? 'active' : '' }}" href="{{ route('my-recipes.index') }}">
                        <i class="bi bi-journal"></i> Мои рецепты
                    </a>
                    <a class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}" href="{{ route('favorites.index') }}">
                        <i class="bi bi-heart"></i> Избранное
                    </a>

                    @if(Auth::user()->isAdmin())
                        <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-shield-lock"></i> Админ-панель
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <div style="display: flex; gap: 0.5rem; align-items: center;">
            @auth
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" style="cursor: pointer;">
                        <span class="avatar-circle">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person"></i> Профиль
                            </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right"></i> Выйти
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a class="btn btn-outline-light" href="{{ route('login') }}" style="border-radius: 20px; padding: 0.5rem 1.5rem;">
                    <i class="bi bi-box-arrow-in-right"></i> Войти
                </a>
                <a class="btn btn-light" href="{{ route('register') }}" style="border-radius: 20px; padding: 0.5rem 1.5rem; background: #fff; color: #ff9a9e; font-weight: 600;">
                    <i class="bi bi-person-plus"></i> Регистрация
                </a>
            @endauth
        </div>
    </nav>

    <!-- Заголовок страницы (опционально) -->
    @isset($header)
        <header class="bg-white shadow-sm">
            <div class="container py-4">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Основной контент -->
    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:16px;">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:16px;">
                    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
            {{ $slot ?? '' }}
        </div>
    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@vite(['resources/js/app.js'])
@stack('scripts')
</body>
</html>
