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
	'group_id', 'round_number','start_date', 'end_date', 'player_off', 'matches_played'
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

        $playerFreeNo = round($usersNo/2, 0, PHP_ROUND_HALF_DOWN);
        
        $roundNumber = $this->round_number;

        if ($usersNo % 2 == 0)
        {
        	for($m=0; $m<$usersNo/2; $m++)
        	{   
                $matches[$m] = $this->matches()->create([
                    'first_player_id' => $groupUsers[$m]['id'],
                    'second_player_id' => $groupUsers[$usersNo-1-$m]['id'],
                    'group_id' => $group->id
                    ]);
        	}
        }

        else
        {
            for($m=0; $m<($usersNo-1)/2; $m++)
            {   
                $matches[$m] = $this->matches()->create([
                    'first_player_id' => $groupUsers[$m]['id'],
                    'second_player_id' => $groupUsers[$usersNo-1-$m]['id'],
                    'group_id' => $group->id
                    ]);

            } 
        }

        foreach($matches as $match){
        
            $match->generateSets();
        
        }
    }

}
