<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish a connection to the database (replace the values with your database credentials)
    $servername = "localhost";
    $username = "mathmsllc_chess";
    $password = "BX,Z,gbfC!8D";
    $dbname = "mathmsllc_chess";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO ChessCampRegistrations (camp_selection, first_name, last_name, age, uscf_rating, parent_first_name, parent_last_name, contact_phone, email, other_parent_first_name, other_parent_last_name, alternate_phone, alternate_email, general_knowledge, instruction, etiquette_rules, played_tournaments, special_moves, notation, school_chess_club, plays_with_family, software_books, online_sites) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiissssssssssssssssss", $camp_selection, $first_name, $last_name, $age, $uscf_rating, $parent_first_name, $parent_last_name, $contact_phone, $email, $other_parent_first_name, $other_parent_last_name, $alternate_phone, $alternate_email, $general_knowledge, $instruction, $etiquette_rules, $played_tournaments, $special_moves, $notation, $school_chess_club, $plays_with_family, $software_books, $online_sites);

    // Extract camp selection
    $camp_selection = implode(", ", $_POST["camps"] ?? []); // Assuming multiple camps can be selected

    // Parent/Guardian information (assuming same for all children)
    $parent_first_name = $_POST["parent_first_name"] ?? null;
    $parent_last_name = $_POST["parent_last_name"] ?? null;
    $contact_phone = $_POST["contact_phone"] ?? null;
    $email = $_POST["email1"] ?? null;
    $other_parent_first_name = $_POST["other_parent_first_name"] ?? null;
    $other_parent_last_name = $_POST["other_parent_last_name"] ?? null;
    $alternate_phone = $_POST["alternate_phone"] ?? null;
    $alternate_email = $_POST["email2"] ?? null;

    // Additional questionnaire data (assuming same for all children)
    $general_knowledge = $_POST["general_knowledge"] ?? null;
    $instruction = $_POST["instruction"] ?? null;
    $etiquette_rules = $_POST["etiquette_rules"] ?? null;
    $played_tournaments = $_POST["played_tournaments"] ?? null;
    $special_moves = $_POST["special_moves"] ?? null;
    $notation = $_POST["notation"] ?? null;
    $school_chess_club = $_POST["school_chess_club"] ?? null;
    $plays_with_family = $_POST["plays_with_family"] ?? null;
    $software_books = $_POST["software_books"] ?? null;
    $online_sites = $_POST["online_sites"] ?? null;

    // Loop through each set of child data
    $children_data = "";
    for ($i = 1; isset($_POST["first_name_$i"]); $i++) {
        // Set parameters for each child
        $first_name = $_POST["first_name_$i"];
        $last_name = $_POST["last_name_$i"];
        $age = $_POST["age_$i"];
        $uscf_rating = $_POST["uscf_rating_$i"];

        // Bind parameters for the current child
        $stmt->bind_param("sssiissssssssssssssssss", $camp_selection, $first_name, $last_name, $age, $uscf_rating, $parent_first_name, $parent_last_name, $contact_phone, $email, $other_parent_first_name, $other_parent_last_name, $alternate_phone, $alternate_email, $general_knowledge, $instruction, $etiquette_rules, $played_tournaments, $special_moves, $notation, $school_chess_club, $plays_with_family, $software_books, $online_sites);

        // Execute the SQL statement
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }

        // Add child data to email body
        $children_data .= "Child $i Information:\n";
        $children_data .= "First Name: $first_name\n";
        $children_data .= "Last Name: $last_name\n";
        $children_data .= "Age: $age\n";
        $children_data .= "USCF Rating: $uscf_rating\n\n";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Send email with form submission details using PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp-relay.brevo.com';                // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'gregpratt86@gmail.com';                // SMTP username
        $mail->Password   = 'xsmtpsib-67ec699a8240cbb090b05a228c95a193b5767592eb4a378839f2d3244ec67849-qc2Z5CDJpAaQbg04';   // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 587 for `PHPMailer::ENCRYPTION_STARTTLS` above

        //Recipients
        $mail->setFrom('system@mathmslls.com', 'Math MS LLC System');
        $mail->addAddress('greg.pratt@mathnasium.com');     // Add a recipient
		$mail->addCC('pschaplin@sbcglobal.net');

