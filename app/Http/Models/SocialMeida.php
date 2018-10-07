<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 16/05/2018
 * Time: 03:21 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class SocialMeida extends Model
{
    protected $table = 'socialmeida';
    protected $primaryKey = 'socialmeida_id';
    protected $fillable = [
        'icone',
        'url'
    ];

}