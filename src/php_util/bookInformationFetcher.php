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

    public function __construct(int $bookId)
    {
        $this->databaseHelper = new BookDatabaseHelper();
        $this->bookInformation = $this->databaseHelper->getBookInfo($bookId);
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
}
