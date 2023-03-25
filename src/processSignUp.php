<?php
require 'php_error_models/signUpErrorCode.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present and not empty
    if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"])) {
        redirectWithError(SignUpErrorCode::MISSING_FIELDS);
        exit();
    }

    // Sanitize and validate the username
    $usernameValidated = tryGetValidatedUsername();
    $emailValidated = tryGetValidatedEmail();
    $passwordValidated = tryGetValidatedPassword();

    saveNewUser($usernameValidated, $passwordValidated, $emailValidated);

    header("Location: login.php?success=signup_complete");
    exit();
} else {
    // Form was not submitted, redirect to the signup page
    header("Location: signUp.php");
    exit();
}

function tryGetValidatedUsername()
{
    $username = filter_var(trim($_POST["username"]), FILTER_SANITIZE_STRING);
    $usernameLength = strlen($username);
    if ($usernameLength < 4 || $usernameLength > 45) {
        redirectWithError(SignUpErrorCode::USERNAME_INPUT_INVALID);
        exit();
    }
    return $username;
}

function tryGetValidatedEmail()
{
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirectWithError(SignUpErrorCode::EMAIL_INPUT_INVALID);
        exit();
    }
    return $email;
}

function tryGetValidatedPassword()
{
    $password = $_POST["password"];
    $passwordLength = strlen($password);
    if ($passwordLength < 8 || $passwordLength > 64) {
        redirectWithError(SignUpErrorCode::PASSWORD_INPUT_INVALID);
        exit();
    }
    return $password;
}

function saveNewUser($newUsername, $newPassword, $newEmail)
{

    require 'php_util/util.php';
    $connection = createDatabaseConnection();
    if ($connection->connect_error) {
        redirectWithError(SignUpErrorCode::CONNECTION_FAILED);
        echo "1";
        exit();
    }
    echo "1";

    $todayDate = getCurrentDate();
    echo "1";
    $statement = prepareBindedInsertUserStatement($connection, $newEmail, $newUsername, $newPassword, $todayDate);
    echo "1";
    if (!$statement->execute()) {
        // TODO: Error message should be recorded into a log file that can be readed from server.
        //$errorMsg = "Execute failed: (" . $statement->errno . ") " . $statement->error;
        redirectWithError(SignUpErrorCode::CONNECTION_FAILED_STATEMENT_ERROR);
        exit();
    }
    $statement->close();
    $connection->close();
}

// Prepares a SQL statement to insert new user, and binds the given input
// NOTE: This function will input password.
// Returns, the statement.
function prepareBindedInsertUserStatement($connection, $email, $username, $rawPassword, $joinedDate)
{
    $stmt = $connection->prepare("INSERT INTO user (email, username, password, joined_date) VALUES (LOWER(?), ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $username, password_hash($rawPassword, PASSWORD_DEFAULT), $joinedDate);
    return $stmt;
}

function redirectWithError(String $errorCode): void
{
    header("Location: signUp.php?error=" . urlencode($errorCode));
}
