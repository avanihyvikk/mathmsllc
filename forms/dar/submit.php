<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
include '../../variables/KJD349ksajf.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Replace with your actual database credentials
    $host = "localhost";
    $database = "mathmsllc_hr";
    $username = "mathmsllc_hr";
    $password = "s@Yo*+0-+-H#";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check for duplicate submission
    if (!isDuplicateSubmission($conn, $_POST)) {
        // Loop through responses and insert into the responses table
        foreach ($_POST as $name => $answer) {
            if ($name !== 'location') {
                // Extract numeric part from the end of the question name
                $question_id = (int)substr($name, strrpos($name, '_') + 1);

                insertResponse($conn, $question_id, $answer, $_POST['location']);
            }
        }

        // Send email to greg.pratt@mathnasium.com using PHPMailer with SMTP
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp-relay.brevo.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'gregpratt86@gmail.com';
            $mail->Password   = 'xsmtpsib-67ec699a8240cbb090b05a228c95a193b5767592eb4a378839f2d3244ec67849-qc2Z5CDJpAaQbg04';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Sender information
            $mail->setFrom('system@mathmsllc.com');

            // Recipient information
            $mail->addAddress($dm1Email);

            // CC information
            $mail->addCC($ownerEmail);

            // Content
            $mail->isHTML(true);

            // Build the subject line with dynamic location name
            $subject = 'Daily Activity Report - ' . $_POST['location'];
            $mail->Subject = $subject;

            // Build the email body with form submission data
            $emailBody = 'A form has been submitted from ' . $_POST['location'] . '. Details:<br><br>';
            foreach ($_POST as $name => $answer) {
                if ($name !== 'location') {
                    // Extract numeric part from the end of the question name
                    $question_id = (int)substr($name, strrpos($name, '_') + 1);

                    // Retrieve question text from the database based on question_id
                    $questionText = getQuestionText($conn, $question_id);

                    // Append question text and answer to the email body
                    $emailBody .= "<strong>$questionText:</strong> $answer<br>";
                }
            }

            $mail->Body = $emailBody;

            // Send email
            $mail->send();

            // Redirect to the confirmation page to avoid form resubmission
            header('Location: confirmation.php');
            exit();
        } catch (Exception $e) {
            echo '<div class="error-message">Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '</div>';
        }
    } else {
        echo '<div class="error-message">Duplicate submission detected. Please try again.</div>';
    }

    $conn->close();
} else {
    echo 'Invalid request.';
}

function insertResponse($conn, $question_id, $answer, $location) {
    // Use prepared statement to insert data into the database
    $sql = "INSERT INTO daily_activity_responses (location, question_id, answer, submission_datetime) VALUES (?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sis", $location, $question_id, $answer);

        // Execute the statement
        $stmt->execute();

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

function isDuplicateSubmission($conn, $responses) {
    // Check if the same responses already exist in the database
    $sql = "SELECT COUNT(*) FROM daily_activity_responses WHERE 1=1";
    foreach ($responses as $questionId => $answer) {
        if ($questionId !== 'location') {
            $sql .= " AND (question_id = '$questionId' AND answer = '" . $conn->real_escape_string($answer) . "')";
        }
    }

    $result = $conn->query($sql);
    $count = $result->fetch_row()[0];

    return $count > 0;
}

function getQuestionText($conn, $question_id) {
    // Retrieve question text from the database based on question_id
    $sql = "SELECT question_text FROM daily_activity_questions WHERE question_id = '$question_id'";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['question_text'];
    }

    return '';
}
?>
