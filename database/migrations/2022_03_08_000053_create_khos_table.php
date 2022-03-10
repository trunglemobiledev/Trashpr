<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:00:53
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khos', function (Blueprint $table) {
			$table->bigIncrements("id");
            $table->string("ten_kho", 191)->nullable();
            $table->string("dia_chi", 191)->nullable();
            $table->string("mo_ta", 191)->nullable();
            $table->string("ma_kho", 191)->nullable()->comment("Mã kho không được trùng")->unique();
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
        Schema::dropIfExists('khos');
    }
}
