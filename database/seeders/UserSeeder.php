<?php

namespace Database\Seeders;

use App\Models\Company\Company;
use App\Models\User;
use App\Models\UserHasCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_MAIL'),
            'password' => Hash::make(env('ADMIN_PASS'))
        ]);

        Company::create([
            'name' => 'JohnJohn 3D',
        ]);

        UserHasCompany::create([
            'user_id' => 1,
            'company_id' => 1
        ]);
    }
}
