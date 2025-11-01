<?php
session_start();
include('../../database/db_config.php');

function validatePassword($password) {
    if (strlen($password) !== 8) return "Password must be exactly 8 characters.";
    if (!preg_match('/[A-Z]/', $password)) return "Password must include at least 1 uppercase letter.";
    if (!preg_match('/[a-z]/', $password)) return "Password must include at least 1 lowercase letter.";
    if (!preg_match('/[0-9]/', $password)) return "Password must include at least 1 number.";
    if (!preg_match('/[\W_]/', $password)) return "Password must include at least 1 symbol.";
    return true;
}

// ✅ CHECK USERNAME - from forgot password modal
if (isset($_POST['username']) && !isset($_POST['new_password'])) {
    $username = trim($_POST['username']);
    
    // Check if username exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username found - store in session and return success
        $_SESSION['reset_user'] = $username;
        echo "success";
    } else {
        // Username not found
        echo "Username not found. Please check and try again.";
    }
    exit;
}

// ✅ RESET PASSWORD - from reset password modal
if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    // Check if user is verified via session
    if (!isset($_SESSION['reset_user'])) {
        echo "Session expired. Please start over.";
        exit;
    }

    $username = $_SESSION['reset_user'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Validate password strength
    $check = validatePassword($new_password);
    if ($check !== true) {
        echo $check;
        exit;
    }

    // Hash new password and update in database
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $update->bind_param("ss", $hashed_password, $username);

    if ($update->execute()) {
        // Password updated successfully
        unset($_SESSION['reset_user']);
        echo "success";
    } else {
        echo "Error resetting password. Please try again.";
    }
    exit;
}
?>