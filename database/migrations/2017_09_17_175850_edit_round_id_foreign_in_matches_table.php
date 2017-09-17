<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditRoundIdForeignInMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropForeign('matches_round_id_foreign');
            $table->dropForeign('matches_group_id_foreign');

            $table->foreign('round_id')->references('id')->on('rounds')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
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
    //         // $table->dropForeign('matches_round_id_foreign');
    //         // $table->dropForeign('matches_group_id_foreign');
    //     });
    // }
}
