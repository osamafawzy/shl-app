<?php

namespace App\Http\Models;

use \Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['phone',
        'user_name',
        'email',
        'profile_pic',
        'activate',
        'v_code',
        'type',
        'token_id',
        'city_id',
        'zone_id',
        'lang_id',
        'accommodation_type',
        'type_of_persons'

    ];

    public function Orders()
    {
        return $this->hasMany('App\Http\Models\Order', 'user_id');
    }

    public function Providor()
    {
        return $this->hasMany('App\Http\Models\Providor', 'user_id');
    }

    public function City(){
        return $this->belongsTo('App\Http\Models\City','city_id');
    }
    public function Zone(){
        return $this->belongsTo('App\Http\Models\Zone','zone_id');
    }
}