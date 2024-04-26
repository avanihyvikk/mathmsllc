<?php include 'protect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Email Reminders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Add your custom styles here -->
    <style>
        .table th, .table td {
            padding: 0.2rem; /* Reduced padding */
            font-size: 0.8rem; /* Reduced font size */
			
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .table tbody tr td[contenteditable="true"] {
            background-color: #dcdcdc; /* Slightly different color for editable cells */
        }
		.table tbody tr {
    border: 1px solid black; /* Black border for every row */
}

.table tbody tr td {
    border: 1px solid black; /* Black border for every cell */
}
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container mt-4">
        <?php
        // Include the configuration file
        require_once 'config.php';

        // Database connection (assuming you already have a database connection established)
        // Adjust the connection details based on your specific setup
        $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbDatabase);

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Retrieve active reminders from the database
        $selectRemindersQuery = "SELECT * FROM email_reminder WHERE active = 1";
        $result = $mysqli->query($selectRemindersQuery);

        // Check if there are any reminders
        if ($result->num_rows > 0) {
        ?>
            <h2 class="mb-4 text-center">Email Reminders</h2>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date Created</th>
                            <th>Email Frequency</th>
                            <th>From Email</th>
                            <th>To Email</th>
                            <th>Subject</th>
                            <th>Content</th>
                            <th>Last Sent</th>
                            <th>Next Send</th>
                            <th>Remaining Sends</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through each row in the result set -->
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= date('m/d/y h:i A', strtotime($row['start_datetime'])) ?></td>
                                <td><?= $row['frequency'] ?></td>
                                <td contenteditable="true" onBlur="updateField(<?= $row['id'] ?>, 'from_email', this.innerText)"><?= $row['from_email'] ?></td>
                                <td contenteditable="true" onBlur="updateField(<?= $row['id'] ?>, 'to_email', this.innerText)"><?= $row['to_email'] ?></td>
                                <td contenteditable="true" onBlur="updateField(<?= $row['id'] ?>, 'subject', this.innerText)"><?= $row['subject'] ?></td>
                                <td contenteditable="true" onBlur="updateField(<?= $row['id'] ?>, 'content', this.innerText)"><?= $row['content'] ?></td>
                                <td><?= $row['last_send_date'] ? date('m/d/y h:i A', strtotime($row['last_send_date'])) : 'Never' ?></td>
                                <td><?= date('m/d/y h:i A', strtotime($row['next_send_date'])) ?></td>
                                <td contenteditable="true" onBlur="updateField(<?= $row['id'] ?>, 'remaining', this.innerText)"><?= $row['remaining'] ?></td>
                                <td><?= ($row['active'] == 1) ? 'Active' : 'Inactive' ?></td>
                                <td><button class="btn btn-danger btn-sm" onclick="updateActive(<?= $row['id'] ?>, <?= $row['active'] ?>)">Delete</button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
            echo "<h2 class='mb-4 text-center'>No active reminders found.</h2>";
        }

        // Close the database connection
        $mysqli->close();
        ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function updateField(id, field, value) {
            $.ajax({
                type: "POST",
                url: "update_field.php",
                data: { id: id, field: field, value: value },
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        function updateActive(id, active) {
            $.ajax({
                type: "POST",
                url: "update_active.php",
                data: { id: id, active: active },
                success: function(response) {
                    console.log(response);
                    location.reload(); // Refresh the page after toggling active status
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    </script>
</body>
</html>
