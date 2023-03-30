<?php

class CheckoutErrorCode
{
    public const MISSING_FIELDS = "missing_fields";
    public const INVALID_CARD = "incalid_card";
    public const CONNECTION_FAILED = "connection_failed"; // Initial connection to database failed.
    public const CONNECTION_FAILED_STATEMENT_ERROR = "connection_failed_statement_error"; // Connection failed when executing SQL statement
    public const NOT_SIGNED_IN = "not_signed_in";
    public const NO_ITEM_IN_CART ="cart_empty";
}
