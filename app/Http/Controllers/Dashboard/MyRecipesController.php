<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class MyRecipesController extends Controller
{
    public function index()
    {
        $recipes = Recipe::where('author_id', auth()->id())
            ->withCount(['comments', 'ratings'])
            ->latest()
            ->paginate(10);
        
        return view('dashboard.my-recipes', compact('recipes'));
    }
}
