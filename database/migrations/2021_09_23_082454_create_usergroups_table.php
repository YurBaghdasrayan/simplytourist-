<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsergroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usergroups', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('usergroup_name', 49);
            $table->text('usergroup_description')->nullable();
            $table->string('usergroup_privat', 3)->nullable();
            $table->string('language_iso', 2)->nullable();
            $table->string('country_iso', 2)->nullable();
            $table->integer('member_count');
            $table->string('edit_lock', 3)->nullable();
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
        Schema::dropIfExists('usergroups');
    }
}
