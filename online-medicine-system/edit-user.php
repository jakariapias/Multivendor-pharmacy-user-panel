<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Show User Location on Map</title>
 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v8.2.0/ol.css">
  <style>
    #map {
      width: 100%;
      height: 500px;
    }
    .button {
      margin-bottom: 10px;
    }
    .marker {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background-color: red;
      animation: markerAnimation 0.5s ease;
      transition: transform 0.5s ease;
    }
    @keyframes markerAnimation {
      0% {
        transform: scale(0);
        opacity: 0;
      }
      100% {
        transform: scale(1);
        opacity: 1;
      }
    }
  </style>
</head>
<body>
  <h1>Show User Location on Map</h1>
  
  <button class="button" onclick="getUserLocation()">Get Location</button>
  <div id="map"></div>

  <script src="https://cdn.jsdelivr.net/npm/ol@v8.2.0/dist/ol.js"></script>
  <script>
    var map, marker;

    function initMap() {
      map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          })
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([90.00000000,24.00000000]),
          zoom: 6
        })
      });

      addMarker();
    }

    function addMarker() {
      marker = new ol.Overlay({
        position: ol.proj.fromLonLat([90.00000000,24.00000000]),
        positioning: 'center-center',
        element: document.createElement('div'),
        stopEvent: false
      });

      marker.getElement().classList.add('marker');
      map.addOverlay(marker);

      var isDragging = false;
      var previousCoordinate;

      map.on('pointerdown', function (event) {
        
        var feature = map.forEachFeatureAtPixel(ol.proj.fromLonLat(event.pixel), function (feature) {
            console.log(feature,"Asdasdasdasd")
          return feature;
        });

        console.log(feature,marker,event)
        if (feature === marker) {
        console.log("sd")
          isDragging = true;
          previousCoordinate = event.coordinate;
        }
      });

      map.on('pointermove', function (event) {
        console.log("asdas",isDragging)
        if (isDragging) {
          var newCoordinate = map.getCoordinateFromPixel(event.pixel);
          var deltaX = newCoordinate[0] - previousCoordinate[0];
          var deltaY = newCoordinate[1] - previousCoordinate[1];
          var newPosition = [
            marker.getPosition()[0] + deltaX,
            marker.getPosition()[1] + deltaY
          ];
          console.log(newPosition)
          marker.setPosition(newPosition);
          previousCoordinate = newCoordinate;
        }
      });

      map.on('pointerup', function () {
        isDragging = false;
      });
    }

    function showUserLocation(latitude, longitude) {
      var userLocation = ol.proj.fromLonLat([longitude, latitude]);

      map.getView().animate({
        center: userLocation,
        zoom: 13,
        duration: 2000
      });

      marker.setPosition(userLocation);
    }

    function getUserLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var latitude = position.coords.latitude;
          var longitude = position.coords.longitude;

          showUserLocation(latitude, longitude);
        });
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }

    // Initialize map on page load
    document.addEventListener('DOMContentLoaded', function () {
      initMap();
    });
  </script>
</body>
</html>
