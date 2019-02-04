<?php
if (isset($_GET['lat']) && isset($_GET['long']))
{
    $lat = $_GET['lat'];
    $long = $_GET['long'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Reverse Geocoding</title>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #floating-panel {
            position: absolute;
            top: 10px;
            left: 25%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto','sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }
        #floating-panel {
            position: absolute;
            top: 5px;
            left: 50%;
            margin-left: -180px;
            width: 350px;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
        }
        #latlng {
            width: 225px;
        }
    </style>
</head>
<body>
<div id="floating-panel">
    <input id="latlng" type="text" value="<?php echo $lat; ?>,<?php echo $long ?>;">
    <input id="submit" type="button" value="Reverse Geocode">
</div>
<div id="map"></div>
<script>
    var llat = <?php echo $lat ?>;
    var llong = <?php echo $long ?>;

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            center: {lat: llat, lng: llong}
        });
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;

        // document.getElementById('submit').addEventListener('click', function() {
            geocodeLatLng(geocoder, map, infowindow);
        // });
    }

    function geocodeLatLng(geocoder, map, infowindow) {
        var input = document.getElementById('latlng').value;
        var latlngStr = input.split(',', 2);
        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
        geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    map.setZoom(11);
                    var marker = new google.maps.Marker({
                        position: latlng,
                        map: map
                    });
                    infowindow.setContent("this is the address:"+results[0].formatted_address);
                    infowindow.open(map, marker);
                    window.location = "save_address.php?address="+results[0].formatted_address;
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });

    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAV_2a1eSO7BYsYhAUy3x6_iisvUBBi0M&callback=initMap">
</script>
</body>
</html>