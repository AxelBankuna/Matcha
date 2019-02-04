<?php
$DS = DIRECTORY_SEPARATOR;

include_once 'config'.$DS.'db_connect.php';
include_once 'login'.$DS.'includes'.$DS.'functions.php';

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

            <div class="row">
                <div class="col-sm-3 side-height">
                    <p><h2>Matched Contacts</h2></p>
                    <?php include_once 'includes'.$DS.'matching.php'?>
                </div>
                <div class="col-sm-9 main-height">
<h2>Search</h2>
                    <form action="search_results.php" method="post">

                        <p>
                            <div class="slidecontainer">
                            <label class="field" for="distance">Search by location: </label><input type="range" min="1" max="100" value="50" class="slider" id="myRange" name="distance" onchange="update_distance(this.value);"/>
                            Range: <input type="text" id="show_distance" value="50" readonly>Km
                            </div>
                        </p>

                        <p>
                        <div class="slidecontainer">
                            <label class="field" for="age">Search by age gap: </label><input type="range" min="0" max="50" value="10" class="slider" id="myRange" name="age" onchange="update_age(this.value);"/>
                            Age gap:<input type="text" id="show_age" value="10" readonly>year/s
                        </div>

                        <p>
                        <div class="slidecontainer">
                            <label class="field" for="fame_rating">Search by fame rating difference: </label><input type="range" min="1" max="300" value="50" class="slider" id="myRange" name="frating" onchange="update_frating(this.value);"/>
                            Fame rating: <input type="text" id="show_frating" value="50" readonly>
                        </div>
                        </p>

                        <?php
                        try {
                        ?>
                        <div class="form-group col-sm-12">
                            <fieldset>
                                <legend>Tags:</legend>
                                <div class="row">
                                    <?php

                                    $stmt = $db->prepare("SELECT * FROM tags WHERE user_id = :user_id");
                                    $stmt->execute(array(':user_id' => $_SESSION['user_id']));
                                    for ($i = 2; $i < $stmt->columnCount(); $i++) {
                                        $col = $stmt->getColumnMeta($i);
                                        $columns[] = $col['name'];

//                                        print_r($columns);
                                        ?>
                                        <?php
                                        try {
                                            $stmt = $db->prepare("SELECT * FROM tags WHERE user_id = :user_id");
                                            $stmt->execute(array(':user_id' => $_SESSION['user_id']));
                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                        } catch (PDOException $e) {
                                            echo $stmt . "<br>" . $e->getMessage();
                                        }
                                        ?>


                                        <div class="col-sm-4">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                  <?php if ($row[$columns[$i-2]] == 0) { ?>
                                                      <input type="checkbox" name="<?php echo $columns[$i-2]; ?>" value="0">
                                                  <?php }
                                                  else{ ?>
                                                      <input type="checkbox" name="<?php echo $columns[$i-2]; ?>" value="1" checked>
                                                  <?php }?>
                                              </span>
                                                <input type="text" class="form-control" aria-label="..."
                                                       value="<?php echo $columns[$i-2]; ?>"
                                                >
                                            </div>
                                        </div>


                                        <?php
                                    }
                                    } catch (PDOException $e) {
                                        echo $stmt . "<br>" . $e->getMessage();
                                    }
                                    ?>
                            </fieldset>
                        </div>
                        <input type='submit' class="btn btn-info" value='Submit Search' name='custom_search'/>
                    </form>


                </div><!-- /.row -->
                        </p>

                </div>
            </div>
            <hr/>
            <div class="footer">
                <p>Copyright &copy; abukasa@student.wethinkcode.co.za</p>
            </div>

        </div>

        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script type="text/JavaScript" src="login/js/sha512.js"></script>
    <script type="text/JavaScript" src="login/js/forms.js"></script>
    <script type="text/JavaScript" src="includes/js/scripts.js"></script>
    </div>
    </body>
    </html>

<?php
endif;