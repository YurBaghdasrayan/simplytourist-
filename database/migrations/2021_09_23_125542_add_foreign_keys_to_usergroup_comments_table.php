<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsergroupCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usergroup_comments', function (Blueprint $table) {
            $table->foreign('user_id', 'usergroup_comments_ibfk_1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('theme_id', 'usergroup_comments_ibfk_2')->references('id')->on('usergroup_themes')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usergroup_comments', function (Blueprint $table) {
            $table->dropForeign('usergroup_comments_ibfk_1');
            $table->dropForeign('usergroup_comments_ibfk_2');
        });
    }
}
