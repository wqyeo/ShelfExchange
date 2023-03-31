<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "php_util/util.php";
    $connection = createDatabaseConnection();
    include_once "php_util/userSessionHelper.php";
    $userSessionHelper = new UserSessionHelper($connection);
    $userid = $userSessionHelper->getUserInformation()['user_id'];

// Verify user's current password first.
    $confirmPassword = $_POST['confirmpassword'];
    $statement = $connection->prepare("SELECT password FROM user WHERE id=?");
    $statement->bind_param("i", $userid);
    if (!$statement->execute()) {
// Failed to execute statement
        echo "Error: Failed to execute statement. Please try again later.";
        exit();
    }


// Get the password result and check if it exists
    $result = $statement->get_result();
    if ($result->num_rows != 1) {
// User not found or multiple users found
        echo "Error: User not found or multiple users found. Please contact support.";
        exit();
    }

// Fetch the password result and verify the password
    $confirmPasswordResult = $result->fetch_assoc();
    if (!password_verify($confirmPassword, $confirmPasswordResult['password'])) {
// Wrong password for confirmation
        echo "Error: The password entered for confirmation is incorrect. Please try again.";
        exit();
    }


    $statement->close();

    $username = $_POST['updateusername'];
    $email = $_POST['updateemail'];
    $contactNum = $_POST['updatecontact'];

    if ((!empty($username)) && !empty($email) && !empty($contactNum)) {
        $stmt = $connection->prepare("UPDATE user SET username=?, email=?, contact_no=? WHERE id=?");
        $stmt->bind_param("sssi", $username, $email, $contactNum, $userid);
        $stmt->execute();
        $updatedResults = $stmt->get_result();

        $stmt->close();
    }

    $newPassword = $_POST['updatepassword'];
// User wants to change password
    if (!empty($newPassword)) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $statement = $connection->prepare("UPDATE user SET password=? WHERE id=?");
        $statement->bind_param("si", $newHashedPassword, $userid);
        if (!$statement->execute()) {
// TODO: Statement failed
        }
        $statement->close();
    }

// If user gave a profile picture.
    if (isset($_FILES["imageInput"])) {
        $file = $_FILES["imageInput"];
        $file_name = $_FILES["imageInput"]["name"];

// Check if the uploaded file is an image
        $file_type = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($file_type, $allowed_types)) {
// create a unique directory for the user's profile picture.
            $directory = "/var/www/html/ShelfExchange/images/u" . $userid;
            createDirectoryIfNotExists($directory);

// full path to directory
            $upload_dir = "images/u" . $userid . "/";
            $file_path = $upload_dir . $file_name;
// Upload the file to the server
            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                updateProfilePicture($connection, $userid, $file_path);
            } else {
// TODO: Error uploading file
                echo "There was an error uploading the file: ";
                echo $_FILES["imageInput"]["error"];
            }
        } else {
// File is not an image;
        }
    }

    $connection->close();
    header("Location: UserProfilePage.php?user='. $userid . '");
}

function createDirectoryIfNotExists(string $directory) {
    if (!file_exists($directory)) {  // check if directory exists
        mkdir($directory);  // create directory if it doesn't exist
    }

    if (!is_writable($directory)) {  // check if directory is writable
        chmod($directory, 0777);  // set directory permissions to writable
    }
}

function updateProfilePicture(mysqli $connection, int $userId, string $picturePath): void {
    $query = "UPDATE user SET profile_picture=? WHERE id=?";
    $statement = $connection->prepare($query);
    $statement->bind_param("si", $picturePath, $userId);
    if ($statement->execute()) {
// TODO: done
    } else {
// TODO: Failure
    }
    $statement->close();
}
