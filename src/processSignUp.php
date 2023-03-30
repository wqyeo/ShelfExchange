<?php

require 'php_error_models/signUpErrorCode.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present and not empty
    if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["lname"]) || empty($_POST["contactNo"])) {
        redirectWithError(SignUpErrorCode::MISSING_FIELDS);
        exit();
    }

    // Sanitize and validate the username
    $usernameValidated = tryGetValidatedUsername();
    $emailValidated = tryGetValidatedEmail();
    $passwordValidated = tryGetValidatedPassword();
    $fnameValidated = tryGetValidatedFname();
    $lnameValidated = tryGetValidatedLname();
    $contactNoValidated = tryGetValidatedContactNo();

    saveNewUser($usernameValidated, $passwordValidated, $emailValidated, $fnameValidated, $lnameValidated, $contactNoValidated);

    header("Location: login.php?success=signup_complete");
    exit();
} else {
    // Form was not submitted, redirect to the signup page
    header("Location: signUp.php");
    exit();
}

function tryGetValidatedFname()
{
    $fname = filter_var(trim($_POST["fname"]), FILTER_SANITIZE_STRING);
    $fnameLength = strlen($fname);
    if ($fnameLength < 1 || $fnameLength > 45) {
        redirectWithError(SignUpErrorCode::FNAME_INPUT_INVALID);
        exit();
    }
    return $fname;
}

function tryGetValidatedLname()
{
    $lname = filter_var(trim($_POST["lname"]), FILTER_SANITIZE_STRING);
    $lnameLength = strlen($lname);
    if ($lnameLength < 4 || $lnameLength > 45) {
        redirectWithError(SignUpErrorCode::LNAME_INPUT_INVALID);
        exit();
    }
    return $lname;
}
function tryGetValidatedContactNo()
{
    $contactNo = filter_var(trim($_POST["contactNo"]), FILTER_SANITIZE_STRING);
    $contactNoLength = strlen($contactNo);
    if ($contactNoLength < 4 || $contactNoLength > 45) {
        redirectWithError(SignUpErrorCode::CONTACTNO_INPUT_INVALID);
        exit();
    }
    return $contactNo;
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

function saveNewUser($newUsername, $newPassword, $newEmail, $newFname, $newLname, $newContactNo)
{
    require 'php_util/util.php';
    $connection = createDatabaseConnection();
    if ($connection->connect_error) {
        redirectWithError(SignUpErrorCode::CONNECTION_FAILED);
        exit();
    }

    // Check if an account with same username/exists first.
    $errorCode = accountExists($connection, $newUsername, $newEmail);
    if ($errorCode != null) {
        redirectWithError($errorCode);
        exit();
    }

    $todayDate = getCurrentDate();
    $statement = prepareBindedInsertUserStatement($connection, $newEmail, $newUsername, $newPassword, $todayDate, $newFname, $newLname, $newContactNo);
    if (!$statement->execute()) {
        // TODO: Error message should be recorded into a log file that can be readed from server.
        //$errorMsg = "Execute failed: (" . $statement->errno . ") " . $statement->error;
        redirectWithError(SignUpErrorCode::CONNECTION_FAILED_STATEMENT_ERROR);
        exit();
    }
    $statement->close();
    $connection->close();
}

/**
 * check if username exists in the database
    *
    * Returns a SignUpErrorCode string, null if no duplicates or error.
    */
function accountExists($connection, string $username, string $email): string
{
    $statement = $connection->prepare("SELECT * FROM user WHERE username = ? OR email = LOWER(?)");
    $statement->bind_param("ss", $username, $email);

    // Statement failed to execute
    if (!$statement->execute()) {
        return SignUpErrorCode::CONNECTION_FAILED_STATEMENT_ERROR;
    }

    $errorCode = '';
    $result = $statement->get_result();
    // There are entries with the same username/email exists
    if ($result->num_rows > 0) {
        // Check which is the duplicate.
        while ($row = $result->fetch_assoc()) {
            if ($row['username'] == $username) {
                $errorCode = SignUpErrorCode::USERNAME_USED;
            }
            if ($row['email'] == $email) {
                $errorCode = SignUpErrorCode::EMAIL_USED;
            }

            if ($errorCode != null) {
                // There is already an error,
                // break out of loop to return it.
                break;
            }
        }
    }
    $statement->close();
    return $errorCode;
}

// Prepares a SQL statement to insert new user, and binds the given input
// NOTE: This function will input password.
// Returns, the statement.
function prepareBindedInsertUserStatement($connection, $email, $username, $rawPassword, $joinedDate, $fname, $lname, $contactNo)
{
    $statement = $connection->prepare("INSERT INTO user (email, username, password, joined_date, fname, lname, contact_no) VALUES (LOWER(?), ?, ?, ?, ?, ?, ?)");
    $statement->bind_param("sssssss", $email, $username, password_hash($rawPassword, PASSWORD_DEFAULT), $joinedDate, $fname, $lname, $contactNo);
    return $statement;
}

function redirectWithError(String $errorCode): void
{
    header("Location: signUp.php?error=" . urlencode($errorCode));
}
