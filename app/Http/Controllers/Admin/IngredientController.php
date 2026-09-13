<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::withCount('recipes')
            ->latest()
            ->paginate(20);
        
        return view('admin.ingredients.index', compact('ingredients'));
    }
    
    public function create()
    {
        return view('admin.ingredients.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ingredients',
            'default_unit' => 'required|string|max:50',
        ]);
        
        Ingredient::create($validated);
        
        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Ингредиент создан');
    }
    
    public function edit(Ingredient $ingredient)
    {
        return view('admin.ingredients.edit', compact('ingredient'));
    }
    
    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name,' . $ingredient->id,
            'default_unit' => 'required|string|max:50',
        ]);
        
        $ingredient->update($validated);
        
        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Ингредиент обновлён');
    }
    
    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        
        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Ингредиент удалён');
    }
}
