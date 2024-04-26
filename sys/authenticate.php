<?php
session_start();

// Simulated user credentials (replace with your actual database query)
$valid_username = 'user_id';
$valid_password_hash = password_hash('password', PASSWORD_DEFAULT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify username and password
    if ($username === $valid_username && password_verify($password, $valid_password_hash)) {
        // Authentication successful, set session variables
        $_SESSION['username'] = $username;
        header("Location: welcome.php");
        exit;
    } else {
        // Authentication failed, redirect back to login page with error message
        header("Location: index.php?error=1");
        exit;
    }
}
?>