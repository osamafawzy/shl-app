<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Providor extends Model
{
    protected $table = 'providor';
    protected $primaryKey = 'provider_id';
    protected $fillable = [
        'user_id',
        'license_number',
        'vehicle_number',
        'vehicle_type',
        'services_id',
        'sub_services_id',
        'personal_pic',
        'license_pic',
        'lat',
        'long',
        'active',
        'rate',
        'city_id'
    ];

    public function Users(){

        return $this->belongsTo('App\Http\Models\Users','user_id');
    }

}