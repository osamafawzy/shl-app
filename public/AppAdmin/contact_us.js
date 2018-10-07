ELEMENT.locale(ELEMENT.lang.ar);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var ContactUs = new Vue({
        el: '#contact_us',
        data: {
            loading: true,
            baseurl: 'http://admin.shl-app.com/',
            dialogTableVisible: false,
            dialogFormVisible: false,
            formLabelWidth: '',
            fullscreen: false,
            ContactUsData: [],
            rules: {
                phone: [{required: true, message: 'ادخل الهاتف'}],
                address_ar: [{required: true, message: 'ادخل العنوان بالعربية'}],
                address_en: [{required: true, message: 'ادخل العنوان بالانجليزية'}],
                adress_ur: [{required: true, message: 'ادخل العنوان بالاوردية'}],
                email: [{required: true, message: 'ادخل البريد الالكترونى'}]

            }
            ,
            ContactUsForm: {
                phone: '',
                address_ar:
                    '',
                address_en:
                    '',
                adress_ur:
                    '',
                email:
                    ''
            }
            ,
            customFilters: [{
                vals: '',
                props: ['phone', 'address_ar', 'address_en', 'adress_ur', 'email']
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
            self.GetContact();
        }
        ,
        methods: {
            GetContact: function () {
                var self = this;
                self.loading = true;
                axios.get(self.baseurl + 'contactus?lang=ar')
                    .then(function (response) {
                        console.log(response.data);
                        self.ContactUsData = response.data;
                        self.loading = false
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            resetForm: function (formName) {
                this.$refs[formName].resetFields();
            },
            AddCountact: function (formName) {
                console.log(formName);
                var self = this;
                self.$refs[formName].validate(function (valid) {
                    if (valid) {
                        console.log(self.ContactUsForm);
                        if (self.ContactUsForm.contact_id === undefined) {
                            self.InsertToServer(self.ContactUsForm)

                        } else {
                            self.UpdateToserver(self.ContactUsForm);
                        }

                    } else {
                        console.log('error submit!!');
                    }
                })
            },
            InsertToServer: function (ContactUsForm) {
                var self = this;
                console.log(ContactUsForm);
                axios.post(self.baseurl + 'createcontact?lang=ar', ContactUsForm)
                    .then(function (response) {
                        console.log(response.data);
                        ContactUs.ContactUsData.push(response.data);
                        self.loading = false;
                        self.$notify({
                            title: '    ',
                            message: 'تم الاضافه بنجاح',
                            type: 'success'
                        });
                        self.dialogFormVisible = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            UpdateToserver: function (ContactUsForm) {

                var self = this;
                console.log(ContactUsForm);
                axios.post(self.baseurl + 'updatecontact/' + ContactUsForm.contact_id + '?lang=ar', ContactUsForm)
                    .then(function (response) {
                        console.log(response.data);
                        self.loading = false;
                        self.$notify({
                            title: '    ',
                            message: 'تم التعديل بنجاح',
                            type: 'success'
                        });
                        self.dialogFormVisible = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            GotoAddNewServices: function (index, row, state, isEditMode) {
                var self = this;
                console.log(isEditMode);
                if (isEditMode === true) {
                    self.ContactUsForm = row;
                    console.log(self.ContactUsForm);
                } else {
                    self.ContactUsForm = {};
                    console.log(self.ContactUsForm);

                }
            },

            DeleteFromContactUs: function (index, row) {
                var self = this;
                console.log(row);

                self.$confirm('هل تريد الحذف', 'تحذير', {
                    confirmButtonText: 'نعم',
                    cancelButtonText: 'لا',
                    // type: 'warning'
                }).then(function () {
                    self.DeleteFormServer(row, index)
                }).catch(function () {
                    self.$notify({
                        title: '    ',
                        message: 'تم الالغاء',
                        type: 'warning'
                    });
                });

            },
            DeleteFormServer: function (row, index) {
                var self = this;
                axios.delete(self.baseurl + 'deleteContact/' + row.contact_id)
                    .then(function (response) {
                        console.log(response.data);
                        self.loading = false;
                        self.$notify({
                            title: '    ',
                            message: 'تم الحذف بنجاح بنجاح',
                            type: 'success'
                        });
                        ContactUs.ContactUsData.splice(index, 1);
                        self.dialogFormVisible = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }


    })
;