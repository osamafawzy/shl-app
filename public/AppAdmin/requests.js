ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var clients = new Vue({
        el: '#requests',
        data: {
            url: 'http://127.0.0.1:8000/',
            requestsData: [],
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
                url: self.url + "allrequests?lang=ar",
                method: 'Get'

            }).done(function (result) {
                // var i;
                // for (i = 0; i < result.length; i++) {
                //     result[i]['created_at'].for
                // }

                self.requestsData = result;

                console.log(self.requestsData);
                // console.log(self.clientsData[]['created_at']);
            });
        },
        methods: {
            handleAccept: function ($index, row) {

                document.location.href = 'acceptrequest/' + row.user_id
            },
            handleReject: function ($index, row) {

                document.location.href = 'rejectrequest/' + row.user_id
            },
            Rejected: function () {

                document.location.href = 'rejectedrequests'
            }
        }
    })
;