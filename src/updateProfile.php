<?php
include "php_util/util.php";
$connection = createDatabaseConnection();
include_once "php_util/userSessionHelper.php";
$userSessionHelper = new UserSessionHelper($connection);

    $userid = $userSessionHelper->getUserInformation()['user_id'];
if (isset($_POST['updateProf'])) {
    $username = $_POST['updateusername'];
    $email = $_POST['updateemail'];
    $contactNum = $_POST['updatecontact'];

    if ((!empty($username)) && !empty($email) && !empty($contactNum)) {
        $stmt = $connection->prepare("UPDATE user SET username='$username', email='$email', contact_no='$contactNum' WHERE id='$userid'");
        $stmt->bind_param("sssi", $username, $email, $contactNum, $userid);
        $stmt->execute();
        $updatedResults = $stmt->get_result();
        
        $stmt->close0;
        header("Location: UserProfilePage.php?user='. $userid . '");
    } else {
        header("Location: UserProfilePage.php?user='. $userSessionHelper->getUserInformation()['user_id'] . '");
    }
//    $file_name = $_FILES["imageInput"]["name"];
//    if(empty($file_name)) {
//        if(isset($_FILES['imageInput']['name'])) {
//
//            $file_type = $_FILES["imageInput"]["type"];
//            $file_size = $_FILES["imageInput"]["size"];
//            $file_tmp_name = $_FILES["imageInput"]["tmp_name"];
//            $upload_dir = 'uploads/'; // change this to your desired upload directory
//            $target_path = $upload_dir . $file_name;
//            if(move_uploaded_file($file_tmp_name, $target_path)) {
//                echo "inserted";
//                $query = "INSERT INTO user (profile_picture) VALUES(?)";
//
//                $result = mysqli_query($connection, $query);
//                header("Location: UserProfilePage.php");
//            } else {
//              echo "Error uploading file.";
//            }
//        }
//    } else {
//        
//        echo "updated";
//        $query = "UPDATE user SET profile_picture=? where id=?";
//        $result = mysqli_query($connection, $query);
//    }
}


?>
