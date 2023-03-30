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
include "php_util/userCartHelper.php";
$userCartHelper = new UserCartHelper($connection);
$books = $userCartHelper->getCartBooks();

// todo: set discount amount.
$discountAmount = 0;
$totalPrice = 0;
?>

  <!--Header-->
  <script src="js/html_generator/headerCreator.js"></script>
  <script>
    const headerCreator = new HeaderCreator();
    headerCreator.createHeadingWith("Your Shopping Cart", " ");
    headerCreator.createSearchBar();
    headerCreator.endHeader();
  </script>


<!--Cart List-->
<div class="container mb-2 my-2">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          Your Cart
        </div>
        <div class="card-body">
          <?php if (count($books) == 0): ?>
            <p>Your cart is currently empty.</p>
          <?php else: ?>
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
                    <div class="col-md-4 text-right">
                      <form method="post">
                        <input type="hidden" name="book_id" value="<?= $book->id ?>">
                        <button type="submit" onclick=<?php echo '"removeFromCart('. $book->id . ')"' ?> class="btn btn-danger btn-sm">
                          Remove
                        </button>
                      </form>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
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

        <!-- Checkout button-->
        <div class="card-footer text-right">
          <a href="checkout.php" id="checkout-btn" class="btn btn-success">
            Checkout
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

 <?php
include "footer.php";
echo "<script>setCheckoutState()</script>";
$connection->close();
?>
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
