<?php
// Start session in case you want it globally
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database credentials
$host = "localhost";
$user = "root";
$password = "";
$dbname = "event_reservation";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
