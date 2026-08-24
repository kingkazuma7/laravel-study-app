<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'person_id' => Person::inRandomOrder()->first()->person_code ?? Person::factory(),
            'body' => $this->faker->sentence(10),
        ];
    }
}
