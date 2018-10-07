<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 16/05/2018
 * Time: 04:29 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TermsCondititon extends Model
{
    protected $table = 'terms_condititon';
    protected $primaryKey = 'terms_condititon_id';
    protected $fillable = [
        'terms_condititon_ar',
        'terms_condititon_en',
        'terms_condititon_ur'
    ];

    public function getTermsCondititonArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->terms_condititon_en;
        if (APP::getLocale() == 'ur')
            $value = $this->terms_condititon_ur;
        return $value;

    }
}