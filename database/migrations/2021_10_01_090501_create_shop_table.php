<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ru', 256)->nullable();
            $table->string('name_en', 256)->nullable();
            $table->integer('name_de')->nullable();
            $table->integer('equipment_id')->nullable();
            $table->integer('equipment_type_id')->nullable();
            $table->integer('shop_url_ru')->nullable();
            $table->integer('shop_url_en')->nullable();
            $table->integer('shop_url_de')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('is_default', 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop');
    }
}
