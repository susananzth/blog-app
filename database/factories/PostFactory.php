<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'  => fake()->realTextBetween($minNbChars = 20, $maxNbChars = 120, $indexSize = 2),
            'body'   => fake()->paragraph(),
            'status' => 1,
        ];
    }
}
