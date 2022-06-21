<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursConditionsRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours_conditions_ratings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tour_condition_id');
            $table->tinyInteger('tour_condition_rating');
            $table->text('description_de')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ru')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours_conditions_ratings');
    }
}
