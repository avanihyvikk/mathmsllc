<?php
$dbHost = "localhost";
$dbUsername = "mathmsllc_chess";
$dbPassword = "BX,Z,gbfC!8D";
$dbName = "mathmsllc_chess";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $field = $_POST["field"];
    $value = $_POST["value"];

    // Create database connection
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE ChessCampRegistrations SET $field = ? WHERE id = ?");
$stmt->bind_param("si", $value, $id); // Changed "ii" to "si" for string and integer
    if ($stmt->execute()) {
        echo "Field updated successfully!";
    } else {
        echo "Error updating field: " . $conn->error;
    }

    // Close prepared statement and connection
    $stmt->close();
    $conn->close();
}
?>
