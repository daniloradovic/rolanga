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


class SetsController extends Controller
{


	public function edit(Tournament $tournament, Match $match)
	{
		
		$group = $match->group;
		$users = $group->users;
		$tournament = $group->tournament;
		// dd($tournament, $match);

		return view('matches.edit', compact('match', 'tournament', 'users'));


	}

	public function update(Request $request)
	{
		$match = Match::find($request->matchId);
		
		$matchId = $request->matchId;
		
		$sets = $match->sets;

		$group = $match->group;

		$tournament = $group->tournament;

		for ($i=1; $i<=count($sets); $i++)
		{	
			$id = $sets[$i-1]->id;
			$setIndexPlayer1 = (string)('set'."".$id."".'player1');
			$setIndexPlayer2 = (string)('set'."".$id."".'player2');

			// dd($request->input($setIndexPlayer1), $request->input($setIndexPlayer2));

			$sets[$i-1]->first_player_games = $request->input($setIndexPlayer1);
			$sets[$i-1]->second_player_games = $request->input($setIndexPlayer2);
			
			$sets[$i-1]->save();
		}

		return redirect()->route('showGroups', ['tournament' => $tournament->id]);

	}
}
