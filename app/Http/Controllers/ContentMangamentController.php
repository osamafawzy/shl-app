<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\SocialMeida;
use App\Http\Models\ContetWithManagment;
use App\Http\Models\TermsCondititon;
use App\Http\Models\AboutApp;

class ContentMangamentController extends Controller
{
    public function __construct()
    {
        $this->content_with_managment = new ContetWithManagment();
        $this->social_media = new SocialMeida();
        $this->terms_condition = new TermsCondititon();
        $this->about_us = new AboutApp();
    }

    public function GetAllContentWithMangmentPage()
    {

        $contentwithmanagment = $this->content_with_managment->all();
        $social_meida = $this->social_media->all();
        return [
            "mangagment_details" => $contentwithmanagment,
            "social_media" => $social_meida
        ];
    }

    public function GetTermsAndCondition()
    {
        return $this->terms_condition->all();
    }

    public function GetAboutApp()
    {
        return $this->about_us->all();
    }
}
