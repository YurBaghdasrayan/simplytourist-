<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('tour_name', 255);
            $table->string('country_iso', 2);
            $table->integer('tour_type_id');
            $table->tinyInteger('tour_type_rating');
            $table->integer('tour_condition_id');
            $table->tinyInteger('tour_condition_rating');
            $table->dateTime('tour_date_start');
            $table->dateTime('tour_date_end');
            $table->text('tour_description');
            $table->text('tour_link');
            $table->string('tour_creator', 64);
            $table->dateTime('tour_created_datetime');
            $table->tinyInteger('attendees_min');
            $table->smallInteger('attendees_max');
            $table->smallInteger('open_places');
            $table->string('guide_needed', 3);
            $table->string('guided', 3);
            $table->decimal('estimated_costs', 10);
            $table->string('tour_status', 49);
            $table->string('edit_lock', 3);
            $table->string('tour_private', 3);
            $table->string('target_longitude', 255);
            $table->string('target_latitude', 255);
            $table->string('target_coordinates', 255);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
}
