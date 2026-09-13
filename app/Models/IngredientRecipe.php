<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \App\Models\Ingredient|null $ingredient
 * @property-read \App\Models\Recipe|null $recipe
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IngredientRecipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IngredientRecipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IngredientRecipe query()
 * @mixin \Eloquent
 */
class IngredientRecipe extends Model
{
    use HasFactory;
    protected $fillable = [
        'recipe_id',
        'ingredient_id',
        'quantity',
        'unit',
    ];
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
