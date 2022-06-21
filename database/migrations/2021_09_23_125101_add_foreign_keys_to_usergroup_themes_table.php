<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsergroupThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usergroup_themes', function (Blueprint $table) {
            $table->foreign('usergroup_id', 'usergroup_themes_ibfk_2')->references('id')->on('usergroups')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign('user_id', 'usergroup_themes_ibfk_3')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usergroup_themes', function (Blueprint $table) {
            $table->dropForeign('usergroup_themes_ibfk_2');
            $table->dropForeign('usergroup_themes_ibfk_3');
        });
    }
}
