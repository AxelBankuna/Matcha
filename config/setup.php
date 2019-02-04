<?php

include_once 'database.php';

try {
    $db = new PDO("mysql:host=$_DB_SERVER", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = "CREATE DATABASE IF NOT EXISTS matcha";
    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Database matcha created successfully<br>";
}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
}

$db = null;


try {
//    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $stmt = "CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(255) NOT NULL,
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table chat created successfully <br>";


    $stmt = "CREATE TABLE IF NOT EXISTS `chat_log` (
  `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table chat_log created successfully <br>";


    $stmt = "CREATE TABLE IF NOT EXISTS `history` (
  `id` int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(10) NOT NULL,
  `contact_id` int(10) NOT NULL,
  `view_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table history created successfully <br>";


    $stmt = "CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table images created successfully <br>";


    $stmt = "CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(10) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table login_attempts created successfully <br>";


    $stmt = "CREATE TABLE IF NOT EXISTS `matching` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table matching created successfully <br>";


    $stmt = "CREATE TABLE IF NOT EXISTS `blocking` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table blocking created successfully <br>";


    $stmt = "CREATE TABLE IF NOT EXISTS `profile_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table profile_pic created successfully <br>";


    $stmt = "CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(100) NOT NULL,
  `vegan` int(1) NOT NULL DEFAULT '0',
  `geek` int(1) NOT NULL DEFAULT '0',
  `sporty` int(1) NOT NULL DEFAULT '0',
  `thot` int(1) NOT NULL DEFAULT '0',
  `kufc_boy` int(1) NOT NULL DEFAULT '0',
  `drama_queen` int(1) NOT NULL DEFAULT '0',
  `angel` int(1) NOT NULL DEFAULT '0',
  `devil` int(1) NOT NULL DEFAULT '0',
  `teen` int(1) NOT NULL DEFAULT '0',
  `greyed` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table tags created successfully <br>";


    $stmt = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob_year` int(4) DEFAULT 0,
  `dob_month` int(2) DEFAULT 0,
  `dob_day` int(2) DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `fame_rating` int(3) NOT NULL DEFAULT '50',
  `sex` varchar(20) DEFAULT NULL,
  `sex_pref` varchar(20) NOT NULL DEFAULT 'Bisexual',
  `bio` text,
  `forgot_pass` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `geo_lat` float DEFAULT 1000,
  `geo_long` float DEFAULT 2000,
  `street_address` varchar(255) DEFAULT '-\,-\,-',
  `activity` datetime DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Table users created successfully <br>";

    /********************************************************************************/

    $sql = "DROP FUNCTION IF EXISTS harvers";
    $db->exec($sql);
    echo "Function dropped successfully <br>";
    $sql = "CREATE FUNCTION harvers(@user_lat float, @user_long float, @contact_lat float, @contact_long float)
    RETURNS floag AS
    
    BEGIN
    return (0.1234)
    END";

    // use exec() because no results are returned
    $db->exec($stmt);
    echo "Function created successfully <br>";

}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
}

$db = null;

?>