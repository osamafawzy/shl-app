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
    <div id="ServicesTermsConditions">
        <div class="row">
            <div class="sp-10"></div>
            <ul class="nav nav-tabs" id="myTab">
                <li><a data-toggle="tab" href="#sectionA"> اللغة العربية</a></li>
                <li><a data-toggle="tab" href="#sectionB"> اللغة الانجليزية</a></li>
                <li><a data-toggle="tab" href="#sectionC"> الاوردية</a></li>
            </ul>
            <div class="tab-content">
                <div id="sectionA" class="tab-pane fade in active">
                    <el-input
                            type="textarea"
                            :rows="7"
                            placeholder="Please input"
                            v-model="ServicesTersmsCondition.terms_ar">
                    </el-input>
                </div>
                <div id="sectionB" class="tab-pane fade">
                    <el-input
                            type="textarea"
                            :rows="7"
                            placeholder="Please input"
                            v-model="ServicesTersmsCondition.terms_en">
                    </el-input>
                </div>
                <div id="sectionC" class="tab-pane fade">
                    <el-input
                            type="textarea"
                            :rows="7"
                            placeholder="Please input"
                            v-model="ServicesTersmsCondition.terms_ur">
                    </el-input>

                </div>
            </div>
        </div>
        <div class="sp-10"></div>
<div class="row">
    <div class="col-md-6 col-md-push-4">
        <button type="submit" class="btn btn-success col-md-6" @click="updateTersms()">تعديل </button>
    </div>
</div>
        </div>
    </div>
@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/services_terms_conditions.js')}}"></script>
@endsection