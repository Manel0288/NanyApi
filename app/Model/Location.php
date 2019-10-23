<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //,

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'longitude','latitude',
    ];


    public function area(){
        return $this->hasOne('App\Model\Area');
    }

    public function users(){
        return $this->belongsToMany( 'App\Model\User', 'locations_users', 'location_id', 'user_id' );
    }
}
