<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Group;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_player = Role::where('name', 'player')->first();
    	$role_admin  = Role::where('name', 'admin')->first();

    	$player = new User();
    	$player->name = 'Sreten Radulovic';
    	$player->email = 'sreten@example.com';
    	$player->password = bcrypt('secret');
    	$player->save();
    	$player->roles()->attach($role_player);
    	
		$player = new User();
    	$player->name = 'Relja Perisic';
    	$player->email = 'relja@example.com';
    	$player->password = bcrypt('secret');
    	$player->save();
    	$player->roles()->attach($role_player);

    	$player = new User();
    	$player->name = 'Pavle Vujosevic';
    	$player->email = 'pavle@example.com';
    	$player->password = bcrypt('secret');
    	$player->save();
    	$player->roles()->attach($role_player);

    	$player = new User();
    	$player->name = 'Nikola Ljumovic';
    	$player->email = 'Nikola@example.com';
    	$player->password = bcrypt('secret');
    	$player->save();
    	$player->roles()->attach($role_player);

    	$player = new User();
    	$player->name = 'Dusan Sekulic';
    	$player->email = 'dusan@example.com';
    	$player->password = bcrypt('secret');
    	$player->save();
    	$player->roles()->attach($role_player);

    	$player = new User();
    	$player->name = 'Danilo Raickovic';
    	$player->email = 'danilorai@example.com';
    	$player->password = bcrypt('secret');
    	$player->save();
    	$player->roles()->attach($role_player);

    	$player = new User();
    	$player->name = 'Jovan Cicmil';
    	$player->email = 'jovanc@example.com';
    	$player->password = bcrypt('secret');
    	$player->save();
    	$player->roles()->attach($role_player);

    	$player = new User();
    	$player->name = 'Dragan Cabarkapa';
    	$player->email = 'dragan@example.com';
    	$player->password = bcrypt('secret');
    	$player->save();
    	$player->roles()->attach($role_player);

    	$player = new User();
    	$player->name = 'Bojan Rosandic';
    	$player->email = 'bojan@example.com';
    	$player->password = bcrypt('secret');
    	$player->save();
    	$player->roles()->attach($role_player);

    	$player = new User();
    	$player->name = 'Jovan Gosovic';
    	$player->email = 'jovang@example.com';
    	$player->password = bcrypt('secret');
    	$player->save();
    	$player->roles()->attach($role_player);

    	$player = new User();
    	$player->name = 'Dragan Gazivoda';
    	$player->email = 'dragang@example.com';
    	$player->password = bcrypt('secret');
    	$player->save();
    	$player->roles()->attach($role_player);

    	$admin = new User();
    	$admin->name = 'Danilo Radovic';
    	$admin->email = 'daniloradovic86@gmail.com';
    	$admin->password = bcrypt('pokerica24');
    	$admin->save();
    	$admin->roles()->attach($role_admin);


       // $user = factory(App\User::class)->create([
       //  'name' => 'Danilo Radovic',
       //  'email' => 'daniloradovic86@gmail.com',
       //  'password' => bcrypt('secret'),
       //  'remember_token' => str_random(10),
       //  ]);

       // $user->roles()->attach($role_admin);


    }
}
