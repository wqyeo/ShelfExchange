<?php

if ($_POST) {
    $userId = $_POST['user_id'];
    $bookId = $_POST['book_id'];

    include_once "php_util/util.php";
    $connection = createDatabaseConnection();
    deleteUserReview($connection, $userId, $bookId);

    header("Location: bookInformation.php?book=" . $bookId);
}

function deleteUserReview(mysqli $connection, int $userId, int $bookId): void
{
    $sql = "DELETE FROM review WHERE user_id = ? AND book_id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $userId, $bookId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
