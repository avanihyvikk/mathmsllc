<?php include 'protect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Reminder Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Add your custom styles here -->
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-4 text-center">Email Reminder Form</h2>

        <!-- Reminder Form -->
        <form action="process_form.php" method="post" id="reminderForm">

            <!-- Time & Date to send the first email -->
            <div class="form-group">
                <label for="start_datetime">Time & Date to send the first email:</label>
                <input type="datetime-local" class="form-control" name="start_datetime" required step="900">
            </div>

            <!-- Frequency to resend the email -->
            <div class="form-group">
                <label for="frequency">Frequency to resend the email:</label>
                <select class="form-control" name="frequency" required>
                    <option value="Daily">Daily</option>
                    <option value="Weekly">Weekly</option>
                    <option value="Bi-Weekly">Bi-weekly</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Quarterly">Quarterly</option>
                    <option value="Yearly">Yearly</option>
                </select>
            </div>

            <!-- Duration or Continual -->
<div class="form-group">
    <label>How long to keep the emails going:</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="duration_option" id="set_end_date" value="set_end_date" checked>
        <label class="form-check-label" for="set_end_date">Set End Date</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="duration_option" id="continual" value="continual">
        <label class="form-check-label" for="continual">Continual</label>
    </div>
</div>

<!-- End Date -->
<div class="form-group" id="end_date_group">
    <label for="end_date">End Date:</label>
    <input type="date" class="form-control" name="end_date">
</div>

            <!-- Who is sending the email -->
            <div class="form-group">
                <label for="from_email">Who is sending the email:</label>
                <input type="email" class="form-control" name="from_email" required>
            </div>

            <!-- What email is it being sent to -->
            <div class="form-group">
                <label for="to_email">What email is it being sent to:</label>
                <input type="email" class="form-control" name="to_email" required>
            </div>

            <!-- Subject of the email -->
            <div class="form-group">
                <label for="subject">What is the subject of the email:</label>
                <input type="text" class="form-control" name="subject" required>
            </div>

            <!-- Body of the email -->
            <div class="form-group">
                <label for="content">What is the body of the email:</label>
                <textarea class="form-control" name="content" rows="5" required></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>



<script>
    $(document).ready(function () {
        // Toggle visibility of the end_date_group based on the selected duration option
        const durationOption = $('input[name="duration_option"]');
        const endDateGroup = $('#end_date_group');

        // Function to toggle visibility
        function toggleEndDateVisibility() {
            endDateGroup.toggle(durationOption.filter(':checked').val() === 'set_end_date');
        }

        // Initially hide the end_date_group if the continual option is selected
        toggleEndDateVisibility();

        // Listen for changes in the form and update visibility accordingly
        durationOption.on('change', toggleEndDateVisibility);
    });
</script>



</div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
