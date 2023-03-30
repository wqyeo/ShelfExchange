<?php

if (isset($connection)) {
    include_once "php_util/userSessionHelper.php";
    $userSessionHelper = new UserSessionHelper($connection);
}?>


  <script src="js/userCartHelper.js"></script>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
     <div class="container px-4 px-lg-5">
         <a class="navbar-brand" href="index.php">Shelf Exchange</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                 <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                 <li class="nav-item"><a class="nav-link" href="aboutUs.php">About</a></li>
             </ul>

            <div class="d-flex">
                 <div class="me-3">
<?php if (isset($userSessionHelper) && $userSessionHelper->isLoggedIn()): ?>
                     <button class="btn btn-outline-dark" type="submit" onclick="window.location.href='userCartPage.php';">
                         <i class="bi-cart-fill me-1"></i>
                         Cart
                         <span class="badge bg-dark text-white ms-1 rounded-pill" id="cart-count"></span>
                            <script>showCartCount()</script> 
                    </button>
<?php else: ?>
                     <button class="btn btn-outline-dark btn-secondary" type="submit" disabled>
                         <i class="bi-cart-fill me-1"></i>
                         Log In to Checkout
                         <span class="badge bg-dark text-white ms-1 rounded-pill" id="cart-count"></span>
                            <script>showCartCount()</script> 
                    </button>

<?php endif; ?>
                 </div>
            <div class="navbar-nav ms-auto">
<?php
function showSignUpLogin(): void
{
    echo ' <li class="nav-item">
            <a class="nav-link" href="signUp.php">Sign up</a></li>
            <li class="nav-item">
            <a class="nav-link" href="login.php">Log in</a></li>';
}

    if (isset($userSessionHelper) && $userSessionHelper->isLoggedIn()) {
        echo '<li><img width="42" height="42" src="' . $userSessionHelper->getUserInformation()['profile_picture']  . '" alt="profile picture"></li>
<li><a class="nav-link" href="UserProfilePage.php?user=' . $userSessionHelper->getUserInformation()['user_id'] . '">' . $userSessionHelper->getUserInformation()['username']  . '</a> '
                . '<li class="nav-item"><a class="nav-link" href="processLogout.php">Logout</a></li>';
    } else {
        showSignUpLogin();
    }

?>
</div>
             </div>
         </div>
     </div>
 </nav>
