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
        for ($i=0;$i<10;$i++){
            Retsept::create([
                'user_id' => random_int(1,10),
                'name' => $ovqatlar[random_int(1,count($ovqatlar)-1)],
                'message' => 'Shashlik juda zor. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel animi nobis ab cum perferendis iste libero fuga explicabo ducimus eos laudantium tenetur nemo, rerum nesciunt minus molestias repellat dolores repellendus.',
                'image' => 'img/blog-1.jpg',
            ]);
        }

    }
}
