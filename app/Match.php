<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Round;
use App\User;
use App\Group;
use App\Set;
use App\Tournament;


class Match extends Model
{	
	
	public $timestamps = false;

	protected $fillable = [

	'first_player_id', 'second_player_id', 'round_id', 'group_id', 'match_winner', 'match_losser', 'draw', 'match_played', 'first_player_games', 'second_player_games'
	
	];


	public function sets()
	{

		return $this->hasMany(Set::class);
		
	}

	public function group()
	{

		return $this->belongsTo(Group::class);

	}

	public function players()
	{

		return $this->belongsToMany(User::class);
	}

	public function round()
	{

		return $this->belongsTo(Round::class);
	}

	public function tournament()
	{

		return $this->belongsTo(Tournament::class);

	}

	public function generateSets()
	{

		$set_no = 5;

		for($i=1; $i<=$set_no; $i++)
		{
			$set[$i] = $this->sets()->create([
				'set_number' => $i
			]);

		}

	}
	
}
