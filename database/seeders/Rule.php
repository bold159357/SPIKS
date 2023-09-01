<?php

namespace Database\Seeders;

use App\Models\indikasi;
use App\Models\kepribadian;
use App\Models\Rule as ModelsRule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Rule extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //kepribadian_id
        //indikasi_id

        ModelsRule::create([
            'kepribadian_id' =>  kepribadian::where('id', 1)->first()->id,
            'indikasi_id' => indikasi::where('id', 1)->first()->id
        ]);


    }
}
