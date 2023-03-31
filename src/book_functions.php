<?php

error_reporting(0);
ini_set('display_errors', 0);
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */


include_once "php_util/util.php";

function getBooks(mysqli $conn)
{
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

function updateBook($bookId, $bookTitle, $bookReleaseDate, $image, $language_id, $description)
{
    // Create a connection to the database
    include_once "php_util/util.php";
    $conn = createDatabaseConnection();
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // If an image was uploaded, handle the image upload and get the new file path
    $uploadedImage = null;
    if ($image !== null && $image['size'] > 0) {
        $uploadedImage = uploadImage($image);
    }

    // Prepare and execute the SQL query to update the book
    $sql = "UPDATE shelf_exchange.book SET title=?, release_date=?, language_id=?, description=?"
            . ($uploadedImage !== null ? ", image=?" : "")
            . " WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($uploadedImage !== null) {
        $stmt->bind_param("ssissi", $bookTitle, $bookReleaseDate, $language_id, $description, $uploadedImage, $bookId);
    } else {
        $stmt->bind_param("ssisi", $bookTitle, $bookReleaseDate, $language_id, $description, $bookId);
    }

    if ($stmt->execute()) {
        // Return a success status and message
        return array('status' => 'success', 'message' => 'Book updated successfully!');
    } else {
        // Return an error status and message
        return array('status' => 'error', 'message' => 'Error updating book.');
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}

function uploadImage($image)
{
    $target_dir = "/var/www/html/ShelfExchange/images/books/";
    $target_file = $target_dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check file size (5MB limit)
    if ($image["size"] > 5000000) {
        echo "File is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "File not uploaded.";
    // If everything is ok, try to upload file
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $filepath = str_replace('/var/www/html/ShelfExchange/', '', $target_file);
            return $filepath;
        } else {
            echo "Error uploading file.";
        }
    }
    return null;
}

function addBook($bookTitle, $bookReleaseDate, $image, $language_id, $description)
{
    include_once "php_util/util.php";
    $conn = createDatabaseConnection();

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // If an image was uploaded, handle the image upload and get the new file path
    $uploadedImage = null;
    if ($image !== null && $image['size'] > 0) {
        $uploadedImage = uploadImage($image);
    }

    // Prepare and execute the SQL query to insert the book
    $sql = "INSERT INTO shelf_exchange.book SET title=?, release_date=?, language_id=?, description=?"
            . ($uploadedImage !== null ? ", image=?" : "");
    $stmt = $conn->prepare($sql);

    if ($uploadedImage !== null) {
        $stmt->bind_param("ssiss", $bookTitle, $bookReleaseDate, $language_id, $description, $uploadedImage);
    } else {
        $stmt->bind_param("ssis", $bookTitle, $bookReleaseDate, $language_id, $description);
    }

    if ($stmt->execute()) {
        // Return a success status and message
        return array('status' => 'success', 'message' => 'Book added successfully!');
    } else {
        // Return an error status and message
        return array('status' => 'error', 'message' => 'Error adding book.');
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['book-id'])) {
        $bookId = $_POST['book-id'];
        $bookTitle = $_POST['update-title'];
        $bookReleaseDate = $_POST['update-release-date'];
        $image = isset($_FILES['update-image']) ? $_FILES['update-image'] : null;
        $language_id = $_POST['update-language-id'];
        $description = $_POST['update-description'];

        if ($image['size'] > 0) {
            $response = updateBook($bookId, $bookTitle, $bookReleaseDate, $image, $language_id, $description);
        } else {
            $response = updateBook($bookId, $bookTitle, $bookReleaseDate, null, $language_id, $description);
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    } elseif (isset($_POST['add-title'])) {
        $bookTitle = $_POST['add-title'];
        $bookReleaseDate = $_POST['add-release-date'];
        $image = isset($_FILES['add-image']) ? $_FILES['add-image'] : null;
        $language_id = $_POST['add-language-id'];
        $description = $_POST['add-description'];

        if ($image['size'] > 0) {
            $response = addBook($bookTitle, $bookReleaseDate, $image, $language_id, $description);
        } else {
            $response = addBook($bookTitle, $bookReleaseDate, null, $language_id, $description);
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    } elseif (isset($_POST['book_id'])) {
        $book_id = $_POST['book_id'];

        include_once "php_util/util.php";
        $conn = createDatabaseConnection();
        // Check if connection was successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the SQL query to delete the book
        $sql = "DELETE FROM shelf_exchange.book WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $book_id);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }

        $stmt->close();
        $conn->close();
    }
}