// Content
$mail->isHTML(true); // Set email format to HTML
$mail->Subject = 'Chess Camp Registration Form Submission';
$mail->Body = "Someone new has signed up. Click <a href='https://mathmsllc.com/chess/admin/'>here</a> to view the submission.<br><br>";
$mail->Body .= "<br><br><b>Parent/Guardian Information:</b><br>";
$mail->Body .= "<b>First Name:</b> $parent_first_name<br>";
$mail->Body .= "<b>Last Name:</b> $parent_last_name<br>";
$mail->Body .= "<b>Contact Phone:</b> $contact_phone<br>";
$mail->Body .= "<b>Email:</b> $email<br>";
$mail->Body .= "<b>Other Parent First Name:</b> $other_parent_first_name<br>";
$mail->Body .= "<b>Other Parent Last Name:</b> $other_parent_last_name<br>";
$mail->Body .= "<b>Alternate Phone:</b> $alternate_phone<br>";
$mail->Body .= "<b>Alternate Email:</b> $alternate_email<br><br>";
$mail->Body .= "<b>Additional Questionnaire Data:</b><br>";
$mail->Body .= "<b>General Knowledge:</b> $general_knowledge<br>";
$mail->Body .= "<b>Instruction:</b> $instruction<br>";
$mail->Body .= "<b>Etiquette Rules:</b> $etiquette_rules<br>";
$mail->Body .= "<b>Played Tournaments:</b> $played_tournaments<br>";
$mail->Body .= "<b>Special Moves:</b> $special_moves<br>";
$mail->Body .= "<b>Notation:</b> $notation<br>";
$mail->Body .= "<b>School/Chess Club:</b> $school_chess_club<br>";
$mail->Body .= "<b>Plays with Family:</b> $plays_with_family<br>";
$mail->Body .= "<b>Software/Books:</b> $software_books<br>";
$mail->Body .= "<b>Online Sites:</b> $online_sites<br><br>";


// Add child data
$mail->Body .= "<b>Children Information:</b><br>";
$mail->Body .= $children_data; // Add child data

        $mail->send();
        echo '';
    } catch (Exception $e) {
        echo "";
    }
// Prepare and send an additional email to the parent
try {
    // Optionally, you can reset the PHPMailer instance here
     $mail->ClearAddresses(); // to clear the previously set recipient
     $mail->ClearCCs(); // to clear previously set CCs
    
    // Recipients - Set to the parent's email
    $mail->setFrom('system@mathmsllc.com', 'Cedar Park Mathnasium Chess Camp');
    $mail->addAddress($email); // Parent's email address
    
    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Chess Camp Registration Confirmation';
    $mail->Body    = "<h1>Chess Camp Registration Received</h1>"
                    ."<p>Dear {$parent_first_name},</p>"
                    ."<p>We have successfully received your submission for the Chess Camp registration. Thank you for entrusting us with the opportunity to be a part of your child's chess journey.</p>"
                    ."<p>We will review the submitted information and get in touch with you within the next 48 hours with further details. Should you have any questions or need immediate assistance, please feel free to contact us.</p>"
                    ."<p>Warm regards,<br>"
                    ."The Mathnasium Cedar Park Chess Camp Team</p>";
    
    // Send the email
    $mail->send();
   echo '';
    } catch (Exception $e) {
        echo "";
}
	
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chess Camp Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            padding: 40px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        p {
            margin-bottom: 20px;
            color: #666;
            line-height: 1.6;
        }
        .redirect-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .redirect-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chess Camp Registration</h2>
        <p>Your form has been submitted successfully! A member of our team will reach out to you within 48 hours.</p>
        <p>Would you like to submit another form?</p>
        <a href="https://mathmsllc.com/chess" class="redirect-button">Submit Another Form</a>
    </div>
</body>
</html>