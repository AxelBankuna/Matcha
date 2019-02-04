<?php

$report = $_POST['reporting'];
$reportee = $_POST['reportee'];

//echo ("report=".$report." and reportee= ".$reportee);

$toEmail = "axe.618@gmail.com";
$subject = "report: fake account!!!";

$content = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<h1>Match-ya</h1>
<p>
User with id: ".$reportee." has reported User with id: ".$report." for potentially having a fake account.
</p>
<footer>Copyright &copy; abukasa@student.wethinkcode.co.za</footer>
</body>
</html>
";

$mailHeaders = 'MIME-Version: 1.0' . "\r\n";
$mailHeaders .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
$mailHeaders .= 'From: Admin <admin@matchya.co.za>' . "\r\n";
if(mail($toEmail, $subject, $content, $mailHeaders)) {
    header("location: ../index.php?report=1");
    echo "email sent";
}
else{
    echo "Email could not be sent.";
}


?>