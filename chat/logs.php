<?php
$DS = DIRECTORY_SEPARATOR;

function dirname_l($path, $count=1){
    if ($count > 1){
        return dirname(dirname_l($path, --$count));
    }else{
        return dirname($path);
    }
}

$path = dirname_l(__FILE__,2);

if (!isset($_SESSION)){session_start();}

require_once  $path.$DS.'config'.$DS.'db_connect.php';
//die($_GET['c']);
if (isset($_GET['c'])){
    $c_id = $_GET['c'];
}
$user_id = $_SESSION['user_id'];
//$result1 = mysqli_query($con, "SELECT * FROM chat ORDER BY id DESC");


//try {
//    $stmt = $db->prepare("SELECT * FROM chat ORDER BY id DESC");
//    $stmt->execute();
//
//    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
//        echo "<span class='uname'> " .$row['username'] . "</span>: <span class='msg'>" . $row['msg'] . "</span><br>";}
//
//} catch (PDOException $e) {
//    echo $stmt . "<br>" . $e->getMessage();
//}



try {
    $stmt = $db->prepare("SELECT chat_log.user_id, chat_log.msg, users.username FROM chat_log
                                    LEFT OUTER JOIN users on chat_log.user_id = users.id
                                    WHERE (chat_log.user_id = $user_id AND chat_log.contact_id = $c_id)
                                    OR (chat_log.user_id = $c_id AND chat_log.contact_id = $user_id)
                                    ORDER BY chat_log.id ASC");
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        if ($row['user_id'] == $_SESSION['user_id']) {
            echo "<span class='uname'> " . $row['username'] . "</span>: <span class='msg'>" . $row['msg'] . "</span><br>";
        }
        else{
            echo "<span class='cname'> " . $row['username'] . "</span>: <span class='cmsg'>" . $row['msg'] . "</span><br>";
        }}

} catch (PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
}


//while($extract = mysqli_fetch_array($result1)){
//    echo "<span class='uname'> " .$extract['username'] . "</span>: <span class='msg'>" . $extract['msg'] . "</span><br>";
//}

?>