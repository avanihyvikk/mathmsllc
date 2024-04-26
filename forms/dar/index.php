<?php include 'protect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Activity Form Manager</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        container {
            width: 80%;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #343a40;
        }

        .link-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .link {
            background-color: #343a40;
            color: #ffffff;
            text-decoration: none;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .link:hover {
            background-color: #28a745;
        }
    </style>
</head>
<body>
    <container>
        <h1>Daily Activity Form Manager</h1>
        <div class="link-container">
            <a href="form.php" class="link">View Form</a>
            <a href="manage.php" class="link">Manage Form</a>
            <a href="responses.php" class="link">View Responses</a>
        </div>
    </container>
</body>
</html>