<?php

use Illuminate\Database\Seeder;

use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_player = new Role();
    	$role_player->name = 'player';
    	$role_player->description = 'Player User';
    	$role_player->save();
    	
    	$role_admin = new Role();
    	$role_admin->name = 'admin';
    	$role_admin->description = 'Admin User';
    	$role_admin->save();
    }
}
