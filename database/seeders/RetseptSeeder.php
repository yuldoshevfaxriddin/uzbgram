<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Retsept;

class RetseptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $ovqatlar = ['Shashlik','Palov','Gumma','Tandir kabob','Tandir so\'msa'];
        // Retseptlarni avtomatik yaratish uchun user random(2,10) oralig'ida       
         
        for ($i=0;$i<10;$i++){
            Retsept::create([
                'user_id' => random_int(2,10),
                'name' => $ovqatlar[random_int(1,count($ovqatlar)-1)],
                'message' => "Shashlik juda zo'r chiqdi. Kecha biz do'stlarimiz 
                bilan tog'ga aylanishga chiqdik shashlik qildik.
                Buning uchun bizga:
                - 1 kg ijon
                - 2 ta piyoz
                - Tuz,murch
                - 1 ta limon
                kerak bo'ldi",
                'image' =>'images/shashlik.webp',
            ]);
        }

    }
}
