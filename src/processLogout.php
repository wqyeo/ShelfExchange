<?php
    
    
    setcookie("shelfexchange_session_cookie", "", time() - (86400 * 90), "/");
    header("Location: index.php?success=logout_complete");
    exit();
?>
