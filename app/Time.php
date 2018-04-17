<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'client_id',
        'sector_id',
        'duration'
    ];

    protected $timestamp = true;
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function clients()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
}
