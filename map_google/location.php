<<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>

<div id="map">

</div>

<script>
    function initMap() {
        var location = {lat: -25.363, lng: 131.044};
        var map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            center: location
        });
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
    }
    AIzaSyDXuCXodX9qEsiYPdtohwMduZGnL_vMxcU
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXuCXodX9qEsiYPdtohwMduZGnL_vMxcU&callback=initMap">

</script>

</body>
</html>