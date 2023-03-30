<?php

class SignUpErrorCode {
    const MISSING_FIELDS = "missing_fields";
    const EMAIL_INPUT_INVALID = "email_input_invalid";
    const PASSWORD_INPUT_INVALID = "password_input_valid";
    const USERNAME_INPUT_INVALID = "username_input_invalid";
    const FNAME_INPUT_INVALID = "fname_input_invalid";
    const LNAME_INPUT_INVALID = "lname_input_invalid";
    CONST CONTACTNO_INPUT_INVALID = "contactno_input_invalid";

    const EMAIL_USED = "email_used";
    const USERNAME_USED = "username_used";

    const CONNECTION_FAILED = "connection_failed"; // Initial connection to database failed.
    const CONNECTION_FAILED_STATEMENT_ERROR = "connection_failed_statement_error"; // Connection failed when executing SQL statement
}

?>
