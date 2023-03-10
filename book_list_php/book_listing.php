<div class="container">
    <?php
        include "book_list_php/book_listing.searchbar.php";
    ?>
    
    <!--The list of books-->
    <h1 class="text-center my-4">Featured Books</h1>
    <div id="book-list" class="row"></div>
</div>

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

<script src="js/book_listing.js"></script>