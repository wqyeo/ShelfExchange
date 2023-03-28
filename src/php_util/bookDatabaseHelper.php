<?php

/**
 * Helper class to fetch books from database
 * NOTE: Remember to call dispose when done.
 */
class BookDatabaseHelper
{
    private mysqli $connection;

    public function __construct()
    {
        require 'php_util/util.php';
        $this->connection = createDatabaseConnection();

        if ($this->connection->connect_error) {
            echo "Connection failed";
        }
    }

    /**
     *  Search for all books based on the given search query.
     *  Where the author, tags and book titles matches the search query.
     */
    public function fetchBookBySearchQuery(string $searchQuery): mysqli_result
    {
        $searchQuery = mysqli_real_escape_string($this->connection, $searchQuery);
        $sql = "SELECT DISTINCT book.*
FROM book
LEFT JOIN book_author ON book.id = book_author.book_id
LEFT JOIN author ON author.id = book_author.author_id
LEFT JOIN book_tag ON book.id = book_tag.book_id
LEFT JOIN tag ON tag.id = book_tag.tag_id
WHERE book.title LIKE CONCAT('%', ? ,'%')
  OR author.name LIKE CONCAT('%', ? ,'%')
  OR tag.name LIKE CONCAT('%', ? ,'%')";
        $statement = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($statement, "sss", $searchQuery, $searchQuery, $searchQuery);

        mysqli_stmt_execute($statement);
        $results = mysqli_stmt_get_result($statement);
        $statement->close();
        return $results;
    }

    /**
     * Randomly fetch a given number of books from the database.
     * @return mysqli_result SQL Results
     */
    public function randomlyFetchBooks(int $bookCount): mysqli_result
    {
        $sql = "SELECT * FROM book ORDER BY RAND() LIMIT " . $bookCount;
        return $this->connection->query($sql);
    }


    //#region Book Information Fetching
    /**
     * Fetch all information about a book from the book id.
     *
     * @param int $bookId ID of the book
     * @return array An array of information based on the book.
     * The direct array contains the book information, additionally:
     * - 'tags' The array of tags.
     * - 'authors' The array of authors.
     * - 'language' The language of the book.
     * - 'reviews' The reviews for this book.
     */
    public function getBookInfo(int $bookId): ?array
    {
        // TODO: Get book price and stock (inventory)
        $bookInfo = $this->getBook($bookId);
        $languageInfo = $this->getLanguage($bookInfo['language_id']);
        $authors = $this->getAuthors($bookId);
        $tags = $this->getTags($bookId);
        $reviews = $this->getReviews($bookId);

        // Combine information into a single array
        $bookInfo['language'] = $languageInfo;
        $bookInfo['authors'] = $authors;
        $bookInfo['tags'] = $tags;
        $bookInfo['reviews'] = $reviews;

        return $bookInfo;
    }

    private function getBook(int $bookId): ?array
    {
        $statement = $this->connection->prepare("SELECT * FROM book WHERE id=?");
        $statement->bind_param("i", $bookId);
        $statement->execute();
        $result = $statement->get_result();
        $bookInfo = $result->fetch_assoc();
        $statement->close();
        return $bookInfo;
    }

    private function getLanguage(int $languageId): ?array
    {
        $statement = $this->connection->prepare("SELECT * FROM book_language WHERE id=?");
        $statement->bind_param("i", $languageId);
        $statement->execute();
        $result = $statement->get_result();
        $languageInfo = $result->fetch_assoc();
        $statement->close();
        return $languageInfo;
    }

    private function getAuthors(int $bookId): ?array
    {
        $statement = $this->connection->prepare("SELECT author.name, author.id FROM book_author LEFT JOIN author ON book_author.author_id = author.id WHERE book_author.book_id=?");
        $statement->bind_param("i", $bookId);
        $statement->execute();
        $result = $statement->get_result();
        $authors = array();
        while ($row = $result->fetch_assoc()) {
            array_push($authors, array('id' => $row['id'], 'name' => $row['name']));
        }
        $statement->close();
        return $authors;
    }

    private function getTags(int $bookId): ?array
    {
        $statement = $this->connection->prepare("SELECT tag.name, tag.id FROM book_tag LEFT JOIN tag ON book_tag.tag_id = tag.id WHERE book_tag.book_id=?");
        $statement->bind_param("i", $bookId);
        $statement->execute();
        $result = $statement->get_result();
        $tags = array();
        while ($row = $result->fetch_assoc()) {
            array_push($tags, array('id' => $row['id'], 'name' => $row['name']));
        }
        $statement->close();
        return $tags;
    }

    /**
    * Additionally, includes the username and user's profile picture for the review.
    */
    private function getReviews(int $bookId): ?array
    {
        $statement = $this->connection->prepare("SELECT review.*, user.username, user.profile_picture FROM review LEFT JOIN user ON review.user_id = user.id WHERE review.book_id=?");
        $statement->bind_param("i", $bookId);
        $statement->execute();
        $result = $statement->get_result();
        $reviews = array();
        while ($row = $result->fetch_assoc()) {
            array_push($reviews, $row);
        }
        $statement->close();
        return $reviews;
    }
    //#endregion

    /**
     * Fetches a set amount of random books that meet the tagId;
     * Additionally, if the result is empty, it will just randomly select books up to the set amount.
     * @param int $excludeBookId The ID of a book to exclude from the search result
     */
    public function getRandomBooksByTagOrRandom(int $tagId, int $maxBooks, int $excludeBookId=null): ?array
    {
        $books = array(); // Array to store selected books

        // SQL statement to exclude a set book from search result,
        // if the param is set.
        $exclude = '';
        if (!empty($excludeBookId)) {
            $exclude = ' AND book.id != ' . $excludeBookId;
        }

        // Prepare SQL statement to select books by tag
        $sql = "SELECT book.* FROM book
                INNER JOIN book_tag ON book.id = book_tag.book_id
                WHERE book_tag.tag_id = ? " . $exclude . "
                ORDER BY RAND()
                LIMIT ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ii", $tagId, $maxBooks);

        // Execute SQL statement and store results in array
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                array_push($books, $row);
            }
        }
        $stmt->close();

        if (empty($books)) {
            // if no results found, select 8 random books
            $statement = $this->connection->prepare("SELECT * FROM book WHERE id != ? ORDER BY RAND() LIMIT ?");
            $statement->bind_param("ii", $excludeBookId, $maxBooks);
            $statement->execute();
            $result = $statement->get_result();
            while ($row = $result->fetch_assoc()) {
                array_push($books, $row);
            }
            $statement->close();
        }

        return $books;
    }

    public function dispose(): void
    {
        $this->connection->close();
    }
}
