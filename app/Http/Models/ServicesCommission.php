<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 03/06/2018
 * Time: 03:07 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class ServicesCommission extends Model
{
    protected $table = 'services_commission';
    protected $primaryKey = 'services_commission_id';
    protected $fillable = [
        'services_id',
        'commission_type',
        'commission_precent',
        'commission_cash'
    ];

}