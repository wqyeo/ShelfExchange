/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */

$(document).ready(function () {
    $('#updateBookModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        console.log(button);
        var bookId = button.data('book-id'); // Extract book ID from data-* attributes
        console.log(bookId);
        var bookTitle = button.data('book-title'); // Extract book title from data-* attributes
        console.log(bookTitle);
        var bookReleaseDate = button.data('book-release-date'); // Extract book release date from data-* attributes
        console.log(bookReleaseDate);
        var modal = $(this);
        modal.find('.modal-title').text('Update Book: ' + bookTitle);
        modal.find('.modal-body input#book-id').val(bookId);
        modal.find('.modal-body input#update-title').val(bookTitle);
        modal.find('.modal-body input#update-release-date').val(bookReleaseDate);

        // Add event listener to "Update Book" button in modal
        modal.find('.modal-footer button#updatebookbutton').on('click', function () {
        var title = modal.find('.modal-body input#update-title').val();
        var releaseDate = modal.find('.modal-body input#update-release-date').val();
        var image = modal.find('.modal-body input#update-image')[0].files[0];
        updateBook(bookId, title, releaseDate, image);
        });
    });
});
