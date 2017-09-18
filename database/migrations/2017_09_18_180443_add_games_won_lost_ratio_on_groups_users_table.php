<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGamesWonLostRatioOnGroupsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups_users', function (Blueprint $table) {
            $table->integer('games_won');
            $table->integer('games_lost');
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
            $table->dropColumn('games_won');
            $table->dropColumn('games_lost');
        });
    }
}
