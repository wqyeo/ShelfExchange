<!DOCTYPE html>
<?php 

    include "php_util/util.php";
    $connection = createDatabaseConnection();  
    
    
?>
<html>
    <head>
        <title>Edit Profile</title>
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
        <script defer src="js/updateOrDelUserAcc.js"></script>

    </head>
    <body>
        <?php
        include "nav.php";
        ?>
        <?php
            // checks if user is logged in
            if (isset($userSessionHelper) && $userSessionHelper->isLoggedIn()) {
                $id = $userSessionHelper->getUserInformation()['user_id'];
                $sel = $connection->prepare("SELECT * FROM user WHERE id=?");
                $sel->bind_param("i", $id);
                $sel->execute();
                $result = $sel->get_result();
                if ($result->num_rows > 0){
                    $row = $result->fetch_assoc(); 
                }
            }
            else {
                header("Location: login.php");
            }
            
            // update profile not working, will continue tmr night
            
        ?>
        
        <main class="container rounded p-3 my-3 border"> 
            <h2> Edit Profile </h2>
            <form action="updateProfile.php" method="POST">
                <input type="hidden" id="userID" value="<?php echo $row['id']; ?>">
                <div class="form-group"> 
                    <label for="username">Username:</label>
                    <input class="form-control" type="text" maxlength="45" id="updateusername" name="updateusername"
                        value='<?php echo $row['username'];?>'>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" id="updateemail" name="updateemail"
                        value='<?php echo $row['email'];?>'>
                </div>
                
                <div class="form-group">
                    <label for="contactno">Contact No:</label>
                    <input class="form-control" type="text" id="updatecontact" name="updatecontact"
                        value='<?php echo $row['contact_no'];?>'>
                </div>
                
<!--                <div class="mb-3">
                    <label for="profpic">Profile Picture:</label>
                    <input class="form-control" type="file" id="updateprofpic" name="updateprofpic"
                        value='<?php echo $row['profile_picture'];?>'>
                </div>-->

                <div class="form-group"> 
                    <button class="btn btn-primary" type="submit" name='updateProf'>Save Changes</button>
                    <button class="btn btn-danger"> <a href="UserProfilePage.php?user=<?php echo $row['id']; ?>" class="text-light"> Cancel </a></button>
                    
                </div>
            </form>
            
        </main>
        <?php
            include "footer.php"
        ?>
    </body>
</html>