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

function updateBook($bookId, $bookTitle, $bookReleaseDate, $image) {
    // Create Database connection
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

    // If an image was uploaded, handle the image upload and get the new file path
    $uploadedImage = null;
    if ($image !== null && $image['size'] > 0) {
        $uploadedImage = uploadImage($image);
    }

    // Prepare and execute the SQL query to update the book
    $sql = "UPDATE shelf_exchange.book SET title=?, release_date=?"
            . ($uploadedImage !== null ? ", image=?" : "")
            . " WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($uploadedImage !== null) {
        $stmt->bind_param("sssi", $bookTitle, $bookReleaseDate, $uploadedImage, $bookId);
    } else {
        $stmt->bind_param("ssi", $bookTitle, $bookReleaseDate, $bookId);
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

function uploadImage($image) {
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

function addBook($bookTitle, $bookReleaseDate, $bookDescription, $bookLanguageId, $image) {
    // Create Database connection
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

    // If an image was uploaded, handle the image upload and get the new file path
    $uploadedImage = null;
    if ($image !== null && $image['size'] > 0) {
        $uploadedImage = uploadImage($image);
    }

    // Prepare and execute the SQL query to add the book
    $sql = "INSERT INTO shelf_exchange.book (title, release_date, description, language_id" . ($uploadedImage !== null ? ", image" : "") . ") VALUES (?, ?, ?, ?" . ($uploadedImage !== null ? ", ?" : "") . ")";
    $stmt = $conn->prepare($sql);

    if ($uploadedImage !== null) {
        $stmt->bind_param("sssi", $bookTitle, $bookReleaseDate, $bookDescription, $bookLanguageId, $uploadedImage);
    } else {
        $stmt->bind_param("sssi", $bookTitle, $bookReleaseDate, $bookDescription, $bookLanguageId);
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

        if ($image['size'] > 0) {
            $response = updateBook($bookId, $bookTitle, $bookReleaseDate, $image);
        } else {
            $response = updateBook($bookId, $bookTitle, $bookReleaseDate, null);
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    } elseif (isset($_POST['book_id'])) {
        $book_id = $_POST['book_id'];

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
