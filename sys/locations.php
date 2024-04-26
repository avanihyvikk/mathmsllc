<?php
// Include the authentication script
include 'authenticate.php';
?>
<!DOCTYPE html>
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
                <!--start Greg Content -->
				
                <div class="row">
                    <div class="col-lg-8 mx-auto">
					<!--Start Form-->
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="mb-4">Add a New Location</h5>
                                <form action="insert_location.php" id="newLocation" method="post" class="row g-3">
                                    <div class="row mb-3">
                                        <label for="locationName" class="col-sm-3 col-form-label">Location Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="locationName" name="locationName" placeholder="Location Name" required pattern="[A-Za-z\s]+">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="streetAddress" class="col-sm-3 col-form-label">Street Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="streetAddress" name="streetAddress" placeholder="Street Address" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="city" class="col-sm-3 col-form-label">City</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="state" class="col-sm-3 col-form-label">State</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="state" name="state" placeholder="2 Letter State abbreviation" required pattern="[A-Za-z]{2}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="zip" class="col-sm-3 col-form-label">Zip Code</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="zip" name="zip" placeholder="5 Digit Zip Code" required pattern="[0-9]{5}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="country" class="col-sm-3 col-form-label">Country</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="country" name="country" required>
                                                <option selected>United States</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="manager" class="col-sm-3 col-form-label">Manager</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="manager" name="manager" required>
                                                <option value="" selected disabled>Select the Center Director</option>
                                                <?php
                                                // Include database connection
                                                include 'db_connection.php';

                                                // Query to fetch users with role ID = 4 (center director)
                                                $sql = "SELECT user.user_id, user.first_name, user.last_name
                                                        FROM user
                                                        JOIN user_details ON user.user_id = user_details.user_id
                                                        WHERE user_details.role_id = 4";
                                                $result = $conn->query($sql);

                                                // Check if there are any users
                                                if ($result->num_rows > 0) {
                                                    // Output options for the dropdown
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo '<option value="' . $row['user_id'] . '">' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="">No managers found</option>';
                                                }

                                                // Close database connection
                                                $conn->close();
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                                                <button type="button" id="resetForm" class="btn btn-light px-4">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
						<!--End Form-->
						<!--Start Table-->
						<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="locationTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Street</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip</th>
                        <th>Country</th>
                        <th>Manager</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include database connection
                    include 'db_connection.php';

                    // Query to fetch location data with manager name
                    $sql = "SELECT location.location_name, location.address_street, 
                            location.address_city, location.address_state, location.address_zip, 
                            location.address_country, CONCAT(user.first_name, ' ', user.last_name) AS manager_name
                            FROM location
                            LEFT JOIN user ON location.manager_id = user.user_id";
                    $result = $conn->query($sql);

                    // Check if there are any locations
                    if ($result->num_rows > 0) {
                        // Output data for each location
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['location_name'] . '</td>';
                            echo '<td>' . $row['address_street'] . '</td>';
                            echo '<td>' . $row['address_city'] . '</td>';
                            echo '<td>' . $row['address_state'] . '</td>';
                            echo '<td>' . $row['address_zip'] . '</td>';
                            echo '<td>' . $row['address_country'] . '</td>';
                            echo '<td>' . $row['manager_name'] . '</td>';
                            // Add the edit button
       echo '<td><button class="btn btn-sm btn-danger edit-location-btn" data-location-id="' . $row['location_id'] . '"><i class="bx bx-edit-alt mr-1"></i>Edit</button></td>';
		
		
        echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7">No locations found</td></tr>';
                    }

                    // Close database connection
                    $conn->close();
                    ?>
                </tbody>
               
            </table>
        </div>
    </div>
</div>

						<!--End Table-->
						<!--Start Modal-->
						<div class="modal fade" id="editLocation" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Modal title</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
													<!--Form in MODAL START-->
													<div class="card">
                            <div class="card-body p-4">
                                <h5 class="mb-4">Add a New Location</h5>
                                <form action="insert_location.php" id="editLocation" method="post" class="row g-3">
                                    <div class="row mb-3">
                                        <label for="locationName" class="col-sm-3 col-form-label">Location Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="locationName" name="locationName" placeholder="Location Name" required pattern="[A-Za-z\s]+">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="streetAddress" class="col-sm-3 col-form-label">Street Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="streetAddress" name="streetAddress" placeholder="Street Address" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="city" class="col-sm-3 col-form-label">City</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="state" class="col-sm-3 col-form-label">State</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="state" name="state" placeholder="2 Letter State abbreviation" required pattern="[A-Za-z]{2}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="zip" class="col-sm-3 col-form-label">Zip Code</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="zip" name="zip" placeholder="5 Digit Zip Code" required pattern="[0-9]{5}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="country" class="col-sm-3 col-form-label">Country</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="country" name="country" required>
                                                <option selected>United States</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="manager" class="col-sm-3 col-form-label">Manager</label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="manager" name="manager" required>
                                                <option value="" selected disabled>Select the Center Director</option>
                                                <?php
                                                // Include database connection
                                                include 'db_connection.php';

                                                // Query to fetch users with role ID = 4 (center director)
                                                $sql = "SELECT user.user_id, user.first_name, user.last_name
                                                        FROM user
                                                        JOIN user_details ON user.user_id = user_details.user_id
                                                        WHERE user_details.role_id = 4";
                                                $result = $conn->query($sql);

                                                // Check if there are any users
                                                if ($result->num_rows > 0) {
                                                    // Output options for the dropdown
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo '<option value="' . $row['user_id'] . '">' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="">No managers found</option>';
                                                }

                                                // Close database connection
                                                $conn->close();
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                                                <button type="button" id="resetForm" class="btn btn-light px-4">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
													<!--Form in MODAL END-->
													
													
													
													
													
													
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
														<button type="button" class="btn btn-primary">Save changes</button>
													</div>
												</div>
											</div>
										</div>
										<!--End Modal-->
										
						
                    </div>
                </div>


                <!--end Greg Content -->



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
        <!--app JS-->
        <script src="assets/js/app.js"></script>
        <!--notification js -->
        <script src="assets/plugins/notifications/js/lobibox.min.js"></script>
        <script src="assets/plugins/notifications/js/notifications.min.js"></script>
        <script src="assets/plugins/notifications/js/notification-custom-script.js"></script>
        <script src="assets/plugins/validation/jquery.validate.min.js"></script>



