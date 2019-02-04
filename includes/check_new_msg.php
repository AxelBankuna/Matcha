<?php
//die("we are in check_new_msg");
$DS = DIRECTORY_SEPARATOR;

if (!isset($_SESSION)){session_start();}
$id = $_SESSION['user_id'];

function dirname_h($path, $count=1){
    if ($count > 1){
        return dirname(dirname_h($path, --$count));
    }else{
        return dirname($path);
    }
}

$path = dirname_h(__FILE__,2);

//die($path);

require_once  $path.$DS.'config'.$DS.'db_connect.php';

$c = $_GET['contact_id'];
//echo "the contact id=".$c;
echo $db->query("SELECT count(*) FROM chat_log WHERE contact_id = '$id' AND user_id = '$c' AND status = 0")->fetchColumn();

//echo($msg_count);

?>