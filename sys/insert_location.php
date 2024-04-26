<?php
// Include database connection
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $locationName = $_POST['locationName'];
    $streetAddress = $_POST['streetAddress'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $manager = $_POST['manager'];

    // SQL INSERT query
    $sql = "INSERT INTO location (location_name, address_street, address_city, address_state, address_zip, address_country, manager_id) 
            VALUES ('$locationName', '$streetAddress', '$city', '$state', '$zip', '$country', '$manager')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Location added successfully
        echo "success";
    } else {
        // Error adding location
        echo "error";
    }

    // Close database connection
    $conn->close();
}
?>