<!-- Include jQuery Validation plugin and Additional Methods -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>

	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#locationTable').DataTable();
		  } );
	</script>

<script>
    $(document).ready(function () {
        // Initialize jQuery Validation for the form
        $("#newLocation").validate({
            // Define validation rules for each input field
            rules: {
                locationName: {
                    required: true,
                    pattern: /^[A-Za-z\s]+$/,
                    minlength: 2
                },
                streetAddress: {
                    required: true
                },
                city: {
                    required: true
                },
                state: {
                    required: true,
                    pattern: /^[A-Za-z]{2}$/
                },
                zip: {
                    required: true,
                    pattern: /^[0-9]{5}$/
                },
                country: {
                    required: true
                },
                manager: {
                    required: true
                }
            },
            // Define custom error messages for each validation rule
            messages: {
                locationName: {
                    required: "Please enter a location name.",
                    pattern: "Location name should only contain letters and spaces.",
                    minlength: "Location name should be at least 2 characters long."
                },
                streetAddress: {
                    required: "Please enter a street address."
                },
                city: {
                    required: "Please enter a city."
                },
                state: {
                    required: "Please enter a state.",
                    pattern: "State should be a two-letter abbreviation."
                },
                zip: {
                    required: "Please enter a zip code.",
                    pattern: "Zip code should be exactly 5 digits."
                },
                country: {
                    required: "Please select a country."
                },
                manager: {
                    required: "Please select a manager."
                }
            },
            // Specify where to display error messages
errorPlacement: function (error, element) {
    error.insertAfter(element); // Append error message after the input field
},
// Define behavior for invalid and valid fields
highlight: function (element, errorClass, validClass) {
    $(element).addClass(errorClass).removeClass(validClass);
    $(element).closest('.form-group').addClass('has-error');
},
unhighlight: function (element, errorClass, validClass) {
    $(element).removeClass(errorClass).addClass(validClass);
    $(element).closest('.form-group').removeClass('has-error');
},
            // Define function to handle form submission
            submitHandler: function (form) {
                // Serialize the form data
                var formData = $(form).serialize();

                // Submit the form data via AJAX
                $.ajax({
                    type: "POST",
                    url: "insert_location.php",
                    data: formData,
                    success: function (response) {
                        if (response.trim() === "success") {
                            success_notice_employee();
                            // Reload the page after a short delay (e.g., 1 second)
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        } else {
                            error_notice_employee();
                        }
                    },
                    error: function () {
                        error_notice_employee();
                    }
                });
            }
        });

        // Function to handle form reset
        $("#resetForm").click(function () {
            // Reset the form fields to their default values
            $("#newLocation").validate().resetForm(); // Reset validation state
            $("#newLocation")[0].reset(); // Reset form fields
        });

        // Function to display error notification
        function error_notice_employee() {
            Lobibox.notify('error', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-x-circle',
                msg: 'Failed to add location.'
            });
        }

        // Function to display success notification
        function success_notice_employee() {
            Lobibox.notify('success', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-check-circle',
                msg: 'Location added successfully.'
            });
        }
    });
	
$('button.edit-location-btn').click(function() {
    // Get the row corresponding to the clicked edit button
    var row = $(this).closest('tr');

    // Extract data from the row
    var locationName = row.find('td:eq(0)').text();
    var streetAddress = row.find('td:eq(1)').text();
    var city = row.find('td:eq(2)').text();
    var state = row.find('td:eq(3)').text();
    var zip = row.find('td:eq(4)').text();
    var country = row.find('td:eq(5)').text();
    var managerId = row.find('td:eq(6)').data('manager-id');

    // Populate the form fields in the modal with the extracted data
    $('#editLocation #locationName').val(locationName);
    $('#editLocation #streetAddress').val(streetAddress);
    $('#editLocation #city').val(city);
    $('#editLocation #state').val(state);
    $('#editLocation #zip').val(zip);
    $('#editLocation #country').val(country);

    // Fetch the manager's name from the database based on the manager ID
    $.ajax({
        type: 'POST',
        url: window.location.href, // URL of the current page
        data: { action: 'get_manager_name', managerId: managerId },
        success: function(response) {
            // Populate the manager select box with the fetched manager's name
            $('#editLocation #manager').val(response);
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error('Error fetching manager name:', error);
            // Optionally, display an error message
        }
    });

    // Show the modal
    $('#editLocation').modal('show');
});

</script>
</body>

</html>
