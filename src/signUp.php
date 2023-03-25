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
        <!-- Big header asking for user to sign up-->
        <header class="bg-dark py-2">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Sign Up</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Get more offers and benefits when browsing!</p>
                </div>
            </div>
        </header>
        
        <main class="container mt-3">
            <form action="processSignUp.php" method="post" onsubmit="return validateForm()">
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" required>
                  <div id="usernameError" class="text-danger"></div>
               </div>
                
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                  <div id="emailError" class="text-danger"></div>
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
                
                <button type="submit" class="btn btn-primary mb-3">Sign up</button>
                <p>Already have an account? <a href="login.php">Log in</a></p>
            </form>
        </main>
        <?php
        include "footer.php";
        ?>
    </body>
</html>
