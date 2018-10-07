<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Models\City;
use App\Http\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function MongoDB\BSON\toJSON;

class zoneAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->zone = new Zone();
        $this->city = new City();

    }
    public function index(){
        return view('zones.addzone');
    }

    public function storezone(){
        $input = Request()->all();
        $flag = false;

       $cities = City::where('city_en',$input['city_en'])->get();

       if (count($cities)>0){
           $input['city_id']=$cities[0]['city_id'];
       }else{
          $out = $this->city->create($input);
           $input['city_id']=$out['city_id'];
       }


        $this->zone->create($input);

    }
}
