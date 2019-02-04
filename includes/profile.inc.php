<?php
$DS = DIRECTORY_SEPARATOR;

session_start();
if(!isset($_SESSION)){ echo "Test";}

$id = $_SESSION['user_id'];

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
    $username = $row['username'];
    $fname = $row['firstname'];
    $lname = $row['lastname'];
    $email = $row['email'];
    $user_sex = $row['sex'];
    $sex_pref = $row['sex_pref'];
    $fame = $row['fame_rating'];
    $bio = $row['bio'];
    $pass_db = $row['password'];
    $id = $row['id'];
    $dob_year = $row['dob_year'];
    $dob_month = $row['dob_month'];
    $dob_day = $row['dob_day'];
    $full_address = $row['street_address'];
}

if (isset($_POST['editsaved'])){

    $vegan=0; $geek=0; $sporty=0; $thot=0; $kufc_boy=0; $drama_queen=0; $angel=0; $devil=0; $teen=0; $greyed=0;

    if (isset($_POST['vegan'])==1){$vegan=1;} if (isset($_POST['geek'])==1){$geek=1;}
    if (isset($_POST['thot'])==1){$thot=1;} if (isset($_POST['kufc_boy'])==1){$kufc_boy=1;}
    if (isset($_POST['drama_queen'])==1){$drama_queen=1;} if (isset($_POST['angel'])==1){$angel=1;}
    if (isset($_POST['teen'])==1){$teen=1;} if (isset($_POST['greyed'])==1){$greyed=1;}


        try {
            $stmt = $db->prepare("UPDATE tags SET vegan = :vegan, geek = :geek, thot = :thot, 
                                            kufc_boy = :kufc_boy, drama_queen = :drama_queen, 
                                            angel = :angel, teen = :teen, greyed = :greyed WHERE user_id = :user_id");
            $stmt->execute(array(':vegan' => $vegan, ':geek' => $geek, ':thot' => $thot, ':kufc_boy' => $kufc_boy,
                ':drama_queen' => $drama_queen, ':angel' => $angel, ':teen' => $teen, ':greyed' => $greyed, ':user_id' => $id));
        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }

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
        $bio = $row['row'];


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

                $stmt->execute(array(':username' => $username, ':email' => $email, ':dob_year' => $dob_year,
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

try {
    $stmt_address = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");

    $stmt_address->execute(array(':id' => $id));

}
catch(PDOException $e)
{
    echo $stmt_address . "<br>" . $e->getMessage();
}

while ($row = $stmt_address->fetch(PDO::FETCH_ASSOC)) {
    $results[] = $row;
    $address = $row['street_address'];
}
//die($address);
?>