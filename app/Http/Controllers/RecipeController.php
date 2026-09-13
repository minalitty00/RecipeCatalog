<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::with(['category', 'author'])
            ->published();

        // Поиск по названию
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        // Фильтр по категории
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Сортировка
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'rating':
                $query->orderByRating();
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'newest':
            default:
                $query->orderByNewest();
                break;
        }

        $recipes = $query->paginate(9)->withQueryString();
        $categories = Category::all();

        return view('recipes.index', compact('recipes', 'categories'));
    }

    public function show(Recipe $recipe)
    {
        if (!$recipe->is_published) {
            abort(404);
        }

        $recipe->load(['category', 'author']);

        return view('recipes.show', compact('recipe'));
    }
}
