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
    <div id="providersReports">
        <div class="row">
            <div class="container">
                <h1 class="text-center"><b class="h1 head">تقارير مزودي الخدمة</b> </h1>
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

                            <!--
                    //
                    //العميل والتعديل
                    //
                 -->

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



                <!--
                    //
                    //جدول العميل بتاع التعديل
                    //
                 -->
                <el-table
                        :data="DataTable"
                        v-show="EnableTable"
                        style="
                                margin: auto;
                                width: 70%;
                                padding: 50px;
"
                        height="300">
                    <el-table-column
                            prop="services_name_ar"
                            label="اسم الخدمه الرئيسية"
                            width="150">

                    </el-table-column>
                    <el-table-column
                            prop="sub_services_name_ar"
                            label="اسم الخدمه الفرعيه"
                            width="150">

                    </el-table-column>
                    <el-table-column label="حالة الطلب"
                                     width="120">
                    <template slot-scope="scope">
                    <div
                    v-show="scope.row.state=='1'"
                    type="success">متاح و حر

                    </div>
                    <div
                    v-show="scope.row.state=='2'"
                    type="success">متاح

                    </div>
                    <div
                    v-show="scope.row.state=='3'"
                    type="success">غير متاح

                    </div>
                    </template>
                    </el-table-column>
                    <el-table-column
                            prop="count"
                            label="العدد"
                            width="120">
                    </el-table-column>
                </el-table>



                
            </div>

            
        </div>
    </div>





@endsection
@section('page-script-level')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script src="{{asset('AppAdmin/providersReports.js')}}"></script>  
    
@endsection