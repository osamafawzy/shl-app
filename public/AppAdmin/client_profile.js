ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var clients = new Vue({
        el: '#client_profile',
        data: {
            url: 'http://127.0.0.1:8000/',
            clientProfile: [],
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

                }

        },
        mounted: function ($index, row) {
            var self = this;
            var url = window.location.pathname;
            var id = url.substring(url.lastIndexOf('/') + 1);
            console.log(id);
            $.ajax({
                url: self.url + 'clientData/' + id,
                method: 'Get'

            }).done(function (result) {
                self.clientProfile = result;

                console.log(self.clientProfile);
            });
        }
    })
;