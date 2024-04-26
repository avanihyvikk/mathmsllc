<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $field = $_POST["field"];
    $value = $_POST["value"];

    $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbDatabase);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $updateFieldQuery = "UPDATE email_reminder SET $field = '$value' WHERE id = $id";

    if ($mysqli->query($updateFieldQuery) === TRUE) {
        echo "Field updated successfully!";
    } else {
        echo "Error: " . $updateFieldQuery . "<br>" . $mysqli->error;
    }

    $mysqli->close();
}
?>
