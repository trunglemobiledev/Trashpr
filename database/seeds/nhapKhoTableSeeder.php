<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:10:12
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class nhapKhoTableSeeder extends Seeder
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
        	\App\Models\nhapKho::create([
                'ngay_nhap' => $faker->dateTime,
                'so_luong' => $faker->numberBetween(1000, 9000),
                'ma_phieu_nhap' => $faker->name,
                'kho_id' => $faker->randomElement($khos),
                //{{SEEDER_NOT_DELETE_THIS_LINE}}
			]);
		}
    }
}
