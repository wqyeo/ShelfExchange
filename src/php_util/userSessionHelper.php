<?php

require_once "php_util/util.php";

/**
 * Helper class to create and verify a user session
 */
class UserSessionHelper
{
    public const SESSION_TOKEN_COOKIE_NAME = "shelfexchange_session_cookie";

    private mysqli $connection;
    private ?array $currentUserInformation;
    private bool $loggedIn;

    public function __construct(mysqli $connection)
    {
        $this->loggedIn = false;
        $this->connection = $connection;

        // If cookie is set
        if (isset($_COOKIE[$this::SESSION_TOKEN_COOKIE_NAME])) {
            $this->fetchUserInformation($_COOKIE[$this::SESSION_TOKEN_COOKIE_NAME]);
        }
    }

    public function removeToken(string $mytoken): void
    {
        $sql = "DELETE FROM session_token where token = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("s", $mytoken);
        $statement->execute();
        $statement->close();
    }

    private function fetchUserInformation(string $token): void
    {
        $sql = "SELECT s.*, u.username, u.profile_picture FROM user u JOIN session_token s ON u.id = s.user_id WHERE s.token = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bind_param("s", $token);

        if ($statement->execute()) {
            $result = $statement->get_result()->fetch_assoc();
            // No matching token found.
            if (!isset($result)) {
                return;
            }

            // check if session expired.
            if ($this->sessionIsValid($result['expiration'])) {
                // Not expired, set information.
                $profile_picture = $result['profile_picture'];
                if (!isset($profile_picture) || $profile_picture == "") {
                    $profile_picture = "images/genericprofpic.png";
                }
                $this->currentUserInformation = array(
"user_id" => $result['user_id'],
"username" => $result['username'],
"profile_picture" => $profile_picture);
                $this->loggedIn = true;
            }
        } else {
            // TODO: Something if failure.
        }
        $statement->close();
    }

/**
 * Check if a session is valid by checking
 * - Token expiry date
 * - browser (if the user's browser is still the same)
 * - operating system (if the user's OS is still the same)
 */
    private function sessionIsValid(string $expiryDate): bool
    {
        $timezone = new DateTimeZone('Asia/Singapore');
        $currentDateTime = new DateTime('now', $timezone);
        $otherDateTime = new DateTime($expiryDate, $timezone);
        // Token expired
        if ($currentDateTime->getTimestamp() > $otherDateTime->getTimestamp()) {
            return false;
        }
        return true;
    }

    public function createNewUserSession(int $userId, string $username, ?string $profile_picture): void
    {
        $currentDateTime = getCurrentDateTime();
        $expiryDate =  date('Y-m-d H:i:s', strtotime($currentDateTime . ' + 3 days'));

        $token = base64_encode(random_bytes(32));
        $statement = $this->connection->prepare("INSERT INTO session_token (token, expiration, user_id) VALUES (?,?,?)");
        $statement->bind_param("ssi", $token, $expiryDate, $userId);
        if ($statement->execute()) {
            setcookie($this::SESSION_TOKEN_COOKIE_NAME, $token, time() + (86400 * 90), "/");
            $this->loggedIn = true;

            if (!isset($profile_picture) || $profile_picture == "") {
                $profile_picture = "images/genericprofpic.png";
            }

            $this->currentUserInformation = array(
"user_id" => $userId,
"username" => $username,
"profile_picture" => $profile_picture
);
        }
    }

    public function isLoggedIn(): bool
    {
        return $this->loggedIn;
    }

    public function getUserInformation(): ?array
    {
        return $this->currentUserInformation;
    }
}
