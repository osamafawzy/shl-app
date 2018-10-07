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
                <h1 class="text-center"><b class="h1 head">لـوحـة الـتـقاريـر</b> </h1>
                <el-row>
                <el-col :span="12">
                     <div style="width: 450px;height: 450px ; margin-top:50px" id="graph-container">
                        <canvas id="myChart"></canvas>
                    </div>
                    <div style="padding-top: 5px"
                         v-for="(label,key) in globalLabels"
                           >

                        <p>@{{label}}</p>
                        <el-progress
                                v-for="(item,index) in order_data"
                                v-show="index == key"
                                :key=item
                                style="width:75%"
                                :percentage=item color="#8e71c7">
                        </el-progress>
                    </div>

                </el-col>
                    <el-col :span="12">
                    <!-- StartDate -->
                
                <div class="sp-50"><div class="block">
                        <span class="demonstration title">بداية التاريخ</span>
                        <el-date-picker
                        v-model="form.from_date"
                        type="date"
                        placeholder="اختر تاريخ"
                        default-value="">
                        </el-date-picker>
                    </div></div>
                    
                    
                    <!-- EndDate -->
                    <div class="sp-50"><div class="block">
                        <span class="demonstration title">نهاية التاريخ</span>
                        <el-date-picker
                        v-model="form.to_date"
                        type="date"
                        placeholder="اختر تاريخ"
                        default-value="">
                        </el-date-picker>
                    </div></div>
                    <!-- Start Time -->
                    <div class="sp-50"><div class="block">
                    <span class="demonstration title">بداية الموعد</span>
                    <el-time-picker
                    arrow-control

                        v-model="form.from_hr"
                        :picker-options="{
                        selectableRange: '01:00:00 - 23:00:00'
                        }"
                        placeholder="بداية الموعد">
                    </el-time-picker>
                    </div></div>
                    <!-- End Time -->
                    <div class="sp-50"><div class="block">
                    <span class="demonstration title">نهاية الموعد</span>
                    <el-time-picker
                    arrow-control

                        v-model="form.to_hr"
                        :picker-options="{
                        selectableRange: '01:00:00 - 23:00:00'
                        }"
                        placeholder="نهاية الموعد">
                    </el-time-picker>
                    </div></div>
                    <!-- Select BasicService -->
                    <div class="sp-100"><div class="block">
                    <span class="demonstration title serve">الخدمات الرئيسية</span>
                    <el-checkbox-group v-model="form.services_id">
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
                    <!-- show Select State -->
                    <div class="sp-50"><div class="block"
                    v-show="form.services_id.length > 1 || form.services_id[0] == '0'"
                    >
                    <span class="demonstration h4">الحالة المراد عرضها</span>
                    <el-select v-model="form.state" clearable placeholder="اختر">
                    <el-option
                        v-for="item in states"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                        </el-option>
                    </el-select>
                    </div></div>



                    <!-- Select SecondaryService -->
                    <div class="sp-100"><div class="block"
                                            v-show="form.services_id.length == 1  && form.services_id[0] != '0'" >
                    <span class="demonstration title  serve">الخدمات الفرعية</span>
                    <el-checkbox-group
                    
                     v-model="form.sub_services_id">
                        <el-checkbox
                        v-on:change="activeSecondary"
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



                    <!-- show Select State -->
                    <div class="sp-50"><div class="block"
                    v-show="(form.sub_services_id.length > 1 || form.sub_services_id[0] == '0')&&(form.services_id.length == 1 || form.services_id[0] == '0')"
                    >
                    <span class="demonstration h4">الحالة المراد عرضها</span>
                    <el-select v-model="form.state" clearable placeholder="اختر">
                    <el-option
                        v-for="item in states"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                        </el-option>
                    </el-select>
                    </div></div>
                    <div class="sp-50"><div class="block">
                    <el-button @click="sendForm()" type="success" round>أعرض</el-button>
                    </div></div>
                    </el-col>
                </el-row>


                <div class="sp-50"><div class="block">
                <el-select 
                v-show="arrayForBasic.length > 0"
                v-model="BringTable" 
                v-on:change="table"
                placeholder="اختر لعرض الجدول">
                    <el-option
                        v-for="item in arrayForBasic"
                        :key="item.services_id"
                        :label="item.services_name_ar"
                        :value="item.services_id">
                    </el-option>
                </el-select>

                
                <el-select 
                v-show="arrayForSub.length > 0"
                v-model="BringTable" 
                v-on:change="table"
                placeholder="اختر لعرض الجدول">
                    <el-option
                        v-for="item in arrayForSub"
                        :key="item.sub_services_id"
                        :label="item.sub_services_name_ar"
                        :value="item.sub_services_id">
                    </el-option>
                </el-select>

                <el-select 
                v-show="arrayWithState.length > 0"
                v-model="BringTable" 
                v-on:change="table"
                placeholder="اختر لعرض الجدول">
                    <el-option
                        v-for="item in arrayWithState"
                        :key="item.order_state"
                        :label="item.order_state_ar"
                        :value="item.order_state">
                    </el-option>
                </el-select>
                    </div></div>



                {{--<data-tables style="width:90%" v-show="EnableTable"--}}
                             {{--:data="DataTable"--}}
                             {{--:show-action-bar="false"--}}
                             {{--:custom-filters="customFilters"--}}
                             {{--:actions-def="actionsDef">--}}
                    {{--<el-row slot="custom-tool-bar" style="margin-bottom: 10px ; text-align: center">--}}
                        {{--<el-col :span="5">--}}
                            {{--<el-input v-model="customFilters[0].vals">--}}
                            {{--</el-input>--}}
                        {{--</el-col>--}}
                    {{--</el-row>--}}

                    {{--<el-table-column label="اسم الخدمه الرئيسيه">--}}
                        {{--<template slot-scope="scope">--}}
                            {{--<p> @{{ scope.row.service.services_name_ar--}}
                                {{--}}</p>--}}
                        {{--</template>--}}
                    {{--</el-table-column>--}}

                    {{--<el-table-column label="اسم الخدمه الفرعيه">--}}
                        {{--<template slot-scope="scope">--}}
                            {{--<p> @{{ scope.row.sub_services.sub_services_name_ar}}</p>--}}
                        {{--</template>--}}
                    {{--</el-table-column>--}}

                    {{--<el-table-column label="اسم مزود الخدمه">--}}
                        {{--<template slot-scope="scope">--}}
                            {{--<p>@{{ scope.row.provider.users.user_name}} </p>--}}
                        {{--</template>--}}
                    {{--</el-table-column>--}}

                    {{--<el-table-column label="اسم العميل">--}}
                        {{--<template slot-scope="scope">--}}
                            {{--<p> @{{ scope.row.users.user_name}}</p>--}}
                        {{--</template>--}}
                    {{--</el-table-column>--}}

                    {{--<el-table-column label="حالة الطلب">--}}
                        {{--<template slot-scope="scope">--}}
                            {{--<div--}}
                                    {{--v-show="scope.row.order_state===1"--}}
                                    {{--type="success">&nbsp; &nbsp;قيد الانتظار--}}

                            {{--</div>--}}
                            {{--<div--}}
                                    {{--v-show="scope.row.order_state===2"--}}
                                    {{--type="success">&nbsp; &nbsp;المقبوله--}}

                            {{--</div>--}}
                            {{--<div--}}
                                    {{--v-show="scope.row.order_state===3"--}}
                                    {{--type="success">&nbsp; &nbsp;المنتهيه--}}

                            {{--</div>--}}
                            {{--<div--}}
                                    {{--v-show="scope.row.order_state===4"--}}
                                    {{--type="success">&nbsp; &nbsp;رفض من جهه العميل--}}

                            {{--</div>--}}
                            {{--<div--}}
                                    {{--v-show="scope.row.order_state===5"--}}
                                    {{--type="success">&nbsp; &nbsp;رفض من جهه الموظف--}}

                            {{--</div>--}}
                        {{--</template>--}}
                    {{--</el-table-column>--}}

                {{--</data-tables>--}}



                <el-table
                        class="dir"
                        :data="DataTable"
                        v-show="EnableTable"
                        style="width: 90%"
                        height="400">
                    <el-table-column
                            prop="created_at"
                            label="تاريخ انشاء الطلب"
                            width="150">

                    </el-table-column>
                    <el-table-column
                            prop="users.user_name"
                            label="اسم العميل"
                            width="150">

                    </el-table-column>
                    <el-table-column
                            prop="users.phone"
                            label="هاتف العميل"
                            width="150">

                    </el-table-column>
                    <el-table-column
                            prop="order_id"
                            label="رقم الطلب"
                            width="85">
                    </el-table-column>
                    <el-table-column
                            prop="updated_at"
                            label="تاريخ ووقت قبول/انتهاء الطلب"
                            width="150">
                    </el-table-column>
                    <el-table-column
                            prop="provider.users.user_name"
                            label="اسم مزود الخدمة"
                            width="150">
                    </el-table-column>
                    <el-table-column
                            prop="provider.users.phone"
                            label="رقم مزود الخدمة"
                            width="150">
                    </el-table-column>
                    <el-table-column
                            prop="rate"
                            label="التقييم"
                            width="150">
                    </el-table-column>
                </el-table>

                
            </div>

            
        </div>
    </div>





@endsection
@section('page-script-level')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script src="{{asset('AppAdmin/servicesReports.js')}}"></script>  
    
@endsection