<?php
session_start();
include('../../database/db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // ✅ Password Validations
    if (strlen($password) !== 8) {
        $_SESSION['popup'] = "Password must be exactly 8 characters";
        header("Location: ../../landingpage/index.php#register");
        exit;
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $_SESSION['popup'] = "Must contain at least 1 uppercase letter";
        header("Location: ../../landingpage/index.php#register");
        exit;
    }

    if (!preg_match('/[a-z]/', $password)) {
        $_SESSION['popup'] = "Must contain at least 1 lowercase letter";
        header("Location: ../../landingpage/index.php#register");
        exit;
    }

    if (!preg_match('/[0-9]/', $password)) {
        $_SESSION['popup'] = "Must include a number (0-9)";
        header("Location: ../../landingpage/index.php#register");
        exit;
    }

    if (!preg_match('/[\W_]/', $password)) {
        $_SESSION['popup'] = "Must include a symbol";
        header("Location: ../../landingpage/index.php#register");
        exit;
    }

    if ($password !== $confirm) {
        $_SESSION['popup'] = "Passwords do not match";
        header("Location: ../../landingpage/index.php#register");
        exit;
    }

    // ✅ Check if username exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['popup'] = "Username already exists";
        header("Location: ../../landingpage/index.php#register");
        exit;
    }

    // ✅ Insert user
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user';
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hash, $role);

    if ($stmt->execute()) {
        $_SESSION['popup'] = "Registration successful! Please login.";
        header("Location: ../../landingpage/index.php#login");
        exit;
    } else {
        $_SESSION['popup'] = "Error during registration.";
        header("Location: ../../landingpage/index.php#register");
        exit;
    }
}
?>
