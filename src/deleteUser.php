<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

if (isset($_POST['deleteid'])) {
    include_once "php_util/util.php";

    if (!isset($connection) || $connection) {
        $connection = createDatabaseConnection();
    }

    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $unique = $_POST['deleteid'];

    $sql="DELETE FROM user WHERE id=?";
    $statement = $connection->prepare($sql);
    $statement->bind_param("i", $unique);

    if ($statement->execute()) {
    } else {
    }
    $statement->close();
    $connection->close();
}
