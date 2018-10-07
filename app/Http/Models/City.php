<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 29/04/2018
 * Time: 11:17 ص
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class City extends Model
{
    protected $table = 'city';
    protected $primaryKey = 'city_id';
    protected $fillable = ['city_ar','city_en','city_ur'];

    public function getCityArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->city_en;
        if (APP::getLocale() == 'ur')
            $value = $this->city_ur;
        return $value;

    }

}