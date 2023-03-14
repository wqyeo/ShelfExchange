<?php
    // Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
        // Check if all required fields are present and not empty
        if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"])) {
            header("Location: signUp.php?error=missing_fields");
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
    
    function tryGetValidatedUsername(){
        $username = filter_var(trim($_POST["username"]), FILTER_SANITIZE_STRING);
        if (strlen($username) < 4) {
            header("Location: signUp.php?error=username_short");
            exit();
        }
        if (strlen($username) > 45) {
            header("Location: signUp.php?error=username_long");
            exit();
        }
        return $username;
    }
    
    function tryGetValidatedEmail(){
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: signUp.php?error=email_invalid");
            exit();
        }
        return $email;
    }
    
    function tryGetValidatedPassword(){
        $password = $_POST["password"];
        if (strlen($password) < 8) {
            header("Location: signUp.php?error=password_short");
            exit();
        }
        if (strlen($password) > 64) {
            header("Location: signUp.php?error=password_long");
            exit();
        }
        return $password;
    }
    
    function saveNewUser($newUsername, $newPassword, $newEmail){
        $connection = createDatabaseConnection();
        if ($connection->connect_error) {
            header("Location: signUp.php?error=connection_failed($connection->connect_error)");
            exit();
        }
        
        $todayDate = getCurrentDate();
        $statement = prepareBindedInsertUserStatement($connection, $newEmail, $newUsername, $newPassword, $todayDate);
        if (!$statement->execute()) {
            // TODO: Error message should be recorded into a log file that can be readed from server.
            //$errorMsg = "Execute failed: (" . $statement->errno . ") " . $statement->error;
            header("Location: signUp.php?error=connection_failed(FATAL)");
            exit();
        }
        $statement->close();
        $connection->close();
    }
    
    // Prepares a SQL statement to insert new user, and binds the given input
    // NOTE: It this function will input password.
    // Returns, the statement.
    function prepareBindedInsertUserStatement($connection, $email, $username, $rawPassword, $joinedDate) {
        $stmt = $connection->prepare("INSERT INTO user (email, username, password, joined_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $username, password_hash($rawPassword, PASSWORD_DEFAULT), $joinedDate);
        return $stmt;
    }
    
    function getCurrentDate() {
        date_default_timezone_set('Asia/Singapore');
        return date('Y-m-d');
    }
    
    function createDatabaseConnection() {
        $config = parse_ini_file('../../private/db-config.ini');
        return new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    }
        
?>
