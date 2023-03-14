<!DOCTYPE html>
<?php

    $fname = $lname = $email = $pwd_hashed = $errorMsg = "";
    $success = true;

    //fname
    if (!empty(filter_input(INPUT_POST, 'fname'))) {
        $fname = sanitize_input(filter_input(INPUT_POST, 'fname'));
        $success = true;
    }


    //email
    if (empty(filter_input(INPUT_POST, 'email'))) {
        $errorMsg .= "Email is required.<br>";
        $success = false;
    } else {
        $email = sanitize_input(filter_input(INPUT_POST, 'email'));

        // Additional check to make sure e-mail address is well-formed.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format.";
            $success = false;
        }
    }

    //password
    if (empty($_POST["pwd"]))
    {
        $errorMsg .= "Password is required. ";
        $success = false;

    }
    
    if ($success) {
        updateDB();
    }


    //Helper function that checks input for malicious or unwanted content.
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    // Helper function to write the member data to the DB

//    function saveMemberToDB()
//    {
//        global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success;
//        // Create database connection.
//        $config = parse_ini_file('../../private/db-config.ini');
//        $conn = new mysqli($config['servername'], $config['username'],
//        $config['password'], $config['dbname']);
//        // Check connection
//        if ($conn->connect_error)
//        {
//            $errorMsg = "Connection failed: " . $conn->connect_error;
//            $success = false;
//        }
//        else
//        {
//            // Prepare the statement:
//            $stmt = $conn->prepare("UPDATE world_of_pets_members SET fname= WHERE id=");
//            // Bind & execute the query statement:
//            $stmt->bind_param("ssss", $fname, $lname, $email, $pwd_hashed);
//            if (!$stmt->execute())
//            {
//                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
//                $success = false;
//            }
//                $stmt->close();
//
//            }
//            $conn->close();
//    }
        
    function updateDB(){
        global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success;
        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'],
        $config['password'], $config['dbname']);
        if ($conn->connect_error)
        {
            $errorMsg = "Connection failed: " . $conn->connect_error;
            $success = false;
        }
        else {
            if (count($_POST)> 0) {
                $sql = "UPDATE world_of_pets_members SET fname='" . $_POST['fname'] . "', "
                        . "email='" . $_POST['email'] . "', "
                        . "pwd='" . $_POST['pwd'] . "' WHERE member_id='" . $_POST['member_id'] . "'";
                $result = mysqli_query($conn, $sql);
                if ($result === false) {
                    echo "Error updating db: " . mysqli_error($conn);
                }
                else {
                    echo "data updated successfully";
                }
            } else {
                $errorMsg = "failed";
            }
        }
    }
?>

<html>
    <head>
        <title>World of Pets</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <link rel="stylesheet"
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity=
              "sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
        <!--<link rel="stylesheet" href="style.css" type="text/css"/>-->
        <link rel="stylesheet" href="css/main.css">

        <!--jQuery-->
        <script defer
                src="https://code.jquery.com/jquery-3.4.1.min.js"
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
                crossorigin="anonymous">
        </script>
        <!--Bootstrap JS-->
        <script defer
                src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
                crossorigin="anonymous">
        </script>

        <!-- Custom JS -->
        <script defer src="js/main.js"></script>

    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        
        
        
        <main class="container rounded p-3 my-3 border"> 
            <h2> Edit Profile </h2>
            <form action="UserPage.php" method="POST">
                
                <div class="form-group"> 
                    <label for="fname">Name:</label>
                    <input class="form-control" type="text" maxlength="45" id="fname" name="fname"
                        >
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" required id="email" name="email"
                        >
                </div>

                <div class="form-group">  
                    <label for="pwd">Password:</label>
                    <input class="form-control" type="password" required id="pwd" name="pwd"
                        >
                </div>

                <div class="form-group"> 
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                </div>
                
            </form>
            
        </main>
        
    </body>
</html>



