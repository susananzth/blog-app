<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->realTextBetween($minNbChars = 10, $maxNbChars = 25, $indexSize = 1),
            'menu' => fake()->realTextBetween($minNbChars = 10, $maxNbChars = 25, $indexSize = 1),
            'permission' => fake()->realTextBetween($minNbChars = 20, $maxNbChars = 50, $indexSize = 1),
        ];
    }
}
