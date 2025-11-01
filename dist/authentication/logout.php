<?php
session_start();
session_unset();
session_destroy();
$_SESSION['popup'] = "You have logged out successfully.";
header("Location: ../../landingpage/index.php");
exit;
?>
