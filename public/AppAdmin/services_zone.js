ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var Services_Zone = new Vue({
        el: '#Services_Zone',
        data: {
            baseurl: 'http://admin.shl-app.com/',
            dialogTableVisible: false,
            active: 1,
            loading: true,
            loading2: false,
            fullscreen: true,
            City: [],
            Zone: [],
            servicesZoneData: [],
            ServicesZone: {
                sub_services_id: '',
                city_id: '',
                zone_id: '',
                price: '',
                active: 1,
                notifications: ''
            },
            gridData: '',
            change_price: 2,
            customFilters: [{
                vals: '',
                props: ['sub_services_name_ar']
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
            self.GetData();
            self.GetCity();
        },
        methods: {

            GetData: function () {
                var self = this;
                var url = window.location.pathname;
                 id = url.substring(url.lastIndexOf('/') + 1);
                axios.get(self.baseurl + 'serviceszone/' + id + '?lang=ar')
                    .then(function (response) {
                        console.log(response.data);
                        self.servicesZoneData = response.data[0].sub_services;
                        self.loading = false
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            GetCity: function () {
                var self = this;
                self.loading = true;
                axios.get(self.baseurl + 'api/cities?lang=ar')
                    .then(function (response) {
                        console.log(response.data.City);
                        self.City = response.data.City;
                        self.loading = false
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getZone: function (city_id) {
                console.log(city_id);
                var self = this;
                self.loading = true;
                axios.get(self.baseurl + 'api/zones/' + city_id + '?lang=ar')
                    .then(function (response) {
                        console.log(response.data.Zones);
                        self.Zone = response.data.Zones;
                        self.loading = false
                    })
                    .catch(function (error) {
                        console.log(error);
                    });


            },
            ServicesZoneDisplay: function (index, row) {
                var self = this;
                self.gridData = [];
                self.loading = true;
                console.log(row);
                axios.get(self.baseurl + 'getServicesZone/' + row.sub_services_id + '?lang=ar')
                    .then(function (response) {
                        self.loading = false
                        self.gridData = response.data;
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            }
            ,
            ChangeActivityServicesInZone: function (services_zone) {
                console.log(services_zone);
                var self = this;
                self.loading = true;
                axios.put(self.baseurl + 'changeservicezoneprice/' + services_zone.services_zone_id, services_zone)
                    .then(function (response) {
                        console.log(response);
                        self.loading = false;
                        if (response.data.active === 1) {
                            self.$notify({
                                title: '    ',
                                message: 'تم تفعيل الخدمة  ',
                                type: 'success'
                            });

                        } else {

                            self.$notify.error({
                                title: '    ',
                                message: 'تم ايقاف الخدمة  '
                            });

                        }

                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },
            changeprice: function (services_zone) {
                var self = this;
                self.loading = true;
                console.log(services_zone);
                axios.put(self.baseurl + 'changeservicezoneprice/' + services_zone.services_zone_id, services_zone)
                    .then(function (response) {
                        console.log(response);
                        self.loading = false;

                        self.$notify({
                            title: '    ',
                            message: 'تم تعديل السعر بنجاح',
                            type: 'success'
                        });


                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            CreateNewServiceZone: function () {
                var self = this;
                console.log(self.ServicesZone);
                self.ServicesZone.sub_services_id = id;

                axios.post(self.baseurl + 'createserviceszone?lang=ar', self.ServicesZone)
                    .then(function (response) {
                        console.log(response);
                        self.loading = false;


                        self.$notify({
                            title: '    ',
                            message: '   تم اضافه الخدمة للحى بنجاح',
                            type: 'success'
                        });

                        self.gridData.push(response.data[0])
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
    })
;