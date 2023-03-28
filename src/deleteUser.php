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

if(isset($_POST['deleteid'])){
    $unique = $_POST['deleteid'];
    
    $sql="DELETE FROM user WHERE id=$unique";
    $result = mysqli_query($conn, $sql);
    
}
?>
