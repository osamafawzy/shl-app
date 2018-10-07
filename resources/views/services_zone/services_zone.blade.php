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
    <div id="Services_Zone">
        <div class="row">
            <data-tables :data="servicesZoneData"
                         v-loading="loading"
                         :show-action-bar="false"
                         :custom-filters="customFilters"
                         :actions-def="actionsDef">
                <el-row slot="custom-tool-bar" style="margin-bottom: 10px ; text-align: center">
                    <el-col :span="5">
                        <el-input v-model="customFilters[0].vals">
                        </el-input>
                    </el-col>

                </el-row>

                <el-table-column
                        prop="sub_services_name_ar"
                        label="الخدمة"
                >
                </el-table-column>

                <el-table-column label="اضافه الخدمة الفرعيه للاحياء">
                    <template slot-scope="scope">

                        <el-button
                                class="fa fa-arrows-alt"
                                size="medium"
                                type="primary"
                                @click="ServicesZoneDisplay(scope.$index, scope.row,dialogTableVisible = true)">
                            &nbsp;&nbsp;
                            اضافه الخدمة الفرعيه للاحياء

                        </el-button>
                    </template>
                </el-table-column>
            </data-tables>
        </div>


        <el-dialog title="اضافه الخدمه الفرعيه للاحياء" :visible.sync="dialogTableVisible" fullscreen>
            {{-- adtto Service To Zone--}}
            <form :form="ServicesZone">
                {{--City Cbo--}}
                <div class="form-group">

                        <el-select v-model="ServicesZone.city_id"
                                   filterable
                                   placeholder="اختار مدينة"
                                   @change="getZone(ServicesZone.city_id)"
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
                {{--Zone Cbo--}}
                <div class="form-group">


                        <el-select
                                v-model="ServicesZone.zone_id"
                                filterable
                                placeholder="اختار منطقة"
                                v-loading="loading"
                        >
                            <el-option
                                    v-for="zone in Zone"
                                    :key="zone.zone_id"
                                    :label="zone.zone_ar"
                                    :value="zone.zone_id"
                                    v-loading="loading">
                            </el-option>

                        </el-select>

                </div>
                {{--Price--}}
                <div class="form-group">


                        <el-input
                                siz="small"
                                placeholder="Please input"
                                v-model="ServicesZone.price"
                                clearable>
                        </el-input>


                <br>
                <br>
                <div class="form-group">

                    <el-button type="success" @click="CreateNewServiceZone()">اضف الخدمة فرعيه الى حى</el-button>
                </div>
            </form>
            {{----}}

            <table class="table table-striped" v-loading="loading">
                <thead>
                <tr>

                    <th scope="col"> اسم الحى</th>
                    <th scope="col"> الحاله</th>
                    <th scope="col">السعر</th>
                    <th scope="col">اشعار</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="services_zone  in gridData">

                    <td>@{{ services_zone.zones.zone_ar}}</td>
                    <td>
                        <el-radio-group v-model="services_zone.active"
                                        @change="ChangeActivityServicesInZone(services_zone)">
                            <el-radio :label="1">تفعيل</el-radio>
                            <el-radio :label="0"> ايقاف</el-radio>
                        </el-radio-group>
                    </td>
                    <td>
                        <el-input
                                class="col-md-3"
                                size="mini"
                                placeholder="Please Input"
                                v-model="services_zone.price">
                        </el-input>
                        <el-button type="success" icon="el-icon-check" circle
                                   @click="changeprice(services_zone)"></el-button>

                    </td>
                    <td>
                        <el-input
                                type="textarea"
                                :autosize="{ minRows: 2, maxRows: 4}"
                                placeholder="Please input"
                                v-model="services_zone.notifications">
                        </el-input>
                        <el-button type="success" icon="el-icon-check" circle
                                   @click="changeprice(services_zone)"></el-button>

                    </td>

                </tr>
                </tbody>
            </table>
        </el-dialog>

    </div>
@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/services_zone.js')}}"></script>
@endsection