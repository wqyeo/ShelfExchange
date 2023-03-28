<?php                                                        
    //fetch.php  
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
    if(isset($_POST["userId"]))  
    {  
        $query = "SELECT * FROM shelf_exchange.user WHERE id '".$_POST["userId"]."'";  
        $result = mysqli_query($conn, $query);  
        $row = mysqli_fetch_array($result);  
        echo json_encode($row);  
    }  
 ?>