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
}
?>
