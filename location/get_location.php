<?php
include_once '../config/db_connect.php';

if (!isset($_SESSION)){session_start();}
$id = $_SESSION['user_id'];

try {
$stmt_address = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");

$stmt_address->execute(array(':id' => $id));

}
catch(PDOException $e)
{
echo $stmt_address . "<br>" . $e->getMessage();
}

while ($row = $stmt_address->fetch(PDO::FETCH_ASSOC)) {
$results[] = $row;
$address = $row['street_address'];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <title>location</title>
</head>
<body>

<a href="#" id="get_location">Get Location</a> &nbsp
<a href="../map_google/click.php" id="set_location">Set Location</a>

<div id="map">

    <iframe id="google_map" width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.za?output=embed"></iframe>

    <script type="text/javascript">
        var uid = 1;
        var mylat;
        var mylong;
        var coords;
        var c = function (pos) {
            var lat = pos.coords.latitude,
                long = pos.coords.longitude,
                coords = lat + ', ' + long;
            mylat = lat;
            mylong = long;
            document.getElementById('google_map').setAttribute('src', 'https://maps.google.co.za/?q='+ coords +'&z=60&output=embed');
            save_location(lat, long);
            return [lat, long];
        }

        var e = function (error) {
            if (error.code === 1)  {
                alert('unable to get location');
            }
        }
        function save_location(thelat, thelong) {
            // var xmlhttp2 = new XMLHttpRequest();
            // xmlhttp2.open("GET", "save_location.php?uid=" + uid + "&lat=" + lat + "&long=" +  long , true);
            window.location = "save_location.php?uid="+ uid +"&lat="+thelat + "&long=" +  thelong;
            // xmlhttp2.send();
            // return false;
        }
        document.getElementById('get_location').onclick = function () {
            navigator.geolocation.getCurrentPosition(c, e);
            return false;
        }
    </script>
    <div class="alert alert-success">
        <strong>Your address: </strong><p id="youraddress"> <?php echo $address; ?></p>
    </div>
</div>

</body>
</html>