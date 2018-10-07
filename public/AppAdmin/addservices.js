ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var addservices = new Vue({
        el: '#addservices',
        data: {
            baseurl: 'http://admin.shl-app.com/',
            ServicesForm: {
                'services_name_ar': '',
                'services_name_en': '',
                'services_name_ur': '',
                'icone': '',
                'sub_services': [{
                    'sub_services_name_ar': '',
                    'sub_services_name_en': '',
                    'sub_services_name_ur': '',
                    'icone': ''
                }
                ],

                'type': 1,
                'services_work_preiod': [
                    {
                        'saturday': '',
                        'sunday': '',
                        'monday': '',
                        'tuesday': '',
                        'wednesday': '',
                        'thursday': '',
                        'friday': '',
                        'from_hr': '',
                        'to_hr': ''
                    }
                ],
                'price_type': '',
                'price_type_visiable': '',
                'commission_precent': '',
                'commission_cash': '',
                'credit_limit_finsih_order': '',
                'serach_provider_limit': '',
                'minimum_time_rate_boxwrite': '',
                'maxmum_schedule_order': '',
                'services_type': '',
                'serivces_payment_type_id': '',
                'request_time_duration': '',
                'offer_count': '',
                'offer_time': ''

            }
        },
        methods: {
            AddMordeSubServices: function () {
                var self = this;
                self.ServicesForm.sub_services.push({
                    'sub_services_name_ar': '',
                    'sub_services_name_en': '',
                    'sub_services_name_ur': '',
                    'icone': ''
                })
            },
            AddSechdule: function () {
                var self = this;
                self.ServicesForm.services_work_preiod.push({

                    'saturday': '',
                    'sunday': '',
                    'monday': '',
                    'tuesday': '',
                    'wednesday': '',
                    'thursday': '',
                    'friday': '',
                    'from_hr': '',
                    'to_hr': ''
                })

            },
            ConvertServicesIamge: function () {
                var self = this;
                var input = document.getElementById('services_icone');
                var file = input.files[0];
                console.log(file);

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    self.ServicesForm.icone = reader.result;
                    document.getElementById('services_icone').src = reader.result;

                };
                reader.onerror = function (error) {
                    console.log('Error: ', error);
                };

            },
            ConvertIamge: function (index) {
                var self = this;
                var input = document.getElementById(index);
                var file = input.files[0];
                console.log(file);
                console.log(index);
                sub_services_img = '';
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    console.log(reader.result);
                    self.ServicesForm.sub_services[index].icone = reader.result;
                    document.getElementById(index + 'img').src = reader.result;

                };
                reader.onerror = function (error) {
                    console.log('Error: ', error);
                };

            },
            RemoveSubSerives: function (index, sub_services, SubServices) {
                console.log(SubServices);
                console.log(index);

                SubServices.splice(index, 1);
            },

            Save: function () {
                var self = this;
                 console.log(self.ServicesForm);

                axios.post(self.baseurl + '/sotreservices', self.ServicesForm)
                    .then(function (response) {
                        console.log(response);
                        self.$notify({
                            title: 'تم بنجاح',
                            message: 'تم اضافه خدمة جديدة بنجاح..جارى تحويلك للصفحه الرئيسية',
                            type: 'success'
                        });
                        setTimeout(function(){
                            window.location.href = '/services';

                        }, 3000);

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

        }
    })
;