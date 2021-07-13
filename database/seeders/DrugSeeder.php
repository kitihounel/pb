<?php

namespace Database\Seeders;

use App\Models\Drug;
use Illuminate\Database\Seeder;

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Drug::create([
            'name' => 'Antalgex T',
            'inn' => 'Tramadol',
            'price' => '1645.00',
            'presentation' => 'Boite de 20 cps'
        ]);
        Drug::create([
            'name' => 'Diazepam',
            'inn' => 'Diazepam',
            'price' => '100.00',
            'presentation' => 'Plaquette de 10 cps'
        ]);
        Drug::create([
            'name' => 'Klipal 300',
            'inn' => 'Para + Codeine',
            'price' => '1625.00',
            'presentation' => 'Boite de 12 cps'
        ]);
    }
}
