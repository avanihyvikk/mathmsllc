<?php include 'protect.php'; ?>
<?php
// Database credentials
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

// Check if form is submitted to update delete status
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateDeleted"])) {
    $questionId = $conn->real_escape_string($_POST["questionId"]);
    $isChecked = $_POST["isChecked"] == "true" ? 1 : 0;

    // If the checkbox is unchecked, show the confirmation dialog
    if ($isChecked == 0) {
        $confirm = array("confirm" => confirm("Are you sure you want to delete this question?"), "questionId" => $questionId);
        echo json_encode($confirm);
        die(); // Stop further execution
    }

    // Update database with the new deleted status
    $sql = "UPDATE daily_activity_questions SET deleted = $isChecked WHERE question_id = $questionId";
    $conn->query($sql);

    $response = array("success" => true);
    echo json_encode($response);
    die(); // Stop further execution
}

// Check if form is submitted to toggle "Is Shown" or "Is Required"
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateToggle"])) {
    $questionId = $conn->real_escape_string($_POST["questionId"]);
    $toggleType = $conn->real_escape_string($_POST["toggleType"]);
    $isChecked = $_POST["isChecked"] == "true" ? 1 : 0;

    // Update database based on toggle type
    if ($toggleType === "toggleShown") {
        $sql = "UPDATE daily_activity_questions SET is_shown = $isChecked WHERE question_id = $questionId";
        $conn->query($sql);
    } elseif ($toggleType === "toggleRequired") {
        $sql = "UPDATE daily_activity_questions SET is_required = $isChecked WHERE question_id = $questionId";
        $conn->query($sql);
    }

    // Check if form is submitted to update field type
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateFieldType"])) {
    $questionId = $conn->real_escape_string($_POST["questionId"]);
    $newFieldType = $conn->real_escape_string($_POST["newFieldType"]);

    // Update database with the new field type
    $sql = "UPDATE daily_activity_questions SET field_type = '$newFieldType' WHERE question_id = $questionId";
    $conn->query($sql);
}

// Check if form is submitted to add a new question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addQuestion"])) {
    $newQuestionText = $conn->real_escape_string($_POST["newQuestionText"]);
    $newQuestionIsShown = $_POST["newQuestionIsShown"] == "on" ? 1 : 0;
    $newQuestionIsRequired = $_POST["newQuestionIsRequired"] == "on" ? 1 : 0;
    $newQuestionFieldType = $conn->real_escape_string($_POST["newQuestionFieldType"]);
    $dropdownOptions = isset($_POST["dropdownOptions"]) ? explode("\n", $_POST["dropdownOptions"]) : [];

    // Insert new question into daily_activity_questions table
    $sql = "INSERT INTO daily_activity_questions (question_text, is_shown, is_required, field_type, creation_date) VALUES ('$newQuestionText', $newQuestionIsShown, $newQuestionIsRequired, '$newQuestionFieldType', NOW())";
    $conn->query($sql);

    // Retrieve the question_id of the newly inserted question
    $newQuestionId = $conn->insert_id;

    // If the field type is dropdown, insert dropdown options into daily_activity_dropdown_options table
    if ($newQuestionFieldType === "dropdown" && !empty($dropdownOptions)) {
        foreach ($dropdownOptions as $option) {
            $optionText = $conn->real_escape_string(trim($option));
            $sql = "INSERT INTO daily_activity_dropdown_options (question_id, option_text) VALUES ($newQuestionId, '$optionText')";
            $conn->query($sql);
        }
    }
}

// Retrieve existing questions from daily_activity_questions table
$sql = "SELECT * FROM `daily_activity_questions` WHERE `deleted` = 0";
$result = $conn->query($sql);

