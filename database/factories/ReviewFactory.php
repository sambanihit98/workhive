<?php

namespace Database\Factories;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employer_id' => '20',
            'user_id' => User::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->text(),
            'is_approved' => '1',
        ];
    }
}
