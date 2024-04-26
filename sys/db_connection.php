<?php
// Database configuration
$servername = "localhost"; // Change this to your database server name
$username = "mathmsllc_sys"; // Change this to your database username
$password = "Kk.uLONqf5rL"; // Change this to your database password
$database = "mathmsllc_sys"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally, you can set character encoding if needed
mysqli_set_charset($conn, "utf8");

// Now, this $conn object can be included in any other PHP file to perform database operations
?>
