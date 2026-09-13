<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\IngredientRecipe;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IngredientRecipe>
 */
class IngredientRecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recipe_id' => Recipe::factory(),
            'ingredient_id' => Ingredient::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'unit' => $this->faker->numberBetween(1, 10),
        ];
    }
}
