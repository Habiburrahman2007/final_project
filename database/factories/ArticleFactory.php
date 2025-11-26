<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->paragraphs(5, true),
            'status' => $this->faker->randomElement(['draft', 'active', 'banned']),
            'image' => $this->faker->imageUrl(640, 480, 'nature', true),
            'user_id' => User::inRandomOrder()->first()?->id, // ambil user acak dari tabel users
            'category_id' => Category::inRandomOrder()->first()?->id, // ambil kategori acak dari tabel categories
        ];
    }
}
