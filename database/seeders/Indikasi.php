<?php

namespace Database\Seeders;

use App\Models\indikasi as Modelsindikasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class indikasi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //prefix
        //name
        Modelsindikasi::create([
            'name' => ' Bagaimana Anda merespons situasi yang menegangkan atau stres?',
        ]);

        
    }
}
