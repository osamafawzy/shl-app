ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);

var clients = new Vue({
        el: '#reports',
        data: {
            url: 'http://127.0.0.1:8000/',
            ordersData: [],
            centerDialogVisible: false,
            formLabelWidth: '120px',orm: {
                grade: ''
            },
            dataTable:[{
                'pending':'',
                'finish':'',
                'accepted':'',
                'cancel_from_client':'',
                'cancel_from_provider':''

            }],
            customFilters: [{
                vals: '',
                props: []
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
            // var self = this;
            // axios.get(self.url + 'reports/orders').then(function (response) {
            //     self.ordersData=response.data;
            //     self.dataTable[0]=response.data;
            //     console.log(self.dataTable);
            //     self.createChart(self.ordersData) ;
            // })
            var self = this;
            $.ajax({
                url: self.url + "reports/orders",
                method: 'Get'

            }).done(function (result) {
                self.ordersData = result;


                // show data in datatable
                self.dataTable[0]['pending']= result['pending'];
                self.dataTable[0]['finish']= result['finish'];
                self.dataTable[0]['accepted']= result['accepted'];
                self.dataTable[0]['cancel_from_client']= result['cancel_from_client'];
                self.dataTable[0]['cancel_from_provider']= result['cancel_from_provider'];
                console.log(self.dataTable);

                // display chart
                self.createChart(self.ordersData) ;
            });


        },
    created:function () {
        var self = this;
        Echo.channel('testChannel')
            .listen('OrderEvent', (e) => {
                console.log(e);
                self.ordersData=e['orders'];
                self.dataTable[0]['pending']= e['orders']['pending'];
                self.dataTable[0]['finish']= e['orders']['finish'];
                self.dataTable[0]['accepted']= e['orders']['accepted'];
                self.dataTable[0]['cancel_from_client']= e['orders']['cancel_from_client'];
                self.dataTable[0]['cancel_from_provider']= e['orders']['cancel_from_provider'];
                console.log(self.dataTable);


                // $.ajax({
                //     url: self.url + "reports/orders",
                //     method: 'Get'
                //
                // }).done(function (result) {
                //     self.ordersData = result;
                //
                //
                //     // show data in datatable
                //     self.dataTable[0]['pending']= result['pending'];
                //     self.dataTable[0]['finish']= result['finish'];
                //     self.dataTable[0]['accepted']= result['accepted'];
                //     self.dataTable[0]['cancel_from_client']= result['cancel_from_client'];
                //     self.dataTable[0]['cancel_from_provider']= result['cancel_from_provider'];
                //     console.log(self.dataTable);
                //     $('#myChart').remove(); // this is my <canvas> element
                //     $('#graph-container').append('<canvas id="myChart"><canvas>');
                //     self.createChart(self.ordersData) ;
                //     });

                    $('#myChart').remove(); // this is my <canvas> element
                    $('#graph-container').append('<canvas id="myChart"><canvas>');
                    self.createChart(self.ordersData) ;


            });
    },
        methods: {
            createChart(ordersData) {
                var ctx = document.getElementById("myChart").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ["قيد الانتظار ", "المقبوله", "المنتهيه","المرفوضه من جهه العميل","المرفوضه من جهه مزود الخدمه"],
                        datasets: [{
                            label: '#',
                            data: [ordersData.pending,ordersData.accepted,ordersData.finish,ordersData.cancel_from_client,ordersData.cancel_from_provider],
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
;