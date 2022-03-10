<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-08 00:22:47
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipnhacCungCapssanphamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sanphams', function (Blueprint $table) {
            $table->unsignedBigInteger('nhac_cung_cap_id')->nullable()->after('id');

            // $table->index('nhac_cung_cap_id');
            // $table->foreign('nhac_cung_cap_id')
            //     ->references('id')->on('nhac_cung_caps')
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
            $table->dropColumn('nhac_cung_cap_id');
            // $table->dropForeign('nhac_cung_cap_id');
        });
    }
}
