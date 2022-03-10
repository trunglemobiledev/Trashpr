<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:32:32
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class sanphamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $nhacCungCaps = \App\Models\nhacCungCap::all()->pluck('id')->toArray();
        $thuongHieus = \App\Models\thuongHieu::all()->pluck('id')->toArray();
        $danhMucs = \App\Models\danhMuc::all()->pluck('id')->toArray();

        $limit = 100;

        for ($i = 0; $i < $limit; $i++){
        	\App\Models\sanpham::create([
                'ma_san_pham' => $faker->name,
                'ten_san_pham' => $faker->name,
                'gia_nhap' => $faker->randomFloat(2, 1000, 9000),
                'gia_ban' => $faker->randomFloat(2, 1000, 9000),
                'ten_khach_ban' => $faker->name,
                'so_dien_thoai_khach_ban' => $faker->name,
                'hinh_anh' => $faker->name,
                'so_may' => $faker->name,
                'don_vi_tinh' => $faker->name,
                'tinh_trang_bao_hanh' => $faker->name,
                'ho_so' => $faker->name,
                'ngay_mua' => $faker->dateTime,
                'mo_ta' => $faker->paragraph,
                'danh_muc_id' => $faker->randomElement($danhMucs),
                'thuong_hieu_id' => $faker->randomElement($thuongHieus),
                'nhac_cung_cap_id' => $faker->randomElement($nhacCungCaps),
                //{{SEEDER_NOT_DELETE_THIS_LINE}}
			]);
		}
    }
}
