<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

// Define database connection parameters
$servername = "localhost";
$dbusername = "shelfdev";
$password = "lmao01234";
$dbname = "shelf_exchange";

// Create database connection
$conn = new mysqli($servername, $dbusername, $password, $dbname);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getBooks() {
    //Create Database connection
    $servername = "localhost";
    $dbusername = "shelfdev";
    $password = "lmao01234";
    $dbname = "shelf_exchange";

    // Create a connection to the database
    $conn = mysqli_connect($servername, $dbusername, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // SQL query to retrieve books
    $sql = "SELECT * FROM shelf_exchange.book";

    // Execute the query and store the results in a variable
    $books = mysqli_query($conn, $sql);

    // Check if any results were returned
    if (mysqli_num_rows($books) > 0) {
        return $books;
    } else {
        echo "No results found.";
    }

    // Close the database connection
    mysqli_close($conn);
}
