<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tournament;
use App\Group;
use App\User;
use App\Round;
use App\Match;

class GroupController extends Controller
{

	// public function index(){


	// 	$groups = Group::all();
	// 	$users = User::all();

	// 	for ($r = 0; $r < $n - 1; $r++) {
	// 		for ($i = 0; $i < $n / 2; $i++) {

	// 			$roundsB[$r][] = [$usersGroupB[$i], $usersGroupB[$n-1 - $i]];
	// 			// $match->round_id = $r;
	// 			// $match->first_player_id = $i;
	// 			// $match->second_player_id = $n-1-$i;	
	// 			// $match->group_id = 2;

	// 		}
	// 	    // Perform round-robin shift, keeping first player in its spot:
	// 		$usersGroupB[] = array_splice($usersGroupB, 1, 1)[0];

	// 	}
	// 	// shift once more to put array in its original sequence:
	// 	$usersGroupB[] = array_splice($usersGroupB, 1, 1)[0];


	// 	return view('groups.index', compact('groups','users'));

	// }

	

	// public function scheduler()
	// {
	// 	$users = array_column((User::all()->where('group_id', '=', 1)->toArray()),'name');

	// 	if (count($users)%2 != 0){
	// 		array_push($users,"bye");
	// 	}

	// 	$away = array_splice($users,(count($users)/2));

	// 	$home = $users;

	// 	for ($i=0; $i < count($home)+count($away)-1; $i++){
	// 		for ($j=0; $j<count($home); $j++){
	// 			$round[$i][$j]["Home"]=$home[$j];
	// 			$round[$i][$j]["Away"]=$away[$j];

	// 		}

	// 		if(count($home)+count($away)-1 > 2){

	// 			array_unshift($away, current(array_splice($home,1,1)));
	// 			array_push($home, array_pop($away));

	// 		}

	// 	}
	// 	dd($round);
	// 	return view('groups.index', compact('groups', 'users', 'round'));

	// }


}
