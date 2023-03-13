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
    </head>
    <body>
        <?php
        include "nav.php";
        ?>
        <main class="container">
            <h1>User Registration</h1>
            <p>
                For existing users, please go to the
                <a href="login.php">Login page</a>.
            </p>
            <form action="processSignUp.php" method="post">
                <div class="form-group">
                <label for="username">Username:</label> <!-- required -->
                <input class="form-control" type="text" id="username" required maxlength="45" name="username" placeholder="Enter username">
                </div>
                
                <div class="form-group">
                <label for="contactNo">Contact Number:</label>
                <input class="form-control" type="text" id="contactNo" required maxlength="45" name="contactNo" placeholder="Enter contact number">
                </div>
                
                <div class="form-group">
                <label for="email">Email:</label> <!-- required -->
                <input class="form-control" type="email" id="email" required maxlength="255" name="email" placeholder="Enter email">
                </div>
                
                <div class="form-group">
                <label for="pwd">Password:</label> <!-- required -->
                <input class="form-control" type="password" id="pwd" required maxlength="255" name="pwd" placeholder="Enter password">
                </div>
                
                <div class="form-group"> <!-- required -->
                <label for="pwd_confirm">Confirm Password:</label>
                <input class="form-control" type="password" id="pwd_confirm" required maxlength="255" name="pwd_confirm" placeholder="Confirm password">
                </div>
                
                <br>
                <button class="btn btn-primary" type="submit">Sign up</button>
            </form>
        </main>
        <?php
        include "footer.php";
        ?>
    </body>
</html>
