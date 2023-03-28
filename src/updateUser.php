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

// Retrieve 
if(isset($_POST['updateID'])){
    $user_id = $_POST['updateID'];
    
    $sql = "SELECT * FROM user WHERE id=$user_id";
    $result = mysqli_query($conn, $sql);
    $response=array();
    while($row= mysqli_fetch_assoc($result)){
        $response = $row;
    }
    echo json_encode($response);
}else{
    $response['status']=200;
    $response['message']="Invalid or data not found";
}


// Update Query (still trying to make it work)
if(isset($_POST['updateUser'])){
    $uniqueid = $_POST['updateUser'];
    $name = $_POST['updateUsername'];
    $email = $_POST['updateEmail'];
    
    $sql = "UPDATE user SET username='$name', email='$email' where id='$uniqueid'";
    
    $result = mysqli_query($conn, $sql);
}

?>

