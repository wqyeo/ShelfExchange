<?php
    $servername = "localhost";
    $dbusername = "shelfdev";
    $password = "lmao01234";
    $dbname = "shelf_exchange";

    // Create a connection to the database
    $conn = mysqli_connect($servername, $dbusername, $password, $dbname);

    // Check connection
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * FROM shelf_exchange.user";
    $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>  
<html>  
    <head>  
        <title>Bootstrap Modal</title>
        <!-- Brarry Css js   -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 

        <!-- css add external -->
        <link rel="stylesheet" href="styles.css">

    </head>  
    <body>  
        <br /><br />  
        <div class="container">  
            <h3 align="center">Employees Insert Data</h3>  
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Employees</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add New Employee</button>
                            <a type="button" name="btn_delete"id="btn_delete" class="btn btn-danger" data-toggle="modal">Delete</a>      
                        </div>
                    </div>
                </div>

                <br />  
                <div id="employee_table">  
                    <table class="table table-striped table-hover">  
                        <tr> 
                        <th>
                        <span class="custom-checkbox">
                            <input type="checkbox" id="selectAll">
                            <label for="selectAll"></label>
                        </span>
                        </th> 
                        <th> User ID</th>  
                        <th> Username</th>  
                        <th> Email</th> 
                        <th>Edit User</th>  
                        <th> Delete User </th>  
                        </tr>  
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            ?>  
                            <tr>  
                                <td>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="checkbox1" name="checkbox" value="<?php echo $row["id"]; ?>">
                                        <label for="checkbox1"></label>
                                    </span>
                                </td>
                                <td><?php echo $row["id"]; ?></td>  
                                <td><?php echo $row["username"]; ?></td>  
                                <td><?php echo $row["email"]; ?></td>  
                                <td><input type="button" name="edit" value="Edit" id="<?php echo $row["id"]; ?>" class="btn btn-primary edit_data" /></td> 
                                <td><button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-primary">Edit</button></td> 
                            </tr>  
                            <?php
                        }
                        ?>  
                    </table>
                </div>  
            </div>  
        </div>  
    </div>  
</body>  
</html>  
 
<div id="add_data_Modal" class="modal fade">  
    <div class="modal-dialog">  
        <div class="modal-content">  
            <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal">&times;</button>  
                <h4 class="modal-title">Insert and Edit</h4>  
            </div>  
            <div class="modal-body">  
                <form method="post" id="insert_form">  
                    <label>User ID</label>  
                    <input type="text" name="name" id="id" class="form-control" />  
                    <br />  
                    <label>Username</label>  
                    <input type="text" name="designation" id="username" class="form-control" />  
                    <br />  
                    <label>Email</label>  
                    <input type="text" name="age" id="email" class="form-control" />  
                    <br />  
                    <input type="hidden" name="userId" id="userId" />  
                    <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />  
                </form>  
            </div>  
            <div class="modal-footer">  
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
            </div>  
        </div>  
    </div>  
</div> 

<!-- Delete Modal HTML -->


<script>
    $(document).ready(function () {
        $('#add').click(function () {
            $('#insert').val("Insert");
            $('#insert_form')[0].reset();
        });
        //$('.edit_data').(function () {
        $(document).on('click', '.edit_data', function () {
            var userId = $(this).attr("id");
            $.ajax({
                url: "fetch.php",
                method: "POST",
                data: {id: userId},
                dataType: "json",
                success: function (data) {
                    $('#id').val(data.id);
                    $('#username').val(data.username);
                    $('#email').val(data.email);
                    $('#insert').val("Update");
                    $('#add_data_Modal').modal('show');
                }
            });
        });
        $('#insert_form').on("submit", function (event) {
            event.preventDefault();
            if ($('#id').val() == "")
            {
                alert("ID is required");
            } 
            else if ($('#username').val() == '')
            {
                alert("Username is required");
            } 
            else if ($('#email').val() == '')
            {
                alert("Email is required");
            } 
            else
            {
                $.ajax({
                    url: "insert.php",
                    method: "POST",
                    data: $('#insert_form').serialize(),
                    beforeSend: function ()
                    {
                        $('#insert').val("Inserting");
                    },
                    success: function (data)
                    {
                        $('#insert_form')[0].reset();
                        $('#add_data_Modal').modal('hide');
                        $('#employee_table').html(data);
                    }
                });
            }
        });

    });
</script>
<script>
    $(document).ready(function ()
    {
        setTimeout(function ()
        {
            $('#message').hide();
        }, 3000);
    });
</script>
<script src="javascript.js"></script>