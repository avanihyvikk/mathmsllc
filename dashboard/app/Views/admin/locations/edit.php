<!-- app/Views/admin/locations/edit.php -->
<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Location</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Location</li>
                </ol>
            </div>
        </div>
		<!-- Add button to go back to the list of locations -->
        <div class="row mb-2">
            <div class="col-sm-12">
                <?php if ( hasPermissions('view_location') ): ?>
				<div class="text-right">
                    <a href="<?= base_url('location') ?>" class="btn btn-success">Back to Location List</a>
                </div>
				<?php endif ?>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="container">
            <!-- Bootstrap success and error alerts -->
            <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                Location updated successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                An error occurred while updating the location. Please try again.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Default card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Location</h3>
                </div>
                <div class="card-body">

                    <?= \Config\Services::validation()->listErrors(); ?>
                    <form id="editLocationForm" action="<?= site_url('location/updateLocation') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="location_id" value="<?= $location['location_id'] ?>">
                        <div class="form-group">
                            <label for="location_name">Location Name:</label>
                            <input type="text" class="form-control" id="location_name" name="location_name" value="<?= $location['location_name'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="address_street">Street Address:</label>
                            <input type="text" class="form-control" id="address_street" name="address_street" value="<?= $location['address_street'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="address_city">City:</label>
                            <input type="text" class="form-control" id="address_city" name="address_city" value="<?= $location['address_city'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="address_state">State:</label>
                            <input type="text" class="form-control" id="address_state" name="address_state" value="<?= $location['address_state'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="address_zip">ZIP Code:</label>
                            <input type="text" class="form-control" id="address_zip" name="address_zip" value="<?= $location['address_zip'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="address_country">Country:</label>
                            <input type="text" class="form-control" id="address_country" name="address_country" value="<?= $location['address_country'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="manager_id">Manager:</label>
                            <select class="form-control" id="manager_id" name="manager_id" required>
                                <option value="">Select Manager</option>
                                <?php foreach ($users as $user) : ?>
                                    <option value="<?= $user->id ?>" <?= ($user->id == $location['manager_id']) ? 'selected' : '' ?>>
                                        <?= $user->first_name ?> <?= $user->last_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Location</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#editLocationForm').validate({
        rules: {
            address_state: {
                minlength: 2,
                maxlength: 2,
                pattern: /^[A-Za-z]{2}$/,
            },
            address_zip: {
                minlength: 5,
                maxlength: 5,
                digits: true
            },
        },
        messages: {
            address_state: {
                minlength: "State abbreviation must be 2 letters",
                maxlength: "State abbreviation must be 2 letters",
                pattern: "Please enter a valid 2-letter state abbreviation"
            },
            address_zip: {
                minlength: "ZIP code must be 5 digits",
                maxlength: "ZIP code must be 5 digits",
                digits: "ZIP code must contain only digits"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    $('#editLocationForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        if ($('#editLocationForm').valid()) {
            // Form is valid, submit it
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (response) {
                    console.log(response); // Log the response to the console for debugging
                    if (response.success) {
                        // Location updated successfully
                        var successMessage = $('<div class="alert alert-success alert-dismissible fade show" role="alert">Location updated successfully<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        $('#editLocationForm').prepend(successMessage);
                    } else {
                        // Location could not be updated
                        var errorMessage = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">An error occurred while updating the location. Please try again<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        $('#editLocationForm').prepend(errorMessage);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    var errorMessage = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">An error occurred while updating the location. Please try again<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    $('#editLocationForm').prepend(errorMessage);
                    console.error(error);
                }
            });
        }
    });
});

</script>

<?= $this->endSection() ?>
