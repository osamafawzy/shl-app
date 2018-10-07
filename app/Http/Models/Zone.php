<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 29/04/2018
 * Time: 09:05 ص
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Zone extends Model
{
    protected $table = 'zone';
    protected $primaryKey = 'zone_id';
    protected $fillable = ['city_id', 'zone_ar', 'zone_en', 'zone_ur'];

    public function getZoneArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->zone_en;
        if (APP::getLocale() == 'ur')
            $value = $this->zone_ur;
        return $value;

    }
}