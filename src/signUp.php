<html lang="en">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"crossorigin="anonymous">
        <!--jQuery-->
        <script defer src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <!--Bootstrap JS-->
        <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
        <!-- Custom JS -->
        <script defer src="js/main.js"></script>
        <link rel="stylesheet" href="css/main.css">
        <title>Shelf Exchange Sign Up</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
                <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        
        <link href="css/signUp.css" rel="stylesheet" />
        <script defer src="js/signUp.js"></script>
    </head>
    <body class="d-flex flex-column h-100">
        <?php
        include "nav.php";
        ?>
  <script src="js/html_generator/headerCreator.js"></script>
<script>
    const headerCreator = new HeaderCreator();
    headerCreator.createHeadingWith("Create An Account", "Create an account for offers and promotions!");
    headerCreator.endHeader();
    </script>
  <!--Find and display server side error to user.-->
    <?php
        require 'php_error_models/signUpErrorCode.php';
        $errorMessage = $_GET['error'];

        $emailErrorMessage = "";
        $usernameErrorMessage = "";
        $genericErrorMessage = "";
        if (isset($errorMessage)) {
            if ($errorMessage == SignUpErrorCode::EMAIL_USED) {
                $emailErrorMessage = "The email is already in use!";
            } elseif ($errorMessage == SignUpErrorCode::USERNAME_USED) {
                $usernameErrorMessage = "Sorry, the username is already taken!";
            } elseif ($errorMessage == SignUpErrorCode::CONNECTION_FAILED_STATEMENT_ERROR || $errorMessage == SignUpErrorCode::CONNECTION_FAILED) {
                $genericErrorMessage = "Error trying to sign up, contact support!";
            } elseif ($errorMessage == SignUpErrorCode::MISSING_FIELDS) {
                $genericErrorMessage = "Ensure all fields are filled!";
            } elseif ($errorMessage == SignUpErrorCode::EMAIL_INPUT_INVALID) {
                $emailErrorMessage = "The email doesn't seem correct.";
            } elseif ($errorMessage == SignUpErrorCode::USERNAME_INPUT_INVALID) {
                $usernameErrorMessage = "Username too long or short.";
            } elseif ($errorMessage == SignUpErrorCode::PASSWORD_INPUT_INVALID) {
                $genericErrorMessage = "Password too short or long";
            }
        }
        ?>
        
        <main class="container mt-3">
            <form action="processSignUp.php" method="post" onsubmit="return validateForm()">
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" required>
                  <div id="usernameError" class="text-danger"><?php echo $usernameErrorMessage; ?></div>
               </div>
                
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
        <div id="emailError" class="text-danger"><?php echo $emailErrorMessage; ?></div>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <small id="password-strength-text" class="form-text text-muted mt-2">Password strength: <span id="password-strength"></span></small>
                    <div class="progress mt-2">
                        <div id="password-strength-bar" class="progress-bar" role="progressbar"></div>
                    </div>
                    <div id="passwordError" class="text-danger"></div>
                </div>

                <div class="mb-1">
                    <!--For any generic error in form submission-->
                    <div id="genericError" class="text-danger"><?php echo $genericErrorMessage; ?></div>
                </div>
                
                <button type="submit" class="btn btn-primary mb-3">Sign up</button>
                <p>Already have an account? <a href="login.php">Log in</a></p>
            </form>
        </main>
        <?php
            include "footer.php";
        ?>
    </body>
</html>
