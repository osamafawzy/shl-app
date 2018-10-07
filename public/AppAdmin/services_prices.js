ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var services_prices = new Vue({
        el: '#Services_prices',
        data: {
            baseurl: 'http://admin.shl-app.com/',
            dialogTableVisible: false,
            active: 1,
            loading: true,
            loading2: false,
            servicesPriceData: [],
            gridData: '',
            City: [],
            fullscreen: true,
            Service_City: {
                services_id: '',
                sub_serivces_id: '',
                city_id: '',
                active: 1,
                notification: ''
            },
            services_city: [],
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
            self.GetData();
            self.GetCity();
        },
        methods: {
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
            GetData: function () {
                var self = this;
                axios.get(self.baseurl + 'allserviceswithcityandzones?lang=ar')
                    .then(function (response) {
                        console.log(response.data);
                        self.servicesPriceData = response.data;
                        self.loading = false
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            Services_zone: function (index, row) {
                var self = this;
                self.loading2 = true;
                window.location.href = 'services_zone/' + row.services_id

            },

            ServicesCityDisplay: function (index, row) {
                var self = this;
                self.gridData = [];
                console.log(row);
                console.log(row.services_id);
                axios.get(self.baseurl + 'getServicesCity/' + row.services_id + '?lang=ar')
                    .then(function (response) {
                        self.gridData = response.data;
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            }
            ,
            ChangeActivityServicesInCity: function (row) {
                console.log(row);
                var self = this;
                self.loading = true;
                axios.put(self.baseurl + 'changeactivaity/' + row.services_city_id, row)
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

            CreateNewServiceCity: function (gridData) {
                var self = this;
                console.log(gridData);
                self.Service_City.services_id = gridData[0].services_id;
                self.Service_City.sub_serivces_id = gridData[0].sub_serivces_id;
                console.log(self.Service_City);

                axios.post(self.baseurl + 'createservicescity?lang=ar', self.Service_City)
                    .then(function (response) {
                        console.log(response);
                        self.loading = false;
                        self.$notify({
                            title: '    ',
                            message: ' تم اضافه الخدمة الى المدينة بنجاح',
                            type: 'success'
                        });
                        self.gridData.push(response.data[0]);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });


            }
        }
    })
;