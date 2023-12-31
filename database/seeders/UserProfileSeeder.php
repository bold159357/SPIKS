<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = ['X RPL 1', 'Lainnya'];

        /**
         * Create Custom User Profile with Factory
         * Uncomment if you want to use User Seeder with Factory
         */
        // for ($i = 1; $i <= User::count(); $i++) {
        //     \App\Models\UserProfile::create([
        //         'user_id' => $i,
        //         'address' => Factory::create()->address,
        //         'city' => 144,
        //         'gender' => 13,
        //         'kelas' => $kelas[rand(0, 1)],
        //     ]);
        // }

        /**
         * Create Custom User Profile with Model
         */
        UserProfile::create([
            'user_id' => 1,
            'address' => '',
            'gender' => 1,
            'kelas' => $kelas[rand(0, 1)],
        ]);
    }
}
