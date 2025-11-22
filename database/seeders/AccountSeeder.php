<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Agency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lesco = Agency::where('slug', 'lesco')->first();
        $wasa  = Agency::where('slug', 'wasa')->first();

        Account::create([
            'agency_id'     => $lesco->id,
            'account_number' => '1001',
            'name' => 'Household A',
            'email' => 'a@example.com',
            'phone' => '03001234567'
        ]);

        Account::create([
            'agency_id'     => $wasa->id,
            'account_number' => '2001',
            'name' => 'Restaurant B',
            'email' => 'b@example.com',
            'phone' => '03007654321'
        ]);
    }
}
