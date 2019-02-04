<?php
//var_dump($_POST);
function haversineGreatCircleDistance(
    $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
{
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * 6371;
}

$DS = DIRECTORY_SEPARATOR;

$age = $_POST['age'];
$distance = $_POST['distance'];
$frating = $_POST['frating'];


//die("frating=".$frating."and age =".$age."and distance=".$distance);

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
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");

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
    $age_year = $row['dob_year'];
    $lat_loc = $row['geo_lat'];
    $long_loc = $row['geo_long'];
    $user_frating = $row['fame_rating'];
}
//die("We've grabbed them all: ".$age_year.", ".$lat_loc.", ".$lat_long.", ".$user_frating);

function myfunc($lat, $long)
{
    return ($lat + $long);
}

$myquery = "SELECT A.id, A.username, A.dob_year, A.fame_rating, D.*, ((2 * ASIN(POWER((POWER((SIN((RADIANS($lat_loc) - RADIANS(A.geo_lat))/2)), 2))
 + COS(RADIANS(A.geo_lat)) * COS(RADIANS($lat_loc)) * (POWER((SIN((RADIANS($long_loc) - RADIANS(A.geo_long))/2)), 2)), 0.5))) * 6371 ) as coord
FROM users A
LEFT JOIN blocking B
ON A.id = B.user_id
LEFT JOIN blocking C
ON A.id = C.contact_id
JOIN tags D
ON A.id = D.user_id
WHERE B.contact_id IS NULL AND C.user_id IS NULL";

if ($sex_pref == "bisexual") {
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


try {
//    $stmt = $db->prepare("SELECT * FROM users WHERE id != :id LIMIT 1");
//
//    $stmt = $db->prepare("SELECT images.*, users.*, images.id AS my_images_id FROM images JOIN users ON users.id = images.user_id ORDER BY title ASC  LIMIT $pg,5");

    $stmt = $db->prepare("$myquery");

    $stmt->execute($array);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $results[] = $row;
        $user_id = $row['id'];
//        echo '<div>';
//        echo $row['username'].'<br>';
//        echo "<a href=''><img class='resp_img' src='temp_images/".$row['title']."'></a>";
//        echo '</div>';
//        echo $row['username'];
        $username = $row['username'];
        $thedistance = $row['coord'];
        $theyear = $row['dob_year'];
        $thefrate = $row['fame_rating'];

        $theyear = abs($theyear - $age_year);
        $thefrate = abs($thefrate - $user_frating);
//        var_dump($theyear);

        $tags = 1;
        if (isset($_POST['vegan']) || isset($_POST['geek']) || isset($_POST['sporty']) || isset($_POST['thot'])
            || isset($_POST['kufc_bot']) || isset($_POST['drama_queen']) || isset($_POST['angel']) || isset($_POST['devil'])
            || isset($_POST['teen']) || isset($_POST['greyed'])) $tags = 0;

        if ((isset($_POST['vegan']) && $row['vegan']) || (isset($_POST['geek']) && $row['geek']) ||
           (isset($_POST['thot']) && $row['thot']) || (isset($_POST['kufc_boy']) && $row['kufc_boy'])
            || (isset($_POST['sporty']) && $row['sporty']) || (isset($_POST['drama_queen']) && $row['drama_queen'])
            || (isset($_POST['angel']) && $row['angel']) || (isset($_POST['devil']) && $row['devil'])
            || (isset($_POST['teen']) && $row['teen']) || (isset($_POST['greyed']) &&
                $row['greyed'])) $tags = 1;

//        if ($tags)
//        die("We have a match!!!");
//        die($theyear);


        /***************/
        if ($thedistance <= $distance && $theyear <= $age && $thefrate <= $frating && $tags) {
            try {
                $stmt2 = $db->prepare("SELECT profile_pic.*, users.activity FROM profile_pic LEFT OUTER JOIN users ON users.id = profile_pic.user_id WHERE user_id = :user_id ORDER BY title DESC LIMIT 1");
//            die("user id = ".$user_id);
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
                        if ((time() - $dbtime > 10 * 60) || !$dbtime) {
                            echo "<br>offline</div>
</div>";
                        } else {
                            echo "<br>online</div>
</div>";
                        }
                    }
                } else {
                    echo "<div class='col-md-4 border'><a href='contact_profile.php?id={$user_id}'><img class='img-responsive size' src='default-profile.png'></a>

     <div class='caption'><a href='contact_profile.php?id={$user_id}' style='color: white; ' class='contacts'>$username</a>";
                    if ((time() - $dbtime > 10 * 60) || !$dbtime) {
                        echo "<br>offline</div>
</div>";
                    } else {
                        echo "<br>online</div>
</div>";
                    }
                }

            } catch (PDOException $e) {
                echo $stmt2 . "<br>" . $e->getMessage();
            }
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

<?php
$msg_count = $db->query("SELECT count(*) FROM chat_log WHERE contact_id = '$id' AND user_id = '$c'")->fetchColumn();
//echo($msg_count);
?>
<!--<div class='col-md-3 border'><a href='#'><img class='img-responsive size' src='temp_images/".$row['title']."'></a>-->
<!---->
<!--    <div class='caption'>Test</div>-->
<!--</div>-->
