<?php

if (!isset($_SESSION)){session_start();}

$id = $_SESSION['user_id'];

if (isset($_POST['fromfile'])) {


    $pic_count = $db->query("SELECT count(*) FROM images WHERE user_id = $id")->fetchColumn();
//die($pic_count);
    if ($pic_count <= 5) {

    $file_type = $_FILES['image']['type']; //returns the mimetype

    $allowed = array("image/jpeg", "image/gif", "image/png");
    if (in_array($file_type, $allowed)) {

        $temp = explode(".", $_FILES["image"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target = "temp_images/" . basename($newfilename);
        $image = $_FILES['image']['name'];
        $msg = "";
        $supUploadImage = $_POST['superUploadImage'];

        //The name of the directory that we need to create.
        $directoryName = 'temp_images';

        //Check if the directory already exists.
        if (!is_dir($directoryName)) {
            //Directory does not exist, so lets create it.
            mkdir($directoryName, 0755);
        }

        try {
            $stmt = $db->prepare("INSERT INTO images (user_id, title) VALUES (:user_id, :title)");
            $stmt->execute(array(':user_id' => $id, ':title' => $newfilename));

        } catch (PDOException $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $$msg = "There was a problem uploading image";
        }
        else{


                try {
                    $stmt1 = $db->prepare("SELECT fame_rating FROM users WHERE id = :id LIMIT 1");
                    $stmt1->execute(array(':id' => $id));

                    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
                    $fame_plus = $row['fame_rating'] + 10;
//                    die("We are in here: ".$fame_plus);

                } catch (PDOException $e) {
                    echo $stmt1 . "<br>" . $e->getMessage();
                }
//die("fame:".$fame_plus." and id:".$id);
            try {
                $stmt2 = $db->prepare("UPDATE users set fame_rating = :fame_rating WHERE id = :the_id)");
                $stmt2->execute(array(':fame_rating' => $fame_plus, ':the_id' => $id));

            } catch (PDOException $e) {
                echo $stmt2 . "<br>" . $e->getMessage();
            }
        }

    } else {

        echo "
        
        <script type='text/javascript'>
            alert('Only jpg, gif, and png files are allowed.');
        </script>
        
        ";
    }
}
else{
        ?>
    <div class="alert alert-danger">
  Maximum of 5 pictures already updated. <a href="pictures.php">Ok</a>
</div>
<?php
}
}


?>


