<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 30/05/2018
 * Time: 10:35 ص
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $table = 'ads';
    protected $fillable = ['pic'];
    protected $primaryKey = 'ads_id';
}