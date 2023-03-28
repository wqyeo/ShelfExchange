<!DOCTYPE html>
<html>

<head>
  <title>Book Information</title>
  <!-- Include Bootstrap CSS -->
  <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
  <link href="css/styles.css" rel="stylesheet" />

</head>

<body>

  <script src="js/html_generator/headerCreator.js"></script>
  <script>
    const headerCreator = new HeaderCreator();
    headerCreator.createHeadingWith("SHELF EXCHANGE", "A bookworm's paradise!");
    headerCreator.createSearchBar();
    headerCreator.endHeader();
  </script>


  <div class="container mt-3 mb-3">
    <div class="row">
      <div class="col-md-4">
        <img src="book-image.jpg" alt="Book Image" class="img-fluid">
      </div>
      <div class="col-md-8">
        <h1>Book Title</h1>
        <p class="lead">Book Description</p>
        <p><strong>Price:</strong> $10.99</p>
        <button class="btn btn-primary mb-3">Add to Cart</button>
        <p><strong>Tags:</strong> Fiction, Thriller, Mystery</p>
        <p><strong>Author:</strong> John Doe</p>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12">
        <h2>Book Reviews</h2>
        <ul class="list-group">
          <li class="list-group-item">Great book! Couldn't put it down.</li>
          <li class="list-group-item">Highly recommended.</li>
          <li class="list-group-item">One of my favorites.</li>
        </ul>
      </div>
    </div>
  </div>

  <?php
  include "footer.php"
  ?>

</body>

</html>
