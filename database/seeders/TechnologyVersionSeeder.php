<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TechnologyVersion;

class TechnologyVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TechnologyVersion::factory()
            ->count(5)
            ->create();
    }
}
