<?php
session_start();
include('../../database/db_config.php');

if (!isset($_SESSION['username'])) {
    header("Location: ../admin/index.php");
    exit;
}

$username = $_SESSION['username'];

$stmt = $conn->prepare("DELETE FROM users WHERE username=?");
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    session_destroy();
    session_start();
    $_SESSION['popup'] = "Your account has been deleted successfully.";
    header("Location: ../admin/index.php#login");
    exit;
} else {
    $_SESSION['popup'] = "Error deleting account.";
    header("Location: ../admin/index.php#profile");
    exit;
}
?>
