<?php

if (isset($_POST['deleteid'])) {
    include_once "php_util/util.php";
    $connection = createDatabaseConnection();

    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $unique = $_POST['deleteid'];

    $sql="DELETE FROM user WHERE id=?";
    $statement = $connection->prepare($sql);
    $statement->bind_param("i", $unique);

    if ($statement->execute()) {
        //success
    }
    $statement->close();
    $connection->close();
}
