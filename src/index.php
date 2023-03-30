<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>BookExchange</title>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Bootstrap icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css/styles.css" rel="stylesheet" />
  <link href="css/browseList.css" rel="stylesheet"/>
</head>
  <?php
  require_once "php_util/util.php";
  $connection = createDatabaseConnection();
  include "nav.php";
  include "php_book_browser/indexBrowserHelper.php";
  $bookListGenerator = new IndexBrowserHelper($connection);

  ?>

  <!--Header-->
  <script src="js/html_generator/headerCreator.js"></script>
  <script>
    const headerCreator = new HeaderCreator();
    headerCreator.createHeadingWith("SHELF EXCHANGE", "A bookworm's paradise.");
    headerCreator.createSearchBar();
    headerCreator.endHeader();
  </script>

  <!--Featured Section-->
  <section class="py-5">
    <div class="container px-4 px-lg-4 mt-3">
      <div class="row">
        <div class="col text-center mb-4">
          <h2>Featured Books</h2>
          <hr class="mx-auto">
        </div>
      </div>
      <div class="row gx-4 mt-2 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

        <?php
        $bookListGenerator->createFeaturedBookList();
  ?>
      </div>
    </div>
  </section>


  <!-- Interest Section-->
  <section class="py-5">
    <div class="container px-4 px-lg-5 mt-3">
      <div class="row">
        <div class="col text-center mb-4">
          <h2>Books You Might Be Interested In</h2>
          <hr class="mx-auto">
        </div>
      </div>
      <div class="row gx-4 mt-2 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

        <?php

  $bookListGenerator->createInterestBookList();

  ?>
      </div>
    </div>
  </section>
  <?php
  include "footer.php";
  $connection->close();
  ?>
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
