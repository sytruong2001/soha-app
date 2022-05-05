<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\logKC;
use Faker\Generator as Faker;

class logKCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $limit = 50;
        for ($i = 0; $i < $limit; $i++) {
            logKC::create([
                'user_id' => $faker->numberBetween(5,8),
                'kc_numb' => $faker->numberBetween(50,1000),
                'mua_kc_time' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
            ]);
        }
    }
}
