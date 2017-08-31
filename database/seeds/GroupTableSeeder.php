<?php

use Illuminate\Database\Seeder;
use App\Group;
use App\Tournament;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = new Group();
    	$group->group_name = 'Grupa A';
    	$group->id = 1;
        $group->tournament_id = 1;
    	$group->save();

    	$group = new Group();
    	$group->group_name = 'Grupa B';
    	$group->id = 2;
        $group->tournament_id = 1;
    	$group->save();
    	
    }
}
