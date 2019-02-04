<?php
$DS = DIRECTORY_SEPARATOR;
//require_once 'config/db_connect.php';

function dirname_r($path, $count=1){
    if ($count > 1){
        return dirname(dirname_r($path, --$count));
    }else{
        return dirname($path);
    }
}


$path = dirname_r ( __FILE__ , 3 );
$logo_path = $path. $DS ."layout". $DS ."matches.png";
//die("$logo_path");
//die($path);
require_once($path . $DS . 'config' . $DS . 'db_connect.php');

/*
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;

    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../login/error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session
    session_regenerate_id();    // regenerated the session, delete the old one.
}
*/

//This function will check the email and password against the database.
//Using the password_verify function rather than comparing the strings helps to prevent timing attacks.
//It will return true if there is a match

function login($username, $password, $db) {
    // Using prepared statements means that SQL injection is not possible.
    if ($stmt = $db->prepare("SELECT id, username, password, status FROM users WHERE username = :username LIMIT 1")) {
        $stmt->execute(array(':username' => $username));    // Bind "$email" to parameter and Execute the prepared query.

        // get variables from result.
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $user_id = $row['id'];
            $username = $row['username'];
            $db_password = $row['password'];
            $status = $row['status'];
            $_SESSION['user_id'] = $row['id'];

        }

        if ($stmt->rowCount() == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts

            if (checkbrute($user_id, $db) == true) {
                // Account is locked
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted. We are using
                // the password_verify function to avoid timing attacks.
                if (password_verify($password, $db_password) && $status == 1) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                        "",
                        $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512',
                        $db_password . $user_browser);
                    // Login successful.

                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    $now = time();
                    $db->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}


function checkbrute($user_id, $db) {
    // Get timestamp of current time
    $now = time();

    // All login attempts are counted from the past 2 hours.
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $db->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = :user_id 
                            AND time > '$valid_attempts'")) {

        // Execute the prepared query.
        $stmt->execute(array(':user_id' => $user_id));

        while ($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $results[] = $row;
        }

        // If there have been more than 5 failed logins
        if ($stmt->rowCount() > 5) {
            return true;
        } else {
            return false;
        }
    }
}


function login_check($db) {
    // Check if all session variables are set
    if (isset($_SESSION['user_id'],
        $_SESSION['username'],
        $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $db->prepare("SELECT password 
                                      FROM users 
                                      WHERE id = :id LIMIT 1")) {
            // Bind "$user_id" to parameter.
            $stmt->execute(array(':id' => $user_id));   // Execute the prepared query.

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $password = $row['password'];
            }


            if ($stmt->rowCount() == 1) {
                // If the user exists get variables from result.
                $password = $row['password'];
                $login_check = hash('sha512', $password . $user_browser);
//                die ("$login_check" . "<br>" . "$login_string");
//                if (hash_equals($login_check, $login_string) ){
//                    // Logged In!!!!
//                    return true;
//                } else {
//                    // Not logged in
//                    return false;
//                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    } else {
        // Not logged in
        return false;
    }

    try {
        $stmt = $db->prepare("UPDATE users SET activity = NOW() WHERE id = :id");
        $stmt->execute(array(':id' => $_SESSION['user_id']));
    } catch (PDOException $e) {
        echo $stmt . "<br>" . $e->getMessage();
    }

    return true;
}

function login_check_new($db) {
    // Check if all session variables are set
    if (isset($_SESSION['user_id'],
        $_SESSION['username'],
        $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $db->prepare("SELECT password 
                                      FROM users 
                                      WHERE id = :id LIMIT 1")) {
            // Bind "$user_id" to parameter.
            $stmt->execute(array(':id' => $user_id));   // Execute the prepared query.

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $password = $row['password'];
            }


            if ($stmt->rowCount() == 1) {
                // If the user exists get variables from result.
                $password = $row['password'];
                $login_check = hash('sha512', $password . $user_browser);
//                die ("$login_check" . "<br>" . "$login_string");
//                if (hash_equals($login_check, $login_string) ){
//                    // Logged In!!!!
//                    return true;
//                } else {
//                    // Not logged in
//                    return false;
//                }
            } else {
                // Not logged in
                header("Location: login/index.php");
            }
        } else {
            // Not logged in
            header("Location: login/index.php");
        }
    } else {
        // Not logged in
        header("Location: login/index.php");
    }

    try {
        $stmt = $db->prepare("UPDATE users SET activity = NOW() WHERE id = :id");
        $stmt->execute(array(':id' => $_SESSION['user_id']));
    } catch (PDOException $e) {
        echo $stmt . "<br>" . $e->getMessage();
    }

    return true;
}


function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function generateRandomString($length = 32) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}


