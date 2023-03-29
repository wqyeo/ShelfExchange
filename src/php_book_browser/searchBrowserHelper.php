
<?php

require_once "php_util/bookDatabaseHelper.php";

/**
 * Helper class to generate book listing HTML code snippets
 */
class SearchBrowserHelper
{
    private BookDatabaseHelper $databaseHelper;
    private string $searchQuery;

    /**
     * How many results are found from search.
     * Unset until 'displaySearchResults' are called.
     */
    public int $searchResultCount;

    public const RECOMMEND_BOOKS_COUNT = 4;

    public function __construct(string $searchQuery, mysqli $connection)
    {
        $this->databaseHelper = new BookDatabaseHelper($connection);
        $this->searchResultCount = 0;
        $this->searchQuery = $searchQuery;
    }

    /**
     * Recommend random books,
     * directly injects HTML into where this function is called.
     */
    public function recommendRandomBooks(): void
    {
        $booksResult = $this->databaseHelper->randomlyFetchBooks($this::RECOMMEND_BOOKS_COUNT);
        if (isset($booksResult)) {
            $this->generateListByResult($booksResult);
        } else {
            echo "Failed to fetch books from server, fresh page or contact support!";
        }
    }

    /**
     *  Display user's search result,
     *  directly injects HTML into where this function is called.
     */
    public function displaySearchResults(): void
    {
        // Nothing in search query
        if (!isset($this->searchQuery)) {
            echo "You placed nothing in your search query...";
            return;
        }
        $searchResult = $this->databaseHelper->fetchBookBySearchQuery($this->searchQuery);
        if (isset($searchResult)) {
            $this->generateListByResult($searchResult);
        } else {
            echo "Failed to execute your search query, try again or contact support.";
        }
    }

    /**
     * From the SQL result of selecting books,
     * generate code snippets of HTML cards for each book
     */
    private function generateListByResult(mysqli_result $booksResult): void
    {
        $this->searchResultCount = 0;
        if (mysqli_num_rows($booksResult) > 0) {
            // For each result, generate HTML card.
            while ($row = mysqli_fetch_assoc($booksResult)) {
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
                <div class="text-center">$' . $row['cost_per_quantity'] . '</div>
              </div>';
                } else {
                    $cartButton = '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center"><a class="btn btn-secondary btn-outline-dark mt-auto text-white" href="#" disabled>Out of Stock</a></div>

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

            $this->searchResultCount += 1;
        } else {
            echo "Got zero results from your search...";
        }
    }
} ?>
