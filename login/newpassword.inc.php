<?php
include_once '../config/db_connect.php';
//include_once 'includes/config.php';

$error_msg = "";
$pwd_error_msg = "";

if (isset($_GET['u']) && isset($_GET['e']) && isset($_GET['key']))
    $username = $_GET['u'];
$email = $_GET['e'];
$key = $_GET['key'];

if (isset($_GET['key'])){


    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE forgot_pass = :forgotpass and email = :email LIMIT 1");

        $stmt->execute(array(':forgotpass' => $key, ':email' => $email));

    }
    catch(PDOException $e)
    {
        echo $stmt . "<br>" . $e->getMessage();
    }

    if(!$stmt->fetchColumn()){
        if (isset($_POST['password'], $_POST['confirmpwd'])) {

            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            $password = hash('sha512', $password);

            $password = password_hash($password, PASSWORD_BCRYPT);
//die($password);

            if ($_POST['password'] == $_POST['confirmpwd']) {

                try {
                    $stmt = $db->prepare("UPDATE users SET password = :password, status = :status WHERE email = :email LIMIT 1");
                    $stmt->execute(array(':email' => $email, ':password' => $password, ':status' => 1));
                } catch (PDOException $e) {
                    echo $stmt . "<br>" . $e->getMessage();
                }

                $u = $username;
                $e = $email;
                $p = $password;
                //        header('Location: ./register_success.php');

                header('Location: index.php?s=c');

            }
            else
            {
                $pwd_error_msg .= '<p class="error">Passwords do not match.</p>';
            }



        }
    }
    else
    {
        $error_msg .= '<p class="error">Forgot password key has expired or is invalid.</p>';
    }



}
?>

