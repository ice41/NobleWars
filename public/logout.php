<?php
// Logout script
setcookie("session", "", time() - 1);
setcookie("id", "", time() - 1);
setcookie("password", "", time() - 1);
header("Location: index.php");
exit;
?>