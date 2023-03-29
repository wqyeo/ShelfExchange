<?php

require "php_util/bookDatabaseHelper.php";

class AuthorInformationFetcher
{
    private ?array $authorInformation;
    private BookDatabaseHelper $bookDatabase;
    private int $authorId;

    public const RELATED_BOOK_LIST_COUNT = 8;

    public function __construct(int $authorId, mysqli $connection)
    {
        $this->authorId = $authorId;
        $this->bookDatabase = new BookDatabaseHelper($connection);
        $this->setAuthorInformation($authorId, $connection);
    }

    private function setAuthorInformation(int $authorId, mysqli $connection): void
    {
        $sql = "SELECT * FROM author WHERE id = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $authorId);
        if ($statement->execute()) {
            $this->authorInformation = $statement->get_result()->fetch_assoc();
        }
        $statement->close();
    }

    public function displayBooksWithAuthor(): void
    {
        $books = $this->bookDatabase->getRandomBooksByAuthorOrRandom($this->authorId, $this::RELATED_BOOK_LIST_COUNT);
        $this->generateListByBookArray($books);
    }

    /**
         * From the SQL result of selecting books,
         * generate code snippets of HTML cards for each book
         */
    private function generateListByBookArray(?array $booksResult): void
    {
        if (count($booksResult) > 0) {
            // For each result, generate HTML card.
            for ($i = 0; $i < count($booksResult); $i++) {
                echo '<div class="col mb-5">
            <div class="card h-100">
              <!--Book image; Href to information-->
            <a href="bookInformation.php?book=' . $booksResult[$i]["id"] . '"> 
              <img class="card-img-top" src="' . $booksResult[$i]["image"] . '" alt="..." />
            </a>  
            <!-- Product details-->
              <div class="card-body p-4">
                <div class="text-center">
                  <!--Book title; Href to information-->
                <a href="bookInformation.php?book=' . $booksResult[$i]["id"] . '" class="text-decoration-none text-dark">
                  <h5>' . $booksResult[$i]["title"] . '</h5>
                </a>
                </div>
              </div>
              <!-- Product actions-->
              <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to Cart</a></div>
              </div>
            </div>
          </div>';
            }
        } else {
            echo "Failed to get any resulting books, refresh the page or contact support!";
        }
    }

    public function getAuthorInformation(): ?array
    {
        return $this->authorInformation;
    }
}
