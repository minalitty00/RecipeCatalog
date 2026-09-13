<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->generateRussianTitle(),
            'slug' => function (array $attributes) {
                return \Illuminate\Support\Str::slug($attributes['title']);
            },
            'description' => $this->generateRussianDescription(),
            'image' => 'https://loremflickr.com/640/480/food?lock=' . $this->faker->numberBetween(1, 100000),
            'category_id' => Category::factory(),
            'author_id' => User::factory(),
            'cooking_time' => $this->faker->numberBetween(15, 120),
            'servings' => $this->faker->numberBetween(2, 8),
            'difficulty' => $this->faker->randomElement(['легко', 'средне', 'сложно']),
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'rating_count' => $this->faker->numberBetween(0, 50),
            'is_published' => true
        ];
    }

    private function generateRussianTitle(): string
    {
        $words = [
            'вкусный', 'ароматный', 'нежный', 'сытный', 'пряный',
            'домашний', 'свежий', 'хрустящий', 'сочно', 'тающий',
            'золотистый', 'аппетитный', 'пикантный', 'необычный',
            'классический', 'настоящий', 'деревенский', 'королевский',
            'завтрак', 'обед', 'ужин', 'десерт', 'салат',
            'суп', 'пирог', 'котлета', 'запеканка', 'рагу',
            'соус', 'каша', 'омлет', 'тост', 'смузи',
            'борщ', 'плов', 'паста', 'стейк', 'бургер',
            'сладкий', 'острый', 'солёный', 'кислый', 'горький',
            'медовый', 'шоколадный', 'ягодный', 'фруктовый', 'овощной',
            'сырный', 'мясной', 'рыбный', 'грибной', 'молочный'
        ];

        $count = rand(2, 5);
        $selected = array_rand(array_flip($words), $count);
        shuffle($selected);

        return implode(' ', $selected) . ' ' . ['вкус', 'блюдо', 'рецепт', 'шедевр'][rand(0, 3)];
    }

    private function generateRussianDescription(): string
    {
        $phrases = [
            'Это блюдо покорит сердца всех гостей.',
            'Идеальное сочетание ингредиентов для настоящих гурманов.',
            'Простота и изысканность в каждой детали.',
            'Секрет этого рецепта — в правильных пропорциях.',
            'Пальчики оближешь — так вкусно, что невозможно остановиться!',
            'Блюдо с душой и характером.',
            'Вкус детства в каждой ложке.',
            'Настоящая кулинарная магия у вас на кухне.',
            'Этот рецепт станет вашим любимым.',
            'Порадуйте себя и близких этим великолепным блюдом.',
            'Согреет в холодный день и поднимет настроение.',
            'Красивый вид и потрясающий вкус — идеальный дуэт.',
            'Всё гениальное — просто, а это блюдо тому доказательство.',
            'Тающее во рту удовольствие для истинных ценителей.',
            'Никаких сложных техник — только настоящий вкус.',
            'Для тех, кто любит вкусно и полезно.',
            'Идеально подходит для семейного ужина.',
            'Потрясающий аромат разнесётся по всему дому.',
            'Рецепт от шеф-повара с любовью к кулинарии.',
            'Каждая порция — это маленький праздник.',
            'Сочетание традиций и современных вкусов.',
            'Самый лучший способ сказать "я тебя люблю" через еду.',
            'Это блюдо станет главным хитом вашего стола.',
            'Наслаждение в каждом кусочке.',
            'Кулинарное приключение для ваших вкусовых рецепторов.'
        ];

        $count = rand(2, 4);
        $selected = array_rand(array_flip($phrases), $count);
        shuffle($selected);

        return implode(' ', $selected);
    }
}
