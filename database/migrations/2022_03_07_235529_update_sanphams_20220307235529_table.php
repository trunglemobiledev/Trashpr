<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:55:29
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSanphams20220307235529Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sanphams', function (Blueprint $table) {
			$table->string("so_may")->nullable(); // Update
            $table->string("don_vi_tinh")->nullable(); // Update
            $table->string("tinh_trang_bao_hanh")->nullable(); // Update
            $table->string("ho_so")->nullable(); // Update
            $table->dateTime("ngay_mua")->nullable(); // Update
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sanphams', function (Blueprint $table) {
            $table->dropColumn("so_may"); //Drop Update
            $table->dropColumn("don_vi_tinh"); //Drop Update
            $table->dropColumn("tinh_trang_bao_hanh"); //Drop Update
            $table->dropColumn("ho_so"); //Drop Update
            $table->dropColumn("ngay_mua"); //Drop Update
        });
    }
}
