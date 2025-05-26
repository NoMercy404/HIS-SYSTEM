<?php

// database/factories/HospitalisationFactory.php

namespace Database\Factories;

use App\Models\Hospitalisation;
use App\Models\Patients;
use Illuminate\Database\Eloquent\Factories\Factory;

class HospitalisationFactory extends Factory
{
    protected $model = Hospitalisation::class;

    public function definition(): array
    {
        $admissionDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $dischargeDate = $this->faker->boolean(70)
            ? $this->faker->dateTimeBetween($admissionDate, 'now')
            : null;

        return [
            'patient_id' => $this->faker->numberBetween(1, 20),
            'date_of_hospital_admission' => $admissionDate,
            'discharge_date' => $dischargeDate,
            'disease_number' => $this->faker->bothify('CH-####'),
            'remember_token' => $this->faker->uuid,
        ];
    }
}

