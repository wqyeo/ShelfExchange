<?php

include_once "php_util/util.php";
$connection = createDatabaseConnection();

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['deleteid'])) {
    $unique = $_POST['deleteid'];

    $sql="DELETE FROM user WHERE id=$unique";
    $result = mysqli_query($conn, $sql);
}
