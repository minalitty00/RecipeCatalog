<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \App\Models\Recipe|null $recipe
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating query()
 * @mixin \Eloquent
 */
class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'recipe_id',
        'rating',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
