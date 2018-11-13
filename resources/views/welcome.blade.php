<?php
$before = \App\UserDetail::all();
$after = \App\UserDetail::all();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Full Screen Leaflet Map</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7/leaflet.css"/>

    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.0/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.0/dist/MarkerCluster.Default.css" />

    <style>
        body {
            padding: 0;
            margin: 0;
        }
        html, body, #map {
            height: 100%;
            width: 100%;
        }
    </style>
</head>
<body>
<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.0/dist/leaflet.markercluster-src.js"></script>

<script>

    var greenIcon = new L.Icon({
        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    var violetIcon = new L.Icon({
        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });


    var before = {!! json_encode($before) !!};
    var after = {!! json_encode($after) !!};
    console.log(before);
    console.log(after);
    /*var map = L.map('map').setView([27.700769, 85.300140], 8);
    mapLink =
        '<a href="http://openstreetmap.org">OpenStreetMap</a>';
    L.tileLayer(
        'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; ' + mapLink + ' Contributors',
            maxZoom: 18,
        }).addTo(map);*/



    var cities = L.layerGroup();

  /*  L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.').addTo(cities),
        L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.').addTo(cities),
        L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.').addTo(cities),
        L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.').addTo(cities);
*/

    var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        mbUrl = 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

    var grayscale   = L.tileLayer(mbUrl, {id: 'mapbox.light', attribution: mbAttr}),
        streets  = L.tileLayer(mbUrl, {id: 'mapbox.streets',   attribution: mbAttr});

    var map = L.map('map', {
        center: [27.700769, 85.300140],
        zoom: 8,
        layers: [streets, cities]
    });

    var baseLayers = {
        "Grayscale": grayscale,
        "Streets": streets
    };

    var overlays = {
        "Cities": cities
    };

    L.control.layers(baseLayers, overlays).addTo(map);






    var markers = L.markerClusterGroup({ chunkedLoading: true });

    var markerList = [];

    //Loop through the markers array
    for (var i=0; i<before.length; i++) {

        var lon = before[i]['long'];
        var lat = before[i]['lat'];

        var popupText = 'Device ID:' + before[i]['email']+"<br>"+'Library Code:';

        /* var markerLocation = new L.LatLng(lat, lon);
         var marker = new L.Marker(markerLocation,{icon: greenIcon});*/

        var marker = L.marker(L.latLng(lat, lon), { title: popupText,icon: greenIcon });
        marker.bindPopup(popupText);
        markerList.push(marker);

    }


    for (var i=0; i<after.length; i++) {

        var lon = after[i]['long'];
        var lat = after[i]['lat'];

        var popupText = 'Device ID:' + after[i]['email']+"<br>"+'Library Code:';

        /* var markerLocation = new L.LatLng(lat, lon);
         var marker = new L.Marker(markerLocation,{icon: greenIcon});*/

        var marker = L.marker(L.latLng(lat, lon), { title: popupText,icon: violetIcon });
        marker.bindPopup(popupText);
        markerList.push(marker);

    }


    markers.addLayers(markerList);
    map.addLayer(markers);




</script>
</body>
</html>