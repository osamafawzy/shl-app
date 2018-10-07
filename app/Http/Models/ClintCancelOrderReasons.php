<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 14/05/2018
 * Time: 03:27 م
 */

namespace App\Http\Models;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;

class ClintCancelOrderReasons extends Model
{
    protected $table = 'clint_cancel_order_reasons';
    protected $primaryKey = 'clint_rate_order_reasons_id';
    protected $fillable = [
        'clint_rate_order_reasons_ar',
        'clint_rate_order_reasons_en',
        'clint_rate_order_reasons_ur'

    ];

    public function getClintCancelOrderReasonsArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->clint_rate_order_reasons_en;
        if (APP::getLocale() == 'ur')
            $value = $this->clint_rate_order_reasons_ur;
        return $value;


    }
}