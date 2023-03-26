# Error Models
This folder should contain all the php files containing enums for error models.

The error models should have assigned string constants, which can be used to redirect to URLs with error code.

For example:

```
class LoginError {
	const BIG_ERROR = "Big_Error";
	const NO_ACCESS = "No_Access";
}

// .. Somewhere if something occured due to error,
// redirect with error
header("Location: webpage.php?error=" . urlencode(LoginError::BIG_ERROR));

// .. Now in the webpage, we can fetch the error:
$errorCode = $_GET["error"] ?? null;
if ($errorCode) {
	// Do something if directed here due to some error;
}
```
