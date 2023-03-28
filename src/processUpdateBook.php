<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require 'php_util/util.php';
$conn = createDatabaseConnection();

$sql = "UPDATE shelf_exchange.books WHERE id=";

if (isset($POST['update_book']))
{
    $id = $POST['book-id'];
    $title = $POST['update-title'];
    $release_date = $POST['update-release_date'];
    $image = $POST['update-image'];      
    
    $sql = "UPDATE shelf_exchange.books SET title = $title, release_date = $release_date, image = $image WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) 
    {
        // Display a success message
        echo "Listing updated successfully!";
    } else 
    {
        // Display an error message
        echo "Error updating listing: " . mysqli_error($conn);
    }
}
?>