<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Izoh;

class IzohSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0;$i<10;$i++){
            Izoh::create([
                'retsept_id' => random_int(1,10),
                'user_id' => random_int(1,10),
                'description' => "Juda ajoyib",
            ]);
        }
    }
}
