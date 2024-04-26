<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Leave Type</title>
    <!-- Optional: Include Bootstrap for styling -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Add Leave Type</h2>
    <form id="leaveTypeForm" action="/path/to/your/controller/method" method="post">
        <div class="part-1">
            <h3>Leave Type Details</h3>
            <div class="form-group">
                <label for="type_name">Leave Name:</label>
                <input type="text" class="form-control" id="type_name" name="type_name" required>
            </div>
            <div class="form-group">
                <label for="effective_after">Starts after (effective after):</label>
                <input type="number" class="form-control" id="effective_after" name="effective_after" required>
                <select class="form-control" id="effective_type" name="effective_type">
                    <option value="days">Days</option>
                    <option value="months">Months</option>
                    <option value="years">Years</option>
                </select>
            </div>
            <div class="form-group">
                <label for="accumulates_after">Starts accumulation (accumulates after):</label>
                <input type="number" class="form-control" id="accumulates_after" name="accumulates_after" required>
                <select class="form-control" id="accumulation_type" name="accumulation_type">
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
            <div class="form-group">
                <label for="expires_after">Expires after:</label>
                <input type="number" class="form-control" id="expires_after" name="expires_after" required>
                <select class="form-control" id="leave_expires_type" name="leave_expires_type">
                    <option value="days">Days</option>
                    <option value="months">Months</option>
                    <option value="years">Years</option>
                </select>
            </div>
            <div class="form-group">
                <label for="unused_leave">What happens to unused leave?</label>
                <select class="form-control" id="unused_leave" name="unused_leave">
                    <option value="paid">Paid out</option>
                    <option value="expires">Expires</option>
                    <option value="rollover">Rollover</option>
                </select>
            </div>
            <div class="form-group">
                <label for="expiration">When does leave expire?</label>
                <select class="form-control" id="expiration" name="expiration">
                    <option value="anniversary">Anniversary</option>
                    <option value="1st of year">1st of Year</option>
                </select>
            </div>
        </div>

         <!-- Part 2: Leave Approvals (Dynamically managed) -->
        <div id="leaveApprovalsSection" class="mt-4">
            <h3>Leave Approvals</h3>
            <div id="approvalsContainer">
                <!-- Approval roles will be added here dynamically -->
            </div>
            <button type="button" id="addApprovalBtn" class="btn btn-info mt-2">Add Approval Role</button>
        </div>

        <!-- Part 3: Leave Steps (Dynamically managed) -->
        <div id="leaveStepsSection" class="mt-4">
            <h3>Leave Steps</h3>
            <div id="stepsContainer">
                <!-- Leave steps will be added here dynamically -->
            </div>
            <button type="button" id="addStepBtn" class="btn btn-info mt-2">Add Leave Step</button>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>

<script>
// Dynamically add approval roles
document.getElementById('addApprovalBtn').addEventListener('click', function() {
    const approvalsContainer = document.getElementById('approvalsContainer');
    const newApprovalDiv = document.createElement('div');
    newApprovalDiv.innerHTML = `
        <div class="form-group">
            <label for="role">Role:</label>
            <select class="form-control" name="approvals[][role]">
                <option value="1">Role 1</option>
                <!-- Add more roles as needed -->
            </select>
        </div>
        <div class="form-group">
            <label for="approver">Approver Role:</label>
            <select class="form-control" name="approvals[][approver_role]">
                <option value="1">Approver Role 1</option>
                <!-- Add more approver roles as needed -->
            </select>
        </div>
    `;
    approvalsContainer.appendChild(newApprovalDiv);
});

// Dynamically add leave steps
document.getElementById('addStepBtn').addEventListener('click', function() {
    const stepsContainer = document.getElementById('stepsContainer');
    const newStepDiv = document.createElement('div');
    newStepDiv.innerHTML = `
        <div class="form-group">
            <label for="years">Year:</label>
            <input type="number" class="form-control" name="steps[][years]" placeholder="Enter year">
        </div>
        <div class="form-group">
            <label for="leave_days">Leave Days:</label>
            <input type="number" class="form-control" name="steps[][leave_days]" placeholder="Enter number of leave days">
        </div>
    `;
    stepsContainer.appendChild(newStepDiv);
});
</script>

</body>
</html>
