<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "codingtest_db";  

$plain_password = 'password';
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR (50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully\n";
} else {
    die("Error creating table: " . $conn->error);
}

$stmt = $conn->prepare("INSERT INTO users (username, name, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username_param, $name_param, $hashed_password);
$name_param = 'Super Administrator';
$username_param = 'superadmin';
if ($stmt->execute() === TRUE) {
    echo "New record created successfully\n";
} else {
    die("Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
