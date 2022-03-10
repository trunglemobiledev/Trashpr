<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:15:37
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class xuatKhoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $khos = \App\Models\kho::all()->pluck('id')->toArray();

        $limit = 100;

        for ($i = 0; $i < $limit; $i++){
        	\App\Models\xuatKho::create([
                'ma_phieu_xuat' => $faker->name,
                'ngay_xuat' => $faker->dateTime,
                'so_luong' => $faker->name,
                'kho_id' => $faker->randomElement($khos),
                //{{SEEDER_NOT_DELETE_THIS_LINE}}
			]);
		}
    }
}
