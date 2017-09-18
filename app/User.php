<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Role;
use App\Group;
use App\Match;
use App\Set;
use App\Tournament;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'name', 'email', 'password', 'group_id', 'points', 'wins', 'losses', 'draws'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'password', 'remember_token',
    ];


    public function tournaments()
    {

        return $this->belongsToMany(Tournament::class, 'tournaments_users');

    }
    
    public function groups()
    {

        return $this->belongsToMany(Group::class, 'groups_users');

    }

    public function matches()
    {

        return $this->belongsToMany(Match::class);

    }

    public function sets()
    {

        return $this->belongsToMany(Set::class);

    }

    // Displays all the roles of this user
    public function roles()
    {

        return $this->belongsToMany(Role::class)->withTimestamps();

    }
    
    public function assignRole(Role $role)
    {

        return $this->roles()->save($role);
    
    }

    public function hasRole($role)
    {

        if($this->roles()->where('name', $role)->first()){

            return true;
        }
        
        return false;

    }

    // method that checks if there has been any role
    public function hasAnyRole($roles)
    {

        if (is_array($roles)){
            foreach ($roles as $role){
                if($this->hasRole($role)){
                    return true;
                }
            }
        }
        
        else
        {
            if($this->hasRole($roles)){

            }
        }

        return false;
    }

    public function authorizedRoles($roles)
    {

        if($this->hasAnyRole($roles)){
            return true;
        }
        abort(401, 'This action is unauthorized');

    }
}
