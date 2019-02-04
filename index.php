<?php
$DS = DIRECTORY_SEPARATOR;
//if(!isset($_SESSION)){echo "error";}
include_once 'config'.$DS.'db_connect.php';
include_once 'login'.$DS.'includes'.$DS.'functions.php';
include_once 'includes'.$DS.'profile.inc.php';
//include_once 'includes'.$DS.'index.inc.php';
//session_start();
//die("redirected to index");
if (login_check_new($db) == true) :
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
            <img src="layout/matches.png" width="250px" style="top: 0; float: right">
            <a href="index.php" id="logo"> <h1>Match-ya</h1></a>

            <p class="col-sm-offset-3">Helping you find your match.</p>
        </div>




        <div class="container">

            <div class="navbar-header navbar-default">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
                    <li><a href="profile.php">Profile </a></li>
                    <li><a href="history.php">History </a></li>
                    <li><a href="likes.php">Likes </a></li>
                    <li><a href="search.php">Search </a></li>
                    <li><a href="blocked.php">Blocked List </a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="login/logout.php">Logout</a></li>
                    <li><a href="profile.php">logged in as: <?php echo $username; ?></a></li>
                </ul>
            </div><!-- /.navbar-collapse -->

            <div class="row" style="margin-bottom: 50px" style="display: flex">
                <div class="col-sm-3" style="background-color:lightgrey;">
                    <p><h2>Matched Contacts</h2></p>

                    <?php include_once 'includes'.$DS.'matching.php'?>

                </div>
                <div class="col-sm-9" style="background-color:gainsboro; padding: 20px">
                    <div class="col-sm-12" style="background-color:gainsboro; padding: 20px">
                        <h2>Top Recommendations:</h2>
                        <?php
                        include_once 'includes'.$DS.'recommendations.php';
                        ?>
                    </div>
                    <div class="col-sm-12" style="background-color:gainsboro; padding: 20px">
                        <hr>
                        <?php
                        include_once 'includes'.$DS.'index.inc.php';
                        ?>
                    </div>
                </div>
            </div>

            <div class="footer">
                <p>Copyright &copy; abukasa@student.wethinkcode.co.za</p>
            </div>

        </div>

        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<!--        <script type="text/JavaScript" src="login/js/sha512.js"></script>-->
<!--        <script type="text/JavaScript" src="login/js/forms.js"></script>-->
    </div>
    </body>
    </html>

<?php
endif;