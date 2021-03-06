ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);
var clients = new Vue({
        el: '#providersReports',
        data: {
            url: 'http://127.0.0.1:8000/',
            form : {
                from_date: '',
                to_date: '',
                services_id: [],
                state: '',
                sub_services_id: []
            },
            services : [] ,
            secondaries:[],  
            states: [{
                value: '1',
                label: 'متاح و حر'
              }, {
                value: '2',
                label: 'متاح'
              }, {
                value: '3',
                label: 'غير متاح'
              }],
              AllIsActive:true,
              stateActive:true,
              AllIsSecondary:true ,
            EnableTable : false ,
              secondaryIsHere : false , 
              arrayForBasic : [] , 
              arrayForSub :[],
              arrayWithState:[] ,
              BringTable :'',
              TableInfo : {
                service_id :'',
                sub_service_id:''
            },
            DataTable:[] , 
            customFilters: [{
              vals: '',
              props: ['services_name_ar']
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
              },
            order_data:[],
            globalLabels:[]



        },

    mounted: function () {      
    this.getServices();

    },
    methods : {
        table:function(){
            var self = this ;
            if(self.form.services_id.length != 1 || self.form.services_id.includes('0') ){
                self.TableInfo.service_id = self.BringTable ;
                self.TableInfo.sub_service_id = null ;
                self.TableInfo.date_from=self.form.from_date;
                self.TableInfo.date_to=self.form.to_date;

            }else if((self.form.sub_services_id.length != 1|| self.form.sub_services_id.includes('0')  )){
                self.TableInfo.sub_service_id = self.BringTable ;
                self.TableInfo.service_id = self.form.services_id[0] ;
                self.TableInfo.date_from=self.form.from_date;
                self.TableInfo.date_to=self.form.to_date;

            }

            else {
                self.TableInfo.service_id = self.form.services_id[0] ;
                self.TableInfo.sub_service_id = self.form.sub_services_id[0] ;
                self.TableInfo.date_from=self.form.from_date;
                self.TableInfo.date_to=self.form.to_date;
            }
            console.log(self.TableInfo);
            axios.post('ProviderReport?lang=ar',self.TableInfo)
                .then(function(response){
                    self.DataTable = response.data ;
                    console.log(self.DataTable);
                    self.EnableTable = true ;
                }).catch(function (error) {
                console.log(error);
            });
        },
        getServices:function(){
            var self = this ; 
            axios.get('mainServices?lang=ar')
                .then(function(response){
                    self.services = response.data ; 
                    console.log(self.services); 
                }).catch(function (error) {
                    console.log(error);
                });
        },
        getSecondaries:function(){
            var self = this ;
                axios.get('subServices/'+self.form.services_id[0]+'?lang=ar')
                .then(function(response){
                    self.secondaries = response.data ;
                    console.log(self.secondaries);
                    self.secondaryIsHere = true ;
                }).catch(function (error) {
                    console.log(error);
                });

            
        },
        activeAll: function(){
            
            this.AllIsActive = !this.AllIsActive;
            console.log(this.form.services_id) ;

            
          // some code to filter users
        },
        state:function(){
            this.stateActive = !this.stateActive;
        },
        activeSecondary:function(){
            this.AllIsSecondary = !this.AllIsSecondary;
        },
        sendForm:function(){
            var self = this;
            $('#myChart').remove(); // this is my <canvas> element
            $('#graph-container').append('<canvas id="myChart"><canvas>');
            // console.log(this.form);
            // self.form.state == ''?self.EnableTable=true:self.EnableTable=false ;
            axios.post(self.url+'sendProviderReport', self.form)
                .then(function(response){
                    console.log(response.data);

                    if ((typeof response.data[0].state === 'undefined') &&(typeof response.data[0].sub_services_name_ar === 'undefined')) {
                        self.arrayForSub =[];
                        self.createChartWithoutState(response.data); // الرئيسية بالنسبة لحالة محددة
                        self.arrayForBasic = response.data ;
                    }else if((typeof response.data[0].state === 'undefined') &&(typeof response.data[0].sub_services_name_ar !== 'undefined')){
                        self.arrayForBasic = [] ;
                        self.createChartSubWithoutState(response.data); // الفرعية بالنسبة لحالة محددة
                        self.arrayForSub = response.data ;
                    }else {
                        self.arrayForBasic = [] ;
                        self.arrayForSub =[];
                        self.createChartWithState(response.data); // تم اختيار الرئيسي والفرعي ولم يختار حالة بالطبع
                        for (i = 0; i < response.data.length; i++) {
                            if (response.data[i].state=="1") {
                                response.data[i]['order_state_ar'] = 'متاح و حر' ;
                            } else if (response.data[i].state=="2") {
                                response.data[i]['order_state_ar'] = 'متاح' ;
                            }else if (response.data[i].state=="3") {
                                response.data[i]['.order_state_ar'] = 'غير متاح' ;
                            } else {

                            }
                        }
                        console.log(response.data);
                        self.table();
                    }
                })
                .catch(function (error) {
                console.log(error);
                swal("للأسف !!", "لا توجد تقارير مطابقة للبيانات التي ادخلتها", "error");

                });

            // return console.log(this.form);
        },

        createChartWithState(ordersData) {
            var self=this ;
            var ctx = document.getElementById("myChart").getContext('2d');
            var labels=[];
            var data=[];
            self.globalLabels = labels ;
            var sum_data=0;
            for (i = 0; i < ordersData.length; i++){
                sum_data+=ordersData[i].count;
            }
            for (i = 0; i < ordersData.length; i++) {
                if (ordersData[i].state=="1") {
                    labels.push("متاح و حر");
                } else if (ordersData[i].state=="2") {
                    labels.push("متاح");
                }else if (ordersData[i].state=="3") {
                    labels.push("غير متاح");
                }
                data.push(ordersData[i].count);
                self.order_data.push(Math.round((ordersData[i].count/sum_data)*100));
            }
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '#',
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132,.4)',
                            'rgba(54, 162, 235,.4)',
                            'rgba(50, 205, 50,.4)',
                            'rgb(201, 203, 207,.4)',
                            'rgb(255, 205, 86,.4)',
                            'rgb(153, 102, 255,.4)',],
                        borderColor: [
                            'rgba(255,99,132,.6)',
                            'rgba(54, 162, 235, .6)',
                            'rgba(50, 205, 50, .6)',
                            'rgb(201, 203, 207,.6)',
                            'rgb(255, 205, 86, .6)',
                            'rgb(153, 102, 255,.6)',
                        ],
                    }]
                },
                options: {

                }
            })
        },
        createChartWithoutState(ordersData) {
            var self=this ;
            var ctx = document.getElementById("myChart").getContext('2d');
            var labels=[];
            var data=[];
            self.globalLabels = labels ;
            var sum_data=0;
            for (i = 0; i < ordersData.length; i++){
                sum_data+=ordersData[i].count;
            }
            for (i = 0; i < ordersData.length; i++) {
                labels.push(ordersData[i].services_name_ar);
                data.push(ordersData[i].count);
                self.order_data.push(Math.round((ordersData[i].count/sum_data)*100));
            }
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '#',
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132,.4)',
                            'rgba(54, 162, 235,.4)',
                            'rgba(50, 205, 50,.4)',
                            'rgb(201, 203, 207,.4)',
                            'rgb(255, 205, 86,.4)'],
                        borderColor: [
                            'rgba(255,99,132,.6)',
                            'rgba(54, 162, 235, .6)',
                            'rgba(50, 205, 50, .6)',
                            'rgb(201, 203, 207,.6)',
                            'rgb(255, 205, 86, .6)'
                        ],
                    }]
                },
                options: {

                }
            })
        },
        createChartSubWithoutState(ordersData) {
            var self=this ;
            var ctx = document.getElementById("myChart").getContext('2d');
            var labels=[];
            var data =[];
            self.globalLabels = labels ;
            var sum_data=0;
            for (i = 0; i < ordersData.length; i++){
                sum_data+=ordersData[i].count;
            }
            for (i = 0; i < ordersData.length; i++) {
                labels.push(ordersData[i].sub_services_name_ar);
                data.push(ordersData[i].count);
                self.order_data.push(Math.round((ordersData[i].count/sum_data)*100));
            }
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '#',
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132,.4)',
                            'rgba(54, 162, 235,.4)',
                            'rgba(50, 205, 50,.4)',
                            'rgb(201, 203, 207,.4)',
                            'rgb(255, 205, 86,.4)'],
                        borderColor: [
                            'rgba(255,99,132,.6)',
                            'rgba(54, 162, 235, .6)',
                            'rgba(50, 205, 50, .6)',
                            'rgb(201, 203, 207,.6)',
                            'rgb(255, 205, 86, .6)'
                        ],
                    }]
                },
                options: {

                }
            })
        }
    }
       
    })