<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:47:52
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNhacCungCapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhac_cung_caps', function (Blueprint $table) {
			$table->bigIncrements("id");
            $table->string("man_nha_cung_cap", 191)->nullable();
            $table->string("ten_nhac_cung_cap", 191)->nullable();
            $table->string("dia_chi", 191)->nullable();
            $table->string("so_dien_thoai", 191)->nullable();
            $table->string("tk_ngan_hang", 191)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nhac_cung_caps');
    }
}
