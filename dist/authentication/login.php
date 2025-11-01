<?php
session_start();
include('../../database/db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if ($user['role'] !== 'user') {
                $popup = "This login page is for users only. Please use the owner login page.";
                echo "<script>
                    alert('$popup');
                    window.history.back();
                </script>";
                exit;
            }
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['popup'] = "Login successful!";

                header("Location: ../../landingpage/index.php");
                exit;
            } else {
                $popup = "Invalid password";
            }
        } else {
            $popup = "Username not found";
        }
    } else {
        $popup = "Please enter a username";
    }
    
    echo "<script>
        alert('$popup');
        window.history.back();
    </script>";
    exit;
}
?>