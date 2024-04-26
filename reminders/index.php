<?php include 'protect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Add your custom styles here -->
    <title>Email Reminder Manager</title>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container mt-4">

<div class="container">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title"><center>Email Reminder Manager</center></h3>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="new.php" class="btn btn-primary btn-block">Create New Email Reminder</a>
                </li>
                <li class="list-group-item">
                    <a href="view_reminders.php" class="btn btn-success btn-block">View Current Email Reminders</a>
                </li>
                <li class="list-group-item">
                    <a href="process.php" class="btn btn-warning btn-block">Manually Run Cron Job</a>
                </li>
            </ul>
        </div>
    </div>
</div>

</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
