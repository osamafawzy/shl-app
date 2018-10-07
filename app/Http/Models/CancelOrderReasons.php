<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 14/05/2018
 * Time: 09:48 ص
 */

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class CancelOrderReasons extends Model
{
    protected $table = 'cancel_order_reasons';
    protected $primaryKey = 'cancel_order_reasons_id';
    protected $fillable = [
        'cancel_order_reasons_ar',
        'cancel_order_reasons_en',
        'cancel_order_reasons_ur'
    ];
    public function getCancelOrderReasonsArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->cancel_order_reasons_en;
        if (APP::getLocale() == 'ur')
            $value = $this->cancel_order_reasons_ur;
        return $value;

    }



}