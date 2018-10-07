$(document).ready(function () {
    $("#myTab li:eq(1) a").tab('show');
});

var ServicesTermsConditions = new Vue({
    el: '#ServicesTermsConditions',
    data: {
        ServicesTersmsCondition: [],
        ServicesTersmsCondition: {
            terms_ar: '',
            terms_en: '',
            terms_ur: ''
        },
        baseurl: 'http://admin.shl-app.com/',
        loading: false

    },
    mounted: function () {
        var self = this;
        self.GetSTerms();
    },
    methods: {
        GetSTerms: function () {
            var self = this;
            self.loading = true;
            axios.get(self.baseurl + 'servicesterms?lang=ar')
                .then(function (response) {
                    console.log(response.data[0]);
                    self.ServicesTersmsCondition = response.data[0];
                    self.loading = false
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        updateTersms: function () {
            var self = this;
            self.loading = true;
            axios.put(self.baseurl + 'updated_services_terms/' + 1, self.ServicesTersmsCondition)
                .then(function (response) {
                    console.log(response.data);
                    self.loading = false;
                    self.$notify({
                        title: '    ',
                        message: 'تم التعديل بنجاح   ',
                        type: 'success'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

    }
});