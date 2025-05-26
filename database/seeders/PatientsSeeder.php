<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Patients;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PatientsSeeder extends Seeder
{
    public function run(): void
    {
        Patients::factory()->count(20)->create();
    }
}
