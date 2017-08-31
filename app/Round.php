<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Match;
use App\Group;
use App\User;

class Round extends Model
{	
	public $timestamps = false;

	protected $fillable = [
	'group_id', 'round_number'
	];

	public function matches()
	{

		return $this->hasMany(Match::class);

	}

	public function group()
	{

		return $this->belongsTo(Group::class);
	}


	public function generateMatches($groupUsers)
    {   
        $group = $this->group;

        // $groupUsers = ($group->users)->toArray();
        
        $usersNo = count($group->users);

        $roundNumber = $this->round_number;

    	for($m=0; $m<$usersNo/2; $m++)
    	{   
            $matches[$m] = $this->matches()->create([
                'first_player_id' => $groupUsers[$m]['id'],
                'second_player_id' => $groupUsers[$usersNo-1-$m]['id'],
                'group_id' => $group->id
                ]);
    	}
        $first = array_splice($groupUsers,0,1)[0];
        array_unshift($groupUsers, array_pop($groupUsers));
        array_unshift($groupUsers, $first);

        return ('$groupUsers');

        // dd($first = array_splice($groupUsers, 0, 1)[0], array_unshift($groupUsers, array_pop($groupUsers)), array_unshift($groupUsers, $first), $groupUsers);
    
    }

}