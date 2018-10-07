ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var clients = new Vue({
        el: '#providers',
        data: {
            url: 'http://127.0.0.1:8000/',
            providersData: [],
            centerDialogVisible: false,
            formLabelWidth: '120px',
            form: {
                grade: ''
            }
            ,
            customFilters: [{
                vals: '',
                props: ['user_name', 'phone']
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
                url: self.url + "allproviders?lang=ar",
                method: 'Get'

            }).done(function (result) {
                // var i;
                // for (i = 0; i < result.length; i++) {
                //     result[i]['created_at'].for
                // }

                self.providersData = result;

                console.log(self.providersData);
                // console.log(self.clientsData[]['created_at']);
            });
        },
        methods: {
            handleEdit: function ($index, row) {
                var self = this;
                // document.location.href = 'updateprovider/' + row.user_id

                axios.put(self.url + 'updateprovider/' + row.user_id, self.providersData)
                    .then(function (response) {
                        if (row.activate==='0'){
                            row.activate='1';
                        }else {
                            row.activate='0';
                        }
                        console.log(response);
                        self.$notify({
                            title: 'تم بنجاح',
                            message: 'تم التعديل علي الموظف بنجاح...سوف يتم تحميل الصفحه مره اخري',
                            type: 'success'
                        })
                        //     ,setTimeout(function(){
                        //     window.location.href = '/providers';
                        // }, 3000);
                    })
            },
            handleProfile: function ($index, row){
                document.location.href = 'providerProfile/' + row.user_id
            }

        }
    })
;