<?php
include('config.php');

function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = validateInput($_POST['name']);
    $username = validateInput($_POST['username']);
    $plain_password = validateInput($_POST['password']); 

    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT); 

    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if($check_stmt->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO users (name, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $username, $hashed_password);
        
        if($stmt->execute()) {
            echo 0; //if success
        }else{
            echo 1; //if failed
        }
        
        $stmt->close();
    }else{
        echo 2; //if already exist
    }

    $check_stmt->close();
    $conn->close();
}
?>
