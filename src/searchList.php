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
    </head>
    <body>
        <?php
            include "nav.php";
        include "php_book_browser/searchBrowserHelper.php";
        $searchQuery = "";
        // get search query
if (isset($_GET['query'])) {
            $searchQuery = $_GET['query'];
        }
        $bookListGenerator = new SearchBrowserHelper($searchQuery);

        ?>

        <!--Header-->
  <script src="js/html_generator/headerCreator.js"></script>
  <script>
    const headerCreator = new HeaderCreator();
    headerCreator.createHeadingWith("SHELF EXCHANGE", "A bookworm's paradise.");
    headerCreator.createSearchBar();
    headerCreator.endHeader();
  </script>

        <!--Search Results-->
<section class="py-5">
            <div class="container px-4 px-lg-4 mt-3">
      <div class="row">
        <div class="col text-center mb-4">
          <h2>Your Search Results</h2>
          <hr class="mx-auto">
        </div>
      </div>
                    <div class="row gx-4 mt-2 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        
<?php
         $bookListGenerator->displaySearchResults();
        ?>
                </div>
            </div>
        </section>

<?php

// If there is very little search results,
// recommend random books to the customer.
if ($bookListGenerator->searchResultCount < 4) {
    echo '        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-3">
      <div class="row">
        <div class="col text-center mb-4">
          <h2>Other books you may be interested in</h2>
          <hr class="mx-auto">
        </div>
      </div>
                    <div class="row gx-4 mt-2 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';

    $bookListGenerator->recommendRandomBooks();
    echo '
                </div>
            </div>
        </section>';
}

// Include footer and end.
include "footer.php";
        $bookListGenerator->dispose();
        ?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
