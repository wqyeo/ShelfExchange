<?php

include "php_book_browser/bookDatabaseHelper.php";

/**
 * Helper class to generate book listing HTML code snippets
    */
class IndexBrowserHelper
{
    private BookDatabaseHelper $databaseHelper;

    public const FEATURED_LIST_COUNT = 4;
    public const INTEREST_LIST_COUNT = 8;

    public function __construct()
    {
        $this->databaseHelper = new BookDatabaseHelper();
    }
    /**
 * Create and generate a HTML code snippet for interest book list.
            * The HTML code is placed on wherever this function is called.
            */
    public function createInterestBookList(): void
    {
        $booksResult = $this->databaseHelper->randomlyFetchBooks($this::INTEREST_LIST_COUNT);
        if (isset($booksResult)) {
            $this->generateListByResult($booksResult);
        } else {
            echo "Failed to fetch books from server, fresh page or contact support!";
        }
    }

    /**
 * Create and generate  HTML code snipper for featured book list
            * The HTML code is placed on where this function is called
            */
    public function createFeaturedBookList(): void
    {
        // TODO: Make it actually show featured;
        $booksResult = $this->databaseHelper->randomlyFetchBooks($this::FEATURED_LIST_COUNT);
        if (isset($booksResult)) {
            $this->generateListByResult($booksResult);
        } else {
            echo "Failed to fetch books from server, fresh page or contact support!";
        }
    }

    /**
 * From the SQL result of selecting books,
 * generate code snippets of HTML cards for each book
            */
    private function generateListByResult(mysqli_result $booksResult): void
    {
        if ($booksResult->num_rows > 0) {
            // For each result, generate HTML card.
            while ($row = $booksResult->fetch_assoc()) {
                echo '<div class="col mb-5">
            <div class="card h-100">
              <!-- Product image-->
              <img class="card-img-top" src="' . $row["image"] . '" alt="..." />
              <!-- Product details-->
              <div class="card-body p-4">
                <div class="text-center">
                  <!-- Product name-->
                  <h5 class="fw-bolder">' . $row["title"] . '</h5>
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

    public function dispose(): void
    {
        $this->databaseHelper->dispose();
    }
}?>
