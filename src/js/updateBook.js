/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */

$(document).ready(function () {
    $('#updateBookModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var bookId = button.data('book-id');
        var bookTitle = button.data('book-title');
        var bookReleaseDate = button.data('book-release-date');
        var modal = $(this);
        modal.find('.modal-title').text('Update Book: ' + bookTitle);
        modal.find('.modal-body input#book-id').val(bookId);
        modal.find('.modal-body input#update-title').val(bookTitle);
        modal.find('.modal-body input#update-release-date').val(bookReleaseDate);

        // Remove previous event listeners
        modal.find('.modal-footer button#updatebookbutton').off('click');

        // Add event listener to "Update Book" button in modal
        modal.find('.modal-footer button#updatebookbutton').on('click', function () 
        {
            var title = modal.find('.modal-body input#update-title').val();
            var releaseDate = modal.find('.modal-body input#update-release-date').val();
            var image = modal.find('.modal-body input#update-image')[0].files[0];
            
            // Create FormData to store book data
            var formData = new FormData();
            formData.append('bookId', bookId);
            formData.append('title', title);
            formData.append('releaseDate', releaseDate);
            formData.append('image', image);

            // AJAX request to update book data
            $.ajax({
                url: 'bookManagement.php',
                type: 'POST',
                data: formData,
                processData: false, // Important to not process the data
                contentType: false, // Important to not set contentType
                success: function (response) {
                    if (response === 'success') {
                        // Close modal and show success message
                        $('#updateBookModal').modal('hide');
                        alert('Book successfully updated.');
                        location.reload(); // Refresh the page to show updated data
                    } else {
                        // Show error message
                        alert('Error: ' + response);
                    }
                },
                error: function (xhr, status, error) {
                    // Show error message
                    alert('An error occurred: ' + error);
                },
            });
        });
    });
});
