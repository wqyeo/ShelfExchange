<?php

$servername = "localhost";
$dbusername = "shelfdev";
$password = "lmao01234";
$dbname = "shelf_exchange";

// Create a connection to the database
$conn = mysqli_connect($servername, $dbusername, $password, $dbname);

// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}

extract($_POST);

if(isset($_POST['sendEmail']) && isset($_POST['sendName']) && isset($_POST['sendPassword'])){
    $sql = "INSERT INTO user (email, username, password) VALUES ('$sendEmail', '$sendName', '$sendPassword')";
    
    $result = mysqli_query($conn, $sql);
}

?>

