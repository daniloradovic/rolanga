<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteStatsFromTournamentsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournaments_users', function (Blueprint $table) {
            $table->dropColumn('wins');
            $table->dropColumn('losses');
            $table->dropColumn('points');
            $table->dropColumn('draws');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournaments_users', function (Blueprint $table) {
             $table->integer('wins');
             $table->integer('losses');
             $table->integer('points');
             $table->integer('draws');
        });
    }
}
