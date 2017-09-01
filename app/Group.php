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

        return $this->belongsToMany(User::class, 'groups_users');
    
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

        for ($i=0; $i<count($this->users)-1; $i++){

            $rounds[$i] = $this->rounds()->create([
                'round_number' => $i+1
                ]);
        }
        
        $groupUsers = ($this->users)->toArray();

        foreach ($rounds as $round){

            $round->generateMatches($groupUsers);

            $first = array_splice($groupUsers,0,1)[0];
            array_unshift($groupUsers, array_pop($groupUsers));
            array_unshift($groupUsers, $first);
            
            $groupUsers;

        }
    }
}