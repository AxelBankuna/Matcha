<?php
$DS = DIRECTORY_SEPARATOR;

include_once 'config'.$DS.'db_connect.php';
include_once 'login'.$DS.'includes'.$DS.'functions.php';
include_once 'includes'.$DS.'profile.inc.php';
include_once 'includes'.$DS.'contact_profile.inc.php';

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <?php
    if (isset($_GET['p'])){echo "<div class='alert alert-success'>
  <strong>Success!</strong> Profile successfully updated. <a href='profile.php'>Ok</a>
</div>";}

    ?>

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
                    <p><h2>Profile: <?php echo $fname." ".$lname ?> </h2></p>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-2 col-md-2">

                                            <?php
                                            try {
                                                $stmt = $db->prepare("SELECT * FROM profile_pic WHERE user_id = :user_id ORDER BY title ASC  LIMIT 1");

                                                $stmt->execute(array(':user_id' => $contact_id));

                                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                $avatar = $row['title'];
                                            }
                                            catch(PDOException $e)
                                            {
                                                echo $stmt . "<br>" . $e->getMessage();
                                            }

//                                            die("id=".$id." user_id=".$contact_id." and avatar is ".$avatar);
                                            ?>
                                            <img src="profile_images/<?php echo $avatar;?>"
                                                 alt="" class="img-rounded img-responsive" />

                                            <?php

                                            $match_count = $db->query("SELECT count(*) FROM matching 
                                                                      WHERE user_id = $user_id AND contact_id = $contact_id")->fetchColumn();

                                            $block_count = $db->query("SELECT count(*) FROM blocking 
                                                                      WHERE user_id = $user_id AND contact_id = $contact_id")->fetchColumn();

                                            $propic_count = $db->query("SELECT count(*) FROM profile_pic WHERE user_id = $contact_id ORDER BY title ASC  LIMIT 1")->fetchColumn();
//                                            die("propic count=".$propic_count);
                                            ?>

                                        </div>
<?php $split_address = explode (",", $full_address);
$split_address = array_reverse($split_address);
$dbtime = strtotime($activity);
if ((time() - $dbtime - 3600) < 5 * 60)
    echo '<span style="color:green;">online</span>';
?>
                                        <div class="col-sm-4 col-md-4">
                                            <blockquote>
                                                <p><?php echo $fname. " " .$lname;?></p> <small><cite title="Source Title"><?php echo ($split_address[2].", ".$split_address[0]);?>  <i class="glyphicon glyphicon-map-marker"></i></cite></small>
                                            </blockquote>
                                            <p><i class="glyphicon glyphicon-star "></i> <?php echo $fame;?> <i class="glyphicon glyphicon-film "></i>
                                                <br /> <i class="glyphicon glyphicon-gift"></i> <?php echo $dob_year.' - '.$dob_month.' - '.$dob_day; ?>
                                                <br/><i class="fa fa-intersex" style="font-size:22px;"><?php echo $sex;?></i>
                                                <br /> <i class="glyphicon glyphicon-circle-arrow-right"></i> <i class="glyphicon glyphicon-circle-arrow-left"></i><?php echo $sex_pref; ?>
                                                <br /> <i class="glyphicon glyphicon-tasks"></i> <?php foreach ($tag_array as $k => $v) {
                                                    if ($v == 1)
                                                        echo ($k. ' ');
                                                } ?>
                                                <?php $distance = sprintf('%0.2f', $distance);?>
                                                <br /> <i class="glyphicon glyphicon-resize-small"></i><?php echo ($distance." kms away"); ?>
                                                <br /> <i class="glyphicon glyphicon-pencil"></i><?php echo ("Bio: ".$bio); ?>
                                            </p>

                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <?php if (!$propic_count){ ?>
                                            <form action="includes/report.php" method="post" onsubmit="return confirm_report()">
                                                <input type='hidden' name='reporting' value='<?php echo $contact_id; ?>'>
                                                <input type='hidden' name='reportee' value='<?php echo $user_id; ?>'>
                                                <input type='submit' class="btn btn-warning" value='report: <?php echo $contact_username; ?>' name='report'/>
                                            </form>
                                            <?php } ?>
                                            &nbsp;
                                            <?php if ($block_count) { ?>
                                                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                                                    <input type='hidden' name='blocking' value='0'>
                                                    <input type='submit' class="btn btn-success" value='Unblock: <?php echo $contact_username; ?>' name='block'/>
                                                </form>
                                            <?php }
                                            else{
                                                ?>
                                                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                                                    <input type='hidden' name='blocking' value='1'>
                                                    <input type='submit' class="btn btn-danger" value='Block: <?php echo $contact_username; ?>' name='block'/>
                                                </form>
                                            <?php } ?>

                                            <?php echo "<br><br>";?>

                                            <?php if ($match_count) { ?>
                                                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                                                    <input type='hidden' name='matching' value='0'>
                                                    <input type='submit' class="btn btn-danger" value='Unmatch Us!' name='match'/>
                                                </form>
                                            <?php }
                                            else{
                                                ?>
                                            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                                                <input type='hidden' name='matching' value='1'>
                                                <input type='submit' class="btn btn-primary" value='Match Us!' name='match'
                                                <?php if($block_count){echo "disabled";} ?>/>
                                            </form>
                                        <?php } ?>
                                        </div>


                                    </div>

                                    <div class="img-row">
                                        <!--                            <div class="img-column">-->
                                        <?php

                                        try {
                                            $stmt = $db->prepare("SELECT * FROM images WHERE user_id = :user_id ORDER BY title ASC");
                                            $stmt->execute(array(':user_id' => $contact_id));

                                            $i = 0;
                                            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                if ($i > 0) {
                                                    echo "<img src='temp_images/$row->title' style='max-width: 200px; max-height: 170px; margin:5px; border-radius: 12%'>";
                                                }
                                                $i++;
                                            }
                                        }
                                        catch(PDOException $e)
                                        {
                                            echo $stmt . "<br>" . $e->getMessage();
                                        }
                                        ?>
<div style="clear:both"></div>
                                    </div>

                                </div>

                </div>
            </div>
            <hr/>
            <div class="footer">
                <p>Copyright &copy; abukasa@student.wethinkcode.co.za</p>
            </div>

        </div>
        <script>
            function confirm_report() {
                if(confirm("Confirm: Report "))
                    return true;
                return false;
            }
        </script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<!--        <script type="text/JavaScript" src="js/sha512.js"></script>-->
<!--        <script type="text/JavaScript" src="js/forms.js"></script>-->
    </div>
    </body>
    </html>

<?php
endif;
