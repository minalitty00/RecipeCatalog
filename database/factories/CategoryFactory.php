<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word();
        return [
                'name' => fake()->randomElement([
                    'Завтрак',
                    'Обед',
                    'Ужин',
                    'Напиток',
                    'Салат',
                    'Перекус',
                    'Гарнир',
                    'Суп',
                    'Подливка',
                    'Выпечка',
                    'Торт',
                ]),
            'slug' => Str::slug($name),
        ];
    }
}
