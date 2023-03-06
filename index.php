<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <link rel="stylesheet" href="css/shopping_list.css">
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity=
        "sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
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
    
    <head>
        <meta charset="UTF-8">
        <title>Shelf Exchange Shopping List</title>
    </head>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        
        <div class="container">
          <h1 class="text-center my-4">Featured Books</h1>
          <div id="book-list" class="row"></div>
        </div>

        <!--The list of books-->
        <div class="modal fade" id="book-modal" tabindex="-1" role="dialog" aria-labelledby="book-modal-label" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="book-modal-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-4">
                    <img id="book-modal-image" class="img-fluid" src="images/not_found.png">
                  </div>
                  <div class="col-sm-8">
                    <p id="book-modal-description"></p>
                    <p id="book-modal-price"></p>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add to Cart</button>
              </div>
            </div>
          </div>
        </div>
        
        <script src="js/shopping_list.js"></script>
    </body>
</html>
