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
            'api_token' => str_repeat('abc', 27),
            'password' => Hash::make('password')
        ]);
        $testUser->role = 'admin';
        $testUser->update();
    }
}
