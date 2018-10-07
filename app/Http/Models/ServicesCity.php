<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 29/04/2018
 * Time: 11:11 ص
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class ServicesCity extends Model
{
    protected $table = 'services_city';
    protected $primaryKey = 'services_city_id';
    protected $fillable = ['services_id','sub_serivces_id', 'city_id', 'active', 'notification'];

    public function City()
    {
       return $this->belongsTo('App\Http\Models\City', 'city_id');
    }

}