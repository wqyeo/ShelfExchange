<?php
include "php_util/util.php";
$connection = createDatabaseConnection();
include_once "php_util/userSessionHelper.php";
$userSessionHelper = new UserSessionHelper($connection);


if (isset($_POST['updateProf'])) {
    $userid = $userSessionHelper->getUserInformation()['user_id'];
    $username = $_POST['updateusername'];
    $email = $_POST['updateemail'];
    $contactNum = $_POST['updatecontact'];

    if ((!empty($username)) && !empty($email) && !empty($contactNum)) {
        $stmt = $connection->prepare("UPDATE user SET username='$username', email='$email', contact_no='$contactNum' WHERE id='$userid'");
        $stmt->bind_param("sssi", $username, $email, $contactNum, $userid);
        $stmt->execute();
        $updatedResults = $stmt->get_result();
        
        header("Location: UserProfilePage.php?user='. $userid . '");
    } else {
        header("Location: UserProfilePage.php?user='. $userSessionHelper->getUserInformation()['user_id'] . '");
    }
}

?>
