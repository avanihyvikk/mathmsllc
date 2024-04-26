<?php
// Replace with your actual database credentials
$host = "localhost";
$database = "mathmsllc_hr";
$username = "mathmsllc_hr";
$password = "s@Yo*+0-+-H#";



$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT r.location, q.question_text, r.answer, r.submission_datetime 
        FROM daily_activity_responses r
        JOIN daily_activity_questions q ON r.question_id = q.question_id";

$result = $conn->query($sql);

$responses = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $responses[] = $row;
    }
}

$conn->close();

// Output responses as JSON
header('Content-Type: application/json');
echo json_encode(['data' => $responses]);
?>