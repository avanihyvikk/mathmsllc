<?php
include 'config.php'; // Include your config file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $center = $_POST['center'];
    $parentsFirstName = $_POST['parentsFirstName'];
    $parentsLastName = $_POST['parentsLastName'];
    $childsFirstName = $_POST['childsFirstName'];
    $childsLastName = $_POST['childsLastName'];
    $parentsEmail = $_POST['parentsEmail'];

    // Remove spaces from the $center variable for email address
    $emailCenter = str_replace(' ', '', $center);

    // Insert data into the database
    $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbDatabase);
	
	

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $insertQuery = "INSERT INTO unenroll_data (center, parents_first_name, parents_last_name, childs_first_name, childs_last_name, parents_email) 
                    VALUES ('$center', '$parentsFirstName', '$parentsLastName', '$childsFirstName', '$childsLastName', '$parentsEmail')";

    if ($mysqli->query($insertQuery) === TRUE) {
        // Send email using PHPMailer
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host       = $smtpHost;
        $mail->SMTPAuth   = $smtpAuth;
        $mail->Username   = $smtpUsername;
        $mail->Password   = $smtpPassword;
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = $smtpPort;

        // Set From address with spaces
        $mail->setFrom($emailCenter . '@mathnasium.com', "Mathnasium of $center");
        $mail->addAddress($parentsEmail);
        $mail->addBCC($ownerEmail); // Add owner's email as BCC

        // Set Reply-To address with spaces
        $replyToEmail = $center . '@mathnasium.com';
        $mail->addReplyTo($replyToEmail);

        $mail->isHTML(true);
        $mail->Subject = "Unenroll from Mathnasium of $center";
        // Dynamically generate the unenrollment link based on the selected center
        $unenrollLink = "https://mathmsllc.com/cancel/";
        $folderNames = [
			'Alamo Heights' => 'g3kPz9qYiRv7aBcF1s',
            'Belterra' => 'tRmN2lAeXcU1oZpH8y',
			'Cedar Park' => 'w5uIaR9bZvY8fXcN3s',
            'League City' => 'qJpL4mUwO2vC5xH9zK',
            'Leander' => 's1FgH8jD4kL7pT2wN6',
        ];

        // Check if the selected center has a corresponding folder name
        if (isset($folderNames[$center])) {
            $unenrollLink .= $folderNames[$center];
        } else {
            // Default to a generic folder name if no match is found
            $unenrollLink .= 'generic';
        }

        $mail->Body = "Hey $parentsFirstName,<br>
		<p>We received your request to unenroll from Mathnasium, and we wanted to reach out one more time to express our gratitude for being part of our Mathnasium community.</p>
        <p>While we respect your decision, we're genuinely sorry to see you go. Your child's learning journey with us has been meaningful, and we're grateful for the trust you've placed in us.</p>              
		<p>If there's anything specific that led to this decision, we'd appreciate any feedback you can share. Your insights are important and help us continually improve.</p>
		<p><b>To complete the unenrollment for $childsFirstName, click this link: <a href='$unenrollLink'>$unenrollLink</a>.</b></p>
		<p>We wish your child continued success, and should your circumstances change, we'd be thrilled to welcome you back.</p>
		<p>Thank you for choosing Mathnasium.</p>
		</br>
		<p>Best regards,</p>
		<p>Mathnasium of $center</p>
		";
        
        if ($mail->send()) {
            // Redirect to a confirmation page or display a success message
            header("Location: confirmation.php");
            exit();
        } else {
            // Log the error or display an error message
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } else {
        // Log the database insertion error or display an error message
        echo "Error submitting form: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
