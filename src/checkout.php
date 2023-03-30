
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


<!--Calculate total cost-->
<?php if (count($books) == 0): ?>
<!--Redirect to shopping cart cuz empty cart-->
<?php header("Location: userCartPage.php"); ?> 
          <?php else: ?>
              <?php foreach ($books as $book): ?>
              <?php $totalPrice += $book->cost_per_quantity; ?>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

<!--Cart List-->
<div class="container mb-3 my-3">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h2 class="mb-3">Checkout</h2>
        <form method="post" action="checkoutProcess.php" onsubmit="return validateForm()">
          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="fullName">Name (Tied to Card)</label>
              <input type="text" class="form-control" id="fullName" name="fullName" required>
              <div class="invalid-feedback">Please enter your full name tied to the card.</div>
                            <div id="fullNameError" class="text-danger"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="email">Email (Optional)</label>
              <input type="email" class="form-control" id="email" name="email">
                            <div id="emailError" class="text-danger"></div>
            </div>
          </div>

          <!--Address line 1-->
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="address-one">Address</label>
                <input type="text" class="form-control" id="address-one" name="address-one" required>
                <div class="invalid-feedback">Please enter your address.</div>
                              <div id="addressError" class="text-danger"></div>
              </div>
            </div>
          <!--Address line 2-->
           <div class="row">
              <div class="col-md-12 mb-3">
                <label for="address-two">Address (Additional Information)</label>
                <input type="text" class="form-control" id="address" name="address">
              </div>
            </div>


          <!--Postal Code, Country-->
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="postalCode">Postal Code</label>
              <input type="text" class="form-control" id="postalCode" name="postalCode" required>
              <div class="invalid-feedback">Please enter your postal code.</div>
              <div id="postalCodeError" class="text-danger"></div>
            </div>
            <div class="col-md-8 mb-3">
              <label for="country">Country</label>
              <input type="text" class="form-control" id="country" name="country" required>
              <div class="invalid-feedback">Please enter your country.</div>
              <div id="countryError" class="text-danger"></div>
            </div>
          </div>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="cardNumber">Card Number</label>
                <input type="text" class="form-control" id="cardNumber"  name="cardNumber" inputmode="numeric" maxlength="19">
                <div class="invalid-feedback">Please enter a valid 16-digit card number.</div>
                              <div id="cardNumberError" class="text-danger"></div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="expiration">Expiration</label>
                <input type="text" class="form-control" id="expiration" name="expiration" >
                <div class="invalid-feedback">Please enter a valid expiration date in MM/YY format.</div>
                              <div id="expirationError" class="text-danger"></div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="cvv">CVV</label>
                <input type="text" class="form-control" id="cvv" name="cvv">
                <div class="invalid-feedback">Please enter a valid 3-digit CVV code.</div>
                              <div id="cvvError" class="text-danger"></div>
              </div>
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Place Order</button>
        </form>
    </div>
    <!--Price-->
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

<script src="js/checkout.js"></script>
 <?php
include "footer.php";
$connection->close();
?>
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
