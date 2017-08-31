<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('first_player_id')->unsigned();
            $table->integer('second_player_id')->unsigned();
            $table->integer('round_id')->unsigned();
            $table->integer('group_id')->unsigned();
        });
        
        Schema::table('matches', function($table) {
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('round_id')->references('id')->on('rounds');
            $table->foreign('first_player_id')->references('id')->on('users');
            $table->foreign('second_player_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
        
    }
}
