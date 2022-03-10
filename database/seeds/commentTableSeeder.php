<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:23:36
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class commentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $limit = 100;

        for ($i = 0; $i < $limit; $i++){
        	\App\Models\comment::create([
                'name' => $faker->name,
                //{{SEEDER_NOT_DELETE_THIS_LINE}}
			]);
		}
    }
}
