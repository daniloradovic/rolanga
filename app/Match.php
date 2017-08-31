<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Round;
use App\User;
use App\Group;


class Match extends Model
{	
	
	public $timestamps = false;

	protected $fillable = [

	'first_player_id', 'second_player_id', 'round_id', 'group_id'
	
	];


	public function sets()
	{

		return $this->hasMany(SetScore::class);
		
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

	
}
