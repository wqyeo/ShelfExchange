<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html lang="en">
    <?php
        include "nav.php";
        include "book_functions.php";
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
                            <table class="table table-bordered text-center"> 
                                <tr class="bg-dark text-white">
                                    <th> User ID </th>
                                    <th> Username </th>
                                    <th> Email </th>
                                    <th> Edit User </th>
                                    <th> Delete User </th>
                                </tr>
                            </table>
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
                                </tr>
                                <?php
                                $books = getBooks();
                                
                                foreach ($books as $book)
                                {
                                    echo "<tr>";
                                    echo "<td> <figure> <img src='" .$book['image'] . "' width='200' height='300'></figure></td>";
                                    echo "<td>" . $book['title'] . "</td>";
                                    echo "<td>" . $book['release_date'] . "</td>";
                                    echo "<td><button class='btn btn-primary' data-toggle='modal' data-target='#updateBookModal' data-book-id='" . $book['id'] . "' data-book-title='" . $book['title'] . "' data-book-release-date='" . $book['release_date'] . "'>Update</button></td>";
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
                    <form>
                        <div class="form-group">
                            <label for="update-title">Title</label>
                            <input type="text" class="form-control" id="update-title" value="<?php echo $book['title']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="update-release-date">Release Date</label>
                            <input type="date" class="form-control" id="update-release-date" value="<?php echo $book['release_date']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="update-image">Image URL</label>
                            <input type="text" class="form-control" id="update-image" value="<?php echo $book['image']; ?>">
                        </div>
                        <input type="hidden" id="book-id" value="<?php echo $book['id']; ?>">
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