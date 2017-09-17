<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatsToGroupsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups_users', function (Blueprint $table) {
            $table->integer('points');
            $table->integer('wins');
            $table->integer('losses');
            $table->integer('draws');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups_users', function (Blueprint $table) {
            $table->dropColumn('points');
            $table->dropColumn('wins');
            $table->dropColumn('losses');
            $table->dropColumn('draws');
        });
    }
}
