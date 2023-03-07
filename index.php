<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="css/book_listing.css">
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity=
        "sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
        crossorigin="anonymous">
    
    <!--jQuery-->
    <script defer
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous">
    </script>
    
    <!--Bootstrap JS-->
    <script defer
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
    integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
    crossorigin="anonymous">
    </script>
    
    <head>
        <meta charset="UTF-8">
        <title>Shelf Exchange Shopping List</title>
    </head>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        
        <?php
            include "book_list_php/book_listing.php";
        ?>
    </body>
</html>
