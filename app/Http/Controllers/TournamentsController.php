<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use App\Tournament;
use App\User;
use App\Group;
use App\Round;
use App\Match;
use Auth;


class TournamentsController extends Controller
{

 	public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function index()
	{

		$tournaments = Tournament::all();

		$users = User::all();
		
		return view('tournaments.index', compact('tournaments'));

	}


	public function create()
	{

		$users = User::all();

		return view('tournaments.create', compact('users'));

	}

	public function store(Request $request)
	{


		$user = Auth::user();

        $roles = $user->roles;
        
        $userIds = $request->user_list;

		$this->validate(request(),
			[
			'tournament_name' => 'required',	
			'groups_number' => 'required',
			'user_list' => 'required',
			'start_date' => 'required'
			]);
		
		$tournament = Tournament::create([
			'tournament_name' => $request->tournament_name,
			'groups_number' => $request->groups_number,
			'start_date' => $request->start_date,
			]);
		
		$tournament->users()->attach($userIds);

		$users = array_column($tournament->users->toArray(),'name');
	
		for ($i=1; $i<=$tournament->groups_number; $i++)
		{
			$groups[$i] = $tournament->groups()->create([
				'group_name' => 'Group'.$i
				]);
			
		}
		
		if ($user->hasRole('admin'))
        {
            $users = $tournament->users;
        } 

		session()->flash('message', 'Your tournament has now been successfully created');

		return redirect()->route('showTournament', ['tournament' => $tournament->id]);

	}

	public function show(Tournament $tournament, User $users)
	{
		
		return view('groups.groups', compact('tournament', 'users'));

	}

	public function generateGroups(Request $request, Tournament $tournament)
	{	
		// if($request->ajax()){
		// 	dd('ajax request');
		// }
		// dd('http');
		$tournament = Tournament::find($request->tournament_id);
		$users = $tournament->users;
		$groups = $tournament->groups;
		$group1_player_ids = $request->group1_player_ids;
		$group2_player_ids = $request->group2_player_ids;
		$group_ids = $request->group_ids;

		$groups[0]->users()->sync($group1_player_ids);
		$groups[1]->users()->sync($group2_player_ids);

		foreach ($groups as $group)
		{
			$groupUsers = ($group->users)->toArray();
			$group->generateRounds();
			$group->save();

		}	

		
		return response()->json(['status' => 'success', 'tournament' => $tournament->id ]);
		// return redirect()->action('TournamentsController@showGroups', ['tournament' => $tournament->id]);

	}

	public function showGroups(Tournament $tournament, Group $groups, User $users, Round $rounds, Match $matches)
	{

		return view('groups.index', compact('tournament', 'users', 'groups', 'rounds', 'matches'));

	}

}
