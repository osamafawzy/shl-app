<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 01/05/2018
 * Time: 02:06 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'order_id';
    protected $fillable = [
        'services_id',
        'sub_services_id',
        'user_id',
        'user_lat',
        'user_long',
        'provider_id',
        'order_state',
        'cancel_order_reasons_id',
        'cancel_order_reasons_text',
        'clint_rate_order_reasons_id',
        'clint_rate_order_text',
        'scheduling_orders',
        'rate'

    ];

    public function Service()
    {
        return $this->belongsTo('App\Http\Models\Services', 'services_id');
    }

    public function SubServices()
    {
        return $this->belongsTo('App\Http\Models\SubServices', 'sub_services_id');
    }

    public function Provider()
    {
        return $this->belongsTo('App\Http\Models\Providor', 'provider_id');

    }

    public function Users()
    {
        return $this->belongsTo('App\Http\Models\Users', 'user_id');
    }

    public function CancelOrderReasons()
    {
        return $this->belongsTo('App\Http\Models\CancelOrderReasons', 'cancel_order_reasons_id');
    }

}