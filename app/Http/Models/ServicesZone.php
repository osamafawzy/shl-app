<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 26/04/2018
 * Time: 03:45 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class ServicesZone extends Model
{
    protected $table = 'services_zone';
    protected $primaryKey = 'services_zone_id';
    protected $fillable = ['sub_services_id', 'zone_id', 'price', 'active', 'notifications'];

    public function Zones()
    {
        return $this->belongsTo('App\Http\Models\Zone', 'zone_id');
    }
}