<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(mt_rand(2, 8)),
            'content' => $this->faker->text(),
            // 'image' => $this->faker->imageUrl(200, 200),
            'image' => 'images/placeholder.png',
            'user_id' => mt_rand(1, 2),
            'category_id' => mt_rand(1,3)
        ];
    }
}
