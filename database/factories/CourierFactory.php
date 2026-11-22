<?php

namespace Database\Factories;

use App\Models\Courier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Courier>
 */
class CourierFactory extends Factory
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
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->numerify('08##########'),
            'level' => fake()->numberBetween(1, 5),
            'vehicle_type' => fake()->randomElement(['Motorcycle', 'Car', 'Bicycle', 'Van']),
            'is_active' => true,
            'registered_at' => fake()->dateTimeBetween('-2 years', 'now'),
        ];
    }
}
