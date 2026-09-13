<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \App\Models\Recipe|null $recipe
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeStep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeStep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeStep query()
 * @mixin \Eloquent
 */
class RecipeStep extends Model
{
    use HasFactory;
    protected $fillable = [
        'recipe_id',
        'step_number',
        'description'
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
