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
                            <a href="index.php">Login</a>
                        </div>
                    </div>
                    <hr>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <?php if(isset($_GET['s'])){ echo '<p>password changed</p>'; } ?>

                            <form id="forgot-form" action="forgotemail.php" method="post" name="forgotform">

                                <div class="form-group col-sm-12">
                                    <label for="email" class="control-label">Email</label>
                                    <div>
                                        <input class="form-control" id="email" name="email" type="email"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" class="form-control btn btn-login" value="Submit" name="forgot_form" onclick="return regformhash(this.form,this.form.email;">

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