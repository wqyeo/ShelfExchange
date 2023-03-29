<?php

require "php_util/bookDatabaseHelper.php";
/**
 * Helper class to fetch information about a book,
 * based on the book id.
 */
class BookInformationFetcher
{
    private BookDatabaseHelper $databaseHelper;
    private ?array $bookInformation;

    public const RELATED_BOOK_LIST_COUNT = 8;

    private ?array $currentUserReviewInformation;

    public function __construct(int $bookId, mysqli $connection, ?int $currentUserId)
    {
        $this->databaseHelper = new BookDatabaseHelper($connection);
        $this->bookInformation = $this->databaseHelper->getBookInfo($bookId, $currentUserId);

        if (isset($currentUserId) && !empty($currentUserId)) {
            $this->currentUserReviewInformation = $this->databaseHelper->getUserBookReview($bookId, $currentUserId);
        }
    }

    public function getCurrentUserReview(): ?array
    {
        return $this->currentUserReviewInformation;
    }

    public function getBookInformation(): ?array
    {
        return $this->bookInformation;
    }

    public function getBookAuthors(): ?array
    {
        return $this->bookInformation['authors'];
    }

    public function getBookTags(): ?array
    {
        return $this->bookInformation['tags'];
    }

    public function getBookLanguage(): ?array
    {
        return $this->bookInformation['language'];
    }

    public function getBookReviews(): ?array
    {
        return $this->bookInformation['reviews'];
    }

    public function displayRelatedBooksList(): void
    {
        if (isset($this->bookInformation)) {
            $books = null;
            $currentBookId = $this->bookInformation['id'];
            $bookTagId = -1; // Force to fetch random books if no tag set.
            if (isset($this->bookInformation['tags']) && !empty($this->bookInformation['tags'])) {
                $bookTagId = reset($this->bookInformation['tags'])['id'];
            }
            $books = $this->databaseHelper->getRandomBooksByTagOrRandom($bookTagId, $this::RELATED_BOOK_LIST_COUNT, $currentBookId);
            $this->generateListByBookArray($books);
        }
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
                $row = $booksResult[$i];
                // Check book quanity, to determine if we should disable
                // the cart button.
                $bookQuantity = -1;
                if (isset($row['quantity'])) {
                    $bookQuantity = $row['quantity'];
                }

                $cartButton = "";
                if ($bookQuantity >= 1) {
                    $cartButton = '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center"><a class="btn btn-outline-dark mt-auto" onclick="addToCart(' . $row["id"] . ')" href="#">Add to Cart</a></div>
                <div class="text-center">' . $row['cost_per_quantity'] . '</div>
              </div>';
                } else {
                    $cartButton = '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center"><a class="text-white btn btn-secondary btn-outline-dark mt-auto" href="#" disabled>Out of Stock</a></div>
              </div>';
                }

                echo '<div class="col mb-5">
            <div class="card h-100">
              <!--Book image; Href to information-->
            <a href="bookInformation.php?book=' . $row["id"] . '"> 
              <img class="card-img-top" src="' . $row["image"] . '" alt="..." />
            </a>  
            <!-- Product details-->
              <div class="card-body p-4">
                <div class="text-center">
                  <!--Book title; Href to information-->
                <a href="bookInformation.php?book=' . $row["id"] . '" class="text-decoration-none text-dark">
                  <h5>' . $row["title"] . '</h5>
                </a>
                </div>
              </div>
              <!-- Product actions-->
                ' . $cartButton .  '
            </div>
          </div>';
            }
        } else {
            echo "Failed to get any resulting books, refresh the page or contact support!";
        }
    }
}
