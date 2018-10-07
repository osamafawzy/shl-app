ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var providers = new Vue({
        el: '#provider_profile',
        data: {
            url: 'http://127.0.0.1:8000/',
            providerProfile: [],
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
                url: self.url + 'providerData/' + id,
                method: 'Get'

            }).done(function (result) {
                self.providerProfile = result;

                console.log(self.providerProfile);
            });
        }
    })
;