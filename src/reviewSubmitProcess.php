<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
if ($_POST) {
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    $userId = $_POST['user_id'];
    $bookId = $_POST['book_id'];

    include_once "php_util/util.php";
    $connection = createDatabaseConnection();
    $success = addReview($connection, $review, $rating, $userId, $bookId);

    // todo: if success is false;
    $connection->close();
    header("Location: bookInformation.php?book=". $bookId);
}


function addReview($connection, $review, $rating, $userId, $bookId): bool
{
    // Create SQL statement
    $sql = "INSERT INTO review (created_at, comment, rating, user_id, book_id) 
            VALUES (NOW(),?,?,?,?)";
    // Prepare and bind
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("siii", $review, $rating, $userId, $bookId);

    $stmt->execute();

    if (!$stmt->affected_rows) {
        return false;
    }

    $stmt->close();
    return true;
}
