<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:36:03
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipRefnhapKhosanphamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_nhap_kho_sanpham', function (Blueprint $table) {
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
        Schema::dropIfExists('ref_nhap_kho_sanpham');
    }
}
