
<?php
require_once "php_util/util.php";
require_once "php_util/bookDatabaseHelper.php";
/**
 * Help with managing the cart page for user.
 */
class UserCartHelper
{
    private mysqli $connection;
    private BookDatabaseHelper $bookDatabase;
    private const CART_LIST_COOKIE_NAME = "userCarts";

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
        $this->bookDatabase = new BookDatabaseHelper($connection);
    }

    public function clearCart(): void
    {
        setcookie($this::CART_LIST_COOKIE_NAME, "", time() - 3600);
    }

    private function getBookIdCarts(): array
    {
        $cookieValue = $_COOKIE[$this::CART_LIST_COOKIE_NAME];
        $cookieValue = trim($cookieValue, '[]'); // remove the brackets
        $valueArray = explode(",", $cookieValue);
        return array_map('intval', $valueArray);
    }

    public function getBookInventoryFromCarts(): ?array
    {
        $bookIds = $this->getBookIdCarts();

        if (empty($bookIds) || 0 === count($bookIds)) {
            return array();
        } else {
            return $this->bookDatabase->getBookInventoryByBookId($bookIds);
        }
    }

    public function getCartBooks(): ?array
    {
        $bookIds = $this->getBookIdCarts();

        if (empty($bookIds) || 0 === count($bookIds)) {
            return array();
        } else {
            return $this->bookDatabase->getBooksByIds($bookIds);
        }
    }
}
