<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Questionaire>
 */
class QuestionaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucfirst(fake()->words(rand(1,2), true)),
            'description' => fake()->paragraph(1),
            'semester' => fake()->randomElement(['1st','2nd']),
            'school_year' => fake()->year() . '-' . fake()->year(),
            'max_respondents' => 100,
            'description' => fake()->paragraph(1),
        ];
    }
}
