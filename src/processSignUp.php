        <?php
        $username = $contactNo = $pwd = $pwd_confirm = $email = $errorMsg = "";
        $success = true;
        
        if (empty($_POST["username"])) {                   
            $errorMsg .= "Username is required.<br>";
            $success = false;
        } else {
            $username = sanitize_input($_POST["username"]);
        }
        if (empty($_POST["contactNo"])) {
            $errorMsg .= "Contact Number is required.<br>";
            $success = false;
        } else{
            $contactNo = sanitize_input($_POST["contactNo"]);
        }
        if (empty($_POST["pwd"])) {                     
            $errorMsg .= "Password is required.<br>";
            $success = false;
        } else {
            $pwd = $_POST['pwd'];
            $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);
        }
        if (empty($_POST["pwd_confirm"])) {            //If the form value of pwd_confirm is not empty, then it will sanitize the input
            $errorMsg .= "Password confirmation required.<br>";
            $success = false;
        } elseif ($_POST["pwd"] === $_POST["pwd_confirm"]) {
        } else {
            $errorMsg .= "Password and confirm password are not the same!";
            $success = false;
        }

        if (empty($_POST["email"])) {
            $errorMsg .= "Email is required.<br>";
            $success = false;
        } else {
            $email = sanitize_input($_POST["email"]);
            // Additional check to make sure e-mail address is well-formed.
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMsg .= "Invalid email format.";
                $success = false;
            }
        }
        if ($success) {
            saveMemberToDB();
            echo "<h4>Registration successful!</h4>";
            echo "<p>Email: " . $email;
            echo "<p>Username: " . $username;
            echo '<form name="return" id="return" action="/ShelfExchange/signUp.php">';
            echo '<button class="btn btn-primary" type="submit">Return</button>';
            echo '</form>';
        } else {
            echo "<h4>The following input errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
            echo '<form name="return" id="return" action="/ShelfExchange/signUp.php">';
            echo '<button class="btn btn-danger" type="submit">Return</button>';
            echo '</form>';
        }

        //Helper function that checks input for malicious or unwanted content.
        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function null_or_empty($fieldName){
            return !isset($_POST[$fieldName]) || empty($_POST[$fieldName]);
        }
        
        //Helper function to write the member data to the DB
        function saveMemberToDB() {
            global $todayDate, $contactNo, $username, $email, $hashed_password, $errorMsg, $success;   //This is to access the global variables.
            
            $todayDate = date("Y/m/d");
// Create database connection.

            $config = parse_ini_file('../../private/db-config.ini');
            $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
            
// Check connection
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            } else {
                echo "Connected Successfully!"; // For testing connection
// Prepare the statement:
                $stmt = $conn->prepare("INSERT INTO user (email, username, password, joined_date, contact_no) VALUES (?, ?, ?, ?, ?)");
// Bind & execute the query statement:
                $stmt->bind_param("sssss", $email, $username, $hashed_password, $todayDate, $contactNo);
                if (!$stmt->execute()) {
                    echo "GG. Failed";
                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $success = false;
                    echo "GG. Failed2";
                }
                $stmt->close();
            }
            $conn->close();
        }
        
?>
