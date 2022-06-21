<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsergroupThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usergroup_themes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('usergroup_id')->index('usergroup_id');
            $table->string('theme', 256);
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('tour_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usergroup_themes');
    }
}
