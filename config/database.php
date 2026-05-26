<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "library_management";

$conn = new mysqli($host, $user, $password, $database);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
