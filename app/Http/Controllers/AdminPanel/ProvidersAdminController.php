<?php

namespace App\Http\Controllers\AdminPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Order;
use App\Http\Models\Providor;
use App\Http\Models\Services;
use App\Http\Models\Users;
use App\Http\Models\Zone;
use Illuminate\Support\Facades\Auth;


class ProvidersAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->serivces = new Services();
        $this->users = new Users();
        $this->providers = new Providor();
        $this->order = new Order();
        $this->zone = new Zone();

    }

    public function index(){
        if (Auth::user()->can('providers.create')) {
            return view('providers.providers');
        }
        return redirect()->back();
    }

    public function Getproviders(){
        $output=$this->users->where('type','3')->where('state','1')->withCount('Orders')->get();
        return $output;
    }

    public function changeactivate($id){

        $provider=$this->users->find($id);
        if ($provider->activate==0){
            $provider->activate=1;
        }else{
            $provider->activate=0;
        }

        $provider->update();

//        return redirect()->back();

    }

    public function profilepage(){
        if (Auth::user()->can('providers.view')) {
            return view('providers.providerProfile');
        }
        return redirect()->back();
    }

    public function providerdata($id){
        $output=$this->users
            ->where("user_id",$id)
            ->with(['Orders.SubServices.ServicesZone.Zones'])
            ->with(['Orders.Provider.Users'])
            ->withCount('Orders')->get();
        return $output;
    }
}
