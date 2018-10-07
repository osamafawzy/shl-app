@extends('admintempate.admintempate')

@section('page-style-level')
    <style>
        .dir {
            direction: rtl;
        }
    </style>
@endsection

@section('content')
    <div id="requests">
        <div class="row" style="cursor: pointer">
            <el-button
                    class=""
                    size="medium"
                    @click="Rejected">&nbsp; &nbsp;الطلبات المرفوضه

            </el-button>
            <data-tables :data="requestsData" :show-action-bar="false" :custom-filters="customFilters"
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
                        prop="phone"
                        label="رقم الهاتف"
                >
                </el-table-column>

                <el-table-column label="نوع الخدمه">
                    <template slot-scope="scope">
                        <p> @{{ scope.row.orders['0'].service.services_name_ar }}</p>
                    </template>
                </el-table-column>

                <el-table-column label="قبول\رفض">
                    <template slot-scope="scope">

                        <el-button
                                class="fa fa-stop-circle"
                                size="small"
                                type="success"
                                @click="handleAccept(scope.$index, scope.row)">&nbsp; &nbsp;قبول

                        </el-button>

                        <el-button
                                class="fa fa-stop-circle"
                                size="small"
                                type="danger"
                                @click="handleReject(scope.$index, scope.row)">&nbsp; &nbsp;رفض

                        </el-button>
                    </template>
                </el-table-column>





            </data-tables>
        </div>



    </div>





@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/requests.js')}}"></script>
@endsection