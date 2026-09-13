<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recipe> $recipes
 * @property-read int|null $recipes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ingredient query()
 * @mixin \Eloquent
 */
class Ingredient extends Model
{
    use HasFactory;
    protected $fillable = ['name, default_unit'];
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class)->withPivot(['quantity', 'unit']);
    }
}
