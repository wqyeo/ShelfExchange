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
  <link href="css/browseList.css" rel="stylesheet"/>
</head>

<body class="d-flex flex-column h-100">
<?php
include_once "php_util/userSessionHelper.php";
include_once "php_util/util.php";
$connection = createDatabaseConnection();
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

$currentUserId = -1;
if (isset($userSessionHelper) && $userSessionHelper->isLoggedIn()) {
    $currentUserId = $userSessionHelper->getUserInformation()['user_id'];
}

$bookInformationFetcher = new BookInformationFetcher($bookId, $connection, $currentUserId);
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

<!-- Current user reviews-->
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12">
         <h2>Your review</h2>
        <ul class="list-group review-list" id="user-reviews-information">
          <?php

if (isset($userSessionHelper) && $userSessionHelper->isLoggedIn()) {
    $currentUserId = $userSessionHelper->getUserInformation()['user_id'];

    if (empty($bookInformationFetcher->getCurrentUserReview())) {
        echo '<form action="reviewSubmitProcess.php" method="post">
 <input type="hidden" name="user_id" value="' . $currentUserId . '">
 <input type="hidden" name="book_id" value="' . $bookId . '">
    <div class="form-group">
        <label class="mb-1" for="review">Review:</label>
        <textarea class="form-control mb-1" name="review" id="review" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <label class="mb-1" for="rating">Rating:</label>
        <select class="form-control mb-1" name="rating" id="rating">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div>
        <input type="submit" class="btn btn-primary mb-1" value="Submit Review">
    </div>
</form>';
    } else {
        echo '<script>displayReviews('. json_encode($bookInformationFetcher->getCurrentUserReview()) . ', "#user-reviews-information");</script>';
        echo '<form action="deleteReviewProcess.php" method="post">
 <input type="hidden" name="user_id" value="' . $currentUserId . '">
 <input type="hidden" name="book_id" value="' . $bookId . '">
        <input type="submit" class="mb-1 my-1 btn btn-danger" value="Delete Review">

</form>';
    }
} else {
    echo 'Log in to leave your own personal review!';
}
?> 
        </ul>
      </div>
    </div>
    </div>

<!--other user reviews-->
    <hr>
    <div class="row">
      <div class="col-md-12">
         <h2>Book Reviews</h2>
        <ul class="list-group review-list" id="reviews-information">
          <?php
  if (isset($bookInformation)) {
      echo'<script>displayReviews('. json_encode($bookInformationFetcher->getBookReviews()) . ', "#reviews-information");</script>';
  }
?> 
        </ul>
      </div>
    </div>

<!--Show some other books user might be interested in-->
  </div>
  <section class="py-5">
    <div class="container px-4 px-lg-5 mt-3">
      <div class="row">
        <div class="col text-center mb-4">
          <h2>Other related books</h2>
          <hr class="mx-auto">
        </div>
      </div>
      <div class="row gx-4 mt-2 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

        <?php

  $bookInformationFetcher->displayRelatedBooksList();

?>
  </section>

<?php
include "footer.php";
$connection->close();

?>

</body>

</html>
