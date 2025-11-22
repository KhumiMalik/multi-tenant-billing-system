<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agency::create(['name' => 'LESCO', 'slug' => 'lesco']);
        Agency::create(['name' => 'WASA', 'slug' => 'wasa']);
        Agency::create(['name' => 'SUI', 'slug' => 'sui']);
    }
}
