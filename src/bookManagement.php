<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */

function getBooks() 
{
    //Create Database connection
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

    // SQL query to retrieve books
    $sql = "SELECT * FROM shelf_exchange.book";

    // Execute the query and store the results in a variable
    $books = mysqli_query($conn, $sql);

    // Check if any results were returned
    if (mysqli_num_rows($books) > 0) 
    {
        return $books;
    } 
    else 
    {
        echo "No results found.";
    }

    // Close the database connection
    mysqli_close($conn); 
}

function updateBook($bookId, $title, $image)
{
    //Create Database connection
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
    
    // Handle image upload
    if (!empty($image["name"])) 
    {
        $target_dir = "/var/www/html/ShelfExchange/images/";
        $target_file = $target_dir . basename($image["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($image["tmp_name"]);
        if ($check === false) 
        {
            die("File is not an image.");
        }
        
        // Check file size
        if ($image["size"] > 500000) 
        {
            die("File is too large.");
        }
        
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") 
        {
            die("Only JPG, JPEG, PNG & GIF files are allowed.");
        }
        
        // Upload file
        if (!move_uploaded_file($image["tmp_name"], $target_file)) 
        {
            die("Failed to upload file.");
        }
        
        // Set image path
        $image_path = $target_file;
    } 
    else 
    {
        // Use existing image path
        $image_path = "";
    }
    
    // Prepare update statement
    $sql = "UPDATE shelf_exchange.book SET title=?, image=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssi", $title, $image_path, $bookId);

    // Execute statement
    $result = mysqli_stmt_execute($stmt);

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    // Check if update was successful and return appropriate response
    if ($result) 
    {
      echo "Book updated successfully";
    } else 
    {
      echo "Error updating book";
    }

    // Add console.log statements to check if function is being called correctly
    error_log("updateBook called with bookId: ".$bookId.", title: ".$title.", releaseDate: ".$releaseDate.", image: ".$image);
    error_log("Query executed: ".$query);

    return $result;
}