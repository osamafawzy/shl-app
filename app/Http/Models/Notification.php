<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 28/05/2018
 * Time: 03:32 م
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;


class Notification extends Model
{
    protected $table = 'notification';
    protected $primaryKey = 'notification_id';
    protected $fillable = [
        'notification_ar',
        'notification_en',
        'notification_ur',
        'user_id',
        'provider_id',
        'services_id',
        'sub_services_id',
        'zone_id'
    ];

    public function getNotificationArAttribute($value)
    {

        if (App::getLocale() == 'en')
            $value = $this->notification_en;
        if (APP::getLocale() == 'ur')
            $value = $this->notification_ur;
        return $value;

    }

}