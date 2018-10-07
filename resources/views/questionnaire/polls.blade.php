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
    <div id="polls">
        <div class="row" style="cursor: pointer">
            @can('polls.create',\Illuminate\Support\Facades\Auth::user())
            <el-button
                    class=""
                    size="medium"
                    type="success"
                    @click="newpoll">&nbsp; اضافه استبيان جديد

            </el-button>
            @endcan

            <data-tables :data="pollsData" :show-action-bar="false" :custom-filters="customFilters"
                         :actions-def="actionsDef">
                <el-row slot="custom-tool-bar" style="margin-bottom: 10px ; text-align: center">
                    <el-col :span="5">
                        <el-input v-model="customFilters[0].vals">
                        </el-input>
                    </el-col>

                </el-row>


                <el-table-column
                        prop="poll_id"
                        label="رقم الاستبيان"
                >
                </el-table-column>

                <el-table-column
                        prop="created_at"
                        label="تاريخ التسجيل"
                >
                </el-table-column>


                @can('polls.showquestion',\Illuminate\Support\Facades\Auth::user())
                <el-table-column label="عرض اسئله الاستبيان">
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

                @can('polls.update',\Illuminate\Support\Facades\Auth::user())
                <el-table-column label="اضافه سؤال جديد ">
                    <template slot-scope="scope">

                        <el-button
                                class="fa fa-stop-circle"
                                size="small"
                                type="success"
                                @click="addnew(scope.$index, scope.row)">&nbsp; &nbsp;اضافه

                        </el-button>
                    </template>
                </el-table-column>
                @endcan

                @can('polls.showresult',\Illuminate\Support\Facades\Auth::user())
                <el-table-column label="نتائج الاستبيان">
                    <template slot-scope="scope">

                        <el-button
                                class="fa fa-stop-circle"
                                size="small"
                                type="primary"
                                @click="showresult(scope.$index, scope.row,dialogTable = true)">&nbsp; &nbsp;النتيجه

                        </el-button>
                    </template>
                </el-table-column>
@endcan

                @can('polls.delete',\Illuminate\Support\Facades\Auth::user())
                <el-table-column label=" حذف سؤال">
                    <template slot-scope="scope">

                        <el-button
                                size="small"
                                type="danger"
                                @click="deleteone(scope.$index, scope.row,dialogTableVisible = true)">&nbsp;
                            حذف  سؤال معين

                        </el-button>

                    </template>
                </el-table-column>
@endcan
                @can('polls.deleteall',\Illuminate\Support\Facades\Auth::user())
                <el-table-column label="حذف كامل">
                    <template slot-scope="scope">

                        <el-button
                                size="small"
                                type="danger"
                                @click="deletefull(scope.$index, scope.row)">&nbsp;
                            حذف الاستبيان بالكامل

                        </el-button>
                    </template>
                </el-table-column>
                    @endcan


            </data-tables>

        </div>


        <el-dialog title="الاسئله الخاصه بالاستبيان" :visible.sync="dialogTableVisible">
            <table class="table table-striped">
                <thead>
                <tr>

                    <th scope="col">السؤال باللغه العربيه</th>
                    <th scope="col">السؤال باللغه الانجليزيه</th>
                    <th scope="col">السؤال باللغه الاورديه</th>
                    <th scope="col">حذف</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(ques,index) in gridData">
                    <td >@{{ ques.question_ar }}</td>
                    <td >@{{ ques.question_en }}</td>
                    <td >@{{ ques.question_ur }}</td>
                    <td>
                        <el-button type="danger" icon="el-icon-delete"
                                   @click="RemoveQuestion(ques.poll_questions_id,index)"></el-button>
                    </td>
                </tr>
                </tbody>
            </table>
        </el-dialog>

        <el-dialog title="نتائج الاستبيان" :visible.sync="dialogTable">
            <table class="table table-striped">
                <thead>
                <tr>

                    <th scope="col">السؤال باللغه العربيه</th>
                    <th scope="col">الاجابه باللغه العربيه</th>
                    <th scope="col">عدد الاجابات</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(count,index) in countsdata">
                    <td>@{{ count.question.question_ar }}</td>
                    <td>@{{ count.answer.answer_ar }}</td>
                    <td>@{{ count.count }}</td>
                </tr>
                </tbody>
            </table>
        </el-dialog>


    </div>





@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/polls.js')}}"></script>
@endsection