ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var clients = new Vue({
        el: '#reject_requests',
        data: {
            url: 'http://127.0.0.1:8000/',
            reject_requestsData: [],
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
                url: self.url + "rejectedrequest?lang=ar",
                method: 'Get'

            }).done(function (result) {
                self.reject_requestsData = result;

                console.log(self.reject_requestsData);
            });
        }
    })
;