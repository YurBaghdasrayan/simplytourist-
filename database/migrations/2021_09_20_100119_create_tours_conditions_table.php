<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours_conditions', function (Blueprint $table) {
            $table->integer('tour_condition_id', true);
            $table->string('name_en', 255);
            $table->text('description_en')->nullable();
            $table->string('name_de', 255)->nullable();
            $table->text('description_de');
            $table->string('name_ru', 255);
            $table->text('description_ru');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours_conditions');
    }
}
