ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var addzone = new Vue({
        el: '#zones',
        data: {
            baseurl: 'http://127.0.0.1:8000/',
            zonesForm: {
                'city_ar': '',
                'city_en': '',
                'city_ur': '',
                'zone_ar':'',
                'zone_en':'',
                'zone_ur':''
            }
        },
        methods: {
            Save: function () {
                var self = this;
                self.zonesForm.city_en=document.getElementById("city_en").value;
                self.zonesForm.zone_en=document.getElementById("district_en").value;
                console.log(self.zonesForm);

                axios.post(self.baseurl + '/storezone', self.zonesForm)
                    .then(function (response) {
                        console.log(response);
                        self.zonesForm=[];
                        document.getElementById("city_en").value="";
                        document.getElementById("district_en").value="";
                        self.$notify({
                            title: 'تم بنجاح',
                            message: 'تم اضافه مدينه و حي جديد بنجاح ',
                            type: 'success'
                        });
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

        }
    })
;