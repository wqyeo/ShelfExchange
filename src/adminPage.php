<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html lang="en">

    <?php

        include_once "php_util/util.php";
        $connection = createDatabaseConnection();
        $query = "SELECT * FROM shelf_exchange.user";
        $result = mysqli_query($connection, $query);
        include "nav.php";
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
        <script defer src="js/updateOrDelUserAcc.js"></script>

        <link rel="stylesheet" href="css/adminPage.css">
    </head>

    <body>
        <?php
        
        include "book_functions.php";
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
                            <p> Name: <?php echo $row['username']; ?>  </p>
                            <p> Email: <?php echo $row['email']; ?> </p>
                            <p> Contact No: <?php echo $row['contact_no']; ?> </p>

                        </div>

                    </div>
                </section>
            </div>

            <div class='col-7' style='display: inline-block;'>
                <section id='accManagement' style='padding-bottom: 50px;'>
                    <div class='row'>
                        <div class="col">
                            <h1> ACCOUNT MANAGEMENT </h1> 
                            <button type='button' class='btn btn-success' data-toggle='modal' data-target='#createNewUser'> Create New User </button>
                            <table class="table table-bordered text-center"> 
                                <tr class="bg-dark text-white">
                                    <th> User ID </th>
                                    <th> Username </th>
                                    <th> Email </th>
                                    <th> Edit User </th>
                                    <th> Delete User </th>
                                </tr>
                                
                                <?php
                        
                                    while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["username"]; ?> </td>
                                    <td><?php echo $row["email"]; ?></td>
                                    <td><button type='button' class='btn btn-primary' onclick='getUserDetails(<?php echo $row["id"]; ?>)'> Edit </button></td> 
                                    <td><button type='button' class='btn btn-danger text-light' onclick='deleteUser(<?php echo $row["id"]; ?>)'>  Delete </button></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </table>

                        </div>
                    </div>
                </section>

                <section id='bookManagement'>
                    <div class='row'>
                        <div class="col">
                            <h1> BOOK MANAGEMENT </h1>
                            <table class="table table-bordered text-center"> 
                                <tr>
                                    <th> Image </th>
                                    <th> Title </th>
                                    <th> Release Date </th>
                                </tr>
                                <tr>
                                    <td style="text-align:center" colspan="4">
                                        <button class='btn btn-primary' data-toggle='modal' data-target='#addBookModal'>Add Book</button>
                                    </td>
                                </tr>
                                <?php
                                $books = getBooks();

                                foreach ($books as $book) {
                                    echo "<tr>";
                                    echo "<td> <figure> <img src='" . $book['image'] . "' width='200' height='300'></figure></td>";
                                    echo "<td>" . $book['title'] . "</td>";
                                    echo "<td>" . $book['release_date'] . "</td>";
                                    echo "<td><button class='btn btn-primary' data-toggle='modal' data-target='#updateBookModal' data-book-id='" . $book['id'] . "' data-book-title='" . rawurlencode($book['title']) . "' data-book-release-date='" . $book['release_date'] . "' data-book-description='" . rawurlencode($book['description']) . "' data-book-language-id='" . $book['language_id'] . "'>Update</button></td>";
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
                        <form id="updateBookForm" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="book-id" id="book-id">
                            <div class="form-group">
                                <label for="update-title">Title</label>
                                <input type="text" class="form-control" name="update-title" id="update-title" required>
                            </div>
                            <div class="form-group">
                                <label for="update-release-date">Release Date</label>
                                <input type="date" class="form-control" name="update-release-date" id="update-release-date" required>
                            </div>
                            <div class="form-group">
                                <label for="update-image">Image</label>
                                <input type="file" class="form-control" name="update-image" id="update-image" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="update-description">Description</label>
                                <textarea class="form-control" id="update-description" rows="3" name="update-description" placeholder="Enter book description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="update-language-id">Language:</label>
                                <select class="form-control" name="update-language-id" id="update-language-id" required>
                                    <?php
                                    $language_query = "SELECT * FROM shelf_exchange.book_language";
                                    $language_result = mysqli_query($conn, $language_query);
                                    while ($language = mysqli_fetch_assoc($language_result)) {
                                        echo '<option value="' . $language['id'] . '">' . $language['language_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="deleteBook" class="btn btn-danger">Delete Book</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" form="updateBookForm" class="btn btn-primary">Update Book</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Book Modal -->
        <div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="addBookModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Add Book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addBookForm">
                            <div class="form-group">
                                <label for="add-title">Title</label>
                                <input type="text" class="form-control" id="add-title" name="add-title" required>
                            </div>
                            <div class="form-group">
                                <label for="add-release-date">Release Date</label>
                                <input type="date" class="form-control" id="add-release-date" name="add-release-date" required>
                            </div>
                            <div class="form-group">
                                <label for="add-description">Description</label>
                                <textarea class="form-control" id="add-description" name="add-description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="add-language-id">Language</label>
                                <select class="form-control" id="add-language-id" name="add-language-id" required>
                                    <?php
                                    $language_query = "SELECT * FROM shelf_exchange.book_language";
                                    $language_result = mysqli_query($conn, $language_query);
                                    while ($language = mysqli_fetch_assoc($language_result)) {
                                        echo '<option value="' . $language['id'] . '">' . $language['language_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="add-image">Image</label>
                                <input type="file" class="form-control" id="add-image" name="add-image">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Book</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

        <!-- add user modal -->
        <div class="modal fade" id="createNewUser" tabindex="-1" role="dialog" aria-labelledby="createUser" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="createUser">Create User</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label for="createUsername">Username</label>
                        <input type="text" class="form-control" id="createUsername">
                    </div>
                    <div class="form-group">
                        <label for="createEmail">Email</label>
                        <input type="text" class="form-control" id="createEmail">
                    </div>
                    <div class="form-group">
                        <label for="createPassword">Password</label>
                        <input type="password" class="form-control" id="createPassword">
                    </div>
                    
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="button" name="create" form="createUser" id="create" class="btn btn-primary"
                          onclick='addUser()'>Create</button>
                  
                </div>
              </div>
            </div>
        </div>
        <!-- update modal --> 
        <div class="modal fade" id="updateUserDetails" tabindex="-1" role="dialog" aria-labelledby="updateUser" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="updateUser">Update User</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="updateUsername">Username</label>
                        <input type="text" class="form-control" id="updateUsername">
                    </div>
                    <div class="form-group">
                        <label for="updateEmail">Email</label>
                        <input type="text" class="form-control" id="updateEmail">
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" name="update" form="updateUser" id="update" class="btn btn-primary"
                            onclick='updateDetails()'>Update User</button>
                    <input type="hidden" id="UserId" value="<?php echo $row['id']; ?>">
                </div>
              </div>
            </div>
        </div>
        
    </body>
    <script>
       //still in progress
        function addUser(){
            $('#createNewUser').modal("show");
            var addName = $('#createUsername').val();
            var addEmail = $('#createEmail').val();
            var addPassword = $('#createPassword').val();
            
            $.ajax({
                url:"createUser.php",
                type:'post',
                data:{
                    sendEmail: addEmail,
                    sendName: addName,
                    sendPassword: addPassword
                }
                success:function(data,status){
                    $('#createNewUser').modal("hide");
//                    location.href='testAPAcc.php';
                    
                }
            });
        }
    </script>
    <?php
        include "footer.php";
    $connection->close();
    ?>

</html>
