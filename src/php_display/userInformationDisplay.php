<?php

require_once "php_util/userSessionHelper.php";

/**
 * Helper class to display all the reviews
 * belonging to the a given user .
 */
class UserReviewsDisplay
{
    private mysqli $connection;
    private int $userId;

    public function __construct(mysqli $connection, int $userId)
    {
        $this->connection = $connection;
        $this->userId = $userId;
    }

    public function displayReviews(): void
    {
        $query = "SELECT review.book_id, review.comment, review.created_at, book.image, book.title, review.rating FROM review JOIN book ON book.id = review.book_id WHERE review.user_id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $this->userId);
        if ($statement->execute()) {
            // Bind variables to the result set columns
            $statement->bind_result($bookId, $comment, $createdAt, $image, $title, $rating);
            // Fetch the result set
            while ($statement->fetch()) {
                $this->showReview($bookId, $comment, $createdAt, $image, $title, $rating);
            }
        }
        $statement->close();
    }

    private function showReview(int $bookId, string $comment, string $createdAt, string $imageSrc, string $title, int $rating): void
    {
        // Html string for rating stars.
        $ratingDisplay = '<div class="rating text-warning d-flex small">';
        for ($i = 0; $i < $rating; ++$i) {
            $ratingDisplay .= '<div class="bi-star-fill"></div>';
        }
        for ($i = $rating; $i < 5; ++$i) {
            $ratingDisplay .= '<div class="bi-star"></div>';
        }
        $ratingDisplay .="</div>";

        echo '
                <li class="my-1 mb-2 review-item">
                  <div class="row">
                      <div class="col-md-4">
                            <img src="'. $imageSrc .'" alt="" class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <a href="bookInformation.php?book='. $bookId .'"><h2 class="review-title">'  . $title . '</h2></a>
                            <div class="review-comment">' .  $comment . '</div>
                            '. $ratingDisplay . '
                            <div class="review-date">' . $createdAt . '</div>
                        </div>
                    </div>
                    <hr>
                </li>
';
    }

    public function displayOrders(): void
    {
        $orderHistoryQuery = "SELECT id, order_date FROM order_history WHERE user_id = ?";
        $orderHistoryStatement = $this->connection->prepare($orderHistoryQuery);
        $orderHistoryStatement->bind_param("i", $this->userId);

        if ($orderHistoryStatement->execute()) {
            $orderHistoryStatement->bind_result($orderHistoryId, $orderDate);
            // Fetch the result set
            while ($orderHistoryStatement->fetch()) {
                $ordersQuery = "SELECT quantity, cost_per_quantity FROM book_order WHERE order_id = ?";
                $ordersStatement = $this->connection->prepare($ordersQuery);
                $ordersStatement->bind_param("i", $orderHistoryId);
                $ordersStatement->execute();

                $orderPrice = 0.0;
                $result = $ordersStatement->get_result();

                while ($row = $result->fetch_assoc()) {
                    $orderPrice += $row['quantity'] * $row['cost_per_quantity'];
                }
                $this->showOrder($orderHistoryId, $orderDate, $orderPrice);
                $ordersStatement->close();
            }
        }

        $orderHistoryStatement->close();
    }

    private function showOrder(int $orderId, string $orderDate, float $price): void
    {
        echo '
                <li class="review-item">
                            <a href="orderInformation.php?order='. $orderId .'"><h2 class="review-title">Order #'  . $orderId . '</h2></a>
                            <div class="review-comment">Total Cost: ' .  $price . '</div>
                            <div class="review-date">' .  $orderDate . '</div>
                </li>

';
    }
}
