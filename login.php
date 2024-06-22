<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    if (!$stmt) {
        $_SESSION['error_message'] = "Prepare failed: " . $conn->error;
        header("Location: index.php?error=" . urlencode($_SESSION['error_message']));
        exit;
    }
    $stmt->bind_param("s", $username);

    if (!$stmt->execute()) {
        $_SESSION['error_message'] = "Execute failed: " . $stmt->error;
        header("Location: index.php?error=" . urlencode($_SESSION['error_message']));
        exit;
    }
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username; 
            header("Location: users.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Invalid username or password";
            header("Location: index.php?error=" . urlencode($_SESSION['error_message']));
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Username not found";
        header("Location: index.php?error=" . urlencode($_SESSION['error_message']));
        exit;
    }
    $stmt->close();
    $conn->close();
}
?>
