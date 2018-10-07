<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Users;
use App\Http\Models\Providor;
use App\Http\Models\City;
use App\Http\Models\Zone;

class UsersController extends Controller
{
    //

    public function __construct()
    {
        $this->users = new Users();
        $this->provider = new Providor();
        $this->city = new City();
        $this->zone = new Zone();
    }

    public function GetCity()
    {
        $output = $this->city->all();
        return ['City' => $output];
    }

    public function GetZones($id)
    {
        $output = $this->zone->where('city_id', $id)->get();
        return ['Zones' => $output];
    }

    public function Login()
    {
        $input = Request()->all();
//        if (strpos($input['phone'], '00966') !== false) {
//            return ['error' => 'error'];
//        } else {
        $input['phone'] = '00966' . $input['phone'];
        $check = $this->users->where('phone', $input['phone'])->get();
        if (count($check) > 0) {
            $input['v_code'] = $this->GenerateVCode();
            $this->SendSMSWithVcode($input['phone'], $input['v_code']);
            $this->users->where('phone', $input['phone'])->update(['v_code' => $input['v_code']]);
            $check = $this->users->where('phone', $input['phone'])->get();
            return Response()->json($check['0']);
        } else {
            $input['v_code'] = $this->GenerateVCode();
            $this->SendSMSWithVcode($input['phone'], $input['v_code']);
            $output = $this->users->create($input);
            return Response()->json($output);
        }
//        }

    }

    public function SendSMSWithVcode($phone, $vcode)
    {
        $fields = array(
            "AppSid" => "dEYXJ5rv9DIGllCkJZ4Ngmx7u1Zzsh",
            "Recipient" => $phone,
            "Body" => $vcode
        );
        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.unifonic.com/rest/Messages/Send");
//        curl_setopt($ch, CURLOPT_URL, "https://private-anon-46b550cebd-unifonic.apiary-proxy.com/rest/Verify/VerifyNumber");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, "AppSid=dEYXJ5rv9DIGllCkJZ4Ngmx7u1Zzsh?Recipient=$phone&Body=$vcode&SenderID=SHL");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "AppSid=dEYXJ5rv9DIGllCkJZ4Ngmx7u1Zzsh&Recipient=$phone&Body=$vcode&SenderID=SHL");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/x-www-form-urlencoded"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;


    }


    public function Activate()
    {
        $input = Request()->all();
        $check = $this->users
            ->where('phone', $input['phone'])
            ->where('v_code', $input['v_code'])
            ->get();

        if (count($check) > 0) {

            $this->users->where('phone', $input['phone'])->update(
                [
                    'activate' => 1,
                    'v_code' => $input['v_code']

                ]
            );
            $check = $this->users->where('phone', $input['phone'])->get();
            return Response()->json($check['0']);

        } else {
            return ['state' => 'رقم التفعيل خاطئ برجاء المراجعة '];

            global $lang;
            return $check;
            foreach ($check as $Userlang) {
                $lang = $Userlang->lang_id;

            }
            if ($lang == 'ar') {

            }
            if ($lang == 'en') {
                return ['state' => 'Invalid activation number Please review'];

            }
            if ($lang == 'ur') {
                return ['state' => 'غلط سرگرمی نمبر برائے مہربانی جائزہ لیں '];

            }
        }

    }


    public function UpdateUserAccount($id)
    {

        $input = Request()->all();
        /* personal_pic*/
        if (!empty($input['profile_pic'])) {
            $image = $input["profile_pic"];
            $jpg_name = "photo-" . time() . ".jpg";
            $path = public_path() . "/personal_pic/" . $jpg_name;
            $input["profile_pic"] = "personal_pic/" . $jpg_name;
            $img = substr($image, strpos($image, ",") + 1);//take string after ,
            $imgdata = base64_decode($img);
            $success = file_put_contents($path, $imgdata);
            $this->users->find($id)->update($input);
        } else {
            $this->users->find($id)->update($input);
        }


        $output = $this->users->with('City', 'Zone')->where('user_id', $id)->get();
        return $output[0];
    }


