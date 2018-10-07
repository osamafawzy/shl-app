<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 08/05/2018
 * Time: 10:54 ص
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class ServicesType extends Model
{
    protected $table = 'services_type';
    protected $primaryKey = 'services_type_id';
    protected $fillable = [
        'services_id',
        'services_type',
        'serivces_payment_type_id',
        'no_return_requets',
        'offer_count',
        'offer_time',
        'request_time_duration'
    ];



}