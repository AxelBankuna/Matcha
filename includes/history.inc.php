<?php

$DS = DIRECTORY_SEPARATOR;

if (!isset($_SESSION)){session_start();}

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

try {
    $stmt = $db->prepare("SELECT history.*, users.username FROM history LEFT OUTER JOIN users 
                                    ON users.id = history.user_id WHERE history.contact_id = :user_id");
    $stmt->execute(array(':user_id' => $_SESSION['user_id']));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
//        echo $row['username']." - ".$row['view_time']."<br/>";
        $name = $row['username'];
        echo "<a href='contact_profile.php?id={$row["user_id"]}'>$name </a>".$row['view_time']."<br/>";
    }
} catch (PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
}

?>