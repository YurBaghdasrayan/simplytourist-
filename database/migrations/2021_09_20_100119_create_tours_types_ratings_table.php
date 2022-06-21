<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTypesRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours_types_ratings', function (Blueprint $table) {
            $table->integer('tour_type_rating_id', true);
            $table->integer('tour_type_id');
            $table->tinyInteger('tour_type_rating');
            $table->text('description_de')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ru')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours_types_ratings');
    }
}
