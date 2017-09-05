<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;
use App\User;
use App\Match;

class Tournament extends Model
{	


	protected $fillable = [
	'tournament_name', 'groups_number', 'from_date', 'user_list'
	];

	public function groups()
	{

		return $this->hasMany(Group::class);

	}

	public function users()
	{

		return $this->belongsToMany(User::class, 'tournaments_users');
	
	}

	public function matches()
	{

		return $this->hasMany(Match::class);

	}
}
