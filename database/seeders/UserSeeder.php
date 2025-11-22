<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lesco = Agency::where('slug', 'lesco')->first();
        $wasa  = Agency::where('slug', 'wasa')->first();

        User::create([
            'name' => 'LESCO Admin',
            'email' => 'lesco.admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'agency_admin',
            'agency_id' => $lesco->id,
        ]);

        User::create([
            'name' => 'Billing Admin',
            'email' => 'billing.admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'billing_admin',
            'agency_id' => null,
        ]);

        User::create([
            'name' => 'WASA Agent',
            'email' => 'wasa.agent@example.com',
            'password' => Hash::make('password'),
            'role' => 'agent',
            'agency_id' => $wasa->id,
        ]);
    }
}
