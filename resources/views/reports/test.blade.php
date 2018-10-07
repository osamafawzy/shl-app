@extends('admintempate.admintempate')

@section('page-style-level')
    <style>
        .dir {
            direction: rtl;
        }
        #map_canvas { height: 100% }
    </style>

@endsection

@section('content')
    {{--while making reports realtime but it not used now--}}
    <div id="reports">
        <div class="row" style="cursor: pointer">
            <h3>Orders</h3>
            <br>
            <data-tables :data="dataTable":show-action-bar="false"  :custom-filters="customFilters"
                         :actions-def="actionsDef" id="app-datatable">


                <el-table-column
                        prop="pending"
                        label="الطلبات قيد الانتظار"
                >
                </el-table-column>

                <el-table-column
                        prop="accepted"
                        label="الطلبات المقبوله"
                >
                </el-table-column>

                <el-table-column
                        prop="finish"
                        label="الطلبات المنتهيه"
                >
                </el-table-column>

                <el-table-column
                        prop="cancel_from_client"
                        label="الطلبات المرفوضه من جهه العميل"
                >
                </el-table-column>
                <el-table-column
                        prop="cancel_from_provider"
                        label="الطلبات المرفوضه من جهه مزود الخدمه"
                >
                </el-table-column>
            </data-tables>
            <br><br><br>

        </div>
            {{--<reports></reports>--}}
            <div style="width: 500px;height: 500px" id="graph-container">
                <canvas id="myChart"></canvas>
            </div>




    </div>





@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/reports.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('AppAdmin/reports.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endsection