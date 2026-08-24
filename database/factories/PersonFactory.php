<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    protected $model = \App\Models\Person::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'mail' => fake()->unique()->safeEmail(),
            'age' => fake()->numberBetween(18, 80),
        ];
    }
}
