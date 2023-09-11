@extends('utama')
@section('isi')
    <style>
        #map {
            height: 500px;
        }
    </style>
    <button id="geo">Test</button>
    <div id="map"></div>
@endsection
@section('javascript')
    <script>
        $("#geo").click(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
                    enableHighAccuracy: true,

                });
            } else {
                console.log('Geolocation is not supported by this browser.');
            }

            function successCallback(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                console.log(latitude, longitude);
                var container = L.DomUtil.get('map');
                if (container != null) {
                    container._leaflet_id = null;
                }
                var map = L.map('map').setView([latitude, longitude], 13);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
                var marker = L.marker([latitude, longitude]).addTo(map);

                // $.get(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`,
                //     function(data) {
                //         console.log("DATA");
                //         console.log(data.address);
                //     }
                // );
                // Use the latitude and longitude to perform further operations
            }

            function errorCallback(error) {
                console.log('Error occurred while getting the device location:', error);
            }
        });
    </script>
@endsection
