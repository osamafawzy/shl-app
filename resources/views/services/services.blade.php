@extends('admintempate.admintempate')

@section('page-style-level')
    <style>
        .dir {
            direction: rtl;
        }
    </style>
@endsection

@section('content')
    <div id="services">
        <div class="row">
            <data-tables :data="servicesData" :show-action-bar="false" :custom-filters="customFilters"
                         :actions-def="actionsDef">
                <el-row slot="custom-tool-bar" style="margin-bottom: 10px ; text-align: center">
                    <el-col :span="5">
                        <el-input v-model="customFilters[0].vals">
                        </el-input>
                    </el-col>

                      @can('services.create',\Illuminate\Support\Facades\Auth::user())
                    <el-col :span="19">
                        <el-button type="success" data-toggle="modal" @Click="GotoAddNewServices()">اضافه خدمة جديدة
                        </el-button>
                    </el-col>
                      @endcan
                </el-row>
                @can('services.update',\Illuminate\Support\Facades\Auth::user())
                <el-table-column label="تعديل">
                    <template slot-scope="scope">
                        <el-button
                                class="el-icon-edit"
                                size="medium"
                                type="warning"
                                @click="handleEdit(scope.$index, scope.row)">
                            &nbsp;&nbsp;
                            تعديل


                        </el-button>
                    </template>
                </el-table-column>
                @endcan
                <el-table-column
                        prop="services_name_ar"
                        label="الخدمة"
                >
                </el-table-column>

                <el-table-column label="الخدمات الفرعية">
                    <template slot-scope="scope">

                        <el-button
                                class="fa fa-arrows-alt"
                                size="medium"
                                type="primary"
                                @click="subSerivcesDisplay(scope.$index, scope.row,dialogTableVisible = true)">
                            &nbsp;&nbsp;
                            الخدمات الفرعية
                        </el-button>
                    </template>
                </el-table-column>

                {{--<el-table-column label="ايقاف">--}}
                    {{--<template slot-scope="scope">--}}

                        {{--<el-button--}}
                                {{--class="fa fa-stop-circle"--}}
                                {{--size="medium"--}}
                                {{--type="danger"--}}
                                {{--@click="handleStop(scope.$index, scope.row)">&nbsp; &nbsp;ايقاف--}}

                        {{--</el-button>--}}
                    {{--</template>--}}
                {{--</el-table-column>--}}

            </data-tables>
        </div>
        {{--stop or resume Services--}}
        <el-dialog
                title="هل تريد ايقاف الخدمة"
                :visible.sync="centerDialogVisible"
                width="30%"
                center>
            <span>هل انت متأكد من ايقاف الخدمة</span>
            <span slot="footer" class="dialog-footer">
                <el-button type="success" @click="centerDialogVisible = false">ايقاف</el-button>
                <el-button type="danger" @click="centerDialogVisible = false">الغاء</el-button>
            </span>
        </el-dialog>

        {{--show Sub Services--}}
        <el-dialog title="الخدمات الفرعية" :visible.sync="dialogTableVisible">
            <table class="table table-striped">
                <thead>
                <tr>

                    <th scope="col">اسم الخدمة الفرعية بالعربية</th>
                    <th scope="col">اسم الخدمة الفرعية بالانجليزية</th>
                    <th scope="col">اسم الخدمة الفرعية بالاوردية</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="sub_serives in gridData">
                    <td>@{{ sub_serives.sub_services_name_ar }}</td>
                    <td>@{{ sub_serives.sub_services_name_en }}</td>
                    <td>@{{ sub_serives.sub_services_name_ur }}</td>
                </tr>
                </tbody>
            </table>
        </el-dialog>


    </div>





@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/services.js')}}"></script>
@endsection