<?php
$DS = DIRECTORY_SEPARATOR;

include_once 'config'.$DS.'db_connect.php';
include_once 'login'.$DS.'includes'.$DS.'functions.php';
include_once 'includes'.$DS.'pictures.inc.php';

if (!isset($_SESSION)){session_start();}

$username = $_SESSION['username'];

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

            <div class="row">
                <div class="col-sm-3 side-height">
                    <p><h2>Matched Contacts</h2></p>
                    <?php include_once 'includes'.$DS.'matching.php'?>
                </div>

                <div class="col-sm-9 main-height">
                    <h1>Pictures</h1>
                    <div class="rowgallery">


                        <?php
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                            if ($page == 1){
                                $pg = 0;
                            }
                            else{
                                $pg = ($page * 5) - 5;
                            }
                        }
                        else{
                            $pg = 0;
                        }
                        $count = $db->query("SELECT count(*) FROM images")->fetchColumn();
                        $count = ceil($count / 5);

                        try {
//                        $stmt = $db->prepare("SELECT * FROM images ORDER BY title ASC");
                            $stmt = $db->prepare("SELECT images.*, users.*, images.id AS my_images_id FROM images JOIN users ON users.id = images.user_id ORDER BY title ASC  LIMIT $pg,5");

                            $stmt->execute();

                            // set the resulting array to associative
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $results[] = $row;
                                echo '<div class="gallerycolumn">';
                                echo $row['username'].'<br>';
                                echo "<a href='viewpic.php?id=".$row['my_images_id']."'><img class='resp_img' src='temp_images/".$row['title']."'></a>";
                                echo '</div>';
                            }
                        }
                        catch(PDOException $e)
                        {
                            echo $stmt . "<br>" . $e->getMessage();
                        }

                        ?>

                    </div>
                    <?php
                    for ($i=1; $i <= $count; $i++){
                        echo "<a href='gallery.php?page=".$i."' style='text-decoration: none'>" .$i. " </a>";
                    }
                    ?>

                    <?php

                    if (isset($_GET['msg'])){
                        if (($_GET['msg']) == 'deleted'){
                            echo "
        <script type='text/javascript'>
         alert('Image deleted successfully');
         window.location.href = \"gallery.php\";
        </script>
        ";
                        }
                    }

                    ?>
                </div>

                <div id="fromfile">

                    <form name="form" method="post" action="pictures.php?a=1" enctype="multipart/form-data">
<!--                        <span class="btn btn-default btn-file">-->
                        <input type="file" name="image">
                        <input type="hidden" id="superUploadImage" name="superUploadImage" value="">
                        <input type="submit" id="upload_image" name="fromfile">
<!--                            </span>-->
                    </form>

                </div>

            </div>
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

<?php
endif;