/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */

$(document).ready(function() {
  $('#updateBookModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var bookId = button.data('book-id'); // Extract book ID from data-* attributes
    var bookTitle = button.data('book-title'); // Extract book title from data-* attributes
    var bookReleaseDate = button.data('book-release-date'); // Extract book release date from data-* attributes
    var modal = $(this);
    modal.find('.modal-title').text('Update Book ' + bookTitle);
    modal.find('.modal-body input#bookId').val(bookId);
    modal.find('.modal-body input#bookTitle').val(bookTitle);
    modal.find('.modal-body input#bookReleaseDate').val(bookReleaseDate);
  });
});
