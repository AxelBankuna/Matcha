<?php

$DS = DIRECTORY_SEPARATOR;

function dirname_c($path, $count=1){
    if ($count > 1){
        return dirname(dirname_c($path, --$count));
    }else{
        return dirname($path);
    }
}

$path = dirname_c(__FILE__,2);
//die($path);
require_once $path.$DS.'config'.$DS.'db_connect.php';
include_once $path.$DS.'login'.$DS.'includes'.$DS.'functions.php';

if (!isset($_SESSION)){session_start();}

if (isset($_GET['c'])){
    $contact_id = $_GET['c'];

    try {
        $stmt = $db->prepare("SELECT username FROM users WHERE id = :id");
        $stmt->execute(array(':id' => $contact_id));

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $contact_username = $row['username'];

    } catch (PDOException $e) {
        echo $stmt . "<br>" . $e->getMessage();
    }

    try {
        $stmt = $db->prepare("UPDATE chat_log SET status = 1 WHERE contact_id = :c_id AND user_id = :u_id");
        $stmt->execute(array(':u_id' => $contact_id, 'c_id' => $_SESSION['user_id']));

    } catch (PDOException $e) {
        echo $stmt . "<br>" . $e->getMessage();
    }
}

$username = $_SESSION['username'];

if (login_check_new($db) == true) :
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Match-ya: Chat</title>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" type="text/css" href="../layout/style.css">
        <link rel="stylesheet" type="text/css" href="chat.css">

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

        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

        <script type="text/javascript">

            function submitChat() {

                if(form1.uname.value == '' || form1.msg.value == ''){
                    alert('ALL FIELDS ARE MANDATORY!!!');
                }
                form1.uname.readonly = true;
                form1.uname.style.border = 'none';
                var uname = form1.uname.value;
                var msg = form1.msg.value;
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        document.getElementById('chatlogs').innerHTML = xmlhttp.responseText;
                    }
                }
                var c_id = "<?php echo $contact_id ?>";
                xmlhttp.open('GET', 'insert.php?uname='+uname+'&msg='+msg+'&c='+c_id, true);
                xmlhttp.send();

            }

            $(document).ready(function (e) {
                var c_id = "<?php echo $contact_id ?>";
                $.ajaxSetup({cache:false});
                setInterval(function (){$('#chatlogs').load('logs.php?c='+c_id);}, 2000);
            });

        </script>

    </head>

    <body>
    <div class="container-fluid">

        <div class="jumbotron">
            <img src="../layout/matches.png" width="250px" style="top: 0; float: right">
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
                    <li class="active"><a href="../index.php">Home <span class="sr-only">(current)</span></a></li>
                    <li><a href="../profile.php">Profile </a></li>
                    <li><a href="../history.php">History </a></li>
                    <li><a href="../search.php">Search </a></li>
                    <li><a href="../blocked.php">Blocked List </a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="../login/logout.php">Logout</a></li>
                    <li><a href="../profile.php">logged in as: <?php echo $username; ?></a></li>
                </ul>
            </div><!-- /.navbar-collapse -->

            <div class="row">
                <div class="col-sm-3 side-height">
<!--                    <p><h2>Matched Contacts</h2></p>-->
<!--                    --><?php //include_once '../includes'.$DS.'matching.php'?>
                </div>
                <div class="col-sm-9 main-height">

                    <form name="form1">
                        <!--Enter your chatname: <input type="text" name="uname" style="width:200px" /><br/>-->

                        <input type="hidden" name="uname" value="<?php echo $_SESSION['username'] ?>">
                        <input type="hidden" name="c_id" value="<?php echo $_GET['c'] ?>">
                        Enter your message: <br/>
                        <textarea name="msg" style="width:200px; height: 70px"></textarea><br/>
                        <a href="#" onclick="submitChat()">Send</a><br/><br/>
                    </form>

                    <div id="chatlogs">
                        LOADING CHATLOGS, PLEASE WAIT...
                    </div>

                </div>
            </div>
            <hr/>
            <div class="footer">
                <p>Copyright &copy; abukasa@student.wethinkcode.co.za</p>
            </div>

        </div>

        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<!--        <script type="text/JavaScript" src="js/sha512.js"></script>-->
<!--        <script type="text/JavaScript" src="js/forms.js"></script>-->
    </div>
    </body>
    </html>

<?php
endif;