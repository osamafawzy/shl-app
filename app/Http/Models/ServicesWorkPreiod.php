<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 03/06/2018
 * Time: 03:20 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class ServicesWorkPreiod extends Model
{
    protected $table = 'services_work_preiod';
    protected $fillable = [
        'services_id',
        'type',
        'saturday',
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'from_hr',
        'to_hr'

    ];
    protected $primaryKey = 'services_work_preiod_id';

}