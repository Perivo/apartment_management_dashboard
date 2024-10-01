<?php
// includes/db.php
$servername = "localhost:3305";
$username = "root"; // Default username
$password = "";     // Use empty string for no password
$dbname = "apartment_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
