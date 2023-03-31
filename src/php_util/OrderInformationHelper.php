

<?php
require_once "php_util/util.php";
require_once "php_util/bookDatabaseHelper.php";


class OrderInformationHelper
{
    private mysqli $connection;
    private BookDatabaseHelper $bookDatabase;
    private int $orderId;

    public function __construct(mysqli $connection, int $orderId)
    {
        $this->orderId = $orderId;
        $this->connection = $connection;
        $this->bookDatabase = new BookDatabaseHelper($connection);
    }

    public function getOrderedBooks(): ?array
    {
        if (isset($this->orderId)) {
            return $this->bookDatabase->getBookInventoryByOrderId($this->orderId);
        } else {
            return array();
        }
    }
}
