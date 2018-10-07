@extends('admintempate.admintempate')

@section('page-style-level')
    <style>
        .dir {
            direction: rtl;
        }
    </style>
@endsection

@section('content')
    <div id="reject_requests">
        <div class="row" style="cursor: pointer">
            <data-tables :data="reject_requestsData" :show-action-bar="false" :custom-filters="customFilters"
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
                        prop="updated_at"
                        label="تاريخ الرفض"
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


            </data-tables>
        </div>

    </div>





@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/reject_requests.js')}}"></script>
@endsection