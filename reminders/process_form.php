<?php
// Include the configuration file
require_once 'config.php';

// Database connection (assuming you already have a database connection established)
// Adjust the connection details based on your specific setup
$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbDatabase);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to prevent SQL injection
    $startDatetime = $_POST["start_datetime"];
    $frequency = $_POST["frequency"];
    $durationOption = $_POST["duration_option"];
    $fromEmail = $_POST["from_email"];
    $toEmail = $_POST["to_email"];
    $subject = $_POST["subject"];
    $content = $_POST["content"];

    // Calculate next send date based on frequency
    $nextSendDate = date('Y-m-d H:i:s', strtotime($startDatetime . ' +' . ($durationOption === 'continual' ? 99999 : $_POST["duration"]) . ' ' . $frequency));

    // Insert into email_reminder table
    $duration = ($durationOption === 'continual' ? 99999 : $_POST["duration"]);
    $insertReminderQuery = "INSERT INTO email_reminder (start_datetime, frequency, duration, from_email, to_email, subject, content, last_send_date, next_send_date, active, remaining) 
                            VALUES ('$startDatetime', '$frequency', '$duration', '$fromEmail', '$toEmail', '$subject', '$content', NULL, '$startDatetime', 1, '$duration')";

    if ($mysqli->query($insertReminderQuery) === TRUE) {
        echo "Reminder inserted successfully!";
    } else {
        echo "Error: " . $insertReminderQuery . "<br>" . $mysqli->error;
    }
}

// Close the database connection
$mysqli->close();
?>
