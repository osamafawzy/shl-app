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
    </style>
@endsection

@section('content')
    <div id="questions">
        <div class="sp-50"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                من فضلك اجب علي الاستبيان
            </div>
            <div class="sp-50"></div>
            <input type="hidden" value="{{$id}}" id="id">
            <div class="panel-body">
                <form :model="chosen">
                <div v-for="(questions,questionIndex) in questionsData">
                    <div>@{{questions.question_ar}}</div>
                    <p v-show="false">@{{questionIndex=questions.poll_questions_id}}</p>
                    <div v-for="(answers,index) in questions.poll_answer">
                        <input type="radio"
                               v-model="chosen[questionIndex]"
                                :value="answers.poll_answer_id"
                        > @{{ answers.answer_ar }}

                    </div>

                    {{--<el-radio-group v-model="chosen[questionIndex]">--}}
                    {{--<el-radio--}}
                    {{-->@{{answers.answer_ar}}</el-radio>--}}
                    {{--</el-radio-group>--}}


                            {{--<el-radio-group v-for="(answers,key) in questions.poll_answer" v-model="questions['poll_questions_id']">--}}
                                {{--<el-radio>@{{answers.answer_ar}}</el-radio>--}}
                            {{--</el-radio-group>--}}


                </div>

                    <el-button
                            size="medium"
                            type="success"
                            @click="Save()">&nbsp; تسجيل الاستبيان
                    </el-button>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/allquestions.js')}}"></script>
@endsection