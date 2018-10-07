ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var clients = new Vue({
        el: '#polls',
        data: {
            url: 'http://127.0.0.1:8000/',
            pollsData: [],
            gridData: [],
            countsdata:[],
            centerDialogVisible: false,
            dialogTableVisible: false,
            dialogTable: false,
            formLabelWidth: '120px',
            form: {
                grade: ''
            }
            ,
            customFilters: [{
                vals: '',
                props: ['poll_id']
            }, {
                vals: []
            }],
            actionsDef:
                {
                    colProps: {
                        span: 8
                    }
                    ,
                    def: [{
                        name: 'new',
                        handler: function () {
                            this.$message("new clicked")
                        }

                    }]
                }

        },
        mounted: function ($index, row) {
            var self = this;
            $.ajax({
                url: self.url + "allpolls?lang=ar",
                method: 'Get'

            }).done(function (result) {

                self.pollsData = result;

                console.log(self.pollsData);
            });
        },
    methods: {
     handleProfile: function ($index, row){
            document.location.href = 'questionspage/' + row.poll_id
        }
        ,
        newpoll: function ($index, row){
            document.location.href = 'addquestionnaire'
        },
        addnew: function ($index, row) {
            document.location.href = 'addquestionnaire/' + row.poll_id
        },
        deletefull: function ($index,row) {
            var self = this;
            axios.get(self.url + 'deletepoll/' + row.poll_id)
                .then(function (response) {
                    console.log(response);
                    self.$notify({
                        title: 'تم بنجاح',
                        message: 'تم  حذف الاستبيان بنجاح...سوف يتم تحميل الصفحه مره اخري',
                        type: 'success'
                    })
                        ,setTimeout(function(){
                        window.location.href = '/polls';

                    }, 2000);
                })
        },
        deleteone:function ($index,row) {
            var self = this;
            $.ajax({
                url: self.url + "allquestions/" + row.poll_id + "?lang=ar",
                method: 'Get'

            }).done(function (result) {

                self.gridData = result;
                console.log(self.gridData);
            });

        },
        RemoveQuestion:function (id,index) {
            var self = this;
            console.log(id);
            axios.get(self.url + 'deletequestion/' + id)
                .then(function (response) {
                    self.gridData.splice(index, 1);
                    console.log(response);
                    self.$notify({
                        title: 'تم بنجاح',
                        message: 'تم  حذف السؤال بنجاح...سوف يتم تحميل الصفحه مره اخري',
                        type: 'success'
                    })
                    //     ,setTimeout(function(){
                    //     window.location.href = '/polls';
                    //
                    // }, 2000);
                })

        },
        showresult:function ($index,row) {
            var self = this;
            axios.get(self.url + 'showresult/' + row.poll_id+'?lang=ar')
                .then(function (response) {
                    self.countsdata=response.data;
                    // var i;
                    // for (i = 0; i < countsdata.length; i++) {
                    //     if (self.countsdata[i].question.question_ar == null){
                    //         self.countsdata.splice(i,1);
                    //     }
                    // }
                    console.log(self.countsdata);
                })
        }
    }
    })
;