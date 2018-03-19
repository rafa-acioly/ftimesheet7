<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Sector;
use App\Role;
use App\Time;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'sector_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sectors()
    {
        return $this->hasOne(Sector::class, 'id', 'sector_id');
    }

    public function roles()
    {
        return $this->hasOne(Role::class);
    }

    public function times()
    {
        return $this->hasmany(Time::class);
    }
}
