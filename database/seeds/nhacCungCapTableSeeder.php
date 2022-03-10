<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:47:52
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class nhacCungCapTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $limit = 10;

        for ($i = 0; $i < $limit; $i++){
        	\App\Models\nhacCungCap::create([
                'man_nha_cung_cap' => $faker->name,
                'ten_nhac_cung_cap' => $faker->name,
                'dia_chi' => $faker->name,
                'so_dien_thoai' => $faker->name,
                'tk_ngan_hang' => $faker->name,
                //{{SEEDER_NOT_DELETE_THIS_LINE}}
			]);
		}
    }
}
