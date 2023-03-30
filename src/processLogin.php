<?php

    require 'php_error_models/loginErrorCode.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all required fields are present and not empty
        if (empty($_POST["email"]) || empty($_POST["password"])) {
            redirectWithError(LoginErrorCode::MISSING_FIELDS);
            exit();
        }

        $emailValidated = tryGetValidatedEmail();
        $passwordValidated = tryGetValidatedPassword();

        $rowResult = authenticateUser($emailValidated, $passwordValidated);
        // TODO: Link to accounts page
        //header("Location: login.php?success=login_complete");
        header("Location: UserProfilePage.php?success=login_complete");
        exit();
    } else {
        // Form was not submitted
        header("Location: login.php");
        exit();
    }

    function tryGetValidatedPassword(): string
    {
        $password = $_POST["password"];
        if (!$password) {
            redirectWithError(LoginErrorCode::PASSWORD_INPUT_INVALID);
            exit();
        }
        return $password;
    }

    function tryGetValidatedEmail(): string
    {
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirectWithError(LoginErrorCode::EMAIL_INPUT_INVALID);
            exit();
        }
        return strtolower($email);
    }

    function authenticateUser(string $email, string $password)
    {
        require 'php_util/util.php';
        $connection = createDatabaseConnection();
        if ($connection->connect_error) {
            redirectWithError(LoginErrorCode::CONNECTION_FAILED);
            exit();
        }

        $statement = prepareBindedFindUserStatement($connection, $email);
        if (!$statement->execute()) {
            // TODO: Error message should be recorded into a log file that can be readed from server.
            //$errorMsg = "Execute failed: (" . $statement->errno . ") " . $statement->error;
            redirectWithError(LoginErrorCode::CONNECTION_FAILED_STATEMENT_ERROR);
            exit();
        }
        // Fetch result from executed statement
        $result = $statement->get_result();
        if ($result-> num_rows <= 0) {
            // Shouldn't have empty results, likely failed due to email not found.
            redirectWithError(LoginErrorCode::EMAIL_ACCOUNT_NOT_FOUND);
            exit();
        }

        // Since email bind to accounts are unique,
        // we can just fetch the first associated row.
        $row = $result->fetch_assoc();
        $statement->close();

        $hashedPassword = $row["password"];
        if (!password_verify($password, $hashedPassword)) {
            // Password mismatch;
            redirectWithError(LoginErrorCode::PASSWORD_INCORRECT);
            exit();
        }

        include "php_util/userSessionHelper.php";
        $userSessionHelper = new UserSessionHelper($connection);
        $userSessionHelper->createNewUserSession($row['id'], $row['username'], $row['profile_picture']);

        $connection->close();
        return $row;
    }

    // Prepare a SQL statement that finds the user by email
    function prepareBindedFindUserStatement($connection, string $email)
    {
        $stmt = $connection->prepare("SELECT * FROM user WHERE LOWER(email)=?");
        $stmt->bind_param("s", $email);
        return $stmt;
    }

    function redirectWithError(string $errorCode): void
    {
        header("Location: login.php?error=" . urlencode($errorCode));
    }
