<?php

namespace Database\Factories;

use App\Models\Visit;
use App\Models\Patients;
use App\Models\User; // jeśli lekarze to użytkownicy
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    protected $model = Visit::class;

    public function definition(): array
    {
        return [
            'patient_id' => $this->faker->numberBetween(1, 20),
            'doctor_id' => $this->faker->numberBetween(1, 20),
            'visit_date' => $this->faker->dateTimeBetween('-3 months', '+1 month'),
            'visit_room' => $this->faker->numberBetween(1, 500),
            'visit_note' => $this->faker->sentence(8),
            'remember_token' => $this->faker->uuid,
        ];
    }
}

