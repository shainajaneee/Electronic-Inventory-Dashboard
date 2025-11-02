<?php
require_once 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        $_SESSION['alert'] = "Email already registered!";
        $_SESSION['type'] = "error";
        header("Location: landing.php");
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $password])) {
        $_SESSION['alert'] = "Registration successful! You can now log in.";
        $_SESSION['type'] = "success";
    } else {
        $_SESSION['alert'] = "Registration failed. Try again.";
        $_SESSION['type'] = "error";
    }

    header("Location: landing.php");
    exit;
}
?>
