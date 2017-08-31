<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;
use App\User;

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
}
