<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function times()
    {
        return $this->hasMany(Time::class);
    }
}
