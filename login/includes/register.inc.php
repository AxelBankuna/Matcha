<?php
//include_once '../config/db_connect.php';
$DS = DIRECTORY_SEPARATOR;

function dirname_reg ($path, $count=1){
    if ($count > 1){
        return dirname(dirname_reg ($path, --$count));
    }else{
        return dirname($path);
    }
}

$path = dirname_reg (__FILE__,3);

//define( 'DS', DIRECTORY_SEPARATOR );
//$parts = explode( DS, PATH_BASE );
//define( 'PATH_ROOT', implode( DS, $parts ) );
//require_once ( $path .DS.'config'.DS.'db_connect.php' );

require_once ( $path.$DS.'config'.$DS.'db_connect.php' );

$error_msg = "";

if (isset($_POST['register-submit'])) {
    if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {

        // Sanitize and validate the data passed in
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Not a valid email
            $error_msg .= '<p class="error">The email address you entered is not valid</p>';
        }

        $password = $_POST['p'];
        $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
//        die("password:".$password);
//        $password = hash('sha512', $password, false);

        if (strlen($password) != 128) {
            // The hashed pwd should be 128 characters long.
            // If it's not, something really odd has happened
            $error_msg .= '<p class="error">Invalid password configuration.</p>';
        }

        // Username validity and password validity have been checked client side.
        // This should should be adequate as nobody gains any advantage from
        // breaking these rules.
        //

        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");

        // check existing email
        if ($stmt) {
            $stmt->execute(array(':email' => $email));
            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                $results[] = $row;
            }


            if ($stmt->rowCount() == 1) {
                // A user with this email address already exists
                $error_msg .= '<p class="error">A user with this email address already exists.</p>';
            }
        } else {
            $error_msg .= '<p class="error">Database error Line 39</p>';
            $stmt->db = null;
        }

        // check existing username
        $stmt = $db->prepare("SELECT id 
                                      FROM users 
                                      WHERE username = :username LIMIT 1");

        if ($stmt) {
            $stmt->execute(array(':username' => $username));
            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                $results[] = $row;
            }

            if ($stmt->rowCount() == 1) {
                // A user with this username already exists
                $error_msg .= '<p class="error">A user with this username already exists</p>';
                $stmt->db = null;
            }
        } else {
            $error_msg .= '<p class="error">Database error line 55</p>';
            $stmt->db = null;
        }

        // TODO:
        // We'll also have to account for the situation where the user doesn't have
        // rights to do registration, by checking what type of user is attempting to
        // perform the operation.

        if (empty($error_msg)) {

            // Create hashed password using the password_hash function.
            // This function salts it with a random salt and can be verified with
            // the password_verify function.

            $password = password_hash($password, PASSWORD_BCRYPT);
//        die($password);
            // Insert the new user into the database
            if ($insert_stmt = $db->prepare("INSERT INTO users (firstname, lastname, username, email, password) VALUES (:firstname, :lastname, :username, :email, :password)")) {
                // Execute the prepared query.
                if (!$insert_stmt->execute(array(':firstname' => $firstname, ':lastname' => $lastname, ':username' => $username, ':email' => $email, ':password' => $password))) {
                    header('Location: ../error.php?err=Registration failure: INSERT');
                }
            }
            $u = $username;
            $e = $email;
            $p = $password;
//        header('Location: ./register_success.php');
            $id = $db->lastInsertId();
            try {
                $stmt = $db->prepare("INSERT INTO tags (user_id) VALUES (:user_id)");
                $stmt->execute(array(':user_id' => $id));
            } catch (PDOException $e) {
                echo $stmt . "<br>" . $e->getMessage();
            }

            header('Location: ../../email/confirmationemail.php?u=' . $u . '&&e=' . $e . '&&p=' . $p . '');
        }
    }
}
?>