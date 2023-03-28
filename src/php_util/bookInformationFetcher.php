<?php

require "php_util/bookDatabaseHelper";

/**
 * Helper class to fetch information about a book,
 * based on the book id.
 */
class BookInformationFetcher
{
  private BookDatabaseHelper $databaseHelper;
  private int $bookId;

  public function __construct(int $bookId)
  {
    $this->bookId = $bookId;
    $this->databaseHelper = new BookDatabaseHelper();
  }
}
