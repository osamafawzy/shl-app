<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 24/05/2018
 * Time: 02:19 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Requerments extends Model
{
    protected $table = 'requerments';
    protected $primaryKey = 'requerments_id';
    protected $fillable = ['requerments_ar', 'requerments_en', 'requerments_ur'];

    public function ServicesRequierments()
    {
        return $this->hasMany('App\Http\Models\ServicesRequuerments', 'requerment_id');
    }

    public function getRequermentsArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->requerments_en;
        if (APP::getLocale() == 'ur')
            $value = $this->requerments_ur;
        return $value;

    }
}