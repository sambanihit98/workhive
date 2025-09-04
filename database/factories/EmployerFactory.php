<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employer>
 */
class EmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'industry' => fake()->randomElement(['Information Technology', 'Healthcare', 'Finance', 'Education', 'Manufacturing']),
            'website' => fake()->url(),
            'email' => fake()->email(),
            'phonenumber' => fake()->phoneNumber(),
            'description' => fake()->text(),
            'type' => 'Private',
            'number_of_employees' => fake()->numberBetween(1, 500),
            'logo' => 'logos/default-company-logo.png',
            'password' => 'password',
        ];
    }
}
