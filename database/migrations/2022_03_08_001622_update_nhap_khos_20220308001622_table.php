<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:16:22
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNhapKhos20220308001622Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhap_khos', function (Blueprint $table) {
			$table->string("ma_phieu_nhap")->nullable(); // Update
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nhap_khos', function (Blueprint $table) {
            $table->dropColumn("ma_phieu_nhap"); //Drop Update
        });
    }
}
