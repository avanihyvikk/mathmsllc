<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Activity Form</title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Add the Select2 CSS file -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add the Select2 JS file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
<body>
    <div class="header">
        <h1>Daily Activity Form</h1>
    </div>

    <div class="container">
        <div class="form-container">
            <form action="submit.php" method="post" class="activity-form">
                <?php
                    // Always include the "Location" question as a dropdown with autocomplete
                    echo '<div class="question-container">';
                    echo '<label class="question-label">Location</label>';
                    $locations = getDropdownOptionsFromTeams();
                    echo createEditableDropdown('location', $locations, 'required');
                    echo '</div>';

                    // Assuming you have a function to fetch shown questions from the database
                    $shownQuestions = getShownQuestions();

                    foreach ($shownQuestions as $question) {
    echo '<div class="question-container">';
    echo createInputElement($question);
    echo '</div>';
}
                ?>
                <button type="submit" class="submit-button">Submit</button>
            </form>
        </div>
    </div>
    <!-- Add the Select2 initialization script -->
    <script>
        $(document).ready(function() {
            // Initialize Select2 for the "Location" dropdown
            $('.editable-dropdown').select2({
                tags: true, // Allow user to add new options
                tokenSeparators: [',', ' '], // Define separators for multiple entries
                width: '100%' // Set the width to 100%
            });
        });
    </script>
</body>
</html>


<?php
function getQuestions() {
    // Replace with your actual database credentials
    $host = "localhost";
    $database = "mathmsllc_hr";
    $username = "mathmsllc_hr";
    $password = "s@Yo*+0-+-H#";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM daily_activity_questions";
    $result = $conn->query($sql);

    $questions = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    }

    $conn->close();

    return $questions;
}


function getShownQuestions() {
    // Replace with your actual database credentials
    $host = "localhost";
    $database = "mathmsllc_hr";
    $username = "mathmsllc_hr";
    $password = "s@Yo*+0-+-H#";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM daily_activity_questions WHERE is_shown = 1";
    $result = $conn->query($sql);

    $questions = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    }

    $conn->close();

    return $questions;
}

function createInputElement($question) {
    $name = 'question_' . $question['question_id'];
    $type = $question['field_type'];
    $isRequired = $question['is_required'] ? 'required' : '';
    $asterisk = $question['is_required'] ? '<span class="required-field">*</span>' : '';

    $inputElement = '';

    switch ($type) {
        case 'text':
            $inputElement = '<input type="text" name="' . $name . '" ' . $isRequired . '>';
            break;
        case 'dropdown':
            $options = getDropdownOptions($question['question_id']);
            $inputElement = createDropdown($name, $options, $isRequired);
            break;
        case 'textarea':
            $inputElement = '<textarea name="' . $name . '" ' . $isRequired . ' rows="6" cols="50"></textarea>';
            break;
        default:
            $inputElement = '<input type="text" name="' . $name . '" ' . $isRequired . '>';
            break;
    }

    // Return the question label, input element, and asterisk
    return '<label class="question-label">' . $question['question_text'] . $asterisk . '</label>' . $inputElement;
}





function createDropdown($name, $options, $isRequired) {
    $dropdown = '<select name="' . $name . '" ' . $isRequired . '>';
    foreach ($options as $option) {
        $dropdown .= '<option value="' . $option . '">' . $option . '</option>';
    }
    $dropdown .= '</select>';
    return $dropdown;
}

function getDropdownOptions($questionId) {
    // Replace this query with your actual database query
    $host = "localhost";
    $database = "mathmsllc_hr";
    $username = "mathmsllc_hr";
    $password = "s@Yo*+0-+-H#";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT option_text FROM daily_activity_dropdown_options WHERE question_id = $questionId";
    $result = $conn->query($sql);

    $options = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options[] = $row['option_text'];
        }
    }

    $conn->close();

    return $options;
}
function getDropdownOptionsFromTeams() {
    // Replace this query with your actual database query
    $host = "localhost";
    $database = "mathmsllc_hr";
    $username = "mathmsllc_hr";
    $password = "s@Yo*+0-+-H#";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT team_name FROM teams";
    $result = $conn->query($sql);

    $options = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options[] = $row['team_name'];
        }
    }

    $conn->close();

    return $options;
}
function createSearchableDropdown($name, $options, $isRequired) {
    $dropdown = '<select name="' . $name . '" class="searchable-dropdown" ' . $isRequired . '>';
    foreach ($options as $option) {
        $dropdown .= '<option value="' . $option . '">' . $option . '</option>';
    }
    $dropdown .= '</select>';
    return $dropdown;
}
function createAutocompleteInput($name, $options, $isRequired) {
    $input = '<input type="text" name="' . $name . '" id="' . $name . '" class="autocomplete-input" ' . $isRequired . '>';
    return $input;
}
function createEditableDropdown($name, $options, $isRequired) {
    $dropdown = '<select name="' . $name . '" class="editable-dropdown" ' . $isRequired . '>';
    foreach ($options as $option) {
        $dropdown .= '<option value="' . $option . '">' . $option . '</option>';
    }
    $dropdown .= '</select>';
    return $dropdown;
}
