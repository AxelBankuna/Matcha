<?php
$DS = DIRECTORY_SEPARATOR;

if (!isset($_SESSION)){session_start();}

if (isset($_GET['id'])){
    $id = $_GET['id'];
}

$user_id = $_SESSION['user_id'];
$contact_id = $id;

//$id = $_SESSION['user_id'];
//print_r("$_SESSION");
//exit;
//die("inside profile...");
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
    $contact_username = $row['username'];
    $fname = $row['firstname'];
    $lname = $row['lastname'];
    $sex = $row['sex'];
    $sex_pref = $row['sex_pref'];
    $fame = $row['fame_rating'];
    $bio = $row['bio'];
    $id = $row['id'];
    $dob_year = $row['dob_year'];
    $dob_month = $row['dob_month'];
    $dob_day = $row['dob_day'];
    $full_address = $row['street_address'];
    $toEmail = $row['email'];
    $bio = $row['bio'];
    $activity = $row['activity'];
}

if (isset($_POST['match'])){
    if ($_POST['matching'] == 1){
        try {
            $stmt = $db->prepare("INSERT INTO matching (user_id, contact_id) VALUES (:user_id, :contact_id)");
            $stmt->execute(array(':user_id' => $user_id, ':contact_id' => $contact_id));
        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }

        try {
            $stmt = $db->prepare("UPDATE users SET fame_rating = fame_rating + 25 WHERE id= :id");
            $stmt->execute(array(':id' => $contact_id));
        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }

        if(mail($toEmail, "Matcha match!!!", "Someone thinks you're hot ;-)")) {
            echo "Email sent successfully";
        }

    }
    else if($_POST['matching'] == 0){
        try {
            $stmt = $db->prepare("DELETE FROM matching WHERE user_id = :user_id AND contact_id = :contact_id");
            $stmt->execute(array(':user_id' => $user_id, ':contact_id' => $contact_id));
        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }
    }
}

//BLOCKING AND UNBLOCKING
if (isset($_POST['block'])){
    if ($_POST['blocking'] == 1){
        try {
            $stmt_block = $db->prepare("INSERT INTO blocking (user_id, contact_id) VALUES (:user_id, :contact_id)");
            $stmt_block->execute(array(':user_id' => $user_id, ':contact_id' => $contact_id));
        } catch (PDOException $e) {
            echo $stmt_block . "<br>" . $e->getMessage();
        }
        try {
            $stmt = $db->prepare("DELETE FROM matching WHERE user_id = :user_id AND contact_id = :contact_id");
            $stmt->execute(array(':user_id' => $user_id, ':contact_id' => $contact_id));
        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }

    }
    else if($_POST['blocking'] == 0){
        try {
            $stmt_block = $db->prepare("DELETE FROM blocking WHERE user_id = :user_id AND contact_id = :contact_id");
            $stmt_block->execute(array(':user_id' => $user_id, ':contact_id' => $contact_id));
        } catch (PDOException $e) {
            echo $stmt_block . "<br>" . $e->getMessage();
        }
    }
}


//GET TAGS INFO

try {
    $stmt = $db->prepare("SELECT * FROM tags WHERE id = :id LIMIT 1");

    $stmt->execute(array(':id' => $id));

}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
}

$tag_array = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $tag_results[] = $row;
    $tag_array['vegan'] = $row['vegan'];
    $tag_array['geek'] = $row['geek'];
    $tag_array['sporty'] = $row['sporty'];
    $tag_array['thot'] = $row['thot'];
    $tag_array['kufc_boy'] = $row['kufc_boy'];
    $tag_array['drama_queen'] = $row['drama_queen'];
    $tag_array['angel'] = $row['angel'];
    $tag_array['devil'] = $row['devil'];
    $tag_array['teen'] = $row['teen'];
    $tag_array['greyed'] = $row['greyed'];
}

//foreach ($tag_results as $key => $value) {
//    if ($value == 1)
//        echo ($key . " ");
//    echo "{$key} => {$value} ";
//}


