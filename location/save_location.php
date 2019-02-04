<?php
//die("we're about to save location...");
if (!isset($_SESSION)){session_start();}

$uid = $_SESSION['user_id'];
//die($uid);
$long = $_GET['long'];
$lat = $_GET['lat'];

$con = mysqli_connect('localhost', 'root', '123456');
mysqli_select_db($con,'matcha');

mysqli_query($con,"UPDATE users SET geo_long = $long, geo_lat = $lat WHERE id = $uid");
//header("get_location.php");
header('Location: ../map_google/click_address.php?lat='.$lat.'&long='.$long);
die("we are meant to be on another page now");
?>