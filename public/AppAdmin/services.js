ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var services = new Vue({
        el: '#services',
        data: {
            url: 'http://admin.shl-app.com/',
            servicesData: [],
            gridData: '',
            dialogFormVisible: false,
            centerDialogVisible: false,
            formLabelWidth: '120px',
            dialogTableVisible: false,
            form: {
                grade: ''
            }
            ,
            customFilters: [{
                vals: '',
                props: ['services_name_ar', 'services_name_en', 'services_name_ur']
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
        mounted: function () {
            var self = this;
            $.ajax({
                url: self.url + "allservices?lang=ar",
                method: 'Get'

            }).done(function (result) {

                self.servicesData = result;

                console.log(self.servicesData);
            });
        }
        ,
        methods: {
            subSerivcesDisplay: function (index, row) {

                var self = this;
                self.gridData = [];

                self.gridData = row.sup_serivces_data;
                console.log(self.gridData);
            },
            GotoAddNewServices: function () {

                document.location.href = 'addservices'
            }
            ,
            handleEdit: function ($index, row) {

                document.location.href = 'updateservice/' + row.services_id
            }
            ,
            handleStop: function ($index, raw) {
                var self = this;
                self.centerDialogVisible = true;
                console.log(self.centerDialogVisible);

            }

        }
    })
;