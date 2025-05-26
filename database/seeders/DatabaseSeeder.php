<?php

namespace Database\Seeders;

use App\Models\Patients;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PatientsSeeder::class,
            HospitalisationSeeder::class,
            VisitSeeder::class,
            ResearchSeeder::class,
        ]);
    }
}
