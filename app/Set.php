<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Tournament;
use App\User;
use App\Group;
use App\Round;
use App\Match;
use Auth;

class Set extends Model
{

	public $timestamps = false;
	
	protected $fillable = [
	'set_number', 'first_player_games', 'second_player_games', 'match_id', 'set_winner', 'setPlayed'
	];    
	
	public function match(){

		return $this->belongsTo(Match::class);
		
	}

}
