<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patients>
 */
class PatientsFactory extends Factory
{

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstNameMale(),
            'last_name' => $this->faker->lastName(),
            'PESEL' => $this->faker->numerify('###########'),
            'DateOfBirth' => $this->faker->dateTime(),
            'adress' => $this->faker->address(),
            'phoneNumber' => $this->faker->phoneNumber(),
            'is_on_ward' => $this->faker->boolean(),
            'remember_token' => \Str::random(10),
        ];
    }
}
