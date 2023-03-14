<!DOCTYPE html>

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
            <div id="content">
                <a href="EditProfile.php"> <img src="images/editprof.png" class="rounded circle" style="height:20px; width:20px;"> </a>
            </div>
            <h3 style="padding-top: 5px; padding-bottom: 10px;"> Welcome, (Username) </h3>
            
            <section id="profilepic" style="text-align:center;">
                
                <figure>
  
                    <img class="img-thumbnail" src="images/genericprofpic.png" alt="Poodle"
                         title="View larger image..."/>
                </figure>

            </section>
            
            <section id="personalinfo"> 
                <div class="row"> 
                    <div class="col"> 
                        <h5><b> Personal Information </b> </h5>
                        <!--<a href="#" style="font-size: 10px;"> Edit Profile </a>-->
                        <p> Name: (Name) </p>
                        <p> Email: (Email) </p>

                    </div>

                    <div class="col"> 
                        <h5> <b> About Me </b> </h5>
                        <p style="text-align:center;"> Add a bio now! </p>
                    </div>
                    
                    <div class="col">
                       <h5> <b> Settings </b> </h5>
                       <p style="text-align:center;"> <a href="#" style="color: red;"> Delete Account </a> </p>
                    </div>
                </div>
            </section>
            
        </main>

    </body>
</html>

