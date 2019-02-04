<?php
//include_once 'includes/register.inc.php';
//include_once 'includes/functions.php';

define('PATH_BASE', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );
$parts = explode( DS, PATH_BASE );
define( 'PATH_ROOT', implode( DS, $parts ) );

require_once ( PATH_BASE .DS.'includes'.DS.'register.inc.php' );
require_once ( PATH_BASE .DS.'includes'.DS.'functions.php' );

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Secure Login: Registration Form</title>
    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
    <link rel="stylesheet" href="../includes/layout/style.css" />
</head>

<body>

    <header>
        <h1>Kamagru</h1>
    </header>

    <div class="row">
        <div class="height">

            <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>"
                  method="post"
                  name="registration_form">
                <fieldset>
                    <legend><h2>Create Account</h2></legend>
                    <p><label class="field" for="username">Username: </label><input type='text' name='username' id='username' /></p>
                    <p><label class="field" for="email">Email: </label></label><input type="text" name="email" id="email" /></p>
                    <p><label class="field" for="password">Password: </label><input type="password" name="password" id="password"/></p>
                    <p><label class="field" for="confirmpwd">Confirm Password: </label><input type="password" name="confirmpwd" id="confirmpwd" /></p>
                    <input type="button" value="Register" onclick="return regformhash(this.form,
                                                                                   this.form.username,
                                                                                   this.form.email,
                                                                                   this.form.password,
                                                                                   this.form.confirmpwd);" />
                </fieldset>

            </form>

            <p>Return to the <a href="index.php">login page</a>.</p>

        </div>
    </div>

    <footer>Copyright &copy; abukasa@student.wethinkcode.co.za</footer>

</body>
</html>