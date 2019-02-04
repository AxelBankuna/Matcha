<?php
$DS = DIRECTORY_SEPARATOR;

include_once '../config'.$DS.'db_connect.php';
include_once 'newpassword.inc.php';
include_once 'includes'.$DS.'functions.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Match-ya: Reset</title>

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

        .size {
            height: 200px;
            width: 200px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            border:5px solid powderblue;
            border-radius: 25%;
        }

        .caption {
            font-size: 20px;
            color: white;
            text-align: center;
            background-color: steelblue;
            border:5px solid steelblue;
            border-radius: 50%;
            width: 200px;

            margin-left: auto;
            margin-right: auto;
        }

    </style>


</head>

<body>
<div class="container-fluid">

    <div class="jumbotron">
        <img src="../layout/matches.png" width="250px" style="top: 0; float: right">
        <a href="index.php" id="logo"> <h1>Match-ya</h1></a>

        <p class="col-sm-offset-3">Helping you find your match.</p>
    </div>




    <div class="container">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
        <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?> "
              method="post"
              name="registration_form"  role="form">
            <fieldset>
                <legend><h2>Create New Password</h2></legend>

                <p><?php echo $error_msg; ?>
                    <?php if(empty($error_msg)){ ?>
                <p>Userrname: <?php echo $username;?> </p>
                <p>Email: <?php echo $email;?></p>
                <div class="form-group col-sm-12">
                    <label for="password" class="control-label">New Password</label>
                    <div>
                        <input class="form-control" id="password" name="password" type="password"/>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label for="confirmpwd" class="control-label">Confirm New Password</label>
                    <div>
                        <input class="form-control" id="password" name="confirmpwd" type="password"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <input type="submit" tabindex="4" class="form-control btn btn-login" value="Update" onclick="return formhash(this.form, this.form.password, this.form.confirmpwd);">
                        </div>
                    </div>
                </div>
<!--                <p><label class="field" for="password">New Password: </label><input type="password" name="password" id="password"/></p>-->
<!--                <p><label class="field" for="confirmpwd">Confirm New Password: </label><input type="password" name="confirmpwd" id="confirmpwd" /></p>-->
<!--                <input type="submit" value="Update" />-->
                <!--                <input type="button" value="Update" onclick="return newpassformhash(this.form,-->
                <!--                                                                                   this.form.password,-->
                <!--                                                                                   this.form.confirmpwd);" />-->
                <?php } ?>
            </fieldset>

        </form>
        </div>
        </div>
        </div>
        <p>Return to the <a href="index.php">login page</a>.</p>
        <hr/>
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