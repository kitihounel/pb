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
            'med_council_id' => 'MC/LN/521',
            'phone_number' => '+229 66 62 13 54',
        ]);
        Doctor::create([
            'name' => 'Henry Jekyll',
            'speciality' => 'Unknown',
            'med_council_id' => 'MC/LN/527',
            'phone_number' => '+229 66 62 13 54',
        ]);
        Doctor::create([
            'name' => 'Dr Strange',
            'speciality' => 'Chirurgy',
            'med_council_id' => 'MC/LN/789',
            'phone_number' => '+229 66 62 13 54',
        ]);
        Doctor::create([
            'name' => 'Dr Ponytail',
            'speciality' => 'Pediatry',
            'med_council_id' => 'MC/LN/965',
            'phone_number' => '+229 66 62 13 54',
        ]);
    }
}
