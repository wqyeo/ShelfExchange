<html lang="en">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"crossorigin="anonymous">
        <!--jQuery-->
        <script defer src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <!--Bootstrap JS-->
        <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
        <!-- Custom JS -->
        <script defer src="js/main.js"></script>
        <script defer src="js/login.js"></script>
        <link rel="stylesheet" href="css/main.css">
        <title>Shelf Exchange Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/login.css" rel="stylesheet" />
        <script defer src="js/login.js"></script>
        
    </head>
    <body class="d-flex flex-column h-100">
        <?php
        include "nav.php";
        ?>
        <!-- Big header asking for user to sign up-->
        <header class="bg-dark py-2">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Login</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Welcome back!</p>
                </div>
            </div>
        </header>
      <!--Find and display server side error to user.-->
    <?php
        require 'php_error_models/loginErrorCode.php';
        $errorMessage = $_GET['error'];

        $emailErrorMessage = "";
        $passwordErrorMessage = "";
        $genericErrorMessage = "";
        if (isset($errorMessage)) {
            switch ($errorMessage) {
                case LoginErrorCode::EMAIL_ACCOUNT_NOT_FOUND:
                    $emailErrorMessage = "No matching email found!";
                    break;
                case LoginErrorCode::PASSWORD_INCORRECT:
                    $passwordErrorMessage = "Password is incorrect!";
                    break;
                case LoginErrorCode::CONNECTION_FAILED:
                    $genericErrorMessage = "Failure reaching the server, try again or contact support.";
                    break;
                case LoginErrorCode::CONNECTION_FAILED_STATEMENT_ERROR:
                    $genericErrorMessage = "Failure signing in, contact support!";
                    break;
            }
        }
        ?>
           
        <main class="container mt-3">
            <form action="processLogin.php" method="post" onsubmit="return validateForm()">
                
                <div class="form-group">
                <label for="email">Email</label> <!-- required -->
                <input class="form-control" type="email" id="email" required maxlength="255" name="email"> 
        <div id="emailError" class="text-danger"><?php echo $emailErrorMessage; ?></div>
                </div>
                
                <div class="form-group">
                <label for="password">Password</label> <!-- required -->
                <input class="form-control" type="password" id="password" required maxlength="255" name="password">
                  <div id="passwordError" class="text-danger"><?php echo $passwordErrorMessage; ?></div>
                </div>
                
                <div class="mb-1">
                <!--For any generic error in form submission-->
                <div id="genericError" class="text-danger"><?php echo $genericErrorMessage; ?></div>
   
                <br>
                <button class="btn btn-primary mb-3" type="submit">Login</button>
                <p>Don't own an account? <a href="signUp.php">Sign Up</a></p>
            </div>

            </form>
        </main>
        <?php
            include "footer.php";
        ?>
    </body>
</html>
