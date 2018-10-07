<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestsAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->users = new Users();

    }

    public function index(){
        return view('requests.requests');
    }

    public function Getrequests(){
        $output=$this->users->where('state','0')->with(['Orders.Service'])->get();
        return $output;
    }

    public function AcceptRequest($id){
        $user=$this->users->find($id);
        $user->state='1';
        $user->save();

        return redirect()->back();


    }

    public function RejectRequest($id){
        $user=$this->users->find($id);
        $user->state='2';
        $user->save();

        return redirect()->back();
    }

    public function RejectedRequests(){
        return view('requests.reject_requests');
    }

    public function RejectedRequest(){
        $output=$this->users->where('state','2')->with(['Orders.Service'])->get();
        return $output;
    }
}
