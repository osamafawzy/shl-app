<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\ContetWithManagment;

class ContactUsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->contact_with_manahment = new ContetWithManagment();

    }

    public function index()
    {
        return view('contactus.contactus');
    }

    public function GetContacts()
    {
        return $this->contact_with_manahment->all();
    }

    public function CreateNewContacts()
    {
        $input = Request()->all();
        return $this->contact_with_manahment->create($input);
    }

    public function UpdateContact($id)
    {
        $input = Request()->all();
        $this->contact_with_manahment->find($id)->update($input);
        $output = $this->contact_with_manahment->where('contact_id', $id)->get();
        return $output[0];

    }

    public function DeleteContact($id)
    {
        $this->contact_with_manahment->find($id)->delete();
    }
}
