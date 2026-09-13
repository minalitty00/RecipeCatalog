<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Статистика пользователя
        $myRecipesCount = Recipe::where('author_id', $user->id)->count();
        $averageRating = Recipe::where('author_id', $user->id)->avg('rating') ?? 0;
        $totalComments = $user->recipes()
            ->withCount('comments')
            ->get()
            ->sum('comments_count');
        $favoritesCount = $user->favorites()->count();
        
        // Последние рецепты пользователя
        $latestRecipes = Recipe::where('author_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard.index', compact(
            'myRecipesCount',
            'averageRating',
            'totalComments',
            'favoritesCount',
            'latestRecipes'
        ));
    }
}
