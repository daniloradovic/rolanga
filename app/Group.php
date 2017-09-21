<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Round;
use App\Match;
use App\Tournament;
use App\User;

class Group extends Model
{
    
    protected $fillable = [

    'group_name', 'tournament_id'
    
    ];

    // one to many relationship with users
    public function users()
    {

        return $this->belongsToMany(User::class, 'groups_users')->withPivot('user_id','group_id','points','wins','losses','draws','matches_played', 'games_won', 'games_lost')->orderBy('pivot_points','desc');
    
    }

    // one to many relationship with matches
    public function matches()
    {

    	return $this->hasMany(Match::class);
    }


    public function rounds()
    {

        return $this->hasMany(Round::class);
    }

    public function tournament()
    {

        return $this->belongsTo(Tournament::class);
    }


    public function generateRounds()
    {
       
        $start = $this->tournament->start_date;

        for ($i=0; $i<(count($this->users))*2-2; $i++){

            $rounds[$i] = $this->rounds()->create([
                'round_number' => $i+1,
                'start_date' => date('Y-m-d', strtotime("+$i weeks $start"))
                ]);
        }
        
        $groupUsers = ($this->users)->toArray();
        
        $usersNo = count($groupUsers);

        $playerFreeNo = round($usersNo/2, 0, PHP_ROUND_HALF_DOWN);        
        
        foreach ($rounds as $round){

            $round->generateMatches($groupUsers);
            
            if($usersNo % 2 != 0)
            {
                $round->player_off = $groupUsers[$usersNo-1]['id'];
                $round->save();
            }
            
            $first = array_splice($groupUsers,0,1)[0];
           
            array_unshift($groupUsers, array_pop($groupUsers));
           
            array_unshift($groupUsers, $first);
            
            $groupUsers;

            

        }
    }
}