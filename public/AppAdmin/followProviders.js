ELEMENT.locale(ELEMENT.lang.en);
Vue.use(DataTables);
Vue.use(DataTables.DataTablesServer);
// $.getScript("../js/app.js");

var clients = new Vue({
        el: '#servicesReports',
        data: {
            url: 'http://127.0.0.1:8000/',
            form : {                
                services_id :[] ,   
                sub_services_id:[]
            },
            services : [] ,
            secondaries:[],  
            AllIsActive:true,
            mapData:[],
            map:'',
            markerNow:[],
            markerColors:['http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
            'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
            'http://maps.google.com/mapfiles/ms/icons/purple-dot.png',
            'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
            'http://maps.google.com/mapfiles/ms/icons/green-dot.png'],

            
            AllIsSecondary:true , 
            secondaryIsHere : false , 
        },
    created:function () {
        var self = this;
    },mounted: function () {
        var self = this;
        self.getServices();
},
        methods : {
            
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
            },
            AllSecondary:function(){
                this.AllIsSecondary = !this.AllIsSecondary;
            },
            sendForm:function(){
                var self = this;
                axios.post(self.url+'sendFollowProviderReport', self.form)
                    .then(function(response){
                        console.log(response.data);
                        self.mapData = response.data;
                        if(self.mapData.length == 0){
                            swal("للأسف !!", "لا يوجد مزودي خدمة متاحين الآن", "error");
                            return ;

                        }
                    })
                    .catch(function (error) {
                        console.log(error);

                    });


                // for delay to execute axios at first
                var delayInMilliseconds = 1000; //1 second

                setTimeout(function() {
                    if(self.mapData.length == 0){
                        return ;
                    }
                    self.initMap();
                    self.markers(self.mapData);
                }, delayInMilliseconds);

                // to execute axios every specific time and remove old markers
                setInterval(function(){
                    axios.post(self.url+'sendFollowProviderReport', self.form)
                        .then(function(response){
                            console.log(response.data);
                            self.mapData = response.data;
                            self.removeMarkers(self.markerNow);
                            self.markers(self.mapData);
                        })
                        .catch(function (error) {
                            console.log(error);

                        });
                }, 3000);


            },
            initMap:function () {
                    var  infoWindow;
                    self.map = new google.maps.Map(document.getElementById('map_canvas'), {
                    center: {lat: 21.586135, lng: 39.162990},
                        mapTypeId: 'roadmap',
                    zoom: 13
                });
                infoWindow = new google.maps.InfoWindow;
                var geocoder = new google.maps.Geocoder;
            },
            markers:function (data) {
                var self = this;
                var marker;
                self.markerNow=[];
                var filteredArray
                var arr=[];


                // to get unique numbers of services id to make each service hsa specific color
                for (var i in data){

                    arr.push(data[i].services_id)
                }
                filteredArray = arr.filter(function(item, pos){
                    return arr.indexOf(item)== pos;
                });
                console.log(filteredArray);



                for (var i in data) {
                    var myLatLng = {lat: data[i].lat, lng: data[i].long};

                    if (data[i].services_id && data[i].sub_services_id){
                        for (var s in filteredArray){
                            if(filteredArray[s]==data[i].services_id){
                                // each providor has same service id,it`s marker will be the same color
                                var image = {
                                    url: self.markerColors[s],
                                    size: new google.maps.Size(71, 71),
                                    origin: new google.maps.Point(0, 0),
                                    anchor: new google.maps.Point(17, 34),
                                    scaledSize: new google.maps.Size(50, 50)

                                };
                                marker = new google.maps.Marker({
                                    position: myLatLng,
                                    map: map,
                                    icon:image,
                                    title: data[i].user_name+"\n"+data[i].services_name_ar,

                                });
                            }

                        }

                    }else{
                        var image = {
                            url: 'https://cdn.iconscout.com/public/images/icon/premium/png-256/van-car-minivan-transportation-bus-transport-truck-delivery-shipping-347794b4f27f8e3a-256x256.png',
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(50, 50)

                        };
                        marker = new google.maps.Marker({
                            position: myLatLng,
                            map: map,
                            title: data[i].user_name,
                            icon:image,

                        });
                    }


                    self.markerNow.push(marker);
                }
                console.log(self.markerNow);
            },
            removeMarkers:function (m){
                for( var i in m){
                    m[i].setMap(null);
                }
            }


        }
       
    })