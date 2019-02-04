<?php
$DS = DIRECTORY_SEPARATOR;

function dirname_i($path, $count=1){
    if ($count > 1){
        return dirname(dirname_i($path, --$count));
    }else{
        return dirname($path);
    }
}

$path = dirname_i(__FILE__,2);

require_once '..'.$DS.'config'.$DS.'db_connect.php';
require_once 'includes'.$DS.'functions.php';
require_once 'includes'.$DS.'register.inc.php';
require_once 'includes'.$DS.'process_login.php';

if(!isset($_SESSION)){session_start();}

if (login_check($db) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}

if (isset($_GET['error'])) {
    echo '<p class="error">Error Logging In!</p>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Match-ya: Log In</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="layout/style.css">

    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: lightgrey;
            text-align: center;
        }
    </style>


</head>

<body>

<div class="container-fluid">

    <div class="jumbotron">
        <img src="matches.png" width="250px" style="top: 0; float: right">
        <a href="index.php" id="logo"> <h1>Match-ya</h1></a>

        <p class="col-sm-offset-3">Helping you find your match.</p>
    </div>

    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="#" class="active" id="login-form-link">Login</a>
                        </div>
                        <div class="col-xs-6">
                            <a href="#" id="register-form-link">Register</a>
                        </div>
                    </div>
                    <hr>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <?php if(isset($_GET['s'])){ echo '<div class="alert alert-success" role="alert">
  Password changed successfully.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>'; } ?>
                            <div id="loginform">
                            <form id="login-form" action="" method="post" role="form" style="display: block;" name="login_form">

                            <div class="form-group col-sm-12">
                                <label for="username1" class="control-label">Username</label>
                                <div>
                                    <input class="form-control" id="username1" name="username1" type="text"/>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="password1" class="control-label">Password</label>
                                <div>
                                    <input class="form-control" id="password1" name="password1" type="password"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <input type="submit" name="login" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In" onclick="return formhash(this.form, this.form.username1, this.form.password1);">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-center">
                                        <a href="forgotpassword.php" id="forgot-form-link">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <form id="register-form" action="includes/register.inc.php" method="post" style="display: none;" name="regform">

                        <div class="form-group col-sm-6">
                            <label for="firstname" class="control-label">First Name</label>
                            <div>
                                <input class="form-control" id="firstname" name="firstname" type="text"/>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="lastname" class="control-label">Last Name</label>
                            <div>
                                <input class="form-control" id="lastname" name="lastname" type="text"/>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="username" class="control-label">Username</label>
                            <div>
                                <input class="form-control" id="username" name="username" type="text"/>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="email" class="control-label">Email</label>
                            <div>
                                <input class="form-control" id="email" name="email" type="email"/>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="password" class="control-label">Password</label>
                            <div>
                                <input class="form-control" id="password" name="password" type="password"/>
                            </div>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="confirmpwd" class="control-label">Confirm Password</label>
                            <div>
                                <input class="form-control" id="confirmpwd" name="confirmpwd" type="password"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <input type="submit" class="form-control btn btn-login" value="Register" name="register-submit" onclick="return regformhash(this.form,
                                                                                   this.form.firstname,
                                                                                   this.form.lastname,
                                                                                   this.form.username,
                                                                                   this.form.email,
                                                                                   this.form.password,
                                                                                   this.form.confirmpwd);">
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
        </div>

    <div class="footer">
        <p>Copyright &copy; abukasa@student.wethinkcode.co.za</p>
    </div>

    </div>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
</div>
</body>
</html>