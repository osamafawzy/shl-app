<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 24/05/2018
 * Time: 02:22 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class ServicesRequuerments extends Model
{
    protected $table = 'services_requuerments';
    protected $primaryKey = 'services_requuerments_id';
    protected $fillable = ['services_id', 'sub_services_id', 'requerment_id'];

}