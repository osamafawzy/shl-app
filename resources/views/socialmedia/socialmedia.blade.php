@extends('admintempate.admintempate')

@section('page-style-level')
    <style>


        .dir {
            direction: rtl;
        }

        .sp-50 {
            width: 100%;
            height: 50px;
        }

        .sp-10 {
            width: 100%;
            height: 10px;
        }

    </style>
@endsection

@section('content')
    <div id="SocialMedia">
        <div class="row">
            <div class="sp-10"></div>

            <div class="col-md-12" v-for="social_meidea in SoicalMedia">
                <div class="col-md-2">
                    <div class="form-group">
                        <img width="50" height="50" :src=social_meidea.icone>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <input type="text" v-model="social_meidea.url" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success" @click="UpdateSocialMedia(social_meidea)">تعديل
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/socialmedia.js')}}"></script>
@endsection