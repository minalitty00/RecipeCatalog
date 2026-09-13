<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('author', 'category')
            ->withCount('comments')
            ->latest()
            ->paginate(15);
        
        return view('admin.recipes.index', compact('recipes'));
    }
    
    public function togglePublish(Recipe $recipe)
    {
        $recipe->update([
            'is_published' => !$recipe->is_published
        ]);
        
        $status = $recipe->is_published ? 'опубликован' : 'снят с публикации';
        
        return back()->with('success', "Рецепт {$status}");
    }
    
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        
        return redirect()->route('admin.recipes.index')
            ->with('success', 'Рецепт удалён');
    }
}
