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
        <title>World of Pets</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        
        $username = $pwd = $pwd_confirm = $email = $errorMsg = "";
        $success = true;
        
        $email = $_POST["email"];
        
        authenticateUser();
        if ($success) {
            echo "<h4>Login successful!</h4>";
            echo "<p>Welcome back: " . $username;
            echo '<form name="returnhome" id="returnhome" action="/ShelfExchange/login.php">'; //Later will need to configure to log in as admin or user
            echo '<button class="btn btn-primary" type="submit">Return</button>';
            echo '</form>';
        } else {
            echo "<h4>The following input errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
            echo '<form name="return" id="return" action="/ShelfExchange/login.php">';
            echo '<button class="btn btn-danger" type="submit">Return</button>';
            echo '</form>';
        }
        
        function authenticateUser(){
            global $username, $email, $pwd_hashed, $errorMsg, $success;
            
            //Create Database connection
            $servername = "localhost";
            $dbusername = "root";
            $password = "lmaozedongs01";
            $dbname = "shelf_exchange";
            
            $conn = new mysqli($servername, $dbusername, $password, $dbname); //The arguments are the database credentials
            
            //Check connection
            if($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            }
            else{
                //Prepare the statement
                $stmt = $conn->prepare("SELECT * FROM user WHERE email=?");
                //Bind & execute the query statement
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows > 0){
                    // Take note that email field is unique, so should only have one row in the result set
                    $row = $result->fetch_assoc();
                    $username = $row["username"];
                    $pwd_hashed = $row["password"];
                    
                    //Check if the password matches:
                    if(!password_verify($_POST["pwd"], $pwd_hashed)){
                        // Dont need to be so specific with the error message - hackers dont need to know what they got right or wrong.
                        $errorMsg = "Email not found or password doesn't match...";
                        $success = false;
                    }
                }
                else{
                    $errorMsg = "Email not found or password doesn't match...";
                    $success = false;
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