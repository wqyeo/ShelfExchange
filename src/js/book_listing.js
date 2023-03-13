document.addEventListener("DOMContentLoaded", function() {
    generateRandomBooksOnElement("#book-list");
});

/*
 * Generate random book list on element.
 * @param {type} elementId ID of the target element. Element should be <ul>.
 * @returns {undefined}
 */
function generateRandomBooksOnElement(elementId) {

    var bookCount = Math.random() * (9 - 5) + 5;
    var bookList = _randomlyCreateBookObject(bookCount);

    var bookListHtml = "";
    for (var i = 0; i < bookList.length; i++) {
      var book = bookList[i];
      var bookHtml = '<div class="col-md-3">' +
                       '<div class="book">' +
                         '<img src="' + book.image + '">' +
                         '<p class="book-title">' + book.title + '</p>' +
                       '</div>' +
                     '</div>';
      bookListHtml += bookHtml;
    }

    $(elementId).html(bookListHtml);
}

/*
 * Create a certain amount of randomly generated book objects.
 * @param {type} createAmount How many books to create.
 * @returns {Array|_randomlyCreateBookObject.bookList} The list of books that are randomly created.
 */
function _randomlyCreateBookObject(createAmount){
        var bookTitles = [
            "The Great Gatsby",
            "To Kill a Mockingbird",
            "1984",
            "The Catcher in the Rye",
            "Pride and Prejudice",
            "Lord of the Flies",
            "The Hobbit",
            "Frankenstein",
            "The Picture of Dorian Gray",
            "The Adventures of Huckleberry Finn",
            "The Scarlet Letter",
            "Dracula",
            "Wuthering Heights",
            "Sense and Sensibility",
            "The Time Machine",
            "Moby-Dick",
            "Little Women",
            "War and Peace",
            "Don Quixote",
            "The Odyssey",
            "The Iliad",
            "Hamlet",
            "Macbeth",
            "Romeo and Juliet",
            "The Canterbury Tales",
            "Paradise Lost"
    ];
    
    var bookList = [];
    for (var i = 0; i < createAmount; ++i) {
        var randomTitleIndex = Math.floor(Math.random() * bookTitles.length);
        var book = {
                title: bookTitles[randomTitleIndex],
                image: "images/not_found.png"
        };
        bookList.push(book);
    }
    
    return bookList;
}