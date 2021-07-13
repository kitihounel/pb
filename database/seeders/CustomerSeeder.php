<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'name' => 'Goku',
            'contact' => 'None',
            'sex' => 'M',
            'birth_year' => 1985
        ]);
        Customer::create([
            'name' => 'Gohan',
            'contact' => 'Unknown',
            'sex' => 'M',
            'birth_year' => 2005
        ]);
        Customer::create([
            'name' => 'Videl',
            'contact' => '01-965-85',
            'sex' => 'F',
            'birth_year' => 2006
        ]);
    }
}
