<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\RecipeStep;
use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::with(['category', 'author'])
            ->withCount('comments')
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

        $recipe->load(['category', 'author', 'comments.user', 'ratings', 'steps', 'ingredients']);

        return view('recipes.show', compact('recipe'));
    }

    public function create()
    {
        $categories = Category::all();
        $ingredients = Ingredient::orderBy('name')->get();
        
        return view('recipes.create', compact('categories', 'ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'difficulty' => 'required|in:easy,medium,hard',
            'cooking_time' => 'required|integer|min:1',
            'servings' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url|max:500',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.ingredient_id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|string|max:100',
            'ingredients.*.unit' => 'required|string|max:50',
            'steps' => 'required|array|min:1',
            'steps.*.description' => 'required|string',
        ]);

        $recipe = new Recipe();
        $recipe->title = $validated['title'];
        $recipe->slug = Str::slug($validated['title']) . '-' . time();
        $recipe->description = $validated['description'];
        $recipe->category_id = $validated['category_id'];
        $recipe->difficulty = $validated['difficulty'];
        $recipe->cooking_time = $validated['cooking_time'];
        $recipe->servings = $validated['servings'];
        $recipe->author_id = auth()->id();
        $recipe->is_published = false; // На модерации

        // Приоритет: сначала загруженный файл, потом URL
        if ($request->hasFile('image')) {
            $recipe->image = $request->file('image')->store('recipes', 'public');
        } elseif ($request->filled('image_url')) {
            $recipe->image = $validated['image_url'];
        }

        $recipe->save();

        // Сохранение ингредиентов
        foreach ($validated['ingredients'] as $ingredientData) {
            $recipe->ingredients()->attach($ingredientData['ingredient_id'], [
                'quantity' => $ingredientData['quantity'],
                'unit' => $ingredientData['unit']
            ]);
        }

        // Сохранение шагов
        foreach ($validated['steps'] as $index => $stepData) {
            RecipeStep::create([
                'recipe_id' => $recipe->id,
                'step_number' => $index + 1,
                'description' => $stepData['description']
            ]);
        }

        return redirect()->route('my-recipes.index')->with('success', 'Рецепт создан и отправлен на модерацию!');
    }

    public function edit(Recipe $recipe)
    {
        // Проверка прав доступа
        if ($recipe->author_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::all();
        $ingredients = Ingredient::orderBy('name')->get();
        $recipe->load(['ingredients', 'steps']);
        
        return view('recipes.edit', compact('recipe', 'categories', 'ingredients'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        // Проверка прав доступа
        if ($recipe->author_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'difficulty' => 'required|in:easy,medium,hard',
            'cooking_time' => 'required|integer|min:1',
            'servings' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url|max:500',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.ingredient_id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|string|max:100',
            'ingredients.*.unit' => 'required|string|max:50',
            'steps' => 'required|array|min:1',
            'steps.*.description' => 'required|string',
        ]);

        $recipe->title = $validated['title'];
        $recipe->description = $validated['description'];
        $recipe->category_id = $validated['category_id'];
        $recipe->difficulty = $validated['difficulty'];
        $recipe->cooking_time = $validated['cooking_time'];
        $recipe->servings = $validated['servings'];

        // Обработка изображения
        if ($request->hasFile('image')) {
            // Удаление старого изображения (только если это файл, а не URL)
            if ($recipe->image && !str_starts_with($recipe->image, 'http')) {
                Storage::disk('public')->delete($recipe->image);
            }
            $recipe->image = $request->file('image')->store('recipes', 'public');
        } elseif ($request->filled('image_url')) {
            // Удаление старого файла если был
            if ($recipe->image && !str_starts_with($recipe->image, 'http')) {
                Storage::disk('public')->delete($recipe->image);
            }
            $recipe->image = $validated['image_url'];
        }

        $recipe->save();

        // Обновление ингредиентов
        $recipe->ingredients()->detach();
        foreach ($validated['ingredients'] as $ingredientData) {
            $recipe->ingredients()->attach($ingredientData['ingredient_id'], [
                'quantity' => $ingredientData['quantity'],
                'unit' => $ingredientData['unit']
            ]);
        }

        // Обновление шагов
        $recipe->steps()->delete();
        foreach ($validated['steps'] as $index => $stepData) {
            RecipeStep::create([
                'recipe_id' => $recipe->id,
                'step_number' => $index + 1,
                'description' => $stepData['description']
            ]);
        }

        return redirect()->route('my-recipes.index')->with('success', 'Рецепт обновлён!');
    }

    public function destroy(Recipe $recipe)
    {
        // Проверка прав доступа
        if ($recipe->author_id !== auth()->id()) {
            abort(403);
        }

        // Удаление изображения
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()->route('my-recipes.index')->with('success', 'Рецепт удалён!');
    }

    public function rate(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        // Проверка существующей оценки
        $existingRating = Rating::where('recipe_id', $recipe->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingRating) {
            $existingRating->update(['rating' => $validated['rating']]);
        } else {
            Rating::create([
                'recipe_id' => $recipe->id,
                'user_id' => auth()->id(),
                'rating' => $validated['rating']
            ]);
        }

        // Обновляем средний рейтинг рецепта
        $averageRating = Rating::where('recipe_id', $recipe->id)->avg('rating');
        $ratingCount = Rating::where('recipe_id', $recipe->id)->count();
        
        $recipe->update([
            'rating' => round($averageRating, 2),
            'rating_count' => $ratingCount
        ]);

        return back()->with('success', 'Ваша оценка сохранена!');
    }

    public function comment(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        Comment::create([
            'recipe_id' => $recipe->id,
            'user_id' => auth()->id(),
            'body' => $validated['comment']
        ]);

        return back()->with('success', 'Комментарий добавлен!');
    }
}
