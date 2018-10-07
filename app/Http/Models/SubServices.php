<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 22/04/2018
 * Time: 03:09 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class SubServices extends Model
{
    protected $table = 'sub_services';
    protected $primaryKey = 'sub_services_id';
    protected $fillable = [
        'services_id',
        'icone',
        'sub_services_name_ar',
        'sub_services_name_en',
        'sub_services_name_ur',
        'visiblity',
        'limit_serach',
        'no_return_req',

    ];
    public function ServicesZone(){
        return $this->hasMany('App\Http\Models\ServicesZone','sub_services_id');
    }
    public function ServicesCity(){
    return $this->hasMany('App\Http\Models\ServicesCity','sub_services_id');
    }

    public function getSubServicesNameArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->sub_services_name_en;
        if (APP::getLocale() == 'ur')
            $value = $this->sub_services_name_ur;
        return $value;

    }


}