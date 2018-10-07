<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Ads;

class AdsController extends Controller
{
    //
    public function __construct()
    {
        $this->ads = new Ads();
    }

    public function GetAllAds()
    {
        $output = $this->ads->get();
        return ['Get_all_ads' => $output];
    }
}
