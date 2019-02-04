<?php
if (!isset($_SESSION)){session_start();}
$uid = $_SESSION['user_id'];
$address = $_GET['address'];
$address1 = "My address";
$con = mysqli_connect('localhost', 'root', '123456');
mysqli_select_db($con,'matcha');
//die("we're about to save address...".$address);

//mysqli_query($con,"UPDATE users SET street_address = $address WHERE id = 1");
if (!mysqli_query($con,"UPDATE users SET street_address = '$address' WHERE id = $uid"))
{
    echo("Error description: " . mysqli_error($con));
}
header('Location: ../location/get_location.php');
?>