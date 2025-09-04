<?php

namespace Database\Factories;

use App\Models\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employer_id' => Employer::factory(),
            'title' => fake()->jobTitle(),
            'salary' => fake()->randomElement(['$90,000', '$50,000', '$30,000', '$70,000']),
            'location' => 'Remote',
            'employment_type' =>  'Full Time',
            'urgent_hiring' => fake()->boolean(),
            'description' => fake()->text()
        ];
    }
}
