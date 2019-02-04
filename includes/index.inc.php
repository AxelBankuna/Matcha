<?php

$DS = DIRECTORY_SEPARATOR;

//function dirname_in ($path, $count=1){
//    if ($count > 1){
//        return dirname(dirname_in ($path, --$count));
//    }else{
//        return dirname($path);
//    }
//}

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
    $stmt = $db->prepare("SELECT sex, sex_pref FROM users WHERE id = :id LIMIT 1");

    $stmt->execute(array(':id' => $id));

}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $results[] = $row;
    $sex = $row['sex'];
    $sex_pref = $row['sex_pref'];
}

$myquery = "SELECT A.id, A.username, A.activity
FROM users A
LEFT JOIN blocking B
ON A.id = B.user_id
LEFT JOIN blocking C
ON A.id = C.contact_id
WHERE B.contact_id IS NULL AND C.user_id IS NULL";

if ($sex_pref == "Bisexual") {
    $myquery .= " AND A.id != :id LIMIT $pg,3";
    $array = array(':id' => $id);
}
else if ($sex_pref == "Heterosexual" && $sex == "Male") {
    $myquery .= " AND A.id != :id AND A.sex = :sex AND A.sex_pref = :sex_pref LIMIT $pg,3";
    $array = array(':id' => $id, ':sex' => "Female", ':sex_pref' => "Heterosexual");
}
else if ($sex_pref == "Heterosexual" && $sex == "Female") {
    $myquery .= " AND A.id != :id AND A.sex = :sex AND A.sex_pref = :sex_pref LIMIT $pg,3";
    $array = array(':id' => $id, ':sex' => "Male", ':sex_pref' => "Heterosexual");
}
else if ($sex_pref == "Homosexual" && $sex == "Male") {
    $myquery = " AND A.id != :id AND sex = :sex AND sex_pref = :sex_pref LIMIT $pg,3";
    $array = array(':id' => $id, ':sex' => "Male", ':sex_pref' => "Homosexual");
}
else if ($sex_pref == "Homosexual" && $sex == "Female") {
    $myquery = " AND A.id != :id AND sex = :sex AND sex_pref = :sex_pref LIMIT $pg,3";
    $array = array(':id' => $id, ':sex' => "Female", ':sex_pref' => "Homosexual");
}
//die($myquery);

try {
//    $stmt = $db->prepare("SELECT * FROM users WHERE id != :id LIMIT 1");
//
//    $stmt = $db->prepare("SELECT images.*, users.*, images.id AS my_images_id FROM images JOIN users ON users.id = images.user_id ORDER BY title ASC  LIMIT $pg,5");

    $stmt = $db->prepare("$myquery");

    $stmt->execute($array);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $results[] = $row;
        $user_id = $row['id'];
        $activity = $row['activity'];
//        echo strtotime($activity)." and now ".time()." and calc = ".((time() - strtotime($activity))/60);
//        echo '<div>';
//        echo $row['username'].'<br>';
//        echo "<a href=''><img class='resp_img' src='temp_images/".$row['title']."'></a>";
//        echo '</div>';
//        echo $row['username'];
        $username = $row['username'];
        $dbtime = strtotime($activity);

        /***************/

        try {
            $stmt2 = $db->prepare("SELECT profile_pic.*, users.activity FROM profile_pic LEFT OUTER JOIN users ON users.id = profile_pic.user_id WHERE user_id = :user_id ORDER BY title DESC LIMIT 1");
//            die("user id = ".$user_id);
            $stmt2->execute(array(':user_id' => $user_id));

            $count = $db->query("SELECT count(*) FROM profile_pic WHERE user_id = $user_id")->fetchColumn();
//            die ("count=".$count ." and id=" .$user_id);
//            $dbtime = NULL;
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
//                    $activity = $row['activity'];
//                    echo ($dbtime = strtotime($activity));
                    if (((time() - $dbtime - 3600) > 5 * 60) || !$dbtime ){
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
                if (((time() - $dbtime - 3600) > 5 * 60) || !$dbtime ){
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
//echo (((time() - $dbtime)/60 )."<br>");
//        echo ("dbtime:".$dbtime."<br>");
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

<?php
$msg_count = $db->query("SELECT count(*) FROM chat_log WHERE contact_id = '$id' AND user_id = '$c'")->fetchColumn();
//echo($msg_count);
?>
<!--<div class='col-md-3 border'><a href='#'><img class='img-responsive size' src='temp_images/".$row['title']."'></a>-->
<!---->
<!--    <div class='caption'>Test</div>-->
<!--</div>-->
