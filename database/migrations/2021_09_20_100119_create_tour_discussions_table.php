<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_discussions', function (Blueprint $table) {
            $table->integer('tour_discussion_id', true);
            $table->integer('tour_id');
            $table->string('theme', 100);
            $table->string('login', 255);
            $table->dateTime('comment_datetime');
            $table->text('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_discussions');
    }
}
