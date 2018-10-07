<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Models\Order;
use App\Http\Models\Providor;
use App\Http\Models\Services;
use App\Http\Models\SubServices;
use App\Http\Models\ServicesType;
use App\Http\Models\Users;
use App\Http\Models\ServicesZone;
use App\Http\Models\Zone;
use App\Http\Models\ProvidersRefusedOrder;
use App\Http\Models\CancelOrderReasons;
use App\Http\Models\ClintCancelOrderReasons;


class OrderContreoller extends Controller
{

    public function __construct()
    {
        $this->order = new Order();
        $this->providor = new Providor();
        $this->services = new Services();
        $this->sub_services = new SubServices();
        $this->service_type = new ServicesType();
        $this->users = new Users();
        $this->services_zone = new ServicesZone();
        $this->zone = new Zone();
        $this->provider_rfused_order = new ProvidersRefusedOrder();
        $this->cancel_order_reasonse = new CancelOrderReasons();
        $this->clint_cancel_order_reasonse = new ClintCancelOrderReasons();

    }


    public function CreateOrder()
    {
        global $user_lat;
        global $user_long;
        global $services_id;
        $input = Request()->all();
        /*create order*/
        $output = $this->order->create($input);
        $user_lat = $output->user_lat;
        $user_long = $output->user_long;
        $services_id = $output->services_id;
        $order_id = $output->order_id;

        $this->SerachForNearsetProvider($user_lat, $user_long, $services_id, $order_id);

        return ['state' => '202'];

    }