//INSERT TIME AND DATE DETAILS FOR A CONTACT'S PROFILE BEING VIEWED
try {
    $stmt = $db->prepare("INSERT INTO history (user_id, contact_id, view_time) VALUES (:user_id, :contact_id, NOW())");
    $stmt->execute(array(':user_id' => $_SESSION['user_id'], ':contact_id' => $_GET['id']));
} catch (PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
}

try {
    $stmt = $db->prepare("UPDATE users SET fame_rating = fame_rating + 5 WHERE id= :id");
    $stmt->execute(array(':id' => $_GET['id']));
} catch (PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
}

if (isset($_POST['editsaved'])){

    if (isset($_POST['password'], $_POST['confirmpwd'])) {

        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        $password = hash('sha512', $password);

        $password = password_hash($password, PASSWORD_BCRYPT);

//die($_POST['dob_year']);

        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $sex = $_POST['sex'];
        $sex_pref = $_POST['sex_pref'];
        $bio = $_POST['bio'];
        $pass_db = $_POST['password'];
        $dob_year = $_POST['dob_year'];
        $dob_month = $_POST['dob_month'];
        $dob_day = $_POST['dob_day'];


        if (isset($_POST['receive'])){
            $receive = 1;
        }
        else{

            $receive = 0;
        }

        if ($_POST['password'] == $_POST['confirmpwd']) {

            try {
                $stmt = $db->prepare("UPDATE users SET username = :username, email = :email, 
                                                dob_year = :dob_year, dob_month = :dob_month, dob_day = :dob_day, 
                                                sex = :sex, sex_pref = :sex_pref, bio = :bio WHERE id = :id LIMIT 1");

                $stmt->execute(array(':username' => $contact_username, ':email' => $email, ':dob_year' => $dob_year,
                    'dob_month' => $dob_month, 'dob_day' => $dob_day,
                    ':sex' => $sex, ':sex_pref' => $sex_pref, ':bio' => $bio, ':id' => $_SESSION['user_id']));
            } catch (PDOException $e) {
                echo $stmt . "<br>" . $e->getMessage();
            }

            if ($_POST['password'] != '') {

                try {
                    $stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id LIMIT 1");
                    $stmt->execute(array(':password' => $password, ':id' => $_SESSION['user_id']));
                } catch (PDOException $e) {
                    echo $stmt . "<br>" . $e->getMessage();
                }
            }
            else
            {
                $pwd_error_msg .= '<p class="error">Passwords do not match.</p>';
            }

            //        header('Location: ./register_success.php');

            header('Location: profile.php?p=c');

        }
        else
        {
            $pwd_error_msg .= '<p class="error">Passwords do not match.</p>';
        }

    }
}


?>

<?php

function haversineGreatCircleDistance(
    $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
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
    return $angle * $earthRadius;
}

$id = $_SESSION['user_id'];
$contact_id = $_GET['id'];

try {
    $stmt_user = $db->prepare("SELECT geo_lat, geo_long FROM users WHERE id = :id LIMIT 1");

    $stmt_user->execute(array(':id' => $id));
}
catch(PDOException $e)
{
    echo $stmt_user . "<br>" . $e->getMessage();
}

while ($row = $stmt_user->fetch(PDO::FETCH_ASSOC)){
    $results[] = $row;
    $user_lat = $row['geo_lat'];
    $user_long = $row['geo_long'];
}

try {
    $stmt_contact = $db->prepare("SELECT geo_lat, geo_long FROM users WHERE id = :id LIMIT 1");

    $stmt_contact->execute(array(':id' => $contact_id));
}
catch(PDOException $e)
{
    echo $stmt_contact . "<br>" . $e->getMessage();
}

while ($row = $stmt_contact->fetch(PDO::FETCH_ASSOC)){
    $results[] = $row;
    $contact_lat = $row['geo_lat'];
    $contact_long = $row['geo_long'];
}

$distance = haversineGreatCircleDistance(
    $user_lat, $user_long, $contact_lat, $contact_long, $earthRadius = 6371);
//die("ulat=".$user_lat." ulong=".$user_long." clat=".$contact_lat." clong=".$contact_long." distance=".$distance);

?>


