<?php
session_start();
include('../../database/db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (!empty($username)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if ($user['role'] !== 'owner') {
                $_SESSION['popup'] = "This login page is for admins only. Please use the user login page.";
                header("Location: ../../landingpage/index.php#admin");
                exit;
            }
            
            if (password_verify($password, $user['password'])) {
                $_SESSION["admin_logged_in"] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                header("Location: ../admin/administrator.php");
                exit;
            } else {
                $_SESSION['popup'] = "Invalid Admins Credentials!";
                header("Location: ../../landingpage/index.php#admin");
                exit;
            }
        } else {
            $_SESSION['popup'] = "Admins account not found!";
            header("Location: ../../landingpage/index.php#admin");
            exit;
        }
    } else {
        $_SESSION['popup'] = "Please enter username!";
        header("Location: ../../landingpage/index.php#admin");
        exit;
    }
}
?>