<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\SocialMeida;

class SocialMediaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->social_media = new SocialMeida();
    }

    public function SocialMeidaIndex()
    {
        return view('socialmedia.socialmedia');
    }

    public function GetSocialMedia()
    {
        return $this->social_media->all();
    }

    public function UpdateSocialMedia($id)
    {
        $input = Request()->all();
        $this->social_media->find($id)->update($input);
    }
}
