<!DOCTYPE html>
<html>

<head>
  <title>Book Information</title>
<!--jquery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <!-- Include Bootstrap CSS -->

  <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
  <link href="css/styles.css" rel="stylesheet" />
<link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Bootstrap icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column h-100">
<?php
include "nav.php";
?>

  <script src="js/html_generator/headerCreator.js"></script>
  <script>
    const headerCreator = new HeaderCreator();
    headerCreator.createHeadingWith("SHELF EXCHANGE", "A bookworm's paradise!");
    headerCreator.createSearchBar();
    headerCreator.endHeader();
  </script>

<?php
// TODO: Error handling when book not found or smth.
include "php_util/bookInformationFetcher.php";

$bookId = $_GET['book'];
$bookInformationFetcher = new BookInformationFetcher($bookId);
$bookInformation = $bookInformationFetcher->getBookInformation();
?>
<script src="js/bookInformation.js"></script>

  <div class="container mt-3 mb-3">
    <div class="row">
      <div class="col-md-4">
<?php
  echo '<img src="' . $bookInformation['image'] . '" alt="Book Image" class="img-fluid">';
?>
      </div>
      <div class="col-md-8" id="book-info">
<?php
if (isset($bookInformation)) {
    // Display book info, tags and authors.
    echo '
    <script>displayBookInformation('. json_encode($bookInformation) . ');displayBookTags(' . json_encode($bookInformationFetcher->getBookTags()) . ');displayBookAuthors(' . json_encode($bookInformationFetcher->getBookAuthors()) . ');</script>
';
} else {
    echo 'Woops, we couldnt find that book D:';
}
?>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12">
         <h2>Book Reviews</h2>
          <!-- TODO: Display reviews-->
        <ul class="list-group review-list" id="reviews-information">
          <?php
  if (isset($bookInformation)) {
      echo'<script>displayReviews('. json_encode($bookInformationFetcher->getBookReviews()) . ');</script>';
  }
?> 
        </ul>
      </div>
    </div>
  </div>

  <?php
  include "footer.php"
?>

</body>

</html>
