<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Services;
use App\Http\Models\SubServices;
use App\Http\Models\ServicesType;
use App\Http\Models\ServicesCommission;
use App\Http\Models\ServicesWorkPreiod;
use App\Http\Models\ServicesCity;
use App\Http\Models\ServicesZone;


class ServicesAdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->serivces = new Services();
        $this->sub_services = new SubServices();
        $this->services_work_preiod = new ServicesWorkPreiod();
        $this->ServicesType = new ServicesType();
        $this->serivces_commision = new ServicesCommission();
        $this->services_city = new ServicesCity();
        $this->serivces_zone = new ServicesZone();

    }

    public function index()
    {
        return view('services.services');
    }


    public function addservicesindex()
    {
        return view('services.addServices');
    }

    public function updateserviceindex()
    {
        return view('services.updateservice');
    }

    public function services_price_index()
    {
        return view('services_price.services_price');
    }

    public function services_zone_index()
    {
        return view('services_zone.services_zone');
    }

    public function GetServices()
    {
        return $output = $this->serivces
            ->with('SupSerivcesData')
            ->get();

    }

    public function StoreServices()
    {
        $input = Request()->all();
        /* first insert services*/
        if (!empty($input['icone'])) {
            $services_pic = $input["icone"];
            $image_name = "pic-" . time() . ".png";
            $path = public_path() . "/service_icone/" . $image_name;
            $input["icone"] = "service_icone/" . $image_name;
            $voc = substr($services_pic, strpos($services_pic, ",") + 1);//take string after ,
            $voicedata = base64_decode($voc);
            $success = file_put_contents($path, $voicedata);
        }
        $output = $this->serivces->create($input);
        $input['services_id'] = $output->services_id;
        $services_id = $output->services_id;
        /*seconed insert Sub Services*/
        for ($i = 0; $i < count($input['sub_services']); $i++) {

            if (!empty($input['sub_services'][$i]['icone'])) {

                $sub_services_pic = $input['sub_services'][$i]['icone'];
                $image_name = "pic-" . time() . ".png";
                $path = public_path() . "/sub_services/" . $image_name;
                $input['sub_services'][$i]['icone'] = "sub_services/" . $image_name;
                $voc = substr($sub_services_pic, strpos($sub_services_pic, ",") + 1);//take string after ,
                $voicedata = base64_decode($voc);
                $success = file_put_contents($path, $voicedata);
            }
            echo $input['sub_services'][$i]['services_id'] = $services_id;
            $this->sub_services->create($input['sub_services'][$i]);
        }

        for ($j = 0; $j < count($input['services_work_preiod']); $j++) {
            $input['services_work_preiod'][$i]['services_id'] = $output->services_id;
            $this->services_work_preiod->create($input['services_work_preiod'][$j]);
        }

        $this->ServicesType->create($input);
        $this->serivces_commision->create($input);


    }


    public function UpdateServices($id)
    {
        $input = Request()->all();

        if (strpos($input['icone'], 'data:image/png;base64,') !== false) {

            if (!empty($input['icone'])) {
                $services_pic = $input["icone"];
                $image_name = "pic-" . time() . ".png";
                $path = public_path() . "/service_icone/" . $image_name;
                $input["icone"] = "service_icone/" . $image_name;
                $voc = substr($services_pic, strpos($services_pic, ",") + 1);//take string after ,
                $voicedata = base64_decode($voc);
                $success = file_put_contents($path, $voicedata);
            }

            $this->serivces->where('services_id', $id)->update(
                ["services_name_ar" => $input['services_name_ar'],
                    "services_name_en" => $input['services_name_en'],
                    "services_name_ur" => $input['services_name_ur'],
                    "color" => $input['color'],
                    "icone" => $input['icone'],
                    "price_type_visiable" => $input['price_type_visiable'],
                    "price_type" => $input['price_type'],
                    "serach_provider_limit" => $input['serach_provider_limit'],
                    "minimum_time_rate_boxwrite" => $input['minimum_time_rate_boxwrite'],
                    "maxmum_schedule_order" => $input['maxmum_schedule_order'],
                    "provider_credit_limit_type" => $input['provider_credit_limit_type'],
                    "credit_limit_total" => $input['credit_limit_total'],
                    "credit_limit_finsih_order" => $input['credit_limit_finsih_order']
                ]);
        } else {
            $this->serivces->where('services_id', $id)->update([
                "services_name_ar" => $input['services_name_ar'],
                "services_name_en" => $input['services_name_en'],
                "services_name_ur" => $input['services_name_ur'],
                "color" => $input['color'],
                "icone" => $input['icone'],
                "price_type_visiable" => $input['price_type_visiable'],
                "price_type" => $input['price_type'],
                "serach_provider_limit" => $input['serach_provider_limit'],
                "minimum_time_rate_boxwrite" => $input['minimum_time_rate_boxwrite'],
                "maxmum_schedule_order" => $input['maxmum_schedule_order'],
                "provider_credit_limit_type" => $input['provider_credit_limit_type'],
                "credit_limit_total" => $input['credit_limit_total'],
                "credit_limit_finsih_order" => $input['credit_limit_finsih_order']

            ]);
        }

        /*sub services */
        for ($i = 0; $i < count($input['sub_services']); $i++) {
            // if new pic
            if (strpos($input['sub_services'][$i]['icone'], 'data:image/png;base64,') !== false) {

                /* exist recored data base updatd case */
                if (isset($input['sub_services'][$i]['services_id'])) {

                    $sub_services_pic = $input['sub_services'][$i]['icone'];
                    $image_name = "pic - " . time() . " . png";
                    $path = public_path() . "/sub_services/" . $image_name;
                    $input['sub_services'][$i]['icone'] = "sub_services/" . $image_name;
                    $voc = substr($sub_services_pic, strpos($sub_services_pic, ",") + 1);//take string after ,
                    $voicedata = base64_decode($voc);
                    $success = file_put_contents($path, $voicedata);
                    $this->sub_services->find($input['sub_services'][$i]['sub_services_id'])->update($input['sub_services'][$i]);

                } else {
                    /*insert new sup servises */
                    $input['sub_services'][$i]['services_id'] = $id;
                    $sub_services_pic = $input['sub_services'][$i]['icone'];
                    $image_name = "pic - " . time() . " . png";
                    $path = public_path() . "/sub_services/" . $image_name;
                    $input['sub_services'][$i]['icone'] = "sub_services/" . $image_name;
                    $voc = substr($sub_services_pic, strpos($sub_services_pic, ",") + 1);//take string after ,
                    $voicedata = base64_decode($voc);
                    $success = file_put_contents($path, $voicedata);
                    $this->sub_services->create($input['sub_services'][$i]);
                }
            } else {
                //   if no new  pic  send in request
                /* if new sub sservices without pic*/
                if (isset($input['sub_services'][$i]['services_id'])) {
                    $this->sub_services->find($input['sub_services'][$i]['sub_services_id'])->update($input['sub_services'][$i]);

                } else {
                    /* updated */
                    $input['sub_services'][$i]['services_id'] = $id;
                    $this->sub_services->create($input['sub_services'][$i]);

                }
            }
        }
        /*sub services end  */
//        return ['state' => '200'];


        /* services work period*/

        for ($j = 0; $j < count($input['services_work_preiod']); $j++) {
            if (isset($input['services_work_preiod'][$j]['services_id'])) {
                $this->services_work_preiod->find($input['services_work_preiod'][$j]['services_work_preiod_id'])->update($input['services_work_preiod'][$j]);
            } else {
                $input['services_work_preiod'][$j]['services_id'] = $id;
                $this->services_work_preiod->create($input['services_work_preiod'][$j]);
            }

        }
//        /* end*/

        /*other*/
        for ($st = 0; $st < count($input['service_type']); $st++) {
            $this->ServicesType->find($input['service_type'][$st]['services_type_id'])->update($input['service_type'][$st]);

        }
        for ($sc = 0; $sc < count($input['services_commission']); $sc++) {
            $this->serivces_commision->find($input['services_commission'][$sc]['services_commission_id'])->update($input['services_commission'][$sc]);

        }

//        /*end*/
//
        return ['state' => '200'];
    }

    public function GetServicesForUpdated($id)
    {
        return $this->serivces->with('SubServices', 'ServiceType', 'ServicesWorkPreiod', 'ServicesCommission')
            ->where('services_id', $id)->get();
    }


    /*GerServices*/
    public function GetServicesZones()
    {

        return $this->serivces->with('ServicesCity.City', 'SubServices.ServicesZone.Zones')->get();
    }

    public function GetServicesCity($id)
    {

        return $this->services_city->with('City')
            ->where($this->services_city->getTable() . '.services_id', $id)
            ->get();
    }

    public function ChangeActivaity($id)
    {

        $input = Request()->all();
        $this->services_city->find($id)->update($input);
        return $input;

    }

    public function ServicesZone($id)
    {
        return $this->serivces->with('SubServices.ServicesZone.Zones')
            ->where('services_id', $id)
            ->get();
    }

    public function getServicesZone($id)
    {

        return $this->serivces_zone->with('Zones')
            ->where('sub_services_id', $id)
            ->get();
    }

    public function ChangeServiceZonePrice($id)
    {

        $input = Request()->all();
        $this->serivces_zone->find($id)->update($input);
        return $input;
    }

    public function CreateServicesZone()
    {
        $input = Request()->all();
        $output = $this->serivces_zone->create($input);
        $sub_services_id = $output->services_zone_id;
        return $this->serivces_zone->with('Zones')
            ->where('services_zone_id', $sub_services_id)
            ->get();
    }

    public function CreateServicesCity()
    {
        $input = Request()->all();
        $output = $this->services_city->create($input);
        $services_city_id = $output->services_city_id;
        return $this->services_city->with('City')
            ->where('services_city_id', $services_city_id)
            ->get();
    }

}
