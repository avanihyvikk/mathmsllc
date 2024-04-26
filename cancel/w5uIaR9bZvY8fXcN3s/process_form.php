<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Center Variables
$centerName = "Cedar Park";
$centeremail = "cedarpark@mathnasium.com";
$DMemail = "dm1@mathnasium.com";
$owneremail = "greg.pratt@mathnasium.com";
$centerNameCombined = "cedarpark";
$centerPhone = "(512) 869-6284";



// Database credentials
$host = "localhost";
$database = "mathmsllc_hr";
$username = "mathmsllc_hr";
$password = "s@Yo*+0-+-H#";

// Create a connection
$connection = new mysqli($host, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Initialize confirmation message and submit button visibility variables
$confirmationMessage = '';
$submitButtonVisible = true;

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $yourName = mysqli_real_escape_string($connection, $_POST["yourName"]);
    $childName = mysqli_real_escape_string($connection, $_POST["childName"]);
    $cancelDate = mysqli_real_escape_string($connection, $_POST["cancelDate"]);
    $reason = mysqli_real_escape_string($connection, $_POST["reason"]);
    $phoneNumber = preg_replace("/[^0-9]/", "", $_POST["phoneNumber"]); // Remove non-numeric characters
    $emailAddress = filter_var($_POST["emailAddress"], FILTER_VALIDATE_EMAIL);
    $accept = isset($_POST["accept"]) ? 1 : 0;

    // Additional values
    $heading = "Cancellation - $centerName - $childName";
    $company_id = 1;
	
	// Fetch team_id from teams table based on $centerName
	$sqlFetchTeamId = "SELECT id FROM teams WHERE team_name = '$centerName'";
	$resultTeamId = $connection->query($sqlFetchTeamId);

	if ($resultTeamId->num_rows > 0) {
		$row = $resultTeamId->fetch_assoc();
		$team_id = $row["id"];
		} else {
    // Handle the case when no team is found
		$team_id = null;
}


    // Fetch user_id from employee_details table
    $sqlFetchUserId = "SELECT user_id FROM employee_details WHERE department_id = $team_id AND designation_id = 1 LIMIT 1";
    $resultUserId = $connection->query($sqlFetchUserId);

    if ($resultUserId->num_rows > 0) {
        $row = $resultUserId->fetch_assoc();
        $userId = $row["user_id"];
    } else {
        // Handle the case when no user is found
        $userId = null;
    }

    // Combine form fields into a single description field
    $description = "Your Name: $yourName\nChild Name: $childName\nReason for Cancelling: $reason\nRequested Cancel Date: $cancelDate\nPhone Number: $phoneNumber\nEmail Address: $emailAddress";

    // Get today's date in the required format
    $start_date = date("Y-m-d");

    // Add 3 days to today's date
    $due_date = date("Y-m-d", strtotime($start_date . "+3 days"));

    // Priority value
    $priority = "high";

    // Board column ID value
    $board_column_id = 1;

    // Column priority value
    $column_priority = 0;

    // Additional fields
    $estimate_hours = 0;
    $estimate_minutes = 0;
    $added_by = 1;
    $created_by = 1;
    $task_category_id = 4;
    $hash = $centerNameCombined . "webform";
    $billable = 0;

	// Insert data into the 'tasks' table
    $sql = "INSERT INTO tasks (heading, description, company_id, start_date, due_date, priority, board_column_id, column_priority, estimate_hours, estimate_minutes, added_by, created_by, task_category_id, hash, billable) 
            VALUES ('$heading', '$description', $company_id, '$start_date', '$due_date', '$priority', $board_column_id, $column_priority, $estimate_hours, $estimate_minutes, $added_by, $created_by, $task_category_id, '$hash', $billable)";

    if ($connection->query($sql) === TRUE) {
        // Get the ID of the last inserted row
        $lastInsertedId = $connection->insert_id;

        // Insert into task_users table
        $sqlInsertTaskUser = "INSERT INTO task_users (task_id, user_id) VALUES ($lastInsertedId, $userId)";
        
        if ($connection->query($sqlInsertTaskUser) === TRUE) {
            // Successfully inserted into task_users table
        } else {
            // Handle error if insertion into task_users fails
            $confirmationMessage .= "<br>Error inserting into task_users: " . $sqlInsertUser . "<br>" . $connection->error;
        }

        $confirmationMessage = "Form submitted successfully!";
        $submitButtonVisible = false; // Hide submit button

        // Send first confirmation email using SMTP
        $mail1 = new PHPMailer(true);
        try {
            // Server settings
            $mail1->isSMTP();
            $mail1->Host       = 'smtp-relay.brevo.com';
            $mail1->SMTPAuth   = true;
            $mail1->Username   = 'gregpratt86@gmail.com';
            $mail1->Password   = 'xsmtpsib-67ec699a8240cbb090b05a228c95a193b5767592eb4a378839f2d3244ec67849-qc2Z5CDJpAaQbg04';
            $mail1->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail1->Port       = 587;

            // Recipients
            $mail1->setFrom('system@mathmsllc.com');
            $mail1->addAddress($centeremail);
			
			 // CC recipients
			$mail1->addCC($owneremail);
			$mail1->addCC($DMemail);

            // Content
            $mail1->isHTML(true);
            $mail1->Subject = "Cancellation Form Submission - $centerName";
            $mail1->Body    = "<p>You have a new cancellation request. The details are listed below. Please go to <a href='http://www.mathmsllc.com/hr/public/account/tasks'>http://www.mathmsllc.com/hr/public/account/tasks</a> to manage this cancellation.</p>\n\n";
            $mail1->Body   .= "<p><strong>Phone Number:</strong> $phoneNumber</p>";
            $mail1->Body   .= "<p><strong>Email Address:</strong> $emailAddress</p>";
            $mail1->Body   .= "<p><strong>Your Name:</strong> $yourName</p>";
            $mail1->Body   .= "<p><strong>Child Name:</strong> $childName</p>";
            $mail1->Body   .= "<p><strong>Requested Cancel Date:</strong> $cancelDate</p>";
            $mail1->Body   .= "<p><strong>Reason:</strong> $reason</p>";

            $mail1->send();
        } catch (Exception $e) {
            $confirmationMessage .= "<br>Mailer Error: " . $mail1->ErrorInfo;
        }

        // Send second confirmation email using SMTP
        $mail2 = new PHPMailer(true);
        try {
            // Server settings
            $mail2->isSMTP();
            $mail2->Host       = 'smtp-relay.brevo.com';
            $mail2->SMTPAuth   = true;
            $mail2->Username   = 'gregpratt86@gmail.com';
            $mail2->Password   = 'xsmtpsib-67ec699a8240cbb090b05a228c95a193b5767592eb4a378839f2d3244ec67849-qc2Z5CDJpAaQbg04';
            $mail2->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail2->Port       = 587;

            // Clear any existing BCC recipients
            $mail2->clearBCCs();
            // Set "From" and "Reply-To" addresses
            $mail2->setFrom($centeremail, 'Mathnasium of ' . $centerName);
			$mail2->addReplyTo($centeremail, 'Mathnasium of ' . $centerName);

            // Recipient
            $mail2->addAddress($emailAddress, $yourName);

            // Email body with inline CSS
            $mail2->isHTML(true);
            $mail2->Subject = 'We are sorry to see you go!';
            $mail2->Body = "
            <div style='font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f0f0f0;'>
                <div style='background-color: #007bff; color: #ffffff; padding: 15px; text-align: center;'>
                    <h2 style='margin: 0;'>We are sorry to see you go!</h2>
                </div>
                <div style='padding: 20px; background-color: #ffffff; border: 1px solid #e5e5e6; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
                    <p style='font-size: 16px; margin-bottom: 20px;'>This is to confirm that we did receive your request to cancel your child's ($childName) Mathnasium account. Your requested date of cancellation is $cancelDate.  The cancellation will be processed in accordance with your enrollment agreement.</p>
                    <p style='font-size: 16px; margin-bottom: 20px;'>If you have any questions, please feel free to reach out to the Center Director.</p>
                    <div style='background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 10px; padding: 15px; margin-top: 20px;'>
                        <p style='font-size: 16px; margin-bottom: 5px;'><strong>Mathnasium of $centerName</strong></p>
                        <p style='font-size: 16px; margin-bottom: 5px;'>Email: <a href='mailto:$centeremail' style='color: #007bff; text-decoration: none;'>$centeremail</a></p>
                        <p style='font-size: 16px; margin-bottom: 0;'>Phone: $centerPhone</p>
                    </div>
                </div>
            </div>
            ";

            $mail2->send();
        } catch (Exception $e) {
            $confirmationMessage .= "<br>Mailer Error: " . $mail2->ErrorInfo;
        }
    } else {
        $confirmationMessage = "Error: " . $sql . "<br>" . $connection->error;
    }
  

        // Redirect to the confirmation page
        header("Location: confirmation.php");
        exit();
    } else {
        $confirmationMessage = "Error: " . $sql . "<br>" . $connection->error;
    }	


// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content remains unchanged -->
    <link rel="stylesheet" href="path/to/your/styles.css">
</head>
<body>
    <div class="form-container">
        <h2 class="mb-4">Cancellation Form</h2>
        <?php if ($submitButtonVisible): ?>
        <form action="process_form.php" method="post">
            <!-- Your form fields here -->
            <div class="mb-3">
                <label for="yourName" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="yourName" name="yourName" required>
            </div>
            <div class="mb-3">
                <label for="childName" class="form-label">Child Name</label>
                <input type="text" class="form-control" id="childName" name="childName" required>
            </div>
            <div class="mb-3">
                <label for="reason" class="form-label">Reason for Cancelling</label>
                <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="cancelDate" class="form-label">Requested Cancel Date</label>
                <input type="text" class="form-control datepicker" id="cancelDate" name="cancelDate" required>
            </div>
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" pattern="\d{10}" placeholder="Enter 10-digit US phone number" required>
            </div>
            <div class="mb-3">
                <label for="emailAddress" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="emailAddress" name="emailAddress" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="accept" name="accept" required>
                <label class="form-check-label" for="accept">I agree to the terms and conditions</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <?php else: ?>
        <div class="confirmation-message">
            <!-- Display confirmation message here -->
            <div class="alert alert-success" role="alert">
                <strong>Success!</strong> <?php echo $confirmationMessage; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <!-- Jquery-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap-datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script>
        // Initialize datepicker
        $(document).ready(function(){
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>
</body>
</html>
