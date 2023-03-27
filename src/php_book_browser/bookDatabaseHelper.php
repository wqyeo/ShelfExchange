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
    *  The result is sorted by matching book titles first, then author, then tags.
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
        $sql = "SELECT title, image FROM book ORDER BY RAND() LIMIT " . $bookCount;
        return $this->connection->query($sql);
    }

    public function dispose(): void
    {
        $this->connection->close();
    }
}?>
