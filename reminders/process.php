<?php

// Include the configuration file
require_once 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Database connection (assuming you already have a database connection established)
// Adjust the connection details based on your specific setup
$mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbDatabase);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get reminders that need to be updated
$query = "SELECT * FROM email_reminder WHERE active = 1 AND next_send_date <= NOW() - INTERVAL 2 MINUTE AND remaining > 0";
$result = $mysqli->query($query);

while ($row = $result->fetch_assoc()) {
    // Send an email using PHPMailer
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = $smtpAuth;
    $mail->Username   = $smtpUsername;
    $mail->Password   = $smtpPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $smtpPort;

    $mail->setFrom('system@mathmsllc.com');
    $mail->addAddress($row['to_email']);
    $mail->Subject = $row['subject'];
    $mail->Body    = $row['content'];

    if ($mail->send()) {
        // Update next_send_date based on frequency
        $updateQuery = "UPDATE email_reminder SET next_send_date = DATE_ADD(next_send_date, INTERVAL ";

        switch ($row['frequency']) {
            case 'Daily':
                $intervalValue = "1 DAY";
                break;
            case 'Weekly':
                $intervalValue = "1 WEEK";
                break;
            case 'Bi-Weekly':
                $intervalValue = "2 WEEK";
                break;
            case 'Monthly':
                $intervalValue = "1 MONTH";
                break;
            case 'Quarterly':
                $intervalValue = "3 MONTH";
                break;
            case 'Yearly':
                $intervalValue = "1 YEAR";
                break;
            default:
                $intervalValue = "1 DAY"; // Default to 1 day if the frequency is unexpected
                break;
        }

        $updateQuery .= $intervalValue . ") WHERE id = {$row['id']}";

        $mysqli->query($updateQuery);

        if ($mysqli->error) {
            echo "Error updating row with ID {$row['id']}: " . $mysqli->error;
        } else {
            // Update last_send_date to the current timestamp
            $updateLastSendDateQuery = "UPDATE email_reminder SET last_send_date = NOW() WHERE id = {$row['id']}";
            $mysqli->query($updateLastSendDateQuery);

            // Update remaining by subtracting 1
            $updateRemainingQuery = "UPDATE email_reminder SET remaining = remaining - 1 WHERE id = {$row['id']}";
            $mysqli->query($updateRemainingQuery);
        }
    } else {
        echo "Error sending email for row with ID {$row['id']}: " . $mail->ErrorInfo;
    }
}

// Close the database connection
$mysqli->close();
?>
