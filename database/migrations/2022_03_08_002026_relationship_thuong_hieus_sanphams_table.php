<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:20:26
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipthuongHieussanphamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sanphams', function (Blueprint $table) {
            $table->unsignedBigInteger('thuong_hieu_id')->nullable()->after('id');

            // $table->index('thuong_hieu_id');
            // $table->foreign('thuong_hieu_id')
            //     ->references('id')->on('thuong_hieus')
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
            $table->dropColumn('thuong_hieu_id');
            // $table->dropForeign('thuong_hieu_id');
        });
    }
}
