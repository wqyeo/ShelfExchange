<?php

$servername = "localhost";
$dbusername = "shelfdev";
$password = "lmao01234";
$dbname = "shelf_exchange";

// Create a connection to the database
$conn = mysqli_connect($servername, $dbusername, $password, $dbname);

if (!empty($_POST)) {
    $output = '';
    $message = '';
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    if ($_POST["userId"] != '') {
        $query = "  
          UPDATE user   
          SET id='$id',   
          username='$username',   
          email='$email',    
          WHERE id='" . $_POST["userId"] . "'";
        $message = 'Data Updated Successfully!';
    } else {
        $query = "  
          INSERT INTO tbl_employee(name, address, gender, designation, age)  
          VALUES('$name', '$address', '$gender', '$designation', '$age');  
          ";
        $message = 'Data inserted Successfully!';
    }
    if (mysqli_query($conn, $query)) {
        $output .= '<label class="text-success">' . $message . '</label>';
        $select_query = "SELECT * FROM shelf_exchange.user ORDER BY id DESC";
        $result = mysqli_query($conn, $select_query);
        $output .= '  
               <table class="table table-striped table-hover">  
                    <tr>  
                         <th>User id</th>  
                         <th>username</th>  
                         <th>email</th> 
                         <th>Edit user</th>  
                         <th>Delete user</th>  
                    </tr>  
          ';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '  
                <tr>  
                     <td>' . $row["id"] . '</td>  
                     <td>' . $row["username"] . '</td>  
                     <td>' . $row["email"] . '</td>
                     <td><input type="button" name="edit" value="Edit" id="' . $row["id"] . '" class="btn btn-info btn-xs edit_data" /></td>  
                     <td><a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a></td>  
                </tr>  
               ';
        }
        $output .= '</table>';
    }
    echo $output;
}
?>
