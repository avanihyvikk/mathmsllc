<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Location</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Blank Page</li>
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
            <?php if (session()->has('success')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session('success') ?>
                </div>
            <?php endif ?>
            <?php if (session()->has('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session('error') ?>
                </div>
            <?php endif ?>



<!-- Bootstrap success and error alerts -->
<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
    Location added successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
    An error occurred while adding the location. Please try again.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>


            <!-- Default card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Location</h3>
                </div>
                <div class="card-body">

                    <?= \Config\Services::validation()->listErrors(); ?>
                    <form id="addLocationForm" action="<?= site_url('location/addLocation') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="location_name">Location Name:</label>
                            <input type="text" class="form-control" id="location_name" name="location_name" required>
                        </div>
                        <div class="form-group">
                            <label for="address_street">Street Address:</label>
                            <input type="text" class="form-control" id="address_street" name="address_street" required>
                        </div>
                        <div class="form-group">
                            <label for="address_city">City:</label>
                            <input type="text" class="form-control" id="address_city" name="address_city" required>
                        </div>
                        <div class="form-group">
                            <label for="address_state">State:</label>
                            <input type="text" class="form-control" id="address_state" name="address_state" required>
                        </div>
                        <div class="form-group">
                            <label for="address_zip">ZIP Code:</label>
                            <input type="text" class="form-control" id="address_zip" name="address_zip" required>
                        </div>
                        <div class="form-group">
                            <label for="address_country">Country:</label>
                            <input type="text" class="form-control" id="address_country" name="address_country" required>
                        </div>
                        <div class="form-group">
                            <label for="manager_id">Manager:</label>
                            <select class="form-control" id="manager_id" name="manager_id" required>
                                <option value="">Select Manager</option>
                                <?php foreach ($users as $user) : ?>
                                    <option value="<?= $user->id ?>"><?= $user->first_name ?> <?= $user->last_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
        $('#addLocationForm').validate({
            rules: {
                location_name: {
                    required: true,
                },
                address_street: {
                    required: true,
                },
                address_city: {
                    required: true,
                },
                address_state: {
                    required: true,
                    minlength: 2,
                    maxlength: 2,
                    pattern: /^[A-Za-z]{2}$/,
                },
                address_zip: {
                    required: true,
                    minlength: 5,
                    maxlength: 5,
                    digits: true
                },
                address_country: {
                    required: true,
                },
                manager_id: {
                    required: false,
                },
            },
            messages: {
                location_name: {
                    required: "Please enter a location name"
                },
                address_street: {
                    required: "Please enter a street address"
                },
                address_city: {
                    required: "Please enter a city"
                },
                address_state: {
                    required: "Please enter a state",
                    minlength: "State abbreviation must be 2 letters",
                    maxlength: "State abbreviation must be 2 letters",
                    pattern: "Please enter a valid 2-letter state abbreviation"
                },
                address_zip: {
                    required: "Please enter a ZIP code",
                    minlength: "ZIP code must be 5 digits",
                    maxlength: "ZIP code must be 5 digits",
                    digits: "ZIP code must contain only digits"
                },
                address_country: {
                    required: "Please enter a country"
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

 $('#addLocationForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        if ($('#addLocationForm').valid()) {
            // Form is valid, submit it
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (response) {
                    console.log(response); // Log the response to the console for debugging
                    if (response.success) {
                        // Location added successfully
                        $('#successAlert').show().delay(15000).fadeOut(); // Show success alert for 5 seconds
                        $('#addLocationForm').trigger('reset'); // Reset form fields
                    } else {
                        // Location could not be added
                        $('#errorAlert').text(response.message).show().delay(15000).fadeOut(); // Show error alert with message for 5 seconds
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    $('#errorAlert').text('An error occurred while adding the location. Please try again.').show().delay(15000).fadeOut(); // Show error alert for 5 seconds
                    console.error(error);
                }
            });
        }
    });
});
</script>



<?= $this->endSection() ?>
