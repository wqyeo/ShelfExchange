<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html lang="en">
    <?php
        include "nav.php"
    ?>
    <head>
        <title>Admin Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
        
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
        
        <!-- Custom JS & CSS -->
        <script defer src="js/main.js"></script>
        <link rel="stylesheet" href="css/adminPage.css">
    </head>
    
    <body>
        <?php
        function getBooks() 
        {
            //Create Database connection
            $servername = "localhost";
            $dbusername = "root";
            $password = "lmaozedongs01";
            $dbname = "shelf_exchange";
            
            // Create a connection to the database
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            // Check connection
            if (!$conn) 
            {
                die("Connection failed: " . mysqli_connect_error());
            }

            // SQL query to retrieve books
            $sql = "SELECT * FROM book";
            
            // Execute the query and store the results in a variable
            $result = mysqli_query($conn, $sql);
            
            // Check if any results were returned
            if (mysqli_num_rows($result) > 0) 
            {
                // Loop through each row of results and output them
                while($row = mysqli_fetch_assoc($result)) 
                {
                    echo "Book Title: " . $row["title"]."<br>";
                }
            } else 
            {
                echo "No results found.";
            }

            // Close the database connection
            mysqli_close($conn);
            }
        ?>
     
        <main class="container rounded p-3 my-3 border"> 
           

            <div class='col-4' style='display: inline-block;'>
                <section id="profilepic" style='display: inline-block;'>


                    <figure>

                        <img class="img-thumbnail" src="images/genericprofpic.png" alt="Poodle"
                             title="View larger image..."/>
                    </figure>

                </section>


                <section id="personalinfo"> 
                    <div class="row"> 
                        <div class="col" style='display: inline-block;'> 
                            <h5 style='text-align:left;'><b> Personal Information </b> </h5>
                            <!--<a href="#" style="font-size: 10px;"> Edit Profile </a>-->
                            <p> Name: (Name) </p>
                            <p> Email: (Email) </p>
                            <p> Contact: (Phone Number) </p>
                            <?php
                                getBooks()
                            ?>
                        </div>

                    </div>
                </section>
            </div>
            
            <div class='col-7' style='display: inline-block;'>
                <section id='accManagement' style='padding-bottom: 50px;'>
                    <div class='row'>
                        <div class="col">
                            <div class='dropdown' style='text-align: center;'>
                                <button class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Account Management
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
                
                <section id='bookManagement'>
                    <div class='row'>
                        <div class="col">
                            <div class='dropdown' style='text-align: center;'>
                                <button class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Book Management
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </body>
    
    <?php
        include "footer.php"
    ?>
</html>