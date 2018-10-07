ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var addservices = new Vue({
        el: '#questions',
        data: {
            url: 'http://127.0.0.1:8000/',
            questionsData: [],
            chosen: []


        },mounted: function ($index, row) {
        var self = this;
        var id = document.getElementById('id').value ;

        console.log(id);
        // $.ajax({
        //     url: self.url + "allquestions/" + id,
        //     method: 'Get'
        //
        // }).done(function (result) {
        //     // console.log(result);
        //     self.questionsData = result;
        //
        //     console.log(self.questionsData);
        // });

        axios.get(self.url + 'allquestions/' + id+'?lang=ar')
            .then(function (response) {
                    self.questionsData = response.data;
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
    },
        methods: {
            Save: function () {
                var self = this;
                console.log(self.chosen);
                var id = document.getElementById('id').value ;
                axios.put(self.url + 'recieveQuestionnaire/' + id ,self.chosen)
                    .then(function (response) {
                        console.log(self.chosen);
                        console.log(response);
                        self.chosen=[''];
                        self.$notify({
                            title: 'تم بنجاح',
                            message: 'شكرا لاجابتك علي الاستبيان',
                            type: 'success'
                        });
                        // setTimeout(function(){
                        //     window.location.href = '/polls';
                        //
                        // }, 3000);

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

        }
    })
;