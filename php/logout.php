<?php

// Adapted from best way to destroy session http://stackoverflow.com/questions/3948230/best-way-to-completely-destroy-a-session-even-if-the-browser-is-not-closed

session_start();
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
// redirect to login
echo '<script type="text/javascript">window.location ="login.php"</script>';

 ?>
