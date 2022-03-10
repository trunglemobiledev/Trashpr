<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:41:21
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipkhosnhapKhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhap_khos', function (Blueprint $table) {
            $table->unsignedBigInteger('kho_id')->nullable()->after('id');

            // $table->index('kho_id');
            // $table->foreign('kho_id')
            //     ->references('id')->on('khos')
            //    ->onDelete('cascade');
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
            $table->dropColumn('kho_id');
            // $table->dropForeign('kho_id');
        });
    }
}
