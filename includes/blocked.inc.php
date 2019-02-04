<?php

$DS = DIRECTORY_SEPARATOR;

function dirname_in ($path, $count=1){
    if ($count > 1){
        return dirname(dirname_in ($path, --$count));
    }else{
        return dirname($path);
    }
}

$path = dirname_in (__FILE__,2);

//die($path);

include_once $path.$DS.'config'.$DS.'db_connect.php';
include_once $path.$DS.'login'.$DS.'includes'.$DS.'functions.php';

if (!isset($_SESSION)){session_start();}

$id = $_SESSION['user_id'];

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == 1){
        $pg = 0;
    }
    else{
        $pg = ($page * 3) - 3;
    }
}
else{
    $pg = 0;
}
$pgcount = $db->query("SELECT count(*) FROM users")->fetchColumn();
$pgcount -= 1;
$pgcount = ceil($pgcount / 3);

//try {
//    $stmt = $db->prepare("SELECT activity FROM users WHERE id = :id LIMIT 1");
//    $stmt->execute(array(':id' => 3));
//    $row = $stmt->fetch(PDO::FETCH_ASSOC);
//    $activity = $row['activity'];
//
//} catch (PDOException $e) {
//    echo $stmt . "<br>" . $e->getMessage();
//}

try {
//    $stmt = $db->prepare("SELECT * FROM users WHERE id != :id LIMIT 1");
//
//    $stmt = $db->prepare("SELECT images.*, users.*, images.id AS my_images_id FROM images JOIN users ON users.id = images.user_id ORDER BY title ASC  LIMIT $pg,5");

    $stmt = $db->prepare("SELECT users.*
FROM users
INNER JOIN blocking ON users.id = blocking.contact_id
WHERE blocking.user_id = :user_id");

    $stmt->execute(array(':user_id' => $id));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $results[] = $row;
        $user_id = $row['id'];
//        echo '<div>';
//        echo $row['username'].'<br>';
//        echo "<a href=''><img class='resp_img' src='temp_images/".$row['title']."'></a>";
//        echo '</div>';
//        echo $row['username'];
        $username = $row['username'];

        /***************/

        try {
            $stmt2 = $db->prepare("SELECT profile_pic.*, users.activity FROM profile_pic LEFT OUTER JOIN users ON users.id = profile_pic.user_id WHERE user_id = :user_id ORDER BY title DESC LIMIT 1");
            $stmt2->execute(array(':user_id' => $user_id));

            $count = $db->query("SELECT count(*) FROM profile_pic WHERE user_id = $user_id")->fetchColumn();
//            die ("count=".$count ." and id=" .$user_id);
            $dbtime = NULL;
            if ($count) {

                while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $results[] = $row;


//        echo '<div>';
//        echo $row['username'].'<br>';
//        echo "<a href=''><img class='resp_img' src='temp_images/".$row['title']."'></a>";
//        echo '</div>';
//                    die ($row['title']);
                    echo "<div class='col-md-4 border'><a href='viewpic.php?id={$row["id"]}'><img class='img-responsive size' src='profile_images/" . $row['title'] . "'></a>

    <div class='caption'><a href='contact_profile.php?id={$user_id}' style='color: white; ' class='contacts'>$username</a>";
                    $activity = $row['activity'];
                    $dbtime = strtotime($activity);
                    if ((time() - $dbtime > 10 * 60) || !$dbtime ){
                        echo "<br>offline</div>
</div>";
                    }
                    else{
                        echo "<br>online</div>
</div>";
                    }
                }
            }
            else{
                echo "<div class='col-md-4 border'><a href='contact_profile.php?id={$user_id}'><img class='img-responsive size' src='default-profile.png'></a>

     <div class='caption'><a href='contact_profile.php?id={$user_id}' style='color: white; ' class='contacts'>$username</a>";
                if ((time() - $dbtime > 10 * 60) || !$dbtime ){
                    echo "<br>offline</div>
</div>";
                }
                else{
                    echo "<br>online</div>
</div>";
                }
            }

        }
        catch(PDOException $e)
        {
            echo $stmt2 . "<br>" . $e->getMessage();
        }

        /****************/


    }

}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
}
?>
<div class='col-sm-2'>
    <?php
    for ($i=1; $i <= $pgcount; $i++){
        echo "

  
        <a href='index.php?page=".$i."' style='text-decoration: none'>" .$i. " </a>
    
";
    }
    ?>
</div>

<!--<div class='col-md-3 border'><a href='#'><img class='img-responsive size' src='temp_images/".$row['title']."'></a>-->
<!---->
<!--    <div class='caption'>Test</div>-->
<!--</div>-->
