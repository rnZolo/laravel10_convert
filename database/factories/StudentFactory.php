<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_number' => fake()->unique()->numberBetween(1,10000),
            'student_type' => fake()->randomElement(['local', 'foreign']),
            'name' => fake()->name(),
            'age' => fake()->numberBetween(1, 100),
            'city' => fake()->city(),
            'gender' => fake()->randomElement(['male', 'female']),
            'mobile_number' => fake()->phoneNumber(),
            'grades' => fake()->numberBetween(75, 100),
            'email' => fake()->unique()->safeEmail()
        ];
    }
}
