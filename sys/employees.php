<?php
// Include the authentication script
include 'db_connection.php';
include 'authenticate.php';
?>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link rel="stylesheet" href="assets/plugins/notifications/css/lobibox.min.css" />
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="assets/css/dark-theme.css" />
    <link rel="stylesheet" href="assets/css/semi-dark.css" />
    <link rel="stylesheet" href="assets/css/header-colors.css" />


    <title>Syndron - Bootstrap 5 Admin Dashboard Template</title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <?php include "sidebar.php"; ?>
        <?php include "header.php"; ?>
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Tables</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <div class="btn-group">
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleFullScreenModal">Add Employee</button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleFullScreenModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-fullscreen">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Employee</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!--begin modal body-->
                                        <div class="col-xl-6 mx-auto">
                                            <div class="card">
                                                <div class="card-body p-4">
                                                    <h5 class="mb-4">Vertical Form</h5>
                                                    <form id="employeeForm" class="row g-3 needs-validation"
                                                        novalidate>
                                                        <div class="col-md-6">
                                                            <label for="firstname" class="form-label">First
                                                                Name</label>
                                                            <input type="text" class="form-control" id="firstname"
                                                                name="firstName" placeholder="First Name" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="lastname" class="form-label">Last
                                                                Name</label>
                                                            <input type="text" class="form-control" id="lastname"
                                                                name="lastName" placeholder="Last Name" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="phone" class="form-label">Phone
                                                                Number</label>
                                                            <input type="text" class="form-control" id="phone"
                                                                name="phoneNumber" placeholder="Phone Number" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email"
                                                                name="email" placeholder="Email" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="username" class="form-label">Username</label>
                                                            <input type="text" class="form-control" id="username"
                                                                name="username" placeholder="Username" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="password" class="form-label">Password</label>
                                                            <input type="password" class="form-control" id="password"
                                                                name="password" placeholder="Password" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="location" class="form-label">Location</label>
                                                            <select id="location" name="location" class="form-select" required>
                                                                <option selected>Choose...</option>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="role" class="form-label">Role</label>
                                                            <select id="role" name="role" class="form-select" required>
                                                                <option selected>Choose...</option>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="manager" class="form-label">Manager</label>
                                                            <select id="manager" name="manager" class="form-select" required>
                                                                <option selected>Choose...</option>
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="startdate" class="form-label">Start
                                                                Date</label>
                                                            <input type="date" class="form-control" id="startdate"
                                                                name="startDate" placeholder="Date" required>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end modal body-->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="reset" class="btn btn-light px-4">Reset</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary">Settings</button>
                            <button type="button"
                                class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a
                                    class="dropdown-item" href="javascript:;">Action</a> <a class="dropdown-item"
                                    href="javascript:;">Another action</a> <a class="dropdown-item"
                                    href="javascript:;">Something else here</a>
                                <div class="dropdown-divider"></div> <a class="dropdown-item"
                                    href="javascript:;">Separated link</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end breadcrumb-->


                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>

                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
    include 'db_connection.php';

    // Fetch users data from the database
    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);

    // Check for errors
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    // Check if there are any users
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';

            echo '<td>' . $row['first_name'] . '</td>';
            echo '<td>' . $row['last_name'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['phone_number'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">No users found.</td></tr>';
    }

    $conn->close();
    ?>
                                </tbody>
                                <tfoot>
                                    <tr>

                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!--end page wrapper -->
        <?php include "footer.php"; ?>
        <?php include "search_modal.php"; ?>
        <?php include "switcher.php"; ?>





        <!-- Bootstrap JS -->
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <!--plugins-->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
        <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
        <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
        <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
        <!--notification js -->
        <script src="assets/plugins/notifications/js/lobibox.min.js"></script>
        <script src="assets/plugins/notifications/js/notifications.min.js"></script>
        <script src="assets/plugins/notifications/js/notification-custom-script.js"></script>
        <script src="assets/plugins/validation/jquery.validate.min.js"></script>
        <!-- jQuery Validation Bootstrap Plugin -->
        <script src="assets/plugins/validation/additional-methods.min.js"></script>
        <script src="assets/plugins/bs-stepper/js/main.js"></script>




        <script>
            $(document).ready(function() {
                var table = $('#example2').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'print']
                });

                table.buttons().container()
                    .appendTo('#example2_wrapper .col-md-6:eq(0)');
            });
        </script>

        <script>
            function error_notice_employee() {
                Lobibox.notify('error', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    position: 'top right',
                    icon: 'bx bx-x-circle',
                    msg: 'There was an error inserting the employee.'
                });
            }

            function success_notice_employee() {
                Lobibox.notify('success', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: false,
                    position: 'top right',
                    icon: 'bx bx-check-circle',
                    msg: 'The employee was created successfully.'
                });
            }

            $(document).ready(function() {
                $("#employeeForm").validate({
                    rules: {
                        firstName: "required",
                        lastName: "required",
                        phoneNumber: "required",
                        email: {
                            required: true,
                            email: true
                        },
                        username: "required",
                        password: {
                            required: true,
                            minlength: 5
                        },
                        location: "required",
                        role: "required",
                        manager: "required",
                        startDate: "required"
                    },
                    messages: {
                        firstName: "Please enter your first name",
                        lastName: "Please enter your last name",
                        phoneNumber: "Please enter your phone number",
                        email: "Please enter a valid email address",
                        username: "Please enter a username",
                        password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long"
                        },
                        location: "Please select a location",
                        role: "Please select a role",
                        manager: "Please select a manager",
                        startDate: "Please select a start date"
                    },
                    submitHandler: function(form) {
                        var formData = $(form).serialize();
                        $.ajax({
                            type: "POST",
                            url: "save_employee.php",
                            data: formData,
                            success: function(response) {
                                console.log(response);
                                success_notice_employee();
                                $('#exampleFullScreenModal').modal('hide');
                            },
                            error: function(response) {
                                console.log(response);
                                error_notice_employee();
                            },
                        });
                    }
                });
            });
        </script>

        <!--app JS-->
        <script src="assets/js/app.js"></script>
</body>

</html>
