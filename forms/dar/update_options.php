<?php
// update_options.php

// Database credentials (same as your main file)
$host = "localhost";
$database = "mathmsllc_hr";
$username = "mathmsllc_hr";
$password = "s@Yo*+0-+-H#";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["questionId"]) && isset($_POST["dropdownOptions"])) {
    $questionId = $conn->real_escape_string($_POST["questionId"]);
    $newOptions = $_POST["dropdownOptions"];

    // Clear existing options for the question
    $sqlDelete = "DELETE FROM daily_activity_dropdown_options WHERE question_id = $questionId";
    if (!$conn->query($sqlDelete)) {
        // Log the error
        error_log("Error deleting options: " . $conn->error);
        echo "Error updating options. Please try again.";
    } else {
        // Insert new options
        foreach ($newOptions as $optionText) {
            $optionText = $conn->real_escape_string($optionText);
            $sqlInsert = "INSERT INTO daily_activity_dropdown_options (question_id, option_text) VALUES ($questionId, '$optionText')";
            
            if (!$conn->query($sqlInsert)) {
                // Log the error
                error_log("Error inserting option: " . $conn->error);
                echo "Error updating options. Please try again.";
                break; // Exit the loop on the first error
            }
        }

        // If the loop completed without errors, options were updated successfully
        if (!isset($error)) {
            echo "Options updated successfully!";
        }
    }
} else {
	
    echo "Invalid request.";
}

// Close the connection
$conn->close();
?>