    protected function GenerateVCode()
    {
        return $six_digit_random_number = mt_rand(1000, 9999);
    }


    public function CreateProvidor()
    {
        $input = Request()->all();

        $check = $this->users->where('phone', $input['phone'])->get();
        if (count($check) > 0) {


            return Response()->json($check['0']);


        } else {
            $users = $this->users->create([
                "user_name" => $input['user_name'],
                "phone" => $input['phone']
            ]);
            $user_id = $users->user_id;

            /* personal_pic*/
            $personal_pic = $input["personal_pic"];
            $image_name = "pic-" . time() . ".png";
            $path = public_path() . "/personal_pic/" . $image_name;
            $input["personal_pic"] = "/personal_pic/" . $image_name;
            $voc = substr($personal_pic, strpos($image_name, ",") + 1);//take string after ,
            $voicedata = base64_decode($voc);
            $success = file_put_contents($path, $voicedata);


            $input['user_id'] = $user_id;
            $output = $this->provider->create($input);
            $output = $this->users->with('Providor')
                ->where($this->users->getTable() . '.user_id', $user_id)
                ->get();
            return Response()->json($output);
        }

    }

    public function UpdateProviderLocations($id)
    {
        $input = Request()->all();
        $updateLocation = $this->provider->find($id)->update([
            "long" => $input['long'],
            "lat" => $input['lat']
        ]);

        $output = $this->provider->select('long', 'lat', 'provider_id')->where('provider_id', $id)->get();
        return Response()->json($output);


    }

    public function ChangActive($id)
    {

        $input = Request()->all();
        $updateLocation = $this->provider->find($id)->update([
            'active' => $input['active']
        ]);

        $output = $this->provider->select('active', 'provider_id')->where('provider_id', $id)->get();
        return Response()->json($output);


    }

    public function UpdateUserToken($id)
    {
        $input = Request()->all();
        $this->users->find($id)->update(['token_id' => $input['token_id']]);
        $output = $this->users->select('token_id')->where('user_id', $id)->get();
        return Response()->json($output['0']);

    }

    public function UpdateProviderToken($id)
    {
        $input = Request()->all();
        global $user_id;
        $getUserID = $this->provider
            ->select('user_id')
            ->where('provider_id', $id)->get();
        foreach ($getUserID as $userID) {
            $user_id = $userID->user_id;

            $this->users->find($user_id)->update(['token_id' => $input['token_id']]);

        }
        $output = $this->users->select('token_id')->where('user_id', $user_id)->get();

        return Response()->json($output['0']);

    }

    public function UpdateProivderData($id)
    {
        $input = Request()->all();
        global $user_id;
        $getUser_id = $this->provider->select('user_id')->where('provider_id', $id)->get();
        foreach ($getUser_id as $user_id) {
            $user_id = $user_id->user_id;
        }

        $users = $this->users->find($user_id)->update([
            "user_name" => $input['user_name'],
            "phone" => $input['phone']
        ]);

        /* personal_pic*/
        if (!empty($input['personal_pic'])) {
            $personal_pic = $input["personal_pic"];
            $image_name = "pic-" . time() . ".png";
            $path = public_path() . "/personal_pic/" . $image_name;
            $input["personal_pic"] = "/personal_pic/" . $image_name;
            $voc = substr($personal_pic, strpos($image_name, ",") + 1);//take string after ,
            $voicedata = base64_decode($voc);
            $success = file_put_contents($path, $voicedata);

        }


        $output = $this->provider->find($id)->update($input);
        $output = $this->users->with('Providor')
            ->where($this->users->getTable() . '.user_id', $user_id)
            ->get();
        return Response()->json($output);

    }

    public function GetVCode($phone)
    {
        return $this->users->select('v_code')->where('phone', $phone)->get();
    }

    public function GetUserData($id)
    {
        $output = $this->users->with('City', 'Zone')->where('user_id', $id)->get();
        return $output[0];
    }
}
