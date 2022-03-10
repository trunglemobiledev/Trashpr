<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 11:13:06
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefxuatKhoRefnhapKhosanphamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $refnhapKhosanphams = \App\Models\RefnhapKhosanpham::all()->pluck('id')->toArray();
        $xuatKhos = \App\Models\xuatKho::all()->pluck('id')->toArray();

        $limit = 100;

        for ($i = 0; $i < $limit; $i++){
        	\App\Models\RefxuatKhoRefnhapKhosanpham::create([
                'refnhap_khosanpham_id' => $faker->randomElement($refnhapKhosanphams),
                'xuat_kho_id' => $faker->randomElement($xuatKhos),
                
			]);
		}
    }
}
