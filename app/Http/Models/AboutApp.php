<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 16/05/2018
 * Time: 04:53 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class AboutApp extends Model
{
    protected $table='aboutapp';
    protected $primaryKey ='id';
    protected $fillable = [
        'aboutapp_ar',
        'aboutapp_en',
        'aboutapp_ur'
    ];

    public function getAboutappArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->aboutapp_en;
        if (APP::getLocale() == 'ur')
            $value = $this->aboutapp_ur;
        return $value;

    }

}