ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var updatedServices = new Vue({
        el: '#updatedServices',
        data: {

            baseurl: 'http://admin.shl-app.com/',
            SaveToServer: false,
            ServicesForm: [],
            ServicesForm:
                {
                    'services_name_ar':
                        '',
                    'services_name_en':
                        '',
                    'services_name_ur':
                        '',
                    'icone':
                        '',
                    'sub_services':
                        [{
                            'sub_services_name_ar': '',
                            'sub_services_name_en': '',
                            'sub_services_name_ur': '',
                            'icone': ''
                        }
                        ],

                    'type':
                        1,
                    'services_work_preiod':
                        [
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
                    'price_type':
                        '',
                    'price_type_visiable':
                        '',
                    'commission_precent':
                        '',
                    'commission_cash':
                        '',
                    'credit_limit_finsih_order':
                        '',
                    'serach_provider_limit':
                        '',
                    'minimum_time_rate_boxwrite':
                        '',
                    'maxmum_schedule_order':
                        '',
                    'services_type':
                        '',
                    'serivces_payment_type_id':
                        '',
                    'request_time_duration':
                        '',
                    'offer_count':
                        '',
                    'offer_time':
                        ''

                }
        },
        mounted: function () {
            var self = this;
            self.GetServices();
        }
        ,
        methods: {
            GetServices: function () {
                var self = this;
                var url = window.location.pathname;
                var id = url.substring(url.lastIndexOf('/') + 1);
                axios.get(self.baseurl + 'getservicestoupdated/' + id + '?lang=ar')
                    .then(function (response) {
                        self.ServicesForm = response.data['0'];
                        self.ServicesForm.price_type = String(self.ServicesForm.price_type);
                        self.ServicesForm.price_type_visiable = Boolean(self.ServicesForm.price_type_visiable);
                        self.ServicesForm.provider_credit_limit_type = String(self.ServicesForm.provider_credit_limit_type);
                        self.ServicesForm.service_type[0].services_type = String(self.ServicesForm.service_type[0].services_type);
                        self.ServicesForm.service_type[0].serivces_payment_type_id = String(self.ServicesForm.service_type[0].serivces_payment_type_id);
                        self.ServicesForm.services_commission[0].commission_type = String(self.ServicesForm.services_commission[0].commission_type);
                        self.ServicesForm.services_commission[0].commission_type = String(self.ServicesForm.services_commission[0].commission_type);
                        for (var i = 0; i < self.ServicesForm.services_work_preiod.length; i++) {
                            self.ServicesForm.services_work_preiod[i].saturday = Boolean(self.ServicesForm.services_work_preiod[i].saturday);
                            self.ServicesForm.services_work_preiod[i].sunday = Boolean(self.ServicesForm.services_work_preiod[i].sunday);
                            self.ServicesForm.services_work_preiod[i].monday = Boolean(self.ServicesForm.services_work_preiod[i].monday);
                            self.ServicesForm.services_work_preiod[i].tuesday = Boolean(self.ServicesForm.services_work_preiod[i].tuesday);
                            self.ServicesForm.services_work_preiod[i].wednesday = Boolean(self.ServicesForm.services_work_preiod[i].wednesday);
                            self.ServicesForm.services_work_preiod[i].thursday = Boolean(self.ServicesForm.services_work_preiod[i].thursday);
                            self.ServicesForm.services_work_preiod[i].friday = Boolean(self.ServicesForm.services_work_preiod[i].friday);
                            self.ServicesForm.services_work_preiod[i].type = String(self.ServicesForm.services_work_preiod[i].type);
                        }


                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
            ,
            AddMordeSubServices: function () {
                var self = this;
                self.ServicesForm.sub_services.push({
                    'sub_services_name_ar': '',
                    'sub_services_name_en': '',
                    'sub_services_name_ur': '',
                    'icone': ''
                })
            }
            ,
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

            }
            ,
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

            }
            ,
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

            }
            ,
            RemoveSubSerives: function (index, sub_services, SubServices) {
                console.log(SubServices);
                console.log(index);

                SubServices.splice(index, 1);
            },


            Save: function () {
                var self = this;
                console.log(self.ServicesForm);

                /* handle new sub services Add Services Id */

                axios.put(self.baseurl + '/updated_services/' + self.ServicesForm.services_id, self.ServicesForm)
                    .then(function (response) {
                        console.log(response);
                        self.$notify({
                            title: 'تم بنجاح',
                            message: 'تم التعديل بنجاح..جارى تحويلك للصفحة الرئيسية',
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