$questions = array();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Retrieve dropdown options for existing questions
$dropdownOptions = array();
foreach ($questions as $question) {
    if ($question["field_type"] == "dropdown") {
        $questionId = $question["question_id"];
        $sql = "SELECT * FROM daily_activity_dropdown_options WHERE question_id = $questionId";

        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $dropdownOptions[$questionId][] = $row["option_text"];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles_manage.css">
  
    <!-- Add Bootstrap JS and Popper.js scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Add your additional scripts here -->
	<script>
    $(document).ready(function () {
        // Handle toggle switch changes
        $('.toggle-shown, .toggle-required').on('change', function () {
            var questionId = $(this).data('question-id');
            var isChecked = $(this).prop('checked');
            var toggleType = $(this).hasClass('toggle-shown') ? 'toggleShown' : 'toggleRequired';

            // Send an AJAX request to update the database
            $.ajax({
                type: 'POST',
                url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
                data: {
                    updateToggle: true,  // New flag to identify update toggle request
                    questionId: questionId,
                    toggleType: toggleType,
                    isChecked: isChecked
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.error('Error updating toggle:', error.responseText);
                }
            });
        });

        // Handle field type dropdown changes
        $('.edit-field-type').on('change', function () {
            var questionId = $(this).data('question-id');
            var newFieldType = $(this).val();

            // Send an AJAX request to update the database
            $.ajax({
                type: 'POST',
                url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
                data: {
                    updateFieldType: true,
                    questionId: questionId,
                    newFieldType: newFieldType
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.error('Error updating field type:', error.responseText);
                }
            });
        });

        // Function to set existing options in the modal
        function setExistingOptions(questionId, existingOptions) {
            var textarea = $('#editDropdownOptions_' + questionId);
            textarea.val(existingOptions.join('\n'));
        }

        $('.edit-options-btn').on('click', function () {
            var questionId = $(this).data('question-id');
            var existingOptions = $(this).data('existing-options');

            // Set existing options in the modal textarea
            setExistingOptions(questionId, existingOptions);

            // Show the modal
            $('#editOptionsModal_' + questionId).modal('show');
        });

        $('.save-options-btn').on('click', function () {
            var questionId = $(this).data('question-id');
            var newOptions = $('#editDropdownOptions_' + questionId).val().split('\n').map(function (option) {
                return option.trim();
            });

            // Send an AJAX request to update the options in the database
            $.ajax({
                type: 'POST',
                url: 'update_options.php',
                data: {
                    questionId: questionId,
                    dropdownOptions: newOptions
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.error('Error updating options:', error.responseText);
                }
            });

            // Close the modal
            $('#editOptionsModal_' + questionId).modal('hide');
        });

        // Your existing code for the toggle switch and dropdown options container
document.getElementById("newQuestionFieldType").addEventListener("change", function () {
    var dropdownOptionsContainer = document.getElementById("dropdownOptionsContainer");
    dropdownOptionsContainer.style.display = this.value === "dropdown" ? "block" : "none";
});

// Add the following line to hide the container by default
document.getElementById("dropdownOptionsContainer").style.display = "none";

		
    });
</script>

</head>

<body class="container">
    <div class="accordion" id="questionAccordion">

        <!-- First Collapsible Section - Add New Question -->
        <div class="card">
            <div class="card-header" id="addQuestionHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#addQuestionCollapse" aria-expanded="false" aria-controls="addQuestionCollapse">
                        Add New Question - Click to expand/collapse
                    </button>
                </h2>
            </div>

            <div id="addQuestionCollapse" class="collapse" aria-labelledby="addQuestionHeading" data-parent="#questionAccordion">
                <div class="card-body">
                    <!-- Add New Question Form -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form">
                        <div class="form-group">
                            <label for="newQuestionText">Question Text:</label>
                            <input type="text" name="newQuestionText" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="newQuestionIsShown">Is Shown:</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="newQuestionIsShown" name="newQuestionIsShown" checked>
                                <label class="custom-control-label" for="newQuestionIsShown"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newQuestionIsRequired">Is Required:</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="newQuestionIsRequired" name="newQuestionIsRequired">
                                <label class="custom-control-label" for="newQuestionIsRequired"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newQuestionFieldType">Field Type:</label>
                            <select name="newQuestionFieldType" id="newQuestionFieldType" class="form-control">
                                <option value="text">Text Line</option>
                                <option value="textarea">Text Area</option>
                                <option value="dropdown">Dropdown</option>
                                <!-- Add more options for other field types if needed -->
                            </select>
                        </div>

                        <!-- Add dropdown options input if field type is dropdown -->
                        <div id="dropdownOptionsContainer" class="form-group">
                            <label for="dropdownOptions">Dropdown Options (One option per line):</label>
                            <textarea name="dropdownOptions" class="form-control"></textarea>
                        </div>

                        <button type="submit" name="addQuestion" class="btn btn-success">Add Question</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Second Collapsible Section - Existing Questions -->
       <div class="card">
            <div class="card-header" id="existingQuestionsHeading">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#existingQuestionsCollapse" aria-expanded="false" aria-controls="existingQuestionsCollapse">
                        Existing Questions - Click to expand/collapse
                    </button>
                </h2>
            </div>

            <div id="existingQuestionsCollapse" class="collapse" aria-labelledby="existingQuestionsHeading" data-parent="#questionAccordion">
                <div class="card-body">
                    <!-- Display Existing Questions Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Question Text</th>
                                <th>Is Shown</th>
                                <th>Is Required</th>
                                <th>Field Type</th>
                                <th>Dropdown Options</th>
                                <th>Deleted</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($questions as $question) : ?>
                                <tr>
                                    <td><?php echo $question["question_text"]; ?></td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input toggle-shown" id="toggleShown_<?php echo $question["question_id"]; ?>" data-question-id="<?php echo $question["question_id"]; ?>" <?php echo $question["is_shown"] ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="toggleShown_<?php echo $question["question_id"]; ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input toggle-required" id="toggleRequired_<?php echo $question["question_id"]; ?>" data-question-id="<?php echo $question["question_id"]; ?>" <?php echo $question["is_required"] ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="toggleRequired_<?php echo $question["question_id"]; ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <select class="form-control edit-field-type" data-question-id="<?php echo $question["question_id"]; ?>">
                                            <option value="text" <?php echo ($question["field_type"] == "text") ? "selected" : ""; ?>>Text</option>
                                            <option value="textarea" <?php echo ($question["field_type"] == "textarea") ? "selected" : ""; ?>>Textarea</option>
                                            <option value="dropdown" <?php echo ($question["field_type"] == "dropdown") ? "selected" : ""; ?>>Dropdown</option>
                                        </select>
                                    </td>
                                    <td>
                                        <!-- Add actions for each question if needed -->
                                        <?php if ($question["field_type"] == "dropdown") : ?>
                                            <button type="button" class="btn btn-primary edit-options-btn" data-toggle="modal" data-target="#editOptionsModal_<?php echo $question["question_id"]; ?>" data-question-id="<?php echo $question["question_id"]; ?>" data-existing-options="<?php echo htmlspecialchars(json_encode($dropdownOptions[$question["question_id"]] ?? array())); ?>">
                                                Edit
                                            </button>

                                            <!-- Edit Dropdown Options Modal -->
                                            <div class="modal fade" id="editOptionsModal_<?php echo $question["question_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="editOptionsModalLabel_<?php echo $question["question_id"]; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editOptionsModalLabel_<?php echo $question["question_id"]; ?>">Edit Dropdown Options</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label for="editDropdownOptions_<?php echo $question["question_id"]; ?>">Edit Dropdown Options (One option per line):</label>
                                                            <textarea name="dropdownOptions" id="editDropdownOptions_<?php echo $question["question_id"]; ?>" class="form-control"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary save-options-btn" data-question-id="<?php echo $question["question_id"]; ?>">Save Options</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input toggle-deleted" id="toggleDeleted_<?php echo $question["question_id"]; ?>" data-question-id="<?php echo $question["question_id"]; ?>" <?php echo $question["deleted"] ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="toggleDeleted_<?php echo $question["question_id"]; ?>"></label>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle delete switch changes
        $('.toggle-deleted').on('change', function () {
            var questionId = $(this).data('question-id');
            var isChecked = $(this).prop('checked');

            // If the checkbox is checked, show the confirmation modal
            if (isChecked) {
                // Display a confirmation dialog
                var confirmDelete = confirm("Are you sure you want to delete this question?");
                if (!confirmDelete) {
                    // Uncheck the checkbox if the user cancels the delete action
                    $(this).prop('checked', false);
                    return;
                }
            }

            // Send an AJAX request to update the database
            $.ajax({
                type: 'POST',
                url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
                data: {
                    updateDeleted: true,  // New flag to identify update delete request
                    questionId: questionId,
                    isChecked: isChecked
                },
                success: function (response) {
                    console.log(response);
                    alert("AJAX request sent successfully. Check console for details.");
                },
                error: function (error) {
                    console.error('Error updating delete:', error.responseText);
                    alert("Error updating delete. Check console for details.");
                }
            });
        });
    </script>
</body>
</html>
