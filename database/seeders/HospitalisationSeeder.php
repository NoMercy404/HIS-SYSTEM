<?php

namespace Database\Seeders;

use App\Models\Hospitalisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalisationSeeder extends Seeder
{

    public function run(): void
    {
        Hospitalisation::factory()->count(20)->create();
    }
}
