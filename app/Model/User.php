<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom','prenom', 'email', 'password','adresse', 'tel','role_id','image_url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function children(){
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Model\Role');
    }

    public function user_areas(){
        return $this->hasMany('App\Model\UsersArea', 'users_areas');
    }

    public function locations(){
        return $this->belongsToMany( 'App\Model\Location', 'locations_users', 'user_id', 'location_id' )->latest();
    }
}
