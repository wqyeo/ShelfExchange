<!DOCTYPE html>

<?php
    // i think need persistent login so can fetch data based on email 
    // right now only fetch the first row in database
    $servername = "localhost";
    $dbusername = "shelfdev";
    $password = "lmao01234";
    $dbname = "shelf_exchange";

    // Create a connection to the database
    $conn = mysqli_connect($servername, $dbusername, $password, $dbname);
    $sel = "SELECT * FROM user";
    $query = mysqli_query($conn, $sel);
    $result = mysqli_fetch_assoc($query);
?>
<html>
    <head>
        
        <title> <?php echo $result['username']; ?> Account</title>"
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <link rel="stylesheet"
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity=
              "sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
        <!--<link rel="stylesheet" href="style.css" type="text/css"/>-->
        <link rel="stylesheet" href="css/userPage.css">

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
            
            <div id='content'>
                    <a href='EditProfile.php'> <img src='images/editprof.png' class='rounded circle' style='height:20px; width:20px;'> </a>
                </div>
            <h3 style='padding-top: 5px; padding-bottom: 10px;'> Welcome, <?php echo $result['username']; ?> </h3>
            
            <section id='profilepic' style='text-align:center;'>
                
                <figure>
  
                    <img class='img-thumbnail' src='images/genericprofpic.png' alt='profpic'>
                </figure>

            </section>
            
            <section id='personalinfo'> 
                <div class='row'> 
                    <div class='col'> 
                        <h5><b> Personal Information </b> </h5>
                        <!--<a href='#' style='font-size: 10px;'> Edit Profile </a>-->
                        <p> Name: <?php echo $result['username']; ?>  </p>
                        <p> Email: <?php echo $result['email']; ?> </p>

                    </div>

                    <div class='col'> 
                        <h5> <b> About Me </b> </h5>
                        <p style='text-align:center;'> Add a bio now! </p>
                    </div>
                    
                    <div class='col'>
                       <h5> <b> Settings </b> </h5>
                       <p style='text-align:center;'> <a href='#' style='color: red;'> Delete Account </a> </p>
                    </div>
                </div>
            </section>
            
        </main>
        <?php
            include "footer.php"
        ?>
    </body>
</html>

