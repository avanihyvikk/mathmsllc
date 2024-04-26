<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $active = $_POST["active"];

    $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbDatabase);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $updateActiveQuery = "UPDATE email_reminder SET active = " . ($active == 1 ? 0 : 1) . " WHERE id = $id";

    if ($mysqli->query($updateActiveQuery) === TRUE) {
        echo "Active status updated successfully!";
    } else {
        echo "Error: " . $updateActiveQuery . "<br>" . $mysqli->error;
    }

    $mysqli->close();
}
?>
