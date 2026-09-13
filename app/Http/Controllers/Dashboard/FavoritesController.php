<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index()
    {
        $favorites = Favorite::where('user_id', auth()->id())
            ->with('recipe.category', 'recipe.author')
            ->latest()
            ->paginate(12);
        
        return view('dashboard.favorites', compact('favorites'));
    }
    
    public function toggle($recipeId)
    {
        $favorite = Favorite::where('user_id', auth()->id())
            ->where('recipe_id', $recipeId)
            ->first();
        
        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Рецепт удалён из избранного');
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'recipe_id' => $recipeId,
            ]);
            return back()->with('success', 'Рецепт добавлен в избранное');
        }
    }
}
