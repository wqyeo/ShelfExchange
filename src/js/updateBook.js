/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */

$('#updateBookModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var bookId = button.data('book-id'); // Extract book id from data-* attributes

    // Fetch book data from server using AJAX
    $.ajax({
        url: 'testAP.php', // Replace with the actual server endpoint that retrieves book data
        data: { id: bookId },
        success: function (book) {
            // Populate input fields with book data
            $('#bookTitle').val(book.title);
            $('#bookAuthor').val(book.author);
            $('#bookReleaseDate').val(book.release_date);
            // ...
        },
        error: function () {
            alert('Failed to fetch book data.');
        }
    });
});
