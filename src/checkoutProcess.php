<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "php_error_models/checkoutErrorCode.php";
require_once "php_util/util.php";

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $cardNumber = $_POST['cardNumber'];
    $expiration = $_POST['expiration'];
    $cvv = $_POST['cvv'];
    /*
        $errorList = validateFormInputs($fullName, $email, $address, $cardNumber, $expiration, $cvv);
        if (!empty($errorList) || count(errorList) != 0) {
            redirectWithErrorCode(CheckoutErrorCode::MISSING_FIELDS);
            exit();
        }
    */
    // Connect to the database
    $connection = createDatabaseConnection();

    // Check if the connection was successful
    if (!$connection) {
        die('Connection failed: ' . mysqli_connect_error());
        redirectWithErrorCode(CheckoutErrorCode::CONNECTION_FAILED);
        exit();
    }

    // Process the checkout
    process_checkout($connection, $address, $cardNumber, $expiration, $cvv);
    $connection->close();
} else {
    header("Location: index.php?transaction=failure");
}

function redirectWithErrorCode(string $errorCode)
{
    header("Location: checkout.php?error=" . urlencode($errorCode));
}

function process_checkout($connection, $address, $cardNumber, $expiration, $cvv)
{
    require_once "php_util/bookDatabaseHelper.php";
    require_once "php_util/userCartHelper.php";
    require_once "php_util/userSessionHelper.php";

    $userSessionHelper = new UserSessionHelper($connection);
    if (!$userSessionHelper->isLoggedIn()) {
        redirectWithErrorCode(CheckoutErrorCode::NOT_SIGNED_IN);
        exit();
    }
    $userInformation = $userSessionHelper->getUserInformation();

    $userCartHelper = new UserCartHelper($connection);
    $bookInventoryInformation = $userCartHelper->getBookInventoryFromCarts();
    if (empty($bookInventoryInformation)) {
        redirectWithErrorCode(CheckoutErrorCode::NO_ITEM_IN_CART);
        exit();
    }


    // TODO: Dummy check for card number details, etc.
    $paymentResult = true;
    if ($paymentResult == true) {
        $orderId = createOrder($connection, $userInformation['user_id']);
        bindBookOrders($connection, $orderId, $bookInventoryInformation);
        $userCartHelper->clearCart();
    } else {
        redirectWithErrorCode(CheckoutErrorCode::INVALID_CARD);
        exit();
    }
}

function bindBookOrders($connection, $orderId, $bookInventoryInformations)
{
    // Loop through the book inventory array and insert each record
    foreach ($bookInventoryInformations as $inventory) {
        $bookInventoryId = $inventory->id;
        echo "\n" . $bookInventoryId;
        $quantity = 1; // NOTE: For now the user can only buy 1 book at a time.
        $costPerQuantity = $inventory->cost_per_quantity;

        $stmt = $connection->prepare("INSERT INTO book_order (book_inventory_id, order_id, quantity, cost_per_quantity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $bookInventoryId, $orderId, $quantity, $costPerQuantity);
        if ($stmt->execute()) {
            echo "\n1-Ok";
        } else {
            echo $stmt->error;
        }
        $stmt->close();

        // Decrement the book inventory quantity by the ordered quantity
        $updateStmt = $connection->prepare("UPDATE book_inventory SET quantity = quantity - ? WHERE id = ?");
        $updateStmt->bind_param("ii", $quantity, $bookInventoryId);
        if ($updateStmt->execute()) {
            echo "\n2-Ok";
        };
        $updateStmt->close();
    }
}

function createOrder($connection, $userId)
{
    // Prepare the SQL statement to insert a new order
    $stmt = $connection->prepare("INSERT INTO order_history (order_date, user_id) VALUES (?, ?)");

    $orderDate = getCurrentDate();
    // Bind the parameters to the prepared statement
    $stmt->bind_param("si", $orderDate, $userId);

    // Execute the prepared statement to insert the new order
    $stmt->execute();
    // Get the ID of the newly inserted order
    $newOrderId = $connection->insert_id;

    // Close the prepared statement and mysqli connection
    $stmt->close();
    return $newOrderId;
}

/*
function validateFormInputs($fullName, $email, $address, $cardNumber, $expiration, $cvv)
{
    $errors = array();

    // Validate full name
    if (empty($fullName)) {
        $errors[] = "Please enter your full name";
    }

    // Validate email
    if (empty($email)) {
        $errors[] = "Please enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Validate address
    if (empty($address)) {
        $errors[] = "Please enter your address";
    }

    // Validate card number
    if (empty($cardNumber)) {
        $errors[] = "Please enter your card number";
    } elseif (!preg_match("/^[0-9]{16}$/", $cardNumber)) {
        $errors[] = "Invalid card number format";
    }

    // Validate expiration
    if (empty($expiration)) {
        $errors[] = "Please enter the expiration date";
    } elseif (!preg_match("/^[0-9]{2}\/[0-9]{2}$/", $expiration)) {
        $errors[] = "Invalid expiration date format";
    }

    // Validate CVV
    if (empty($cvv)) {
        $errors[] = "Please enter the CVV";
    } elseif (!preg_match("/^[0-9]{3}$/", $cvv)) {
        $errors[] = "Invalid CVV format";
    }

    // Return errors array
    return $errors;
}*/
