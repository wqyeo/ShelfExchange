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

    /**
     * Fetch all information about a book from the book id.
     *
     * @param int $bookId ID of the book
     * @return array An array of information based on the book.
     * The direct array contains the book information, additionally:
     * - 'tags' The array of tags.
     * - 'authors' The array of authors.
     * - 'language' The language of the book.
     */
    public function fetchBookInformation(int $bookId): array
    {
        // Prepare and execute query to retrieve book information
        $statement = $this->connection->prepare('SELECT * FROM book WHERE id = ?');
        $statement->bind_param("i", $bookId);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();

        // Prepare and execute query to retrieve book language information
        $statement = $this->connection->prepare('SELECT * FROM book_language WHERE id = ?');
        $statement->bind_param("i", $result['language_id']);
        $statement->execute();
        $bookLanguage = $statement->get_result()->fetch_assoc();

        // Prepare and execute query to retrieve author information
        $statement = $this->connection->prepare('SELECT * FROM author INNER JOIN author_tag ON author.id = author_tag.author_id WHERE author_tag.book_id = ?');
        $statement->bind_param("i", $bookId);
        $statement->execute();
        $authors = $statement->get_result()->fetch_all(MYSQLI_ASSOC);

        // Prepare and execute query to retrieve tag information
        $statement = $this->connection->prepare('SELECT * FROM tag INNER JOIN book_tag ON tag.id = book_tag.tag_id WHERE book_tag.book_id = ?');
        $statement->bind_param("i", $bookId);
        $statement->execute();
        $tags = $statement->get_result()->fetch_all(MYSQLI_ASSOC);

        // Combine all the information into an array and return it
        $result['language'] = $bookLanguage;
        $result['authors'] = $authors;
        $result['tags'] = $tags;
        return $result;
    }

    public function dispose(): void
    {
        $this->connection->close();
    }
}
