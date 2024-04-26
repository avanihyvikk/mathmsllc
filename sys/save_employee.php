<?php
// Retrieve form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phoneNumber = $_POST['phoneNumber'];
$username = $_POST['username'];
$password = $_POST['password'];
$location = $_POST['location'];
$role = $_POST['role'];
$manager = $_POST['manager'];
$startDate = $_POST['startDate'];

// Insert data into the user table (Assuming you have a database connection)
// Replace the database connection details
include "db_connection.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert user data into the users table
$sql = "INSERT INTO user (first_name, last_name, email, phone_number, username, password) 
        VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', '$username', '$password')";

if ($conn->query($sql) === TRUE) {
    // Retrieve the user ID of the newly inserted user
    $userId = $conn->insert_id;

    // Insert user details into the user_details table
    $sql = "INSERT INTO user_details (user_id, location_id, role_id, manager_id, start_date) 
            VALUES ('$userId', '$location', '$role', '$manager', '$startDate')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
