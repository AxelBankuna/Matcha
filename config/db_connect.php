<?php

define( 'DS', DIRECTORY_SEPARATOR );
$DS = DIRECTORY_SEPARATOR;

require_once 'database.php';
//include_once '/goinfre/abukasa/MAMP/apache2/htdocs/kamagru/config/database.php';
try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
//    echo $stmt . "<br>" . $e->getMessage();
    echo "failed to connect.";
}
?>