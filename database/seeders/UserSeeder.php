<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testUser = User::create([
            'name' => 'Kofi',
            'username' => 'kofi',
            'api_token' => Str::repeat('abcd', 20),
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
    }
}
