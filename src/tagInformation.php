
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
include "php_util/util.php";
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
include "php_util/tagInformationFetcher.php";
$tagId = $_GET['tag'];
$tagInformationFetcher = new TagInformationFetcher($tagId, $connection);
?>
<div class="container d-flex justify-content-center p-3">
    <div class="card bg-light">
        <div class="card-body">
            <h5 class="card-title text-center mb-3" id="name"></h5>
            <p class="card-text" id="description"></p>
        </div>
    </div>
</div><?php
echo '<script src="js/tagInformation.js"></script>';
echo '<script>displayTagInformation(' . json_encode($tagInformationFetcher->getTagInformation())  . ');</script>'
?>
  <section class="py-5">
    <div class="container px-4 px-lg-5 mt-3">
      <div class="row">
        <div class="col text-center mb-4">
          <h2>Books with the related Tags</h2>
          <hr class="mx-auto">
        </div>
      </div>
      <div class="row gx-4 mt-2 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

        <?php

  $tagInformationFetcher->displayBooksWithTags();

?>
  </section>

<?php
include "footer.php";
$connection->close();

?>

</body>

</html>
