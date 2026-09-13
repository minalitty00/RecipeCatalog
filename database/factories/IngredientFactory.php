<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Помидор',
                'Молоко',
                'Лук',
                'Чеснок',
                'Яйца',
                'Соль',
                'Перец',
                'Мука',
                'Кефир',
                'Шпинат',
                'Майонез',
                'Масло',
                'Сахар',
                'Салат',
                'Мясо',
                'Морковь'
            ]),
            'default_unit' => fake()->randomElement(['г.', 'мл.', 'шт.','ст.л.']),
        ];
    }
}
