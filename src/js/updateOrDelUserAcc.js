/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */
function getUserDetails(updateID) {
    $('#UserId').val(updateID);

    $.post("updateUser.php", {updateID: updateID}, function (data, status) {
        var userid = JSON.parse(data);
        $('#updateUsername').val(userid.username);
        $('#updateEmail').val(userid.email);
    });
    $('#updateUserDetails').modal("show");
}

function updateDetails() {
    var updateUsername = $('#updateUsername').val();
    var updateEmail = $('#updateEmail').val();
    var UserId = $('#UserId').val();

    $.post("updateUser.php", {
        updateUsername: updateUsername,
        updateEmail: updateEmail,
        UserId: UserId
    }, function (data, status) {
        $('#updateUserDetails').modal('hide');
        location.href = 'testAPAcc.php';
    });
}

function deleteUser(deleteID) {
    if(confirm("Are you sure you want to delete this user record?")) {
        $.ajax({
            url: "delete.php",
            type: 'post',
            data: {
                deleteid: deleteID
            },
            success: function (data, status) {
                location.href = 'testAPAcc.php';

            }
        });
    }
    else {
        location.href = 'testAPAcc.php';
    }
}

