<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:18:34
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipdanhMucssanphamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sanphams', function (Blueprint $table) {
            $table->unsignedBigInteger('danh_muc_id')->nullable()->after('id');

            // $table->index('danh_muc_id');
            // $table->foreign('danh_muc_id')
            //     ->references('id')->on('danh_mucs')
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
        Schema::table('sanphams', function (Blueprint $table) {
            $table->dropColumn('danh_muc_id');
            // $table->dropForeign('danh_muc_id');
        });
    }
}
