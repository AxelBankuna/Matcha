<?php
$DS = DIRECTORY_SEPARATOR;

include_once 'config'.$DS.'db_connect.php';
include_once 'login'.$DS.'includes'.$DS.'functions.php';
include_once 'includes'.$DS.'profile.inc.php';
include_once 'includes'.$DS.'profile_pic.php';

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
                    <p><h2>Profile</h2></p>

                    <form enctype="multipart/form-data" id="login-form" method="post" role="form" style="display: block;" name="edit" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
                            <fieldset>

                            <?php if(isset($_POST['edit'])){
                                if (isset($_POST['password'])){
                                    $password = $_POST['password'];
                                    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                                    $password = hash('sha512', $password, false);
                                }
                                if (isset($_POST['editview'])) {?>

                                    <p>Enter Password to edit profile:</p>
                                    <p><label class="field" for="password">Password: </label><input type="password" name="password" id="password"/></p>
                                    <input type="hidden" name="editprofile" value="true">
                                    <input type="submit" value="Submit" name="edit"/>

                                <?php }
                                else if (isset($_POST['editprofile']) && login($username, $password, $db) == true) {?>
                                <div class="form-group">
                                    <a href="pictures.php" type="button" class="btn btn-info" style="margin-bottom: 10px">Pictures</a>
                                    <p><label class="field" for="fname">First Name: </label><input class="form-control" type="text" name="fname" id="fname" value="<?php echo $fname; ?>"/></p>
                                    <p><label class="field" for="fname">Last Name: </label><input class="form-control" type="text" name="lname" id="lname" value="<?php echo $lname; ?>"/></p>
                                    <p><label class="field" for="username">Username: </label><input class="form-control" type="text" name="username" id="username" value="<?php echo $username; ?>"/></p>
                                    <p><label class="field" for="email">Email: </label><input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>"/></p>

                                    <div class="form-group col-sm-12">
                                        <fieldset>
                                            <legend>Date Of Birth:</legend>
                                    <div class="col-sm-2">
                                        <label for="year">Year:</label>
                                        <select class="form-control" id="year" name="dob_year">
                                            <option value='<?php echo $dob_year ?>' selected><?php echo $dob_year ?></option>
                                            <!-- <option disabled selected value> <?php echo $dob_year ?> </option> -->
                                            <?php
                                            for ($i=1918;$i<2001;$i++){
                                                echo "<option value='{$i}'>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="month">Month:</label>
                                        <select class="form-control" id="month" name="dob_month">
                                            <option value = '<?php echo $dob_month ?>' selected><?php echo $dob_month ?></option>
<!--                                            <option disabled selected value> - select - </option>-->
                                            <?php
                                                for ($i=1;$i<13;$i++){
                                                    echo "<option value='{$i}'>$i</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="day">Day:</label>
                                        <select class="form-control" id="day" name="dob_day">
                                            <option value = '<?php echo $dob_day; ?>' selected><?php echo $dob_day; ?></option>
<!--                                            <option disabled selected value> - select - </option>-->
                                            <?php
                                            for ($i=1;$i<32;$i++){
                                                echo "<option value='{$i}'>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                        </fieldset>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <hr/>
                                        <div class="col-sm-3">
                                            <label class="field" for="sex">Sex:</label>
                                            <select class="form-control" id="sex" name="sex">
                                                <!-- <option disabled selected value> <?php echo $sex ?> </option> -->
                                                <option value = '<?php echo $user_sex; ?>' selected>- <?php echo $user_sex; ?> -</option>
                                                <option value='Male'>Male</option>
                                                <option value='Female'>Female</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-3">
                                            <label class="field" for="sex_pref">Sex Preference:</label>
                                            <select class="form-control" id="sex_pref" name="sex_pref">
                                               <option value='<?php echo $sex_pref; ?>' selected>- <?php echo $sex_pref; ?> -</option>
                                               <!--  <option disabled selected value> <?php echo $sex_pref ?> </option> -->
                                                <option value='Heterosexual'>Hetrosexual</option>
                                                <option value='Homosexual'>Homosexual</option>
                                                <option value='Bisexual'>Bisexual</option>
                                            </select>
                                        </div>
                                    </div>
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
                                </div><!-- /.row -->
                                <iframe id="google_map" width="425" height="470" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="location/get_location.php"></iframe>
                                    <p><label class="field" for="bio">Bio: </label><textarea class="form-control" name="bio"> <?php echo $bio;?> </textarea></p>

                                    <p><label class="field" for="password">New Password: </label><input class="form-control" type="password" name="password" id="password"/></p>
                                    <p><label class="field" for="confirmpwd">Confirm New Password: </label><input class="form-control" type="password" name="confirmpwd" id="confirmpwd" /></p>
                                    <input type="submit" value="Save Changes" name="editsaved"/>
                                </div>


                                <?php }

                                else if ($_POST['editprofile'] == "true" && !password_verify($password, $pass_db)) {?>

                                    <div class="alert alert-danger">
                                        <strong>Danger!</strong> Incorrect password.
                                        <a href="profile.php">Return</a>
                                    </div>

                                <?php }

                            }else{
                                ?>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-2 col-md-2">

                                            <?php

                                            try {
                                                $stmt = $db->prepare("SELECT * FROM profile_pic WHERE user_id = :user_id ORDER BY id DESC  LIMIT 1");

                                                $stmt->execute(array(':user_id' => $id));

                                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                $avatar = $row['title'];
                                            }
                                            catch(PDOException $e)
                                            {
                                                echo $stmt . "<br>" . $e->getMessage();
                                            }

//die("$avatar");
                                            ?>
                                            <img src="profile_images/<?php echo $avatar;?>"
                                                 alt="" class="img-rounded img-responsive" />

                                                <input type="file" name="image">
                                                <input type="submit" id="upload_image" name="fromfile">

                                            <?php $split_address = explode (",", $full_address);
                                            $split_address = array_reverse($split_address);?>

                                        </div>
                                        <input type='hidden' name='editview' value='1'>
                                        <input type='submit' class="btn btn-info" value='Edit Profile' name='edit'/>
                                        <div class="col-sm-4 col-md-4">
                                            <blockquote>
                                                <p><?php echo $fname. " " .$lname;?></p> <small><cite title="Source Title"><?php echo ($split_address[2].", ".$split_address[0]);?>  <i class="glyphicon glyphicon-map-marker"></i></cite></small>
                                            </blockquote>
                                            <p> <i class="glyphicon glyphicon-envelope"></i> <?php echo $email; ?>
                                                <br
                                                /> <i class="glyphicon glyphicon-star "></i> <?php echo $fame;?> <i class="glyphicon glyphicon-film "></i>
                                                <br /> <i class="glyphicon glyphicon-gift"></i> <?php echo $dob_year.' - '.$dob_month.' - '.$dob_day; ?>
                                            <br/><i class="fa fa-intersex" style="font-size:22px;"></i> <?php echo $user_sex; ?>
                                            <br /> <i class="glyphicon glyphicon-pencil"></i><?php echo ("My Bio: ".$bio); ?></p>
                                        </div>
<!--                                        --><?php //die($user_sex);?>
                                    </div>

                                    <div class="img-row">
                                        <!--                            <div class="img-column">-->
                                        <?php

                                        try {
                                            $stmt = $db->prepare("SELECT * FROM images WHERE user_id = :user_id ORDER BY title ASC");
                                            $stmt->execute(array(':user_id' => $id));

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



<!--                                        <img src='temp_images/$avatar' style='max-width: 200px; max-height: 170px; margin:5px; border-radius: 12%'>-->
<!--                                        <img src="vault1.jpg" style="max-width: 200px; max-height: 170px; margin:5px; border-radius: 12%">-->
<!--                                        <img src="vault2.jpg" style="max-width: 200px; max-height: 170px; margin:5px; border-radius: 12%">-->
<!--                                        <img src="vault3.jpg" style="max-width: 200px; max-height: 170px; margin:5px; border-radius: 12%">-->
                                        <!--                            </div>--><div style="clear:both"></div>
                                    </div>

                                </div>

                                <?php
                            }?>
                        </fieldset>

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
    <script type="text/JavaScript" src="login/js/sha512.js"></script>
    <script type="text/JavaScript" src="login/js/forms.js"></script>
    </div>
    </body>
    </html>

<?php
endif;
