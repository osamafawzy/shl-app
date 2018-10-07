<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 5/25/2018
 * Time: 10:58 AM
 */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
class ServicesTremsConditions extends Model
{
    protected $table = 'services_trems_conditions';
    protected $primaryKey = 'services_trems_conditions_id';
    protected $fillable = [
        'sub_services_id',
        'serivecs_id',
        'terms_ar',
        'terms_en',
        'terms_ur'
    ];


    public function getTermsArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->terms_en;
        if (APP::getLocale() == 'ur')
            $value = $this->terms_ur;
        return $value;

    }

}