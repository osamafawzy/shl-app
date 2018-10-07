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
    <div id="addquestions">
        <div class="sp-50"></div>
        <div class="sp-50"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                اضافة سؤال جديد
            </div>
            <div class="sp-50"></div>

            <div class="panel-body">
                <form :model="QuestionsForm">
                    <div class="row">
                        <div class="col-md-2"><label > السؤال:</label>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه العربيه" v-model="QuestionsForm.question_ar"
                                   class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الانجليزيه" v-model="QuestionsForm.question_en"
                                   class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الاورديه" v-model="QuestionsForm.question_ur"
                                   class="form-control" />
                        </div>

                    </div>
                    <div class="sp-10"></div>
                    <div class="row">
                        <div class="col-md-2"><label > الاجابه1:</label>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه العربيه" v-model="QuestionsForm.answer_ar1"
                                   class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الانجليزيه" v-model="QuestionsForm.answer_en1"
                                   class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الاورديه" v-model="QuestionsForm.answer_ur1"
                                   class="form-control" />
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-2"><label > الاجابه2:</label>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه العربيه" v-model="QuestionsForm.answer_ar2"
                                   class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الانجليزيه" v-model="QuestionsForm.answer_en2"
                                   class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الاورديه" v-model="QuestionsForm.answer_ur2"
                                   class="form-control" />
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-2"><label > الاجابه3:</label>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه العربيه" v-model="QuestionsForm.answer_ar3"
                                   class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الانجليزيه" v-model="QuestionsForm.answer_en3"
                                   class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الاورديه" v-model="QuestionsForm.answer_ur3"
                                   class="form-control" />
                        </div>

                    </div>

                    <div class="sp-10"></div>
                    <div class="sp-10"></div><div class="sp-10"></div>

                    <div v-for="(sub_question,index) in QuestionsForm.other_question">
                    <div class="row">
                        <div class="col-md-2"><label > السؤال:</label>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه العربيه" id="questions" v-model="sub_question.questions_ar"
                                   class="form-control"/>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الانجليزيه" id="questions" v-model="sub_question.questions_en"
                                   class="form-control"/>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الاورديه" id="questions" v-model="sub_question.questions_ur"
                                   class="form-control"/>
                        </div>

                    </div>
                        <div class="sp-10"></div>
                    <div class="row" >
                        <div class="col-md-2"><label > الاجابه1:</label>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه العربيه"id="answers" v-model="sub_question.answers_ar1"
                                   class="form-control"/>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الانجليزيه"id="answers" v-model="sub_question.answers_en1"
                                   class="form-control"/>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="اللغه الاورديه"id="answers" v-model="sub_question.answers_ur1"
                                   class="form-control"/>
                        </div>
                    </div>

                        <div class="row" >
                            <div class="col-md-2"><label > الاجابه2:</label>
                            </div>
                            <div class="col-md-2">
                                <input placeholder="اللغه العربيه"id="answers" v-model="sub_question.answers_ar2"
                                       class="form-control"/>
                            </div>
                            <div class="col-md-2">
                                <input placeholder="اللغه الانجليزيه"id="answers" v-model="sub_question.answers_en2"
                                       class="form-control"/>
                            </div>
                            <div class="col-md-2">
                                <input placeholder="اللغه الاورديه"id="answers" v-model="sub_question.answers_ur2"
                                       class="form-control"/>
                            </div>
                        </div>


                        <div class="row" >
                            <div class="col-md-2"><label > الاجابه3:</label>
                            </div>
                            <div class="col-md-2">
                                <input placeholder="اللغه العربيه"id="answers" v-model="sub_question.answers_ar3"
                                       class="form-control"/>
                            </div>
                            <div class="col-md-2">
                                <input placeholder="اللغه الانجليزيه"id="answers" v-model="sub_question.answers_en3"
                                       class="form-control"/>
                            </div>
                            <div class="col-md-2">
                                <input placeholder="اللغه الاورديه"id="answers" v-model="sub_question.answers_ur3"
                                       class="form-control"/>
                            </div>
                            <el-button type="danger" icon="el-icon-delete"
                                       @click="RemoveSubQuestion(index,sub_question,QuestionsForm.other_question)"></el-button>
                        </div>




                        <div class="sp-10"></div><div class="sp-10"></div>
                    </div>
                    <div class="sp-10"></div><div class="sp-10"></div>

                    <div class="row">
                        <center>
                            <button type="button" class="btn btn-success el-icon-circle-plus"
                                    @click="AddQuestion">
                                اضف سؤال اخر
                            </button>
                        </center>
                    </div>

                    <div class="sp-10"></div>
                    <div class="sp-10"></div>
                    <div class="sp-10"></div>
                    <div class="sp-10"></div>
                    <div class="sp-10"></div>
                    <div class="sp-10"></div>

                    <div class="row">
                        <div class="col-md-6 col-md-push-5">
                            <input type="hidden" id="id" value="{{$id}}">
                            <button type="button" class="btn btn-success col-md-4" @click="Save()">حفظ</button>
                        </div>
                    </div>
                    <div class="sp-50"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/addquestions.js')}}"></script>
@endsection