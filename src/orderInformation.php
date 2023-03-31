<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>BookExchange</title>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Bootstrap icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css/styles.css" rel="stylesheet" />
  <link href="css/browseList.css" rel="stylesheet"/>
</head>


<body class="d-flex flex-column h-100">
<?php
  require_once "php_util/util.php";
$connection = createDatabaseConnection();
include "nav.php";
$books = array();
$orderId = -1;

if (isset($_GET['order'])) {
    $orderId = $_GET['order'];
} else {
    header("Location: index.php");
    exit();
}

require_once "php_util/OrderInformationHelper.php";
$orderInformationHelper = new OrderInformationHelper($connection, $orderId);
$books = $orderInformationHelper->getOrderedBooks();
$totalPrice = 0.0;
$discountAmount = 0.0;
?>

  <!--Header-->
  <script src="js/html_generator/headerCreator.js"></script>
<script>
const urlParams = new URLSearchParams(window.location.search);
const order = urlParams.get('order');

    const headerCreator = new HeaderCreator();
    headerCreator.createHeadingWith("Order History #" + order, "");
    headerCreator.endHeader();
  </script>


<main class="container">
<!--Cart List-->
<div class="container mb-2 my-2">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          Your Cart
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
              <?php foreach ($books as $book): ?>
              <?php $totalPrice += $book->cost_per_quantity; ?>
              <li class="list-group-item" id="book-cart-element-" + <?= $book->id?>>
                  <div class="row">
                    <div class="col-md-2">
                      <img src="<?= $book->image ?>" class="img-fluid rounded">
                    </div>
                    <div class="col-md-6">
                      <h5 class="mb-1"><?= $book->title ?></h5>
                      <p class="mb-1"><?= $book->author_names ?></p>
                      <p class="mb-1"><?= $book->tag_names ?></p>
                      <p class="mb-1"><?= $book->cost_per_quantity ?></p>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          Total
        </div>
        <div class="card-body">
          <p class="mb-1">
            Subtotal: $<?= $totalPrice ?>
          </p>
          <p class="mb-1">
            Discount: $<?= $discountAmount ?>
          </p>
          <h5>
            Total: $<?= $totalPrice + $discountAmount ?>
          </h5>
        </div>

              </div>
    </div>
  </div>
</div>
</main>
 <?php
include "footer.php";
$connection->close();
?>
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</html>
