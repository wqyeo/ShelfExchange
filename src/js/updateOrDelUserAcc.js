/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */
//$(document).ready(function() {
//  $('#updateUserDetails').on('show.bs.modal', function (event) {
//    var button = $(event.relatedTarget); // Button that triggered the modal
//    var userID = button.data('UserId'); // Extract book ID from data-* attributes
//    var userName = button.data('Username'); // Extract book title from data-* attributes
//    var userEmail = button.data('Email'); // Extract book release date from data-* attributes
//    var modal = $(this);
//    modal.find('.modal-title').text('Update User ' + userName);
//    modal.find('.modal-body input#userID').val(userID);
//    modal.find('.modal-body input#userName').val(userName);
//    modal.find('.modal-body input#userEmail').val(userEmail);
//  });
//});
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
