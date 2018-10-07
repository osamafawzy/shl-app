<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Services;
use App\Http\Models\SubServices;
use App\Http\Models\ServicesZone;
use App\Http\Models\Zone;
use App\Http\Models\FavouriteUserLocation;
use App\Http\Models\ServicesTremsConditions;
use DB;

class ServicesController extends Controller
{

    public function __construct()
    {
        $this->serivces = new Services();
        $this->sub_services = new SubServices();
        $this->services_zone = new ServicesZone();
        $this->zone = new Zone();
        $this->favourit_user_location = new FavouriteUserLocation();
        $this->services_trems_conditions = new ServicesTremsConditions();
    }

    public function GetALlServicesAndSupservices($area)
    {

        /*get Zone ID form String I got It form api link*/
        $zones = $this->zone->where('zone_en', 'LIKE', '%' . $area . '%')->get();
        global $zone_Id;
        foreach ($zones as $zone) {
            $zone_Id = $zone->zone_id;
        }

        $output = $this->serivces
            ->select($this->serivces->getTable() . '.*')
            ->with(['SupSerivcesData' => function ($query) use ($zone_Id) {

                $query->with(['ServicesZone' => function ($query) use ($zone_Id) {
                    $query->with('Zones')
                        ->where($this->services_zone->getTable() . '.zone_id', $zone_Id);
                }]);
            }])
            ->leftjoin($this->sub_services->getTable(), $this->serivces->getTable() . '.services_id', $this->sub_services->getTable() . '.services_id')
            ->leftjoin($this->services_zone->getTable(), $this->sub_services->getTable() . '.sub_services_id', $this->services_zone->getTable() . '.sub_services_id')
            ->where($this->services_zone->getTable() . '.zone_id', $zone_Id)
            ->groupBy($this->sub_services->getTable() . '.services_id')
            ->withCount('SubServices')
            ->get();

        if (Count($output) > 0) {
            return Response()->json($output);

        } else {
            return ['state' => 'عفوا لايوجد خدمات فى هذة المنطقة فى الوقت الحالى'];
        }

    }

    public function StoreFavLocation()
    {

        $input = Request()->all();
        return $this->favourit_user_location->create($input);
    }

    public function getFavLocationList($id)
    {
        return $this->favourit_user_location->where($this->favourit_user_location->getTable() . '.user_id', $id)->get();
    }

    public function DeleteFavLocation($id){
        $this->favourit_user_location->where('favourite_user_location_id',$id)->delete();
        return ['state'=>'202'];
    }


    public function GetServicesForProvidor()
    {
        $output = $this->serivces->select(
            $this->serivces->getTable() . '.services_id',
            $this->serivces->getTable() . '.services_name_ar'

        )->get();

        return Response()->json($output);

    }

    public function GetSupServicesForProvidor($id)
    {
        $output = $this->sub_services->select(
            $this->sub_services->getTable() . '.sub_services_id',
            $this->sub_services->getTable() . '.services_id',
            $this->sub_services->getTable() . '.sub_services_name_ar'
        )
            ->where($this->sub_services->getTable() . '.services_id', $id)
            ->get();
        return Response()->json($output);


    }

    public function ServicesPrice()
    {

        $output = $this->serivces->with(['ServicesCity.City', 'SupSerivcesData.ServicesZone.Zones'])
            ->get();
        return ["services_subserivces_price" => $output];
    }

    public function GetAllavaliableServices()
    {
        return $this->serivces->all();
    }

    public function GetSubServices($id)
    {
        return $this->sub_services->where('services_id', $id)->get();
    }

    public function GetSubServicesCondtions()
    {

        return $this->services_trems_conditions->take(1)->get();
    }

    public function GetSubServicesRealtedMainSerbives($id)
    {

        return $this->sub_services
            ->leftjoin($this->services_zone->getTable(),$this->sub_services->getTable().'.sub_services_id', $this->services_zone->getTable().'.sub_services_id')
            ->with('ServicesZone')
            ->where('services_id', $id)
            ->take(1)
            ->get();

    }


}
