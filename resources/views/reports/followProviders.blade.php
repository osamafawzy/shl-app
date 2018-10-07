@extends('admintempate.admintempate')
@section('page-style-level')
    <style>
        h3 {
            color : #606266 ; 
        }
        .title {
            font: 17px arial, sans-serif; 
            font-weight: bold;
        }
        .dir {
            direction: rtl;
        }
        #map_canvas { height: 100% }
        
        .center {
            margin: auto;
            width: 50%;
            
            padding: 10px;
        }
        .head{
            font: 40px arial, sans-serif; 
        }
        .serve{
            color : #428bca ; 
            font-size : 25px ; 
        }
    </style>

@endsection
@section('content')
    <div id="servicesReports">
        <div class="row">
            <div class="container">
                <h1 class="text-center"><b class="h1 head">تتبع مذودي الخدمة</b> </h1>
                <el-row>


                    <!-- Select BasicService -->
                    <div class="sp-100"><div class="block">
                    <span class="demonstration title serve">الخدمات الرئيسية</span>
                    <el-checkbox-group v-model="form.services_id" >
                        <el-checkbox
                        v-on:change="activeAll"
                        :value=0
                        :key=0
                        label=0
                        ><p class="h4">جميع الخدمات</p>
                        </el-checkbox>
                        <el-checkbox
                        v-show="AllIsActive"
                        v-on:change="getSecondaries"
                        v-for ="service in services"
                        :key ="service.services_id"
                        :value="service.services_id"
                        :label="service.services_id"><p class="h4">@{{service.services_name_ar}}</p></el-checkbox>
                    </el-checkbox-group>
                    </div></div>
                    <!-- Select SecondaryService -->
                    <div class="sp-100"><div class="block"
                    v-show="form.services_id.length == 1  && form.services_id[0] != '0'" >
                    <span class="demonstration title  serve">الخدمات الفرعية</span>
                    <el-checkbox-group
                            id="subservice_id"
                     v-model="form.sub_services_id">
                        <el-checkbox
                        v-on:change="AllSecondary"
                        :value=0
                        :key=0
                        label=0
                        ><p class="h4">جميع الخدمات الفرعية</p>
                        </el-checkbox>
                        <el-checkbox
                        v-show="AllIsSecondary"
                        v-for ="secondary in secondaries"
                        :key ="secondary.sub_services_id"
                        :value="secondary.sub_services_id"
                        :label="secondary.sub_services_id"><p class="h4">@{{secondary.sub_services_name_ar}}</p></el-checkbox>
                    </el-checkbox-group>
                    </div></div>
                    <el-button
                    @click="sendForm()"
                     type="primary"
                     icon="el-icon-view">    اعرض</el-button>
                        <div id="map_canvas" style="width: 1000px; height: 600px; margin:50px 20px 50px 0px "></div>


                </el-row>


            </div>





        </div>
    </div>





@endsection
@section('page-script-level')
    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0EFdDpoMUQ_7w-MKKd3V4tawZ5TcUPcQ">
    </script>
<script src="{{asset('AppAdmin/followProviders.js')}}"></script>
    {{--<script src="{{asset('js/app.js')}}"></script>  --}}




@endsection