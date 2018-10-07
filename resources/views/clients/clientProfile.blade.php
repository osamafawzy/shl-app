@extends('admintempate.admintempate')

@section('page-style-level')
    <style>
        .dir {
            direction: rtl;
        }
    </style>
@endsection

@section('content')
    <div id="client_profile">
        <div class="row" v-for="client in clientProfile">
            <div>
                <label > الاسم بالكامل :</label>
                <label>@{{client['user_name']}}</label>
            </div>
            <div >
                <label > رقم الهاتف:</label>
                <label>@{{client['phone']}}</label>
            </div>
            <div >
                <label > البريد الالكتروني :</label>
                <label>@{{client['email']}}</label>
            </div>
            <div >
                <label >عدد العمليات :</label>
                <label>@{{client['orders_count']}}</label>
            </div>
            <div >
                <label > تاريخ التسجيل :</label>
                <label>@{{client['created_at']}}</label>
            </div>
        </div>

        <h2 style="text-align: center">تاريخ العمليات</h2>

        <div class="row" style="cursor: pointer"  v-for="clientorders in clientProfile">
            <data-tables :data="clientorders['orders']" :show-action-bar="false" :custom-filters="customFilters"
                         :actions-def="actionsDef">
                <el-row slot="custom-tool-bar" style="margin-bottom: 10px ; text-align: center">
                    <el-col :span="5">
                        <el-input v-model="customFilters[0].vals">
                        </el-input>
                    </el-col>

                </el-row>


                <el-table-column
                        prop="created_at"
                        label="التاريخ"
                >
                </el-table-column>


                <el-table-column label="مكان العمليه">
                    <template slot-scope="scope">
                    <p> @{{ scope.row.sub_services.services_zone['0'].zones.zone_ar }}</p>
                    </template>
                </el-table-column>

                <el-table-column label="الحاله">
                    <template slot-scope="scope">

                        <div
                                v-show="scope.row.order_state===1"
                                type="success">&nbsp; &nbsp;قيد الانتظار

                        </div>
                        <div
                                v-show="scope.row.order_state===2"
                                type="success">&nbsp; &nbsp;تم الاستلام

                        </div>
                        <div
                                v-show="scope.row.order_state===3"
                                type="success">&nbsp; &nbsp;رفض من جهه العميل

                        </div>
                        <div
                                v-show="scope.row.order_state===4"
                                type="success">&nbsp; &nbsp;رفض من جهه الموظف

                        </div>

                        <el-button
                                class="fa fa-stop-circle"
                                size="medium"
                                type="danger"
                                v-show="scope.row.activate==='1'"
                                @click="handleEdit(scope.$index, scope.row)">&nbsp; &nbsp;ايقاف

                        </el-button>
                    </template>
                </el-table-column>


                <el-table-column label="مقدم الخدمه">
                    <template slot-scope="scope">
                        <p> @{{ scope.row.provider.users.user_name }}</p>
                    </template>
                </el-table-column>







            </data-tables>
        </div>



    </div>





@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/client_profile.js')}}"></script>
@endsection