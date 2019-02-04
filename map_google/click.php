<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
</head>
<body>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXuCXodX9qEsiYPdtohwMduZGnL_vMxcU&callback=initMap">
</script>
<form method="get" action="../location/save_location.php">
    Coordinates for your location:<br>
    <input type="text" id="lat" name="lat" placeholder="latitude">
    <input type="text" id="long" name="long" placeholder="longitude">
    <br><br>
    <input type="submit" value="Submit">
</form>
<script type="text/javascript">
    window.onload = function () {
        var mapOptions = {
            center: new google.maps.LatLng(-26.2049, 28.0401),
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var infoWindow = new google.maps.InfoWindow();
        var latlngbounds = new google.maps.LatLngBounds();
        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
        google.maps.event.addListener(map, 'click', function (e) {
            alert("Latitude: " + e.latLng.lat() + "\r\nLongitude: " + e.latLng.lng());
            document.getElementById("lat").value = e.latLng.lat();
            document.getElementById("long").value = e.latLng.lng();
            // window.location = "../location/save_location.php?uid="+ uid +"&lat="+thelat + "&long=" +  thelong;
        });
    }
</script>
<div id="dvMap" style="width: 500px; height: 500px">
</div>

</body>
</html>