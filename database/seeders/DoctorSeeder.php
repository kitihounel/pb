<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

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
        Doctor::create([
            'name' => 'Dr Strange',
            'speciality' => 'Chirurgy',
            'number' => '074-173-789',
            'contact' => '722 001 78 71',
        ]);
        Doctor::create([
            'name' => 'Dr Ponytail',
            'speciality' => 'Pediatry',
            'number' => '025-98-965-6',
            'contact' => '12 74 874 522',
        ]);
    }
}
