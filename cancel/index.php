<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unenroll Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Unenroll Form</h2>

    <form action="process_form.php" method="post">

        <!-- Which Center -->
        <div class="form-group">
            <label for="center">Which Center:</label>
            <select class="form-control" name="center" required>
                <!-- Populate dropdown with values from the teams table -->
                <?php
                // Fetch teams from the database and populate the dropdown
                // Replace the database connection details with your own
                $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbDatabase);

                if ($mysqli->connect_error) {
                    die("Connection failed: " . $mysqli->connect_error);
                }

                $teamsQuery = "SELECT team_name FROM teams";
                $teamsResult = $mysqli->query($teamsQuery);

                if ($teamsResult->num_rows > 0) {
                    while ($row = $teamsResult->fetch_assoc()) {
                        echo "<option value='" . $row['team_name'] . "'>" . $row['team_name'] . "</option>";
                    }
                }

                $mysqli->close();
                ?>
            </select>
        </div>

        <!-- Parents First Name -->
        <div class="form-group">
            <label for="parentsFirstName">Parents First Name:</label>
            <input type="text" class="form-control" name="parentsFirstName" required>
        </div>

        <!-- Parents Last Name -->
        <div class="form-group">
            <label for="parentsLastName">Parents Last Name:</label>
            <input type="text" class="form-control" name="parentsLastName" required>
        </div>

        <!-- Childs First Name -->
        <div class="form-group">
            <label for="childsFirstName">Childs First Name:</label>
            <input type="text" class="form-control" name="childsFirstName" required>
        </div>

        <!-- Childs Last Name -->
        <div class="form-group">
            <label for="childsLastName">Childs Last Name:</label>
            <input type="text" class="form-control" name="childsLastName" required>
        </div>

        <!-- Parents Email Address -->
        <div class="form-group">
            <label for="parentsEmail">Parents Email Address:</label>
            <input type="email" class="form-control" name="parentsEmail" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
