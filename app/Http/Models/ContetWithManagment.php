<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 16/05/2018
 * Time: 03:19 م
 */

namespace App\Http\Models;
use Illuminate\Support\Facades\App;


use Illuminate\Database\Eloquent\Model;

class ContetWithManagment extends Model
{

    protected $table='contet_with_managment';
    protected $primaryKey = 'contact_id';
    protected $fillable=[
        'phone',
        'address_ar',
        'address_en',
        'adress_ur',
        'email'
        ];
    public function getAddressArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->address_en;
        if (APP::getLocale() == 'ur')
            $value = $this->adress_ur;
        return $value;

    }
}