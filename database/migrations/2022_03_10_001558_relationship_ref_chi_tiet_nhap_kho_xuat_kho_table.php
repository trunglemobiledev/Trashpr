<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelationshipRefChiTietNhapKhoXuatKhoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ChiTietXuatKho', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sanpham_id');
            $table->unsignedBigInteger('nhap_kho_id');
            $table->timestamps();

            // $table->index('sanpham_id');
            // $table->foreign('sanpham_id')
            //     ->references('id')
            //     ->on('sanphams')
            //     ->onDelete('cascade');
            // $table->index('nhap_kho_id');
            // $table->foreign('nhap_kho_id')
            //     ->references('id')
            //     ->on('nhap_khos')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
