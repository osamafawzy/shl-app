<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 22/04/2018
 * Time: 03:07 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Services extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'services_id';
    protected $fillable = [

        'services_name_ar',
        'services_name_en',
        'services_name_ur',
        'color',
        'icone',
        'price_type_visiable',
        'price_type',
        'serach_provider_limit',
        'minimum_time_rate_boxwrite',
        'maxmum_schedule_order',
        'provider_credit_limit_type',
        'credit_limit_total',
        'credit_limit_finsih_order'

    ];

    public function getServicesNameArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->services_name_en;
        if (APP::getLocale() == 'ur')
            $value = $this->services_name_ur;
        return $value;

    }

    public function SupSerivcesData()
    {
        return $this->hasMany('App\Http\Models\SubServices', 'services_id');
    }

    public function SubServices()
    {
        return $this->hasMany('App\Http\Models\SubServices', 'services_id');
    }

    public function ServiceType()
    {
        return $this->hasMany('App\Http\Models\ServicesType', 'services_id');
    }

    public function ServicesCity()
    {
        return $this->hasMany('App\Http\Models\ServicesCity', 'services_id');
    }
    public function ServicesZone(){
        return $this->hasMany('App\Http\Models\ServicesZone', 'services_id');

    }

    public function ServicesWorkPreiod()
    {
        return $this->hasMany('App\Http\Models\ServicesWorkPreiod', 'services_id');
    }

    public function ServicesCommission()
    {
        return $this->hasMany('App\Http\Models\ServicesCommission', 'services_id');
    }

}