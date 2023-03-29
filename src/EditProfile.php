<!DOCTYPE html>
<?php 

    include "php_util/util.php";
    $connection = createDatabaseConnection();
    include_once "php_util/userSessionHelper.php";
    $userSessionHelper = new UserSessionHelper($connection);
    
    $query = "SELECT * FROM shelf_exchange.user";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);    
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
        <script defer src="js/main.js"></script>

    </head>
    <body>
        <?php
        include "nav.php";
        ?>
        
        
        <main class="container rounded p-3 my-3 border"> 
            <h2> Edit Profile </h2>
            <form action="#" method="POST">
                <input type='hidden' name='id' value='<?php echo $row['id'];?>'/>
                <div class="form-group"> 
                    <label for="username">Name:</label>
                    <input class="form-control" type="text" maxlength="45" id="username" name="username"
                        value='<?php echo $row['username'];?>'>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" required id="email" name="email"
                        value='<?php echo $row['email'];?>'>
                </div>

                <div class="form-group"> 
                    <button class="btn btn-primary" type="submit" name='update'>Save Changes</button>
                    <button class="btn btn-danger"> <a href="UserProfilePage.php" class="text-light"> Cancel </a></button>
                </div>
            </form>
            
        </main>
        <?php
            include "footer.php"
        ?>
    </body>
</html>