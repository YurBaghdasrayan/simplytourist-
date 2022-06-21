<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string('about_surname', 64)->nullable();
            $table->string('about_forename', 64)->nullable();
            $table->string('about_phone', 50)->nullable();
            $table->string('settings_phone_visible_for_simplytourit_only', 3)->nullable();
            $table->string('settings_phone_visible_for_tour_admin_only', 3)->nullable();
            $table->string('settings_phone_visible_for_all_tour_members', 3)->nullable();
            $table->string('settings_phone_visible_for_group_admin_only', 3)->nullable();
            $table->string('settings_phone_visible_for_all_group_members', 3)->nullable();
            $table->string('settings_email_visible_for_simplytourit_only', 3)->nullable();
            $table->string('settings_email_visible_for_tour_admin_only', 3)->nullable();
            $table->string('settings_email_visible_for_all_tour_members', 3)->nullable();
            $table->string('settings_email_visible_for_group_admin_only', 3)->nullable();
            $table->string('settings_email_visible_for_all_group_members', 3)->nullable();
            $table->string('certification_mountain_guide', 3)->nullable();
            $table->string('certification_mountain_guide_approved', 3)->nullable();
            $table->string('certification_hiking_guide', 3)->nullable();
            $table->string('certification_hiking_guide_approved', 3)->nullable();
            $table->text('certification_note')->nullable();
            $table->text('about_me')->nullable();
            $table->string('about_address_street', 255)->nullable();
            $table->string('about_address_zip_code', 255)->nullable();
            $table->string('about_address_city', 255)->nullable();
            $table->string('about_address_country', 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sec_users');
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('surname');
            $table->dropColumn('forename');
            $table->dropColumn('phone');
            $table->dropColumn('phone_visible_for_simplytourit_only');
            $table->dropColumn('phone_visible_for_tour_admin_only');
            $table->dropColumn('phone_visible_for_all_tour_members');
            $table->dropColumn('phone_visible_for_group_admin_only');
            $table->dropColumn('phone_visible_for_all_group_members');
            $table->dropColumn('email_visible_for_simplytourit_only');
            $table->dropColumn('email_visible_for_tour_admin_only');
            $table->dropColumn('email_visible_for_all_tour_members');
            $table->dropColumn('email_visible_for_group_admin_only');
            $table->dropColumn('email_visible_for_all_group_members');
            $table->dropColumn('certification_mountain_guide');
            $table->dropColumn('certification_mountain_guide_approved');
            $table->dropColumn('certification_hiking_guide');
            $table->dropColumn('certification_hiking_guide_approved');
            $table->dropColumn('certification_note');
            $table->dropColumn('about_me');
            $table->dropColumn('address_street');
            $table->dropColumn('address_zip_code');
            $table->dropColumn('address_city');
            $table->dropColumn('address_country');
        });
    }
}
