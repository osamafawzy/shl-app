<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 14/05/2018
 * Time: 09:54 ص
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class ProvidersRefusedOrder extends Model
{
    protected $table ='providers_refused_order';
    protected $primaryKey = 'providers_refused_order_id';
    protected $fillable = [
        'provider_id',
        'order_id'
    ];

}