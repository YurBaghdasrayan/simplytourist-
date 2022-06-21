<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_type', function (Blueprint $table) {
            $table->integer('equipment_type_id', true);
            $table->string('name_en', 190)->nullable()->unique('equipment_type_en_UNIQUE');
            $table->string('name_de', 191)->nullable()->unique('equipment_type_de_UNIQUE');
            $table->string('name_ru', 191)->nullable()->unique('equipment_type_ru_UNIQUE');
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
        Schema::dropIfExists('equipment_type');
    }
}
