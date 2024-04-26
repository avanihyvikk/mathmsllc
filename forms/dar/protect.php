<?php
session_start();

// Set your desired password
$correctPassword = 'BEMORECAREFUL!!!';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the entered password is correct
    $enteredPassword = isset($_POST['password']) ? $_POST['password'] : '';

    if (password_verify($enteredPassword, password_hash($correctPassword, PASSWORD_DEFAULT))) {
        $_SESSION['authenticated'] = true;
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        $errorMessage = 'Incorrect password. Please try again.';
    }
}

// Check if the user is already authenticated
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // User is authenticated, continue to the protected content
} else {
    // User is not authenticated, show the password form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Password Protection</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body class="bg-light">
        <div class="container mt-5">
            <div class="card mx-auto" style="max-width: 400px;">
                <div class="card-body">
                    <h5 class="card-title">Enter Password</h5>
                    <?php if (isset($errorMessage)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS and Popper.js -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
    exit();
}
?>
