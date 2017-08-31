<?php

use Illuminate\Database\Seeder;
use App\Tournament;

class TournamentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tournament = new Tournament();
    	$tournament->tournament_name = 'Rolanga';
    	$tournament->id = 1;
    	$tournament->save();
    }
}
