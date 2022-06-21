<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsergroupInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usergroup_invitations', function (Blueprint $table) {
            $table->foreign('usergroup_id', 'usergroup_invitations_ibfk_1')->references('id')->on('usergroups')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign('user_id', 'usergroup_invitations_ibfk_2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usergroup_invitations', function (Blueprint $table) {
            $table->dropForeign('usergroup_invitations_ibfk_1');
            $table->dropForeign('usergroup_invitations_ibfk_2');
        });
    }
}
