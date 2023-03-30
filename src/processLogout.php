<?php
    
    
    require 'php_util/util.php';
    $connection = createDatabaseConnection();
    
    include "php_util/userSessionHelper.php";
    $userSessionHelper = new UserSessionHelper($connection);
    $userSessionHelper->removeToken($_COOKIE[UserSessionHelper::SESSION_TOKEN_COOKIE_NAME]);
    
    setcookie("shelfexchange_session_cookie", "", time() - (86400 * 90), "/");
    
    
    header("Location: index.php?success=logout_complete");

    exit();
?>
