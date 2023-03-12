
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"crossorigin="anonymous">
        <!--jQuery-->
        <script defer src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <!--Bootstrap JS-->
        <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
        <!-- Custom JS -->
        <script defer src="js/main.js"></script>
        <link rel="stylesheet" href="css/main.css">
        <title>ShelfExchange</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        $username = $contactNo = $pwd = $pwd_confirm = $email = $errorMsg = "";
        $success = true;
        
        if (empty($_POST["username"])) {                   //If the form value of lname is not empty, then it will sanitize the input
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
        if (empty($_POST["pwd"])) {                     //If the form value of pwd is not empty, then it will sanitize the input
            $errorMsg .= "Password is required.<br>";
            $success = false;
        } else {
            //Do hashing
            $pwd = $_POST['pwd'];
            $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);
            //var_dump($hashed_password); //This is to check if the password is hashed by displaying it out.
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
        
        //Helper function to write the member data to the DB
        function saveMemberToDB() {
            global $todayDate, $contactNo, $username, $email, $hashed_password, $errorMsg, $success;   //This is to access the global variables.
            
            $todayDate = date("Y/m/d");
// Create database connection.
          /**  
            $config = parse_ini_file('../../private/db-config.ini');
            $conn = new mysqli($config['servername'], $config['username'],
                    $config['password'], $config['dbname']); 
          **/
            $servername = "localhost";
            $dbusername = "root";
            $password = "lmaozedongs01";
            $dbname = "shelf_exchange";
            
            $conn = new mysqli($servername, $dbusername, $password, $dbname); //The arguments are the database credentials
            
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
        
        <main>
        </main>
    </body>
</html>