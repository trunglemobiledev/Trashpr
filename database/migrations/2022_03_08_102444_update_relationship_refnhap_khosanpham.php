<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRelationshipRefnhapKhosanpham extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ref_nhap_kho_sanpham', function (Blueprint $table) {
            $table->string("don_vi_tinh")->nullable();
            $table->integer("so_luong")->nullable();
            $table->string("ghi_chu")->nullable();
            $table->dateTime("ngay_nhap")->nullable();
            $table->string("qr_code_nhap")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ref_nhap_kho_sanpham', function (Blueprint $table) {
            $table->dropColumn("don_vi_tinh");  //Drop Update
            $table->dropColumn("so_luong");  //Drop Update
            $table->dropColumn("ghi_chu");  //Drop Update
            $table->dropColumn("ngay_nhap");  //Drop Update
            $table->dropColumn("qr_code_nhap");  //Drop Update
        });
    }
}
