<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Research>
 */
class ResearchFactory extends Factory
{

    public function definition(): array
    {
        return [
            'hospital_id' => \App\Models\Hospitalisation::factory(),

            'research_type' => $this->faker->randomElement(['laboratoryjne', 'radiologiczne', 'zabieg']),
            'note' => $this->faker->sentence(8),
            'date_of_research' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'status' => $this->faker->randomElement(['Zakończone', 'W toku', 'Anulowane']),
            'result' => $this->faker->text(30),
            'remember_token' => $this->faker->uuid,
        ];
    }
}
