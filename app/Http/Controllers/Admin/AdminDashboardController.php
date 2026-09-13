<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Comment;
use App\Models\Ingredient;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalRecipes' => Recipe::count(),
            'publishedRecipes' => Recipe::where('is_published', true)->count(),
            'unpublishedRecipes' => Recipe::where('is_published', false)->count(),
            'totalComments' => Comment::count(),
            'totalIngredients' => Ingredient::count(),
            'totalCategories' => Category::count(),
            'averageRating' => round(Recipe::avg('rating'), 2) ?? 0,
        ];
        
        // Последние рецепты
        $latestRecipes = Recipe::with('author', 'category')
            ->latest()
            ->take(5)
            ->get();
        
        // Последние пользователи
        $latestUsers = User::latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact('stats', 'latestRecipes', 'latestUsers'));
    }
}
