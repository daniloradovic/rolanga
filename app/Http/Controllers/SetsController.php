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
use App\Role;
use Auth;


class SetsController extends Controller
{

	public function __construct() {

      $this->middleware('auth');
    
    }
    
	public function edit(Request $request, Tournament $tournament, Match $match)
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

			$users = $group->users;

			$playerOneCount = 0;
			
			$playerTwoCount = 0;
			
			$draw = 0;

		if ($match->first_player_id == Auth::id() || $match->second_player_id == Auth::id() || Auth::user()->roles()->where('name', '=', 'admin')->exists()){
			// store games per set results
			for ($i=1; $i<=count($sets); $i++)
			{	
				$id = $sets[$i-1]->id;
				$setIndexPlayer1 = (string)('set'."".$id."".'player1');
				$setIndexPlayer2 = (string)('set'."".$id."".'player2');

				$sets[$i-1]->first_player_games = $request->input($setIndexPlayer1);
				$sets[$i-1]->second_player_games = $request->input($setIndexPlayer2);

				$setAbs = abs($sets[$i-1]->first_player_games - $sets[$i-1]->second_player_games);

				if (($sets[$i-1]->first_player_games == 0) && ($sets[$i-1]->second_player_games == 0))
				{
					$sets[$i-1]->set_winner = null;
					$sets[$i-1]->setPlayed = false;
					$sets[$i-1]->set_draw = false;

				}

				elseif (($sets[$i-1]->first_player_games > $sets[$i-1]->second_player_games) && $setAbs > 1)
				{
					$sets[$i-1]->set_winner = $match->first_player_id;
					$sets[$i-1]->setPlayed = true;
					$sets[$i-1]->set_draw = false;

				}

				elseif ($sets[$i-1]->first_player_games < $sets[$i-1]->second_player_games && $setAbs > 1)
				{
					$sets[$i-1]->set_winner = $match->second_player_id;
					$sets[$i-1]->setPlayed = true;
					$sets[$i-1]->set_draw = false;

				}

				elseif($setAbs <= 1 && ($sets[$i-1]->first_player_games != 0 && $sets[$i-1]->first_player_games != 7 && $sets[$i-1]->second_player_games != 7 ))
				{

					$sets[$i-1]->set_winner = null;
					$sets[$i-1]->set_draw = true;
					$sets[$i-1]->setPlayed = true;
				}

				elseif($setAbs <= 1 && ($sets[$i-1]->second_player_games != 0 && $sets[$i-1]->second_player_games != 7 && $sets[$i-1]->first_player_games != 7))
				{

					$sets[$i-1]->set_winner = null;
					$sets[$i-1]->set_draw = true;
					$sets[$i-1]->setPlayed = true;
				}

				elseif ($setAbs == 1 && $sets[$i-1]->first_player_games == 7)
				{
					$sets[$i-1]->set_winner = $match->first_player_id;
					$sets[$i-1]->setPlayed = true;
					$sets[$i-1]->set_draw = false;
				}

				elseif ($setAbs == 1 && $sets[$i-1]->second_player_games == 7)
				{
					$sets[$i-1]->set_winner = $match->second_player_id;
					$sets[$i-1]->setPlayed = true;
					$sets[$i-1]->set_draw = false;
				}


				$sets[$i-1]->save();
			}

			// Count sets won by each player
			foreach ($sets as $set){
				
				if (($set->set_winner == (int)($set->match->first_player_id)) && ($set->setPlayed = true))
					$playerOneCount ++;

				if (($set->set_winner == (int)($set->match->second_player_id)) && ($set->setPlayed = true))
					$playerTwoCount ++;

				if($set->set_draw == true && $set->setPlayed == true)
					$draw ++;

			}

			// Match final result - winner, losser or a draw
			if ($playerOneCount > $playerTwoCount)
			{
				$match->match_winner = $match->first_player_id;
				$match->match_losser = $match->second_player_id;
				$match->draw = false;
			}

			elseif ($playerOneCount < $playerTwoCount)
			{
				$match->match_winner = $match->second_player_id;
				$match->match_losser = $match->first_player_id;
				$match->draw = false;
			}

			elseif(($playerOneCount == $playerTwoCount) && ($playerOneCount != 0) && ($playerTwoCount != 0))
			{
				$match->match_winner = null;
				$match->match_losser = null;
				$match->draw = true;
			}

			elseif(($draw != 0) && ($playerOneCount == 0) && ($playerTwoCount == 0))
			{
				$match->match_winner = null;
				$match->match_losser = null;
				$match->draw = true;
			}

			elseif($draw == 0)
			{
				$match->match_winner = null;
				$match->match_losser = null;
				$match->draw = false;
			}

			$match->save();

			foreach ($users as $user){
				
				$winsNo = count($group->matches()->where('match_winner', '=', $user->id)->get());
				// $user->wins = $winsNo;
				$lossesNo = count($group->matches()->where('match_losser','=',$user->id)->get());
				// $user->losses = $lossesNo;
				$drawsNo = 0;

				foreach ($group->matches as $match){
					if (($user->id == $match->first_player_id || $user->id == $match->second_player_id) && ($match->draw == true)){
						$drawsNo ++;
					}
				}

				$user->draws = $drawsNo;

				$user->points = $winsNo*3 + $drawsNo;
				
				$userId = $user->id;

				$group->users()->updateExistingPivot($userId, ['wins'=> $winsNo, 'losses' => $lossesNo, 'draws' => $drawsNo, 'points' => ($winsNo*3 + $drawsNo)]);
				
				// $user->save();
			}
			
			return redirect()->route('showGroups', ['tournament' => $tournament->id]);
		}
			else{
				return redirect()->route('showGroups', ['tournament' => $tournament->id])->withErrors(['Nisi autorizovan za ovu akciju MAGARCE', 'The Message']);
			}
	}
}
