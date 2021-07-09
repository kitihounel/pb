<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Doctor::create([
            'name' => 'Greg House',
            'speciality' => 'Funny diseases',
            'number' => '521-85-54',
            'contact' => '745 985 85 24',
        ]);
        Doctor::create([
            'name' => 'Henry Jekyll',
            'speciality' => 'Unknown',
            'number' => '070-123-789',
            'contact' => '722 741 74 52',
        ]);
    }
}
