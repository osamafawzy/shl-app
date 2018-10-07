@extends('admintempate.admintempate')

@section('page-style-level')
    <style>
        .dir {
            direction: rtl;
        }
    </style>
@endsection

@section('content')
    <div id="zones">
        <div class="row">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    اضافة حي  جديد
                </div>
                <div class="sp-50"></div>
                <div class="panel-body">
                    <div id="map_canvas" style="width: 800px; height: 400px; margin-right: 120px"></div>
                    <div class="sp-50"></div>
                    <form :model="zonesForm">
                        <div class="row">
                            <div class="col-md-2"><label for="city"> اسم المدينه :</label>
                            </div>
                            <div class="col-md-2">
                                <input placeholder="اسم المدينه بالعربيه" v-model="zonesForm.city_ar"
                                       class="form-control"/>
                            </div>
                            <div class="col-md-2">
                                <input placeholder="اسم المدينه بالانجليزية"
                                       class="form-control" id="city_en"
                                >
                            </div>
                            <div class="col-md-2">
                                <input placeholder="اسم المدينه بالاورديه" v-model="zonesForm.city_ur"
                                       class="form-control"
                                >
                            </div>
                        </div>
                        <br>
                        <div class="row">

                            <div class="sp-10"></div>
                            <div class="col-md-2">
                                <label for="district"> اسم الحي : </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" placeholder="اسم الحي بالعربيه"
                                       v-model="zonesForm.zone_ar" class="form-control"/>
                            </div>
                            <div class="col-md-2">
                                <input type="text" placeholder="اسم الحي بالانجليزية" id="district_en"
                                        class="form-control"/>
                            </div>
                            <div class="col-md-2">
                                <input type="text" placeholder="اسم الحي بالاورديه"
                                       v-model="zonesForm.zone_ur" class="form-control"/>
                            </div>
                            <div class="sp-10"></div>

                            <div class="row">
                                <div class="col-md-6 col-md-push-5">
                                    <button type="button" class="btn btn-success col-md-4" @click="Save()">حفظ</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>



    </div>





@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/addzones.js')}}"></script>

    <script>
        // Note: This example requires that you consent to location sharing when
        // prompted by your browser. If you see the error "The Geolocation service
        // failed.", it means you probably did not give permission for the browser to
        // locate you.
        var map, infoWindow;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map_canvas'), {
                center: {lat: 24.713552, lng: 46.675296},
                zoom: 6
            });
            infoWindow = new google.maps.InfoWindow;
            var geocoder = new google.maps.Geocoder;

            addNewMarker(map);

            // Try HTML5 geolocation.
            // if (navigator.geolocation) {
            //     navigator.geolocation.getCurrentPosition(function(position) {
            //         var pos = {
            //             lat: position.coords.latitude,
            //             lng: position.coords.longitude
            //         };
            //         console.log(pos);
            //
            //         infoWindow.setPosition(pos);
            //         // var marker = new google.maps.Marker({position: pos, map: map});
            //         infoWindow.setContent("<br>"+"Here You Are now");
            //         infoWindow.open(map);
            //         map.setCenter(pos);
            //         geocodeLatLng(geocoder,map,infoWindow,pos);
            //     }, function() {
            //         handleLocationError(true, infoWindow, map.getCenter());
            //     });
            // } else {
            //     // Browser doesn't support Geolocation
            //     handleLocationError(false, infoWindow, map.getCenter());
            // }
        }

        // function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        //     infoWindow.setPosition(pos);
        //     infoWindow.setContent(browserHasGeolocation ?
        //         'Error: The Geolocation service failed.' :
        //         'Error: Your browser doesn\'t support geolocation.');
        //     infoWindow.open(map);
        // }

        function geocodeLatLng(geocoder, map, infowindow,pos) {
            var city;
            var district;
            geocoder.geocode({'location': pos}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        map.setZoom(11);
                        var marker = new google.maps.Marker({
                            position: pos,
                            map: map
                        });
                        infowindow.setContent(results[0].formatted_address);
                        var length=results[0]['address_components'].length;
                        console.log(results[0]['address_components']);
                        var i;
                        for (i = 0; i < length; i++) {
                            if (results[0]['address_components'][i]['types'][0]==="locality"){
                                console.log(results[0]['address_components'][i]['long_name']);
                                district = results[0]['address_components'][i]['long_name'];
                                // console.log(results[0]['address_components'][i]['long_name']);
                                // district = document.getElementById('district_en').value = results[0]['address_components'][i]['long_name'] ;
                            }
                            if (results[0]['address_components'][i]['types'][0]==="administrative_area_level_1"){
                                console.log(results[0]['address_components'][i]['long_name']);
                                city = results[0]['address_components'][i]['long_name'];
                                 // city = document.getElementById('city_en').value = results[0]['address_components'][i]['long_name'] ;

                                // console.log(results[0]['address_components'][i]['long_name']);
                            }
                        }
                        infowindow.open(map, marker);
                        document.getElementById('district_en').value = district;
                        document.getElementById('city_en').value = city;



                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }

        function addNewMarker(map) {
            google.maps.event.addListener(map, 'click', function(event) {
                marker = new google.maps.Marker({
                    position: event.latLng,
                    map: map
                });


                console.log( 'Lat: ' + event.latLng.lat() + ' and Longitude is: ' + event.latLng.lng() );
                var geocoder = new google.maps.Geocoder;

                geocodeLatLng(geocoder,map,infoWindow,event.latLng);

            });

        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAs6hORAOGKAy9z0fXfad3cQvXbaJ1_wp4&callback=initMap">
    </script>
@endsection