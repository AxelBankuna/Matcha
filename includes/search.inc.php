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

$age = 1;
$distance = 1;
$fame = 1;
$tags = 1;

$where = '';

if(isset($age)){
    $where .= 'AND age = "" ';
}

if(isset($distance)){
    $where .= 'AND distance = "" ';
}

try {
    $stmt = $db->prepare("SELECT * from users where status = '1' ".$where." ");
    $stmt->execute(array(':user_id' => $_SESSION['user_id']));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo $row['username']." - ".$row['view_time']."<br/>";
    }
} catch (PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
}




?>