<?php
$DS = DIRECTORY_SEPARATOR;

function dirname_pl ($path, $count=1){
    if ($count > 1){
        return dirname(dirname_pl ($path, --$count));
    }else{
        return dirname($path);
    }
}

$path = dirname_pl(__FILE__, 3);

require_once $path.''.$DS.'config'.$DS.'db_connect.php';
include_once 'functions.php';

 // Our custom secure way of starting a PHP session.

if (isset($_POST['login'])) {

    if (isset($_POST['username1'], $_POST['password1'])) {
        session_start();
        $username = $_POST['username1'];
        $password = $_POST['password1'];// The hashed password.
        $password = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING);
        $password = hash('sha512', $password, false);
        if (login($username, $password, $db) == true) {
            // Login success
            print_r($_SESSION);

            header('Location: ../index.php');
        } else {
            // Login failed
            echo "<div class='alert alert-danger'>
  <strong>Warning!</strong> Incorrect login details.
</div>";

        }
    } else {
        // The correct POST variables were not sent to this page.
        echo 'Invalid Request';
    }
}