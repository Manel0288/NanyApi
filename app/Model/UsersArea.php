<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersArea extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','area_id',
    ];


    public function user(){
        return $this->belongsTo('App\Model\User');
    }

    public function area(){
        return $this->belongsTo('App\Model\Area');
    }
}
