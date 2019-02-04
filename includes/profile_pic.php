<?php

if (!isset($_SESSION)){session_start();}

$id = $_SESSION['user_id'];

if (isset($_POST['fromfile'])){

    $file_type = $_FILES['image']['type']; //returns the mimetype

    $allowed = array("image/jpeg", "image/gif", "image/png");
    if(in_array($file_type, $allowed)) {

        $temp = explode(".", $_FILES["image"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target =  "profile_images/".basename($newfilename);
        $image = $_FILES['image']['name'];
        $msg = "";

        //The name of the directory that we need to create.
        $directoryName = 'profile_images';

        //Check if the directory already exists.
        if(!is_dir($directoryName)){
            //Directory does not exist, so lets create it.
            mkdir($directoryName, 0755);
        }

        try{
            $stmt =  $db->prepare("INSERT INTO profile_pic (user_id, title) VALUES (:user_id, :title)");
            $stmt->execute(array(':user_id' => $id, ':title' => $newfilename));

        }
        catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)){
            $$msg = "There was a problem uploading image";
        }

    }
    else{

        echo "
        
        <script type='text/javascript'>
            alert('Only jpg, gif, and png files are allowed.');
        </script>
        
        ";
    }

}


?>


