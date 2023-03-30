<!DOCTYPE html>
<html lang="en">
    <head>
                
        <!--Bootstrap JS-->
        <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
        <!-- Custom JS -->
        <script defer src="js/main.js"></script>
        
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>About Us</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <?php
            include "nav.php"
        ?>


         <?php
            include "php_util/util.php";
            $connection = createDatabaseConnection();
         
         
            function getUserContact(){
                $servername = "localhost";
                $dbusername = "shelfdev";
                $password = "lmao01234";
                $dbname = "shelf_exchange";

                // Create a connection to the database
                $conn = mysqli_connect($servername, $dbusername, $password, $dbname);

                // Check connection
                if (!$conn) 
                {
                    die("Connection failed: " . mysqli_connect_error());
                }

                
                $sql = "SELECT * FROM shelf_exchange.user INNER JOIN shelf_exchange.seller ON user.id = seller.user_id";
                // Execute the query and store the results in a variable
                $users = mysqli_query($conn, $sql);

                // Check if any results were returned
                if (mysqli_num_rows($users) > 0) 
                {
                    return $users;
                } 
                else 
                {
                    echo "No results found.";
                }

                // Close the database connection
                mysqli_close($conn);
            }
        ?>
  <script src="js/html_generator/headerCreator.js"></script>
  <script>
    const headerCreator = new HeaderCreator();
    headerCreator.createHeadingWith("About Us", "");
    headerCreator.createSearchBar();
    headerCreator.endHeader();
  </script>

        <main class="container mt-3">
            <section class="py-5">
                <div class="text-center mt-3" id="abtus">
                    <h1 class="display-4 fw-bolder">BRAND PROFILE</h1>

                    <p class="lead fw-normal text-black-50">
                        At Shelf Exchange we offer a wide variety of books for all different types of bookworms. Whether you're looking for the latest mystery novel, a classic romance, or a how-to guide, we've got you covered.

                        We understand that everyone has different taste in literature, which is why we offer such a diverse selection of books. Whether you're looking to be scared, laugh, or cry, we have a book that will fit your needs.

                        If you're looking for something new to read, but don't know where to start, our team of experts are always on hand to recommend the perfect book for you.
                    </p>

                </div>

                <div class="text-center mt-3">
                    <h3 class="display-4 fw-bolder">Contact Us</h3>
                    <?php
                    $users = getUserContact();

                        foreach ($users as $user)
                        {
                            echo  $user['fname'] . $user['lname'] . "<br>";
                            echo $user['email'] . "<br>";
                            echo $user['contact_no'] . "<br><br>";
                        }
                        ?>
                                

                </div>
            </section>
        </main>
        <?php
            include "footer.php"
        ?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
