<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Notification;

class NotificationController extends Controller
{
    //
    public function __construct()
    {
        $this->notification = new Notification();
    }

    public function GetProviderNotification($id)
    {
        return $this->notification->where('provider_id', $id)->get();

    }

    public function GetClintNotification($id)
    {
        return $this->notification->where('user_id', $id)->get();

    }


    public function HandlePushToClintWhenRecivieMessages()
    {
        $input = Request()->all();
        $Title = $input['Title'];
        $Token = $input['Token'];
        $content = array(
            "en" => $Title
        );
        $ProviderData[] = ['ayhage' => '55555'];
        $ProviderData[] = ['type' => 'clint_notification'];
        $fields = array(
            'app_id' => "a3551d54-e1bc-4f12-874c-7f6cb7982f95",
            'include_player_ids' => [$Token],
            'data' => array("data" => $ProviderData),
            'contents' => $content
        );
//        return $fields;
        $fields = json_encode($fields);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic NjY1ZDRkYjYtZDA5NC00NjFlLTlhMWEtNmFkODc0MGIyY2Rk'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

    }
}