    public function SerachForNearsetProvider($user_lat, $user_long, $services_id, $order_id)
    {
        /*gloabal Variabal start*/
        global $serach_provider_limit;
        global $provider_id;
        global $token_id;
        global $request_time_duration;
        global $ServiceData;
        global $ServiceZone;
        global $price;
        global $zone_ar;
        global $lang_id;
        global $Title;
        global $zone_en;
        global $zone_ur;
        global $zone;
        global $ProviderRefused;
        $ProviderRefused = array();
        /*end*/

        /*get Kolometer to Serach in this services*/
        $kilomiterQuery = $this->services
            ->select('serach_provider_limit')
            ->where('services_id', $services_id)
            ->get();

        foreach ($kilomiterQuery as $KilomiterData) {
            $serach_provider_limit = $KilomiterData->serach_provider_limit;
        }
        /*end*/


        /* get Previos Privders Refused this Order */
        $PrviderRefusedQuery = $this->provider_rfused_order->where('order_id', $order_id)->get();

        /*check if empty query*/
        if (empty($PrviderRefusedQuery)) {
            foreach ($PrviderRefusedQuery as $ProvderRefusedData) {
                $provider_id = $ProvderRefusedData->provider_id;
                array_push($ProviderRefused, $provider_id);
            }

            /*find Nerset Privider within Spicific Kilometer*/
            $ProvderQuery = $this->providor
                ->select(
                    $this->providor->getTable() . '.*',
                    DB::raw('(3959 * acos(cos(radians(' . $user_lat . ')) * cos(radians("lat")) * cos( radians("long") - radians(' . $user_long . ')) + sin(radians(' . $user_lat . ')) * 
sin(radians("lat")))) 
AS distance_in_km')
                )
                ->whereIN($this->providor->provider_id, $ProviderRefused)
                ->having('distance_in_km', '>', $serach_provider_limit)
                ->get();
            foreach ($ProvderQuery as $ProviderData) {
                $provider_id = $ProviderData->provider_id;
            }
            /*end serach*/

        } else {
            /*find Nerset Privider within Spicific Kilometer*/
            $ProvderQuery = $this->providor
                ->select(
                    $this->providor->getTable() . '.*',
                    DB::raw('(3959 * acos(cos(radians(' . $user_lat . ')) * cos(radians("lat")) * cos( radians("long") - radians(' . $user_long . ')) + sin(radians(' . $user_lat . ')) * 
sin(radians("lat")))) 
AS distance_in_km')
                )
                ->having('distance_in_km', '>', $serach_provider_limit)
                ->get();
            foreach ($ProvderQuery as $ProviderData) {
                $provider_id = $ProviderData->provider_id;
            }
            /*end serach*/

        }
        /* end */

        /*get provdier Token*/
        $TokenQuery = $this->users
            ->select('token_id', 'lang_id')
            ->join($this->providor->getTable(), $this->users->getTable() . '.user_id', $this->providor->getTable() . '.user_id')
            ->where($this->providor->getTable() . '.provider_id', $provider_id)
            ->get();


        foreach ($TokenQuery as $TokenData) {
            $token_id = $TokenData->token_id;
            $lang_id = $TokenData->lang_id;
        }

        /*end*/

        /*get request_time_duration*/
        $TimeDurationQuery = $this->service_type
            ->select('request_time_duration')
            ->where('services_id', $services_id)
            ->get();
        /*end*/
        foreach ($TimeDurationQuery as $TimeDurationData) {

            $request_time_duration = $TimeDurationData->request_time_duration;
        }
        /*end*/

        /*get ServiceZone and PriceService */
        $ServiceDataQuerty = $this->services
            ->with(['SupSerivcesData' => function ($query) {
                $query->with(['ServicesZone' => function ($query2) {
                    $query2->with('Zones');
                }]);
            }])
            ->where($this->services->getTable() . '.services_id', $services_id)
            ->get();

        foreach ($ServiceDataQuerty as $ServiceData) {
            $ServiceData = $ServiceData->SupSerivcesData;
            foreach ($ServiceData as $ServiceZone) {
                $ServiceZone = $ServiceZone->ServicesZone;
                foreach ($ServiceZone as $GetPrice) {
                    $price = $GetPrice->price;
                    $zone_ar = $GetPrice->Zones->zone_ar;
                    $zone_en = $GetPrice->Zones->zone_en;
                    $zone_ur = $GetPrice->Zones->zone_ur;

                }
            }
        }
        /*end*/

        /*title lang*/
        if ($lang_id == 'ar') {
            $Title = 'لديك طلب جديد';
            $zone = $zone_ar;
        } else if ($lang_id == 'en') {
            $Title = 'You have a new request';
            $zone = $zone_en;
        } else if ($lang_id == 'ur') {
            $Title = 'آپ کی نئی درخواست ہے';
            $zone = $zone_ur;
        }
        /*end */

        $this->PushNotificationToProvider($token_id, $Title, $request_time_duration, $price, $zone, $order_id);
    }

    public function PushNotificationToProvider($Token, $Title, $request_time_duration, $price, $zone, $order_id)
    {


        $content = array(
            "en" => $Title
        );

        $fields = array(
            'app_id' => "6f9fbf9d-b26e-477a-9710-ed334b1a274b",
            'include_player_ids' => array($Token),
            'data' => array(
                "title" => $Title,
                "duration" => $request_time_duration,
                "pric" => $price,
                "zone" => $zone,
                "order_id" => $order_id

            ),
            'contents' => $content
        );

        $fields = json_encode($fields);
//        print("\nJSON sent:\n");
//        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic MmE0MTg4YWQtY2NlOS00ODEwLTg3YTUtNWE3MjNjZDNkZDY1'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

//        $url = "https://fcm.googleapis.com/fcm/send";
//        $token = $Token;
//        $serverKey = 'AAAAmpFst3U:APA91bE_XLKDIJBw8dRsf90q_cmAyHqoPlVFvDwQHHyQ57VmTbDPM4P7jYXKHsW0UAA6_4ODrGrO7v16I8cp97CfPm9hyou4gL-UAou8QcnSFq_o8pgaIsmnvJ0JuhHhpqX3wv7aIDTU';
//        $title = $Title;
//        $body = array(
//            "title" => $Title,
//            "duration" => $request_time_duration,
//            "pric" => $price,
//            "zone" => $zone,
//            "order_id" => $order_id
//        );
//        $notification = array('title' => $title, 'text' => $body, 'sound' => 'default', 'badge' => '1');
//        $arrayToSend = array('to' => $Token, 'notification' => $notification, 'priority' => 'high');
////         print_r($arrayToSend);
//        $json = json_encode($arrayToSend);
//        $headers = array();
//        $headers[] = 'Content-Type: application/json';
//        $headers[] = 'Authorization: key=' . $serverKey;
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//
//        $respons = curl_exec($ch);
////        if ($respons === FALSE) {
////            die('FCM Send Error: ' . curl_error($respons));
////        } else {
////         echo   $respons;
////        }
//
//        curl_close($ch);

    }

    public function RefusedOrder()
    {
        global $user_lat;
        global $user_long;
        global $services_id;

        $input = Request()->all();
        $this->provider_rfused_order->create($input);

        $order_id = $input['order_id'];

        $OrderQuery = $this->order->where('order_id', $order_id)->get();
        foreach ($OrderQuery as $OrderData) {
            $user_lat = $OrderData->user_lat;
            $user_long = $OrderData->user_long;
            $services_id = $OrderData->services_id;
        }

        $this->SerachForNearsetProvider($user_lat, $user_long, $services_id, $order_id);

        return ['state' => '202'];


    }

    public function AcceptedOrder($id)
    {
        global $user_id;
        $input = Request()->all();
        $this->order->find($id)->update(["provider_id" => $input['provider_id']]);
        $this->HandlePushToClint($id);
        $this->provider_rfused_order->where('order_id', $id)->delete();
        $OrderQuery = $this->order->where('order_id', $id)
            ->get();
        foreach ($OrderQuery as $item) {
            $user_id = $item->user_id;

        }

        $output = $this->users->with(['Orders' => function ($query) use ($id) {
            $query->where($this->order->getTable() . '.order_id', $id);
        }])->where('user_id', $user_id)->get();
        return $output['0'];
    }

    public function HandlePushToClint($order_id)
    {
        global $provider_id;
        global $clint_id;
        global $Token;
        global $lang_id;
        global $Title;
        $getProviderId = $this->order->where('order_id', $order_id)->get();
        foreach ($getProviderId as $providerdata) {
            $provider_id = $providerdata->provider_id;
            $clint_id = $providerdata->user_id;
        }

        $ProvderQuery = $this->providor->with('Users')->where('provider_id', $provider_id)->get();
        $ClintTokenQuery = $this->users->where('user_id', $clint_id)->get();
        foreach ($ClintTokenQuery as $Clint) {

            $Token = $Clint->token_id;
            $lang_id = $Clint->lang_id;
        }

        if ($lang_id == 'ar') {
            $Title = 'تم قبول طلبك';

        } else if ($lang_id == 'en') {
            $Title = 'Request accepted';

        } else if ($lang_id == 'ur') {
            $Title = 'آپ قبول طلب';

        }

        $this->PushNotificationToCLintAccept($Token, $Title, $ProvderQuery, $order_id);
    }

    public function PushNotificationToCLintAccept($Token, $Title, $ProviderData, $order_id)
    {


        $content = array(
            "en" => $Title
        );
        $ProviderData[] = ['type' => 'order_accepted'];
        $ProviderData[] = ['order_id' => $order_id];
        $fields = array(
            'app_id' => "a3551d54-e1bc-4f12-874c-7f6cb7982f95",
            'include_player_ids' => [$Token],
            'data' => array("data" => $ProviderData),
            'contents' => $content
        );

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


    public function GetCancelOrderReasons()
    {
        return $this->cancel_order_reasonse->all();
    }

    public function GetClintCancelOrderReasons()
    {
        return $this->clint_cancel_order_reasonse->all();
    }

    public function ProviderCancelOrder($order_id)
    {
        $input = Request()->all();
        $output = $this->order->find($order_id)->update([
            "cancel_order_reasons_id" => $input['cancel_order_reasons_id'],
            "cancel_order_reasons_text" => $input['cancel_order_reasons_text'],
            "order_state" => 4
        ]);
        $this->HandleParamtesTOSetPushWhenProviderCancelOrder($order_id);

        return ['state' => 202];
    }

    public function HandleParamtesTOSetPushWhenProviderCancelOrder($order_id)
    {
        global $provider_id;
        global $clint_id;
        global $Token;
        global $lang_id;
        global $Title;
        $getProviderId = $this->order->where('order_id', $order_id)->get();
        foreach ($getProviderId as $providerdata) {
            $provider_id = $providerdata->provider_id;
            $clint_id = $providerdata->user_id;
        }

        $ProvderQuery = $this->providor->where('provider_id', $provider_id)->get();

        $ClintTokenQuery = $this->users->where('user_id', $clint_id)->get();
        foreach ($ClintTokenQuery as $Clint) {

            $Token = $Clint->token_id;
            $lang_id = $Clint->lang_id;
        }

        if ($lang_id == 'ar') {
            $Title = 'قام مزود الخدمة بالغاء طلبك';

        } else if ($lang_id == 'en') {
            $Title = 'Your service provider has canceled your order';

        } else if ($lang_id == 'ur') {
            $Title = 'آپ کے سروس فراہم کنندہ نے آپ کا حکم منسوخ کردیا ہے';

        }

        $this->HandlePushToClintWhenProvderCancelOrder($Title, $Token, $ProvderQuery);
    }


    public function HandlePushToClintWhenProvderCancelOrder($Title, $Token, $ProviderData)
    {
        $content = array(
            "en" => $Title
        );
        $ProviderData[] = ['type' => 'order_cancel'];
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


    public function ClintCacelOrder($order_id)
    {
        global $token_id;
        global $Title;
        $this->order->find($order_id)->update([
            "order_state" => 2,
        ]);
        global $provider_id;
        $ProvderQuery = $this->order->select('provider_id')->where('order_id', $order_id)->get();
        foreach ($ProvderQuery as $ProvderData) {
            $provider_id = $ProvderData->provider_id;

        }

        /*get provdier Token*/
        $TokenQuery = $this->users
            ->select('token_id', 'lang_id')
            ->join($this->providor->getTable(), $this->users->getTable() . '.user_id', $this->providor->getTable() . '.user_id')
            ->where($this->providor->getTable() . '.provider_id', $provider_id)
            ->get();


        foreach ($TokenQuery as $TokenData) {
            $token_id = $TokenData->token_id;
            $lang_id = $TokenData->lang_id;
        }


        /*title lang*/
        if ($lang_id == 'ar') {
            $Title = 'قام العميل بالغاء الطلب';

        } else if ($lang_id == 'en') {
            $Title = 'The customer has canceled the order';

        } else if ($lang_id == 'ur') {
            $Title = 'کسٹمر نے حکم منسوخ کر دیا ہے';

        }
        /*end */


         $this->PushNotificationCancelOrderToProvider($token_id, $Title, $order_id);
        return ["state" => '202'];
    }

    public function PushNotificationCancelOrderToProvider($Token, $Title, $order_id)
    {


        $content = array(
            "en" => $Title
        );

        $fields = array(
            'app_id' => "6f9fbf9d-b26e-477a-9710-ed334b1a274b",
            'include_player_ids' => array($Token),
            'data' => array(
                "order_id" => $order_id

            ),
            'contents' => $content
        );

        $fields = json_encode($fields);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic MmE0MTg4YWQtY2NlOS00ODEwLTg3YTUtNWE3MjNjZDNkZDY1'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;


    }


    public function ClintFinsihOrder($order_id)
    {
        $input = Request()->all();
        $this->order->find($order_id)->update([
            "order_state" => 2,
            "rate" => $input['rate'],
//            "clint_rate_order_reasons_id" => $input['clint_rate_order_reasons_id'],
            "clint_rate_order_text" => $input['clint_rate_order_text']
        ]);
        $this->ProviderFinalRate($order_id);

        return ['state' => 202];

    }

    public function ProviderFinalRate($order_id)
    {
        global $provider_id;
        global $count_rate;
        global $sum_rate;
        $ProvderQuery = $this->order->select('provider_id')->where('order_id', $order_id)->get();
        foreach ($ProvderQuery as $ProvderData) {
            $provider_id = $ProvderData->provider_id;
        }

        $ProviderOrderRates = $this->order
            ->select(
                DB::raw('count(rate)as count_rate'),
                DB::raw('sum(rate)as sum_rate')
            )
            ->where('provider_id', $provider_id)
            ->get();

        foreach ($ProviderOrderRates as $clintRate) {
            $count_rate = $clintRate->count_rate;
            $sum_rate = $clintRate->sum_rate;

        }
        $final_rate = $sum_rate / $count_rate;
        $this->providor->find($provider_id)->update(['rate' => $final_rate]);


    }


    public function FinishOrderSuccess($order_id)
    {
        $this->order->find($order_id)->update([
            "order_state" => 2
        ]);

        $this->HandleParamtesTOSetPushWhenFinishOrder($order_id);
        return ['state' => 202];

    }

    public function HandleParamtesTOSetPushWhenFinishOrder($order_id)
    {
        global $provider_id;
        global $clint_id;
        global $Token;
        global $lang_id;
        global $Title;
        $getProviderId = $this->order->where('order_id', $order_id)->get();
        foreach ($getProviderId as $providerdata) {
            $provider_id = $providerdata->provider_id;
            $clint_id = $providerdata->user_id;
        }

        $ProvderQuery = $this->providor->where('provider_id', $provider_id)->get();

        $ClintTokenQuery = $this->users->where('user_id', $clint_id)->get();
        foreach ($ClintTokenQuery as $Clint) {

            $Token = $Clint->token_id;
            $lang_id = $Clint->lang_id;
        }

        if ($lang_id == 'ar') {
            $Title = 'تم انهاء الطلب بنجاح';

        } else if ($lang_id == 'en') {
            $Title = 'Request successfully completed';

        } else if ($lang_id == 'ur') {
            $Title = 'درخواست کامیابی سے مکمل ہوگئی';

        }

        $this->HandlePushToClintWhenFinsishOrder($Title, $Token, $ProvderQuery);
    }


    public function HandlePushToClintWhenFinsishOrder($Title, $Token, $ProviderData)
    {
        $content = array(
            "en" => $Title
        );
        $ProviderData[] = ['type' => 'order_finish'];
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

    public function GetClintOrderHistory($clint_id)
    {
        return $this
            ->order
            ->with(['Service',
                'SubServices' => function ($query) {
                    $query->with('ServicesZone.Zones');
                },
                'Provider.Users'
            ])
            ->where('user_id', $clint_id)->get();


    }

    public function GetProviderOrderHistory($provider_id)
    {
        return $this
            ->order
            ->with(['Service',
                'SubServices' => function ($query) {
                    $query->with('ServicesZone.Zones');
                },
                'Users'
            ])
            ->where('provider_id', $provider_id)->get();


    }

    public function SechudelOrder()
    {
        $input = Request()->all();
        $this->order->create($input);
        return ['state' => '202'];

    }


}

