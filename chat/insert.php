<?php

$uname = $_REQUEST['uname'];
$msg = $_REQUEST['msg'];

$DS = DIRECTORY_SEPARATOR;

if (!isset($_SESSION)){session_start();}

function dirname_in($path, $count=1){
    if ($count > 1){
        return dirname(dirname_in($path, --$count));
    }else{
        return dirname($path);
    }
}

if (isset($_GET['c'])){
    $c_id = $_GET['c'];
}

$path = dirname_in(__FILE__,2);

//die($path);

require_once  $path.$DS.'config'.$DS.'db_connect.php';

//mysqli_query($con,"INSERT INTO chat (username, msg) VALUES('$uname', '$msg')");


//try {
//    $stmt = $db->prepare("INSERT INTO chat (username, msg) VALUES (:username, :msg)");
//    $stmt->execute(array(':username' => $uname, ':msg' => $msg));
//} catch (PDOException $e) {
//    echo $stmt . "<br>" . $e->getMessage();
//}


try {
    $stmt = $db->prepare("INSERT INTO chat_log (user_id, contact_id, msg) VALUES (:user_id, :contact_id, :msg)");
    $stmt->execute(array(':user_id' => $_SESSION['user_id'], ':contact_id' => $_GET['c'],':msg' => $msg));
} catch (PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
}

//$result1 = mysqli_query($con, "SELECT * FROM chat ORDER BY id DESC");


try {
    $stmt = $db->prepare("SELECT chat_log.user_id, chat_log.msg, users.username FROM chat_log
                                    LEFT OUTER JOIN users on chat_log.user_id = users.id
                                    WHERE (chat_log.user_id = 2 AND chat_log.contact_id = 5)
                                    OR (chat_log.user_id = 5 AND chat_log.contact_id = 2)
                                    ORDER BY chat_log.id DESC");
    $stmt->execute(array(':id' => $_SESSION['user_id'], ':contact_id' => $c_id));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['username'] == $_SESSION['user_id']) {
            echo "<span class='uname'> " . $row['username'] . "</span>: <span class='msg'>" . $row['msg'] . "</span><br>";
        }
        else{
            echo "<span class='cname'> " . $row['username'] . "</span>: <span class='cmsg'>" . $row['msg'] . "</span><br>";
        }
    }

} catch (PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
}


//while($extract = mysqli_fetch_array($result1)){
//    echo "<span class='uname'> " .$extract['username'] . "</span>: <span class='msg'>" . $extract['msg'] . "</span><br>";
//}

?>