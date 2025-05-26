<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        $roles = ['admin', 'lekarz'];

        return [
            'first_name' => $this->faker->firstNameMale(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make($this->faker->password()),
            'role' => 'lekarz',
            'password_changed_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
            'remember_token' => \Str::random(10),
        ];
    }
}
