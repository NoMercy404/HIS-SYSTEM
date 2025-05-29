<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class UserSeeder extends Seeder
{
    public function run(): void
    {

        User::factory()->count(20)->create();

        DB::table('users')->insert([
            [
                'first_name' => 'Mateusz',
                'last_name' => 'Majchrowski',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'password_changed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Tester',
                'last_name' => 'Testowy',
                'email' => 'test@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'lekarz',
                'password_changed_at' => Carbon::now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Anna',
                'last_name' => 'Kowalska',
                'email' => 'anna@example.com',
                'password' => Hash::make('admin'),
                'role' => 'lekarz',
                'password_changed_at' => Carbon::create(2025, 4, 20, 12, 0, 0),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
