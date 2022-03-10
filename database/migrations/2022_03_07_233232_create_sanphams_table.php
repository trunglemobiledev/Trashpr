<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-07 23:32:32
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSanphamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanphams', function (Blueprint $table) {
			$table->bigIncrements("id");
            $table->string("ma_san_pham", 191)->nullable()->comment("Số khung xe không thể trùng")->unique();
            $table->string("ten_san_pham", 191)->nullable();
            $table->float("gia_nhap")->nullable()->default("0");
            $table->float("gia_ban")->nullable()->default("0");
            $table->string("ten_khach_ban", 191)->nullable();
            $table->string("so_dien_thoai_khach_ban", 191)->nullable();
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
        Schema::dropIfExists('sanphams');
    }
}
