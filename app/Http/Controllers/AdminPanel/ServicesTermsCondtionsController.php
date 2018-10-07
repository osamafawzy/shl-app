<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Models\ServicesTremsConditions;
use Illuminate\Http\Request;

class ServicesTermsCondtionsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->services_tersms_condtions = new ServicesTremsConditions();

    }

    public function ServicesCondtionsIndex()
    {
        return view('servics_terms.servics_terms');
    }

    public function GetServicesTermsConditions()
    {
        return $this->services_tersms_condtions->all();
    }

    public function UpdateTermsCondtions($id)
    {
        $input = Request()->all();
        $this->services_tersms_condtions->find($id)->update();
    }
}
