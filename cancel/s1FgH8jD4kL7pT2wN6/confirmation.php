<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content remains unchanged -->
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
            font-family: 'Arial', sans-serif;
        }

        .confirmation-container {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 500px;
            margin: auto;
            text-align: center;
        }

        .confirmation-container h2 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            padding: 15px;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .confirmation-message strong {
            font-weight: bold;
        }

        .confirmation-message p {
            font-size: 16px;
            margin-bottom: 0;
        }

        .btn-back {
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <?php
        // Check if the referer is from a valid redirect
        $validReferers = array(
            'https://mathmsllc.com/cancel/s1FgH8jD4kL7pT2wN6/',
           'https://mathmsllc.com/cancel/s1FgH8jD4kL7pT2wN6/index.html',
           'https://mathmsllc.com/cancel/s1FgH8jD4kL7pT2wN6/process_form.php',
		   'http://mathmsllc.com/cancel/s1FgH8jD4kL7pT2wN6/',
           'http://mathmsllc.com/cancel/s1FgH8jD4kL7pT2wN6/index.html',
           'http://mathmsllc.com/cancel/s1FgH8jD4kL7pT2wN6/process_form.php'
        );

        $validRedirect = false;

        if (isset($_SERVER['HTTP_REFERER']) && in_array($_SERVER['HTTP_REFERER'], $validReferers)) {
            $validRedirect = true;
        }

        if ($validRedirect):
        ?>
        <h2>We are sad to see you go!</h2>
        <div class="alert alert-success" role="alert">
            <strong>Form submitted successfully!</strong>
            <p>You will receive a confirmation email at the email address you submitted.</p>
            <p>Thank you for being a part of Mathnasium. If you ever decide to return, we'll be here to assist you.</p>
        </div>
        
        <!-- Button to redirect back to the form page -->
        <button class="btn-back" onclick="redirectToForm()">Unenroll Another Kid</button>

        <!-- JavaScript to handle the redirection -->
        <script>
            function redirectToForm() {
                // Change the URL to the actual form page URL
                window.location.href = '<?php echo $validReferers[0]; ?>';
            }
        </script>

        <?php else: ?>
        <p>Invalid access. You are not allowed to access this page directly.</p>
        <?php endif; ?>
    </div>
</body>
</html>
