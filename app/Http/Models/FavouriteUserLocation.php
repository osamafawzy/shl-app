<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 29/04/2018
 * Time: 11:46 ص
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class FavouriteUserLocation extends Model
{
    protected $table = 'favourite_user_location';
    protected $primaryKey = 'favourite_user_location_id';
    protected $fillable = ['user_id','label','area','long','lat'];

}