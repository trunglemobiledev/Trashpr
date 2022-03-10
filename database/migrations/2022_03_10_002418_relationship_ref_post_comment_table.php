<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:24:18
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationshipRefpostcommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_post_comment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('comment_id');
            $table->unsignedBigInteger('post_id');
            $table->timestamps();

            // $table->index('comment_id');
            // $table->foreign('comment_id')
            //     ->references('id')
            //     ->on('comments')
            //     ->onDelete('cascade');
            // $table->index('post_id');
            // $table->foreign('post_id')
            //     ->references('id')
            //     ->on('posts')
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
        Schema::dropIfExists('ref_post_comment');
    }
}
