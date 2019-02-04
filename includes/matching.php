<?php

$DS = DIRECTORY_SEPARATOR;

function dirname_m ($path, $count=1){
    if ($count > 1){
        return dirname(dirname_m ($path, --$count));
    }else{
        return dirname($path);
    }
}

$path = dirname_m (__FILE__,2);

include_once $path.$DS.'config'.$DS.'db_connect.php';
include_once $path.$DS.'login'.$DS.'includes'.$DS.'functions.php';

if (!isset($_SESSION)){session_start();}

$id = $_SESSION['user_id'];
$c = 0;
$msg_count = 0;
$countarray = array();

try {
    $stmt = $db->prepare("SELECT A.contact_id, C.activity, C.username FROM matching A LEFT OUTER JOIN matching B ON A.user_id = B.contact_id
                                    LEFT OUTER JOIN users C on A.contact_id = C.id
                                    AND A.contact_id = B.user_id WHERE A.user_id = :id");
    $stmt->execute(array(':id' => $_SESSION['user_id']));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $results[] = $row;
        $c = $row['contact_id'];
        if ($row['username'] != '')
        echo "<a id='$c' href='chat/chat.php?u=$id&c=$c'>".$row['username']."&nbsp;"."</a>";
//        echo "&nbsp;";
        $dbtime = strtotime($row['activity']);
//        echo ("activity: ".$row['activity']."<br>");
//        echo $dbtime;
//        echo "<br>";
//        echo time();

//        echo ($dbtime."and time:".time()."=".($dbtime - time()));
        if ($row['username'] != '') {
//            echo("date default timezone: ".date_default_timezone_get());
//            date_default_timezone_set('Africa/Cairo');

//            echo("DBTime" . $dbtime . "<br>");
//            echo("Other time" . time())."<br>";
//            echo ((time() - $dbtime) - 3600);
            if ((time() - $dbtime - 3600) > 5 * 60) {
//            echo "offline";
            echo '<span style="color:red;">offline</span>';

            } else {
//            echo "online";
                echo '<span style="color:green;">online</span>';
            }
        }
        $msg_count = $db->query("SELECT count(*) FROM chat_log WHERE contact_id = '$id' AND user_id = '$c'")->fetchColumn();
        array_push($countarray, $c);
        echo "<br>";
//        $countarray [$c] = $msg_count;
//        echo "&nbsp;";
//        if ($row['username'] != '')
//        echo ("<p id='new_msg_$c'>Check...</p>");
//        echo "Here we are.";
    }
//var_dump($countarray);

    echo ("
    <script>
    async function check(contact_id) {
        if (window.XMLHttpRequest)
                        xmlhttp = new XMLHttpRequest();
                    else
                        xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
                    xmlhttp.open('GET', 'includes/check_new_msg.php?contact_id='+contact_id, true);
                    xmlhttp.send();
                    xmlhttp.onreadystatechange = function () {
//                        alert('This Response Text: ' + this.responseText);
                        if (this.responseText && this.responseText != 0){
//                            alert('We are doing it...'+contact_id);
//                            document.getElementById(elemid).innerHTML = message;
                            document.getElementById(contact_id).style.color = 'black';
                        }
                    }
    }
            setInterval(async function msg_update() {
                var js_array = ['" . implode("','", $countarray) . "'];
//                alert(js_array[0]);
//                alert(js_array[1]);
//                alert('hello there...');
//                contact_id = $c;
                thecontact = 100;
                var elemid = 'new_msg_'+contact_id;
                var message = 'New message!';

//                alert(js_array[0]);
for (var i = 0, len = js_array.length; i < len; i++) {
//                if (msg_count == 0){
//                    document.getElementById(elemid).innerHTML = '';
//                    return;
//                }
//                else {
                    var contact_id = js_array[i];
//                    alert('ID: ' + contact_id);
                    await check(contact_id);
                }
            }, 2000);
        </script>");

} catch (PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
}


?>