<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:08:26
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefnhapKhosanphamTableSeeder extends Seeder
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
        	\App\Models\RefnhapKhosanpham::create([
                'don_vi_tinh' => $faker->name,
                'ghi_chu' => $faker->name,
                'so_luong' => $faker->numberBetween(1000, 9000),
                'ngay_nhap' => $faker->dateTime,
                'qr_code_nhap' => $faker->name,
                //{{SEEDER_NOT_DELETE_THIS_LINE}}
			]);
		}
    }
}
