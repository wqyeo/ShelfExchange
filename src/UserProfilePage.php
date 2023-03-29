<!DOCTYPE html>

<?php
    
    
    include "php_util/util.php";
    $connection = createDatabaseConnection();    
    
?>
<html>
    <head>
        
        <title> <?php echo $row['username']; ?> Account</title>"
        
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
        ?>

        <main class="container rounded p-3 my-3 border"> 
            
            <div id='content'>
                <input type='hidden' name='id' value='<?php echo $row['id']; ?>'/>
                <a href='EditProfile.php?user=<?php echo $row['id']; ?>'><img src='images/editprof.png' class='rounded circle' style='height:20px; width:20px;'></a>
            </div>
            <h3 style='padding-top: 5px; padding-bottom: 10px;'> Welcome, <?php echo $row['username']; ?> </h3>
            
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
                        <p> Name: <?php echo $row['username']; ?>  </p>
                        <p> Email: <?php echo $row['email']; ?> </p>

                    </div>

                    <div class='col'> 
                        <h5> <b> About Me </b> </h5>
                        <p style='text-align:center;'> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
                    </div>
                    
                    <div class='col'>
                       <h5> <b> Settings </b> </h5>
<!--                       <p style='text-align:center;'> <a href='#' style='color: red;' 
                            onclick='deleteAcc(<?php echo $row['id']; ?>)'> Delete Account </a> </p>-->
                            <button type='button' class='btn btn-danger text-light' 
                                    onclick='deleteAcc(<?php echo $row['id']; ?>)'>  Delete Account </button>
                    </div>
                </div>
            </section>
            
        </main>
        <?php
            include "footer.php";
        ?>
    </body>
</html>

