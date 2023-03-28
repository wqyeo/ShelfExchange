<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html lang="en">
    <?php
        include "nav.php";
        include "bookManagement.php"
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
        <script defer src="js/updateBook.js"></script>
        <link rel="stylesheet" href="css/adminPage.css">
        
    </head>
    
    <body>
        <?php
        function getBooks() 
        {
            //Create Database connection
        function getUsers(){
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

            // SQL query to retrieve books
            $sql = "SELECT * FROM shelf_exchange.book";
            
            // Execute the query and store the results in a variable
            $books = mysqli_query($conn, $sql);
            
            // Check if any results were returned
            if (mysqli_num_rows($books) > 0) 
            {
                return $books;
            }
            
            $sql = "SELECT * FROM shelf_exchange.user";
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
                        </div>

                    </div>
                </section>
            </div>
            
            <div class='col-7' style='display: inline-block;'>
                <section id='accManagement' style='padding-bottom: 50px;'>
                    <div class='row'>
                        <div class="col">
                            <h1> ACCOUNT MANAGEMENT </h1>
                        </div>
                    </div>
                </section>
                
                <section id='bookManagement'>
                    <div class='row'>
                        <div class="col">
                            <h1> BOOK MANAGEMENT </h1>
                            <table> 
                                <tr>
                                    <th> Image </th>
                                    <th> Title </th>
                                    <th> Release Date </th>
                                    <th> Delete </th>
                                </tr>
                                
                                <?php
                                $books = getBooks();
                                
                                foreach ($books as $book)
                                {
                                    echo "<tr>";
                                    echo "<td> <figure> <img src='" .$book['image'] . "'></figure></td>";
                                    echo "<td>" . $book['title'] . "</td>";
                                    echo "<td>" . $book['release_date'] . "</td>";
                                    echo "<td><button class='btn btn-primary' data-toggle='modal' data-target='#updateBookModal' data-book-id='" . $book['id'] . "'>Update</button></td>";
                                    echo "<td><button class='btn btn-primary' data-toggle='modal' data-target='#updateBookModal' data-book-id='" . $book['id'] . "' data-book-title='" . htmlspecialchars($book['title'], ENT_QUOTES) . "' data-book-release-date='" . $book['release_date'] . "'>Update</button></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <!-- Book Update Modal -->
        <div class="modal fade" id="updateBookModal" tabindex="-1" role="dialog" aria-labelledby="updateBookModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="updateBookModalLabel">Update Book</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="updateBookForm">
                    <input type="hidden" name="book_id" id="updateBookId">
                    <div class="form-group">
                      <label for="updateBookTitle">Title</label>
                      <input type="text" class="form-control" id="updateBookTitle" name="title">
                    </div>
                    <div class="form-group">
                      <label for="updateBookReleaseDate">Release Date</label>
                      <input type="date" class="form-control" id="updateBookReleaseDate" name="release_date">
                    </div>
                    <div class="form-group">
                      <label for="updateBookImage">Image URL</label>
                      <input type="text" class="form-control" id="updateBookImage" name="image">
                    </div>
                  </form>
                    <form>
                        <div class="form-group">
                            <label for="update-title">Title</label>
                            <input type="text" class="form-control" id="update-title" value="">
                        </div>
                        <div class="form-group">
                            <label for="update-author">Author</label>
                            <input type="text" class="form-control" id="update-author" value="">
                        </div>
                        <div class="form-group">
                            <label for="update-genre">Genre</label>
                            <input type="text" class="form-control" id="update-genre" value="">
                        </div>
                        <div class="form-group">
                            <label for="update-release-date">Release Date</label>
                            <input type="date" class="form-control" id="update-release-date" value="">
                        </div>
                        <div class="form-group">
                            <label for="update-image">Image URL</label>
                            <input type="file" class="form-control" id="update-image" value="">
                        </div>
                        <input type="hidden" id="book-id" value="">
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" form="updateBookForm" class="btn btn-primary">Update Book</button>
                </div>
              </div>
            </div>
          </div>
    </body>
    
    <?php
        include "footer.php"
    ?>
</html>