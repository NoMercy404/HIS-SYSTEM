<?php

namespace Database\Seeders;

use App\Models\Research;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Research::factory()->count(100)->create();
    }
}
//x
