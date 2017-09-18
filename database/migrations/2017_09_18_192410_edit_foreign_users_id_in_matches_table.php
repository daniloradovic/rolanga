<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditForeignUsersIdInMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropForeign('matches_first_player_id_foreign');
            $table->dropForeign('matches_second_player_id_foreign');
            
            $table->foreign('first_player_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('second_player_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::table('matches', function (Blueprint $table) {
    //         //
    //     });
    // }
}
