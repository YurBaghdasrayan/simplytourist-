<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name_en', 191)->nullable()->unique('name_en_UNIQUE');
            $table->string('name_de', 191)->nullable()->unique('name_de_UNIQUE');
            $table->string('name_ru', 191)->nullable()->unique('name_ru_UNIQUE');
            $table->integer('equipment_type_id')->nullable()->index('equipment_type_id');
            $table->string('packlist_hiking_daytour', 3)->nullable();
            $table->string('packlist_skitour', 3)->nullable();
            $table->string('packlist_via_ferrata', 3)->nullable();
            $table->string('packlist_ice_climbing', 3)->nullable();
            $table->string('packlist_bouldering_on_rock', 3)->nullable();
            $table->string('packlist_expedition', 3)->nullable();
            $table->string('packlist_indoor_climbing', 3)->nullable();
            $table->string('packlist_snowshoe_tour', 3)->nullable();
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
        Schema::dropIfExists('equipment');
    }
}
