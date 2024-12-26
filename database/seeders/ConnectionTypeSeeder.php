<?php

namespace Database\Seeders;

use App\Models\ConnectionType;
use Illuminate\Database\Seeder;

class ConnectionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConnectionType::factory()
            ->count(5)
            ->create();
    }
}
