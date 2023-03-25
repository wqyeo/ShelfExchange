<?php

class LoginErrorCode {
    const MISSING_FIELDS = "missing_fields";
    const EMAIL_INPUT_INVALID = "email_input_invalid";
    const PASSWORD_INPUT_INVALID = "password_input_valid";
    const EMAIL_ACCOUNT_NOT_FOUND = "email_account_not_found";
    const PASSWORD_INCORRECT = "password_incorrect";
    const CONNECTION_FAILED = "connection_failed"; // Initial connection to database failed.
    const CONNECTION_FAILED_STATEMENT_ERROR = "connection_failed_statement_error"; // Connection failed when executing SQL statement
}

?>
