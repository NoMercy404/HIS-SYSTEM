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
            'doctor_id' => $this->faker->numberBetween(1, 23),
            'visit_date' => function () {
                $start = now()->subMonths(3);
                $end = now()->addMonth();

                // Losowy dzień z zakresu
                $randomDate = \Carbon\Carbon::createFromTimestamp(rand($start->timestamp, $end->timestamp))->startOfDay();

                // Losowa godzina między 8:00 a 17:30
                $hour = rand(8, 17);
                $minute = rand(0, 1) * 30; // 0 albo 30

                return $randomDate->setTime($hour, $minute);
            },
            'visit_room' => $this->faker->numberBetween(1, 500),
            'visit_note' => $this->faker->sentence(8),
            'remember_token' => $this->faker->uuid,
        ];
    }
}

