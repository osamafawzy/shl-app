@extends('admintempate.admintempate')

@section('page-style-level')
    <style>
        /*@import url("//unpkg.com/element-ui@2.3.9/lib/theme-chalk/index.css");*/

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

        .el-shl-loading {
            background-image: url("shl-loading.gif");
        }
    </style>
@endsection

@section('content')
    <div id="Services_prices">
        <div class="row">
            <data-tables :data="servicesPriceData" :show-action-bar="false"
                         v-loading="loading"
                         :custom-filters="customFilters"
                         :actions-def="actionsDef">
                <el-row slot="custom-tool-bar" style="margin-bottom: 10px ; text-align: center">
                    <el-col :span="5">
                        <el-input v-model="customFilters[0].vals">
                        </el-input>
                    </el-col>

                </el-row>
                <el-table-column
                        prop="services_name_ar"
                        label="الخدمة"
                >
                </el-table-column>

                {{--<el-table-column label="الخدمات داخل المدن">--}}
                    {{--<template slot-scope="scope">--}}

                        {{--<el-button--}}
                                {{--class="fa fa-arrows-alt"--}}
                                {{--size="medium"--}}
                                {{--type="primary"--}}
                                {{--@click="ServicesCityDisplay(scope.$index, scope.row,dialogTableVisible = true)">--}}
                            {{--&nbsp;&nbsp;--}}
                            {{--الخدمات داخل المدن--}}
                        {{--</el-button>--}}
                    {{--</template>--}}
                {{--</el-table-column>--}}
                <el-table-column label="احياء الخدمات">
                    <template slot-scope="scope">

                        <el-button
                                v-loading.fullscreen.lock="loading2"
                                element-loading-text="جارى تحويلك"
                                element-loading-spinner="el-icon-loading"
                                element-loading-background="rgba(0, 0, 0, 0.8)"
                                class="fa fa-arrows-alt"
                                size="medium"
                                type="info"
                                @click="Services_zone(scope.$index, scope.row)">
                            &nbsp;&nbsp;
                            الخدمات الفرعيه داخل الاحياء
                        </el-button>
                    </template>
                </el-table-column>

            </data-tables>
        </div>


        <el-dialog title="الخدمات الفرعية" :visible.sync="dialogTableVisible" fullscreen>
            <form :form="Service_City">
                <div class="form-group">

                    <el-select v-model="Service_City.city_id"
                               filterable
                               placeholder="اختار مدينة"
                               v-loading="loading"
                    >

                        <el-option
                                v-for="city in City"
                                :key="city.city_id"
                                :label="city.city_ar"
                                :value="city.city_id">
                        </el-option>

                    </el-select>

                </div>

                <div class="form-group">
                    <el-button type="success" @click="CreateNewServiceCity(gridData)">اضف الخدمة فرعيه الى مدينة</el-button>


                </div>

            </form>


            <table class="table table-striped" v-loading="loading">
                <thead>
                <tr>

                    <th scope="col"> اسم المدينة</th>
                    <th scope="col"> الحاله</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="services_city in gridData">

                    <td>@{{ services_city.city.city_ar }}</td>
                    <td>
                        <el-radio-group v-model="services_city.active"
                                        @change="ChangeActivityServicesInCity(services_city)">
                            <el-radio :label="1">تفعيل</el-radio>
                            <el-radio :label="0"> ايقاف</el-radio>
                        </el-radio-group>
                    </td>

                </tr>
                </tbody>
            </table>
        </el-dialog>

    </div>
@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/services_prices.js')}}"></script>
@endsection