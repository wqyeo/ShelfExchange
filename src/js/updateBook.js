/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */

$(document).ready(function () {
    $('#addBookForm').on('submit', function (event) {
        event.preventDefault();
        if (!confirm('Are you sure you want to add this book?')) {
            return;
        }

        var form = $('#addBookForm')[0];
        var formData = new FormData(form);
        $.ajax({
            type: 'POST',
            url: 'book_functions.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('Error adding book: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
                alert('Error adding book.');
            }
        });
    });

    $('#updateBookModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var bookId = button.data('book-id');
        var bookTitle = decodeURIComponent(button.data('book-title'));
        var bookReleaseDate = button.data('book-release-date');
        var bookDescription = decodeURIComponent(button.data('book-description'));
        var modal = $(this);
        modal.find('.modal-title').text('Update Book: ' + bookTitle);
        modal.find('.modal-body input#book-id').val(bookId);
        modal.find('.modal-body input#update-title').val(bookTitle);
        modal.find('.modal-body input#update-release-date').val(bookReleaseDate);
        modal.find('.modal-body textarea#update-description').val(bookDescription);
    });
    
    $('#updateBookForm').on('submit', function (event) {
        event.preventDefault();
        if (!confirm('Are you sure you want to update this book?')) {
            return;
        }

        var form = $('#updateBookForm')[0];
        var formData = new FormData(form);
        $.ajax({
            type: 'POST',
            url: 'book_functions.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('Error adding book: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
                alert('Error adding book.');
            }
        });

    });
    $('#deleteBook').on('click', function () {
        if (!confirm('Are you sure you want to delete this book?')) {
            return;
        }

        var bookId = $('#book-id').val();
        $.post('book_functions.php', {'book_id': bookId}, function (response) {
            if (response === 'success') {
                alert('Book deleted successfully!');
                location.reload();
            } else {
                alert('Error deleting book: ' + response);
            }
        });
    });
});