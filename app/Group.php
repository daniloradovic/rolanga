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

        return $this->belongsToMany(User::class, 'groups_users')->withPivot('user_id','group_id','points','wins','losses','draws','matches_played', 'games_won', 'games_lost', 'game_ratio')->orderBy('pivot_points','desc')->orderBy('pivot_game_ratio', 'desc');

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
        $roundStart = $start->subDays(7);    

        $userNumber = $this->users->count();
        $loopNumber = ($userNumber % 2 == 0) ? ($userNumber - 1) * 2 : $userNumber * 2;

        for ($i = 0; $i < $loopNumber; $i++)
        {
            
            $roundStart->addDays(7);
            $rounds[$i] = $this->rounds()->create([
                'round_number' => $i+1,
                'start_date' => $roundStart
            ]);

        }

        // if((count($this->users)) % 2 != 0){

        //     for ($i=0; $i<(count($this->users))*2; $i++){
        //         $roundStart->addDays(7);
        //         $rounds[$i] = $this->rounds()->create([
        //             'round_number' => $i+1,
        //             'start_date' => $roundStart)
        //             ]);
        //     }
        // }

        // else {

        //     for ($i=0; $i<(count($this->users) - 1) * 2; $i++){
        //         $roundStart->addDays(7);
        //         $rounds[$i] = $this->rounds()->create([
        //             'round_number' => $i+1,
        //             'start_date' => date('Y-m-d', strtotime("+$i weeks $start"))
        //             ]);
        //     }
        // }
        
        $groupUsers = ($this->users)->toArray();
        
        $usersNo = count($this->users);

        $playerFreeNo = round($usersNo/2, 0, PHP_ROUND_HALF_DOWN);        
        
        foreach ($rounds as $round){

            $round->generateMatches($groupUsers);
            
            if($usersNo % 2 != 0)
            {
                $round->player_off = $groupUsers[$usersNo-1]['id'];
                $round->save();

                // $last = array_splice($groupUsers,$usersNo-1,1);

                array_unshift($groupUsers, array_pop($groupUsers));
                // array_unshift($groupUsers, $last);
            }
            elseif($usersNo % 2 == 0){
            
                $first = array_splice($groupUsers,0,1)[0];

                array_unshift($groupUsers, array_pop($groupUsers));
                array_unshift($groupUsers, $first);
            }

        }
    }
}