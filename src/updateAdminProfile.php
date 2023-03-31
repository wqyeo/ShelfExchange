<?php
include "php_util/util.php";
$connection = createDatabaseConnection();
include_once "php_util/userSessionHelper.php";
$userSessionHelper = new UserSessionHelper($connection);

    $userid = $userSessionHelper->getUserInformation()['user_id'];
if (isset($_POST['updateAdminProf'])) {
    $username = $_POST['updateAdminUsername'];
    $email = $_POST['updateAdminEmail'];
    $contactNum = $_POST['updateAdminContact'];

    if ((!empty($username)) && !empty($email) && !empty($contactNum)) {
        $stmt = $connection->prepare("UPDATE user SET username='$username', email='$email', contact_no='$contactNum' WHERE id='$userid'");
        $stmt->bind_param("sssi", $username, $email, $contactNum, $userid);
        $stmt->execute();
        $updatedResults = $stmt->get_result();
        
        $stmt->close0;
        header("Location: adminPage.php");
    } else {
        header("Location: adminPage.php");
    }

}
?>
