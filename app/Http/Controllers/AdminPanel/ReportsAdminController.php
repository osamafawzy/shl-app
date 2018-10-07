<?php

namespace App\Http\Controllers\AdminPanel;

use App\Events\followProviders;
use App\Http\Models\Order;
use App\Http\Models\Providor;
use App\Http\Models\Services;
use App\Http\Models\SubServices;
use App\Http\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->users = new Users();
        $this->orders= new Order();

    }
    public function index(){
        if (Auth::user()->can('reports.services')) {
            return view('reports.servicesReports');
        }
        return redirect()->back();
    }
    public function indexForProvider(){
        if (Auth::user()->can('reports.providers')) {
            return view('reports.providersReports');
        }
        return redirect()->back();
    }

    public function indexForFollowProvider(){
        if (Auth::user()->can('reports.followproviders')) {
            return view('reports.followProviders');
        }
        return redirect()->back();
    }
    //    ///////////   realtime reports  ///////////////////
//    public function GetOrdersWithListner(){
//        $out1=$this->orders->where('order_state',1)->count();
//        $out2=$this->orders->where('order_state',2)->count();
//        $out3=$this->orders->where('order_state',3)->count();
//        $out4=$this->orders->where('order_state',4)->count();
//        $out5=$this->orders->where('order_state',5)->count();
//        $output=['pending'=>$out1,
//                'accepted'=>$out2,
//            'finish'=>$out3,
//            'cancel_from_client'=>$out4,
//            'cancel_from_provider'=>$out5
//                ];
//        event(new OrderEvent($output));
//    }
//
//    public function GetOrdersWithoutListner(){
//        $out1=$this->orders->where('order_state',1)->count();
//        $out2=$this->orders->where('order_state',2)->count();
//        $out3=$this->orders->where('order_state',3)->count();
//        $out4=$this->orders->where('order_state',4)->count();
//        $out5=$this->orders->where('order_state',5)->count();
//        $output=['pending'=>$out1,
//            'accepted'=>$out2,
//            'finish'=>$out3,
//            'cancel_from_client'=>$out4,
//            'cancel_from_provider'=>$out5
//        ];
//        return $output;
//    }
public function allServices(){
        $services = new Services();
        $services = $services->all();
        return $services;
}
    public function subServices($id){
        $subServices = SubServices::where('services_id',$id)->get();
        return $subServices ;
    }

    public function sendRequestReportForOrders(){
        $input = Request()->all();
//        date and time from inputs
//        add 2 hours because time came from form decreased by 2 hours
        $from_date = Carbon::parse($input['from_date'])->addHour(2)->toDateString();
        $to_date = Carbon::parse($input['to_date'])->addHour(2)->toDateString();
        $from_hr = Carbon::parse($input['from_hr'])->addHour(2)->toTimeString();
        $to_hr = Carbon::parse($input['to_hr'])->addHour(2)->toTimeString();

        if (in_array("0",$input['services_id'])){
//            if seleced all main services


            if ($input['from_date']==null || $input['to_date']==null){
                $orders = Order::whereTime('order.created_at','>=',$from_hr)
                    ->Join('services','services.services_id','order.services_id')
                    ->whereTime('order.created_at','<=',$to_hr)
                    ->where('order.order_state',$input['state'])
                    ->select(DB::raw('services.services_id,services.services_name_ar,count(*) as count'))
                    ->groupBy('order.services_id')
                    ->get();
                return $orders;
            }else if($input['from_date']!=null || $input['to_date']!=null){
                $orders = Order::whereBetween('order.created_at',[$from_date,$to_date])
                    ->Join('services','services.services_id','order.services_id')
                    ->whereTime('order.created_at','>=',$from_hr)
                    ->whereTime('order.created_at','<=',$to_hr)
                    ->where('order.order_state',$input['state'])
                    ->select(DB::raw('services.services_id,services.services_name_ar,count(*) as count'))
                    ->groupBy('order.services_id')
                    ->get();

                return $orders;
            }




        }else{
            if (count($input['services_id'])===1){
                //            if seleced one main service
                if (in_array("0",$input['sub_services_id'])){
//                    if select all sub services

                    if ($input['from_date']==null || $input['to_date']==null){
                        $orders = Order::where('order.services_id',$input['services_id'])
                            ->whereTime('order.created_at','>=',$from_hr)
                            ->Join('sub_services','sub_services.sub_services_id','order.sub_services_id')
                            ->whereTime('order.created_at','<=',$to_hr)
                            ->where('order.order_state',$input['state'])
                            ->select(DB::raw('order.sub_services_id,sub_services.sub_services_name_ar,count(*) as count'))
                            ->groupBy('sub_services.sub_services_id')
                            ->get();
                        return $orders;

                    }else{

                            $orders = Order::whereBetween('order.created_at',[$from_date,$to_date])
                                ->where('order.services_id',$input['services_id'])
                                ->whereTime('order.created_at','>=',$from_hr)
                                ->Join('sub_services','sub_services.sub_services_id','order.sub_services_id')
                                ->whereTime('order.created_at','<=',$to_hr)
                                ->where('order.order_state',$input['state'])
                                ->select(DB::raw('order.sub_services_id,sub_services.sub_services_name_ar,count(*) as count'))
                                ->groupBy('sub_services.sub_services_id')
                                ->get();
                        return $orders;
                    }

                }else{
                    if (count($input['sub_services_id'])===1){
//                        if selected one sub service

                        if ($input['from_date']==null || $input['to_date']==null){
                            $orders = Order::whereTime('order.created_at','>=',$from_hr)
                                ->Join('sub_services','sub_services.sub_services_id','order.sub_services_id')
                                ->whereTime('order.created_at','<=',$to_hr)
                                ->whereIn('order.sub_services_id',$input['sub_services_id'])
                                ->select(DB::raw('sub_services.sub_services_id,sub_services.services_id,sub_services.sub_services_name_ar,order.order_state,count(*) as count'))
                                ->groupBy('order.order_state')
                                ->get();
                            return $orders;
                        }else{
                            $orders = Order::whereBetween('order.created_at',[$from_date,$to_date])
                                ->Join('sub_services','sub_services.sub_services_id','order.sub_services_id')
                                ->whereTime('order.created_at','>=',$from_hr)
                                ->whereTime('order.created_at','<=',$to_hr)
                                ->whereIn('order.sub_services_id',$input['sub_services_id'])
                                ->select(DB::raw('sub_services.sub_services_id,sub_services.services_id,sub_services.sub_services_name_ar,order.order_state,count(*) as count'))
                                ->groupBy('order.order_state')
                                ->get();
                            return $orders;
                        }


                    }else{
//                        if selected more than one sub service

                        if ($input['from_date']==null || $input['to_date']==null){
                            $orders = Order::whereTime('order.created_at','>=',$from_hr)
                                ->Join('sub_services','sub_services.sub_services_id','order.sub_services_id')
                                ->whereTime('order.created_at','<=',$to_hr)
                                ->whereIn('order.sub_services_id',$input['sub_services_id'])
                                ->where('order.order_state',$input['state'])
                                ->select(DB::raw('sub_services.sub_services_id,sub_services.services_id,sub_services.sub_services_name_ar,count(*) as count'))
                                ->groupBy('order.sub_services_id')
                                ->get();
                            return $orders;
                        }else{
                            $orders = Order::whereBetween('order.created_at',[$from_date,$to_date])
                                ->Join('sub_services','sub_services.sub_services_id','order.sub_services_id')
                                ->whereTime('order.created_at','>=',$from_hr)
                                ->whereTime('order.created_at','<=',$to_hr)
                                ->whereIn('order.sub_services_id',$input['sub_services_id'])
                                ->where('order.order_state',$input['state'])
                                ->select(DB::raw('sub_services.sub_services_id,sub_services.services_id,sub_services.sub_services_name_ar,count(*) as count'))
                                ->groupBy('order.sub_services_id')
                                ->get();
                            return $orders;
                        }

                    }
                }

            }else{
//                where select more than one main service

                if ($input['from_date']==null || $input['to_date']==null){
                    $orders = Order::whereTime('order.created_at','>=',$from_hr)
                        ->Join('services','services.services_id','order.services_id')
                        ->whereTime('order.created_at','<=',$to_hr)
                        ->whereIn('order.services_id',$input['services_id'])
                        ->where('order.order_state',$input['state'])
                        ->select(DB::raw('services.services_id,services.services_name_ar,count(*) as count'))
                        ->groupBy('order.services_id')
                        ->get();
                    return $orders;
                }else{
                    $orders = Order::whereBetween('order.created_at',[$from_date,$to_date])
                        ->Join('services','services.services_id','order.services_id')
                        ->whereTime('order.created_at','>=',$from_hr)
                        ->whereTime('order.created_at','<=',$to_hr)
                        ->whereIn('order.services_id',$input['services_id'])
                        ->where('order.order_state',$input['state'])
                        ->select(DB::raw('services.services_id,services.services_name_ar,count(*) as count'))
                        ->groupBy('order.services_id')
                        ->get();
                    return $orders;
                }

            }
        }
    }

    public function allServicesReport(){

        $orders = Order::Join('services','services.services_id','order.services_id')
            ->select(DB::raw('services.services_name_ar,count(*) as count'))
            ->groupBy('order.services_id')
            ->get();
        return $orders;
    }

    public function tableReportForOrders(){
        $input= Request()->all();
        if ($input['order_state'] !=null){
            $input['order_state'] = (int)$input['order_state'];
        }
        if ($input['hour_from'] && $input['hour_to']){
            $from_hr = Carbon::parse($input['hour_from'])->addHour(2)->toTimeString();
            $to_hr = Carbon::parse($input['hour_to'])->addHour(2)->toTimeString();
        }

//        return $input;

        if ($input['date_from'] && $input['date_to']){
            $from_date = Carbon::parse($input['date_from'])->addHour(2)->toDateString();
            $to_date = Carbon::parse($input['date_to'])->addHour(2)->toDateString();

            if ($input['sub_service_id'] !=null){
// give time and subservice
                $output=Order::whereBetween('created_at',[$from_date,$to_date])
                    ->where('sub_services_id',$input['sub_service_id'])
                    ->where('order_state',$input['order_state'])
                    ->with('Service')
                    ->with('SubServices')
                    ->with('Users')
                    ->with('Provider.Users')
                    ->get();
                return $output;




            }else{
// give time and main service
                $output=Order::whereBetween('created_at',[$from_date,$to_date])
                    ->where('services_id',$input['service_id'])
                    ->where('services_id',$input['service_id'])
                    ->where('order_state',$input['order_state'])
                    ->with('Service')
                    ->with('SubServices')
                    ->with('Users')
                    ->with('Provider.Users')
                    ->get();
                return $output;
            }

        }else{
            // if there is no date
            if ($input['sub_service_id'] != null){
// if there is a sub service id
                $output=Order::where('sub_services_id',$input['sub_service_id'])
                    ->where('order_state',$input['order_state'])
//                    ->with('Service')
//                    ->with('SubServices')
//                    ->with('Users')
//                    ->with('Provider.Users')
                    ->get();
                return $output;




            }else{
// if there is no sub service id
                $output=Order::where('services_id',$input['service_id'])
                    ->where('order_state',$input['order_state'])
                    ->with('Service')
                    ->with('SubServices')
                    ->with('Users')
                    ->with('Provider.Users')
                    ->get();
                return $output;
            }
        }




//


    }

    public function sendRequestReportForProviders(){
        $input = Request()->all();
//        date and time from inputs
//        add 2 hours because time came from form decreased by 2 hours
        $from_date = Carbon::parse($input['from_date'])->addHour(2)->toDateString();
        $to_date = Carbon::parse($input['to_date'])->addHour(2)->toDateString();

        if (in_array("0",$input['services_id'])){
//            if seleced all main services


            if ($input['from_date']==null || $input['to_date']==null){
                $provider = Providor::Join('services','services.services_id','providor.services_id')
                    ->Join('users','users.user_id','providor.user_id')
                    ->where('users.state',$input['state'])
                    ->select(DB::raw('services.services_id,services.services_name_ar,count(*) as count'))
                    ->groupBy('providor.services_id')
                    ->get();
                return $provider;
            }else if($input['from_date']!=null || $input['to_date']!=null){
                $provider = Providor::whereBetween('providor.created_at',[$from_date,$to_date])
                    ->Join('services','services.services_id','providor.services_id')
                    ->Join('users','users.user_id','providor.user_id')
                    ->where('users.state',$input['state'])
                    ->select(DB::raw('services.services_id,services.services_name_ar,count(*) as count'))
                    ->groupBy('providor.services_id')
                    ->get();

                return $provider;
            }




        }else{
            if (count($input['services_id'])===1){
                //            if seleced one main service
                if (in_array("0",$input['sub_services_id'])){
//                    if select all sub services

                    if ($input['from_date']==null || $input['to_date']==null){
                        $provider = Providor::where('providor.services_id',$input['services_id'])
                            ->Join('sub_services','sub_services.sub_services_id','providor.sub_services_id')
                            ->Join('users','users.user_id','providor.user_id')
                            ->where('users.state',$input['state'])
                            ->select(DB::raw('providor.sub_services_id,sub_services.sub_services_name_ar,count(*) as count'))
                            ->groupBy('sub_services.sub_services_id')
                            ->get();
                        return $provider;

                    }else{

                        $provider = Providor::whereBetween('providor.created_at',[$from_date,$to_date])
                                ->where('providor.services_id',$input['services_id'])
                                ->Join('sub_services','sub_services.sub_services_id','providor.sub_services_id')
                            ->Join('users','users.user_id','providor.user_id')
                                ->where('users.state',$input['state'])
                                ->select(DB::raw('providor.sub_services_id,sub_services.sub_services_name_ar,count(*) as count'))
                                ->groupBy('sub_services.sub_services_id')
                                ->get();
                        return $provider;
                    }

                }else{
                    if (count($input['sub_services_id'])===1){
//                        if selected one sub service

                        if ($input['from_date']==null || $input['to_date']==null){
                            $provider = Providor::Join('sub_services','sub_services.sub_services_id','providor.sub_services_id')
                                ->Join('users','users.user_id','providor.user_id')
                                ->whereIn('providor.sub_services_id',$input['sub_services_id'])
                                ->select(DB::raw('sub_services.sub_services_id,sub_services.services_id,sub_services.sub_services_name_ar,users.state,count(*) as count'))
                                ->groupBy('users.state')
                                ->get();
                            return $provider;
                        }else{
                            $provider = Providor::whereBetween('providor.created_at',[$from_date,$to_date])
                                ->Join('sub_services','sub_services.sub_services_id','providor.sub_services_id')
                                ->Join('users','users.user_id','providor.user_id')
                                ->whereIn('providor.sub_services_id',$input['sub_services_id'])
                                ->select(DB::raw('sub_services.sub_services_id,sub_services.services_id,sub_services.sub_services_name_ar,users.state,count(*) as count'))
                                ->groupBy('users.state')
                                ->get();
                            return $provider;
                        }


                    }else{
//                        if selected more than one sub service

                        if ($input['from_date']==null || $input['to_date']==null){
                            $provider = Providor::Join('sub_services','sub_services.sub_services_id','providor.sub_services_id')
                                ->Join('users','users.user_id','providor.user_id')
                                ->whereIn('providor.sub_services_id',$input['sub_services_id'])
                                ->where('users.state',$input['state'])
                                ->select(DB::raw('sub_services.sub_services_id,sub_services.services_id,sub_services.sub_services_name_ar,count(*) as count'))
                                ->groupBy('providor.sub_services_id')
                                ->get();
                            return $provider;
                        }else{
                            $provider = Providor::whereBetween('providor.created_at',[$from_date,$to_date])
                                ->Join('sub_services','sub_services.sub_services_id','providor.sub_services_id')
                                ->Join('users','users.user_id','providor.user_id')
                                ->whereIn('providor.sub_services_id',$input['sub_services_id'])
                                ->where('users.state',$input['state'])
                                ->select(DB::raw('sub_services.sub_services_id,sub_services.services_id,sub_services.sub_services_name_ar,count(*) as count'))
                                ->groupBy('providor.sub_services_id')
                                ->get();
                            return $provider;
                        }

                    }
                }

            }else{
//                where select more than one main service

                if ($input['from_date']==null || $input['to_date']==null){
                    $provider = Providor::Join('services','services.services_id','providor.services_id')
                        ->Join('users','users.user_id','providor.user_id')
                        ->whereIn('providor.services_id',$input['services_id'])
                        ->where('users.state',$input['state'])
                        ->select(DB::raw('services.services_id,services.services_name_ar,count(*) as count'))
                        ->groupBy('providor.services_id')
                        ->get();
                    return $provider;
                }else{
                    $provider = Providor::whereBetween('providor.created_at',[$from_date,$to_date])
                        ->Join('services','services.services_id','providor.services_id')
                        ->Join('users','users.user_id','providor.user_id')
                        ->whereIn('providor.services_id',$input['services_id'])
                        ->where('users.state',$input['state'])
                        ->select(DB::raw('services.services_id,services.services_name_ar,count(*) as count'))
                        ->groupBy('providor.services_id')
                        ->get();
                    return $provider;
                }

            }
        }
    }

    public function tableReportForProviders(){

        $input= Request()->all();
//        if ($input['state'] !=null){
//            $input['state'] = (int)$input['state'];
//        }

        if ($input['date_from'] && $input['date_to']){
            $from_date = Carbon::parse($input['date_from'])->addHour(2)->toDateString();
            $to_date = Carbon::parse($input['date_to'])->addHour(2)->toDateString();

            if ($input['sub_service_id'] !=null){
// give time and subservice
                $output=Providor::whereBetween('providor.created_at',[$from_date,$to_date])
                    ->where('providor.services_id',$input['service_id'])
                    ->where('providor.sub_services_id',$input['sub_service_id'])
                    ->Join('services','services.services_id','providor.services_id')
                    ->Join('sub_services','sub_services.sub_services_id','providor.sub_services_id')
                    ->Join('users','users.user_id','providor.user_id')
                    ->select(DB::raw('services.services_id,services.services_name_ar,sub_services.sub_services_name_ar,users.state,count(*) as count'))
                    ->groupBy('users.state')
                    ->get();
                return $output;




            }else{
// give time and main service
                $output=Providor::whereBetween('providor.created_at',[$from_date,$to_date])
                    ->where('services.services_id',$input['service_id'])
                    ->Join('services','services.services_id','providor.services_id')
                    ->Join('sub_services','sub_services.sub_services_id','providor.sub_services_id')
                    ->Join('users','users.user_id','providor.user_id')
                    ->select(DB::raw('services.services_id,services.services_name_ar,sub_services.sub_services_name_ar,users.state,count(*) as count'))
                    ->groupBy('users.state')
                    ->get();
                return $output;
            }

        }else{
            // if there is no date
            if ($input['sub_service_id'] != null){
// if there is a sub service id
                $output=Providor::where('providor.sub_services_id',$input['sub_service_id'])
                    ->where('providor.services_id',$input['service_id'])
                    ->Join('services','services.services_id','providor.services_id')
                    ->Join('sub_services','sub_services.sub_services_id','providor.sub_services_id')
                    ->Join('users','users.user_id','providor.user_id')
                    ->select(DB::raw('services.services_id,services.services_name_ar,sub_services.sub_services_name_ar,users.state,count(*) as count'))
                    ->groupBy('users.state')
                    ->get();
                return $output;




            }else{
// if there is no sub service id
                $output=Providor::where('services.services_id',$input['service_id'])
                    ->Join('services','services.services_id','providor.services_id')
                    ->Join('sub_services','sub_services.sub_services_id','providor.sub_services_id')
                    ->Join('users','users.user_id','providor.user_id')
                    ->select(DB::raw('services.services_id,services.services_name_ar,sub_services.sub_services_name_ar,users.state,count(*) as count'))
                    ->groupBy('users.state')
                    ->get();
                return $output;
            }
        }




//


    }

    public function sendFollowProviderReport(){
        $input = Request()->all();

        if ($input['services_id'][0]==0){
            // if select all main services
            $providers = Users::where('users.state',2)
                ->Join('providor','providor.user_id','users.user_id')
                ->Join('services','services.services_id','providor.services_id')
                ->select(DB::raw('users.user_name,providor.lat,providor.long,providor.services_id,providor.sub_services_id,services.services_name_ar'))
                ->get();
            return $providers;
        }elseif (count($input['services_id']) >1){
            // if select more than one main services
            $providers=[];
            foreach ($input['services_id'] as $id){
                $output = Users::where('users.state',2)
                    ->Join('providor','providor.user_id','users.user_id')
                    ->where('providor.services_id',$id)
                    ->select(DB::raw('users.user_name,providor.lat,providor.long'))
                    ->get();
                    array_push($providers,$output);
            }
            foreach ($providers as $key => $provider){
                // for delete empty array
                if (!isset($provider[0])) {
                    unset($providers[$key]);
                }
            }
            return $providers;
        }elseif($input['services_id'][0]!=0 &&$input['services_id'][0]!=null){
            // if select one main service
            if ($input['sub_services_id'][0]==0){
                // if select all sub services
                $providers = Users::where('users.state',2)
                    ->Join('providor','providor.user_id','users.user_id')
                    ->where('providor.services_id',$input['services_id'][0])
                    ->select(DB::raw('users.user_name,providor.lat,providor.long'))
                    ->get();
                return $providers;
            }
            elseif (count($input['sub_services_id']) >1){
                // if select more than one sub services
                $providers=[];
                foreach ($input['sub_services_id'] as $id){
                    $output = Users::where('users.state',2)
                        ->Join('providor','providor.user_id','users.user_id')
                        ->where('providor.services_id',$input['services_id'][0])
                        ->where('providor.sub_services_id',$id)
                        ->select(DB::raw('users.user_name,providor.lat,providor.long'))
                        ->get();
                    array_push($providers,$output);
                }
                foreach ($providers as $key => $provider){
                    // for delete empty array
                    if (!isset($provider[0])) {
                        unset($providers[$key]);
                    }
                }
                return $providers;
            }

            elseif ($input['sub_services_id'][0]!=0 &&$input['sub_services_id'][0]!=null){
                // if select one sub service
                $providers = Users::where('users.state',2)
                    ->Join('providor','providor.user_id','users.user_id')
                    ->where('providor.services_id',$input['services_id'][0])
                    ->where('providor.sub_services_id',$input['sub_services_id'][0])
                    ->select(DB::raw('users.user_name,providor.lat,providor.long'))
                    ->get();
                return $providers;
            }

        }


    }

}
