<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label','adresse', 'category', 'location_id', 'child_id', 'from', 'to'
    ];

    protected $casts = [
        'from' => 'hh:mm',
        'to' => 'hh:mm'
    ];

    public function location(){
        return $this->belongsTo('App\Model\Location');
    }

    public function user_areas(){
        return $this->hasMany('App\Model\UsersArea', 'users_areas');
    }

    public function toArray() {
        $array = parent::toArray();
        $array['latitude'] = $array['location']['latitude'];
        $array['longitude'] = $array['location']['longitude'];
        unset($array['location']);
        unset($array['created_at']);
        unset($array['updated_at']);
        return $array;
    }
}
