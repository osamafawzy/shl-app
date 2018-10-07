<?php

namespace App\Http\Controllers\AdminPanel;

use App\Events\followProviders;
use App\Http\Models\Order;
use App\Http\Models\Providor;
use App\Http\Models\Services;
use App\Http\Models\Users;
use App\Http\Controllers\Controller;
use App\Http\Models\Zone;
use Illuminate\Support\Facades\Auth;


class ClientsAdminController extends Controller
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
        if (Auth::user()->can('clients.create')) {
            return view('clients.clients');
        }
        return redirect()->back();
    }

    public function GetClients(){
        $output=$this->users->with('Providor')->where('type','2')->withCount('Orders')->get();
        return $output;
    }

    public function changeactivate($id){

        $user=$this->users->find($id);
        if ($user->activate==0){
            $user->activate=1;
        }else{
            $user->activate=0;
        }

        $user->update();

//        return redirect()->back();

    }

    public function profilepage(){
        if (Auth::user()->can('clients.view')) {
            return view('clients.clientProfile');
        }
        return redirect()->back();
    }

    public function clientdata($id){
        $output=$this->users
            ->where("user_id",$id)
            ->with(['Orders.SubServices.ServicesZone.Zones'])
            ->with(['Orders.Provider.Users'])
            ->withCount('Orders')->get();
        return $output;
    }
}
