<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Ingredient;
use App\Models\Rating;
use App\Models\Recipe;
use App\Models\RecipeStep;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1️⃣ Админ
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'avatar' => 'avatar.png',
            'role' => 'admin',
        ]);

        // 2️⃣ Пользователи
        $users = User::factory(20)->create();

        // 3️⃣ Категории
        $categories = Category::factory(5)->create();

        // 4️⃣ Ингредиенты
        $ingredients = Ingredient::factory(20)->create();

        // 5️⃣ СОЗДАЁМ РЕЦЕПТЫ (15 штук)
        $recipes = Recipe::factory(15)->create();

        // 6️⃣ ДОБАВЛЯЕМ ДАННЫЕ ДЛЯ КАЖДОГО РЕЦЕПТА
        foreach ($recipes as $recipe) {
            // Автор и категория
            $recipe->update([
                'author_id' => $users->random()->id,
                'category_id' => $categories->random()->id
            ]);

            // Ингредиенты
            $selected = $ingredients->random(rand(3, 7));
            foreach ($selected as $ingredient) {
                $recipe->ingredients()->attach($ingredient->id, [
                    'quantity' => rand(50, 500),
                    'unit' => $ingredient->default_unit ?? 'г.'
                ]);
            }

            // Шаги (1-10)
            foreach (range(1, rand(1, 10)) as $i) {
                RecipeStep::create([
                    'recipe_id' => $recipe->id,
                    'step_number' => $i,
                    'description' => fake()->sentence(6),
                ]);
            }

            // Комментарии (2-6)
            foreach (range(1, rand(2, 6)) as $i) {
                Comment::create([
                    'recipe_id' => $recipe->id,
                    'user_id' => $users->random()->id,
                    'body' => fake()->sentence(8),
                ]);
            }

            // Оценки (3-10 пользователей)
            $ratingUsers = $users->random(rand(3, min(10, $users->count())))->unique('id');
            foreach ($ratingUsers as $user) {
                Rating::create([
                    'recipe_id' => $recipe->id,
                    'user_id' => $user->id,
                    'rating' => rand(1, 5)
                ]);
            }

            // Обновляем рейтинг
            $avg = $recipe->ratings()->avg('rating');
            $recipe->update([
                'rating' => $avg ? round($avg, 2) : 0,
                'rating_count' => $recipe->ratings()->count()
            ]);
        }

        // 7️⃣ ИЗБРАННОЕ (отдельно, ПОСЛЕ создания всех рецептов)
        $allRecipes = Recipe::all();
        foreach ($users as $user) {
            $favoriteRecipes = $allRecipes->random(rand(2, min(5, $allRecipes->count())));
            foreach ($favoriteRecipes as $recipe) {
                Favorite::firstOrCreate([
                    'user_id' => $user->id,
                    'recipe_id' => $recipe->id,
                ]);
            }
        }

        // 8️⃣ ОТЧЁТ
        $this->command->info('✅ Сидер выполнен!');
        $this->command->info('👤 Пользователей: ' . User::count());
        $this->command->info('📁 Категорий: ' . Category::count());
        $this->command->info('🛒 Ингредиентов: ' . Ingredient::count());
        $this->command->info('📖 Рецептов: ' . Recipe::count());
        $this->command->info('📝 Шагов: ' . RecipeStep::count());
        $this->command->info('💬 Комментариев: ' . Comment::count());
        $this->command->info('⭐ Оценок: ' . Rating::count());
        $this->command->info('❤️ Избранных: ' . Favorite::count());
    }
}
