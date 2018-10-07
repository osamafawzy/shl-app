ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var addservices = new Vue({
        el: '#addquestions',
        data: {
            baseurl: 'http://127.0.0.1:8000/',
            QuestionsForm: {
                'question_ar': '',
                'question_en': '',
                'question_ur': '',
                'answer_ar1':'',
                'answer_en1':'',
                'answer_ur1':'',
                'answer_ar2':'',
                'answer_en2':'',
                'answer_ur2':'',
                'answer_ar3':'',
                'answer_en3':'',
                'answer_ur3':'',
                'other_question': [{
                    'questions_ar': '',
                    'questions_en': '',
                    'questions_ur': '',
                    'answers_ar1': '',
                    'answers_en1': '',
                    'answers_ur1': '',
                    'answers_ar2': '',
                    'answers_en2': '',
                    'answers_ur2': '',
                    'answers_ar3': '',
                    'answers_en3': '',
                    'answers_ur3': '',
                }
                ],



            }
        },
        methods: {
            AddQuestion: function () {
                var self = this;
                self.QuestionsForm.other_question.push({
                    'questions': '',
                    'answers': ''
                })
            },
            RemoveSubQuestion: function (index, other_question, SubQuestions) {
                console.log(SubQuestions);
                console.log(index);

                SubQuestions.splice(index, 1);
            },

            Save: function () {
                var self = this;
                // var url = window.location.pathname;
                // var id = url.substring(url.lastIndexOf('/') + 1);
                // console.log(id);
                var id = document.getElementById('id').value ;
                console.log(id);
                console.log(self.QuestionsForm);
                if(id==""){
                    axios.post(self.baseurl + 'storequestions', self.QuestionsForm)
                        .then(function (response) {
                            console.log(response);
                            self.$notify({
                                title: 'تم بنجاح',
                                message: 'تم اضافه سؤال جديد بنجاح',
                                type: 'success'
                            });
                            // setTimeout(function(){
                            //     window.location.href = '/addquestionnaire';
                            //
                            // }, 3000);

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }else {
                    axios.post(self.baseurl + 'storequestions/'+ id , self.QuestionsForm)
                        .then(function (response) {
                            console.log(response);
                            self.$notify({
                                title: 'تم بنجاح',
                                message: 'تم اضافه سؤال جديد بنجاح',
                                type: 'success'
                            });
                            // setTimeout(function(){
                            //     window.location.href = '/addquestionnaire';
                            //
                            // }, 3000);

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }



            },



            ques: function () {
                document.location.href = 'questionspage/'
            }

        }
    })
;