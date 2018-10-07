@extends('admintempate.admintempate')

@section('page-style-level')
    <style>
        .dir {
            direction: rtl;
        }
    </style>
@endsection

@section('content')
    <div id="clients">
        <div class="row" @click="ffff" style="cursor: pointer">
            <data-tables :data="clientsData" :show-action-bar="false" :custom-filters="customFilters"
                         :actions-def="actionsDef">
                <el-row slot="custom-tool-bar" style="margin-bottom: 10px ; text-align: center">
                    <el-col :span="5">
                        <el-input v-model="customFilters[0].vals">
                        </el-input>
                    </el-col>

                </el-row>


                <el-table-column
                        prop="user_name"
                        label="الاسم"
                >
                </el-table-column>

                <el-table-column
                        prop="created_at"
                        label="تاريخ التسجيل"
                >
                </el-table-column>

                <el-table-column
                        prop="orders_count"
                        label="عدد العمليات"
                >
                </el-table-column>

                <el-table-column
                        prop="phone"
                        label="رقم الهاتف"
                >
                </el-table-column>
                @can('clients.update',\Illuminate\Support\Facades\Auth::user())

                <el-table-column label="تشغيل\ايقاف">
                    <template slot-scope="scope">

                        <el-button
                                class="fa fa-stop-circle"
                                size="medium"
                                v-show="scope.row.activate==='0'"
                                type="success"
                                @click="handleEdit(scope.$index, scope.row)">&nbsp; &nbsp;تشغيل

                        </el-button>

                        <el-button
                                class="fa fa-stop-circle"
                                size="medium"
                                type="danger"
                                v-show="scope.row.activate==='1'"
                                @click="handleEdit(scope.$index, scope.row)">&nbsp; &nbsp;ايقاف

                        </el-button>
                    </template>
                </el-table-column>
                @endcan

                @can('clients.view',\Illuminate\Support\Facades\Auth::user())
                <el-table-column label="معلومات اضافيه">
                    <template slot-scope="scope">

                        <el-button
                                class="fa fa-stop-circle"
                                size="medium"
                                type="warning"
                                @click="handleProfile(scope.$index, scope.row)">&nbsp; &nbsp;عرض

                        </el-button>
                    </template>
                </el-table-column>
@endcan



            </data-tables>
        </div>



    </div>





@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/clients.js')}}"></script>
@endsection