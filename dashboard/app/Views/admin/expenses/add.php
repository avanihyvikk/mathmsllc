<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Add Expense</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Blank Page</li>
        </ol>
      </div>
    </div>
    <!-- Add button to go back to the list of expenses -->
    <?php if ( hasPermissions('view_expense_module') ): ?>
    <div class="row mb-2">
      <div class="col-sm-12">
        <div class="text-right"> <a href="<?= base_url('expenses') ?>" class="btn btn-success">Back to Expense List</a> </div>
      </div>
    </div>
    <?php endif ?>
  </div>
  <!-- /.container-fluid --> 
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
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Add Expense</h3>
        </div>
        <div class="card-body">
        <?= \Config\Services::validation()->listErrors(); ?>
        <form id="addExpenseForm" action="<?= base_url('expenses/store') ?>" method="post" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="form-group">
            <label for="item_name">Item Name:</label>
            <input type="text" class="form-control" id="item_name" name="item_name" value="<?= set_value('item_name') ?>">
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('item_name') ?>
            </small> </div>
          <label for="price">Price:</label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text">$</span> </div>
            <input type="text" class="form-control" id="price" name="price" value="<?= set_value('price') ?>">
          </div>
          <small class="text-danger">
          <?= \Config\Services::validation()->getError('price') ?>
          </small>
          <p>
          <div class="form-group">
            <label for="purchase_date">Purchase Date:</label>
            <input type="text" class="form-control" id="purchase_date" name="purchase_date" value="<?= set_value('purchase_date') ?>">
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('purchase_date') ?>
            </small> </div>
          
          <!-- Add dropdown for employee selection -->
          <div class="form-group">
            <label for="employee_id">Employee:</label>
<select class="form-control" id="employee_id" name="employee_id">
    <?php foreach ($managedEmployees as $employee): ?>
    <option value="<?= $employee->id ?>" <?= ($employee->id == $userId) ? 'selected' : '' ?>>
        <?= $employee->first_name ?> <?= $employee->last_name ?>
    </option>
    <?php endforeach; ?>
</select>
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('employee_id') ?>
            </small> </div>
          
          <!-- Add dropdown for location selection -->
          <div class="form-group">
            <label for="location_id">Location:</label>
            <select class="form-control" id="location_id" name="location_id">
              <?php foreach ($assignedLocations as $location): ?>
              <option value="<?= $location->location_id ?>">
              <?= $location->location_name ?>
              </option>
              <?php endforeach; ?>
            </select>
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('location_id') ?>
            </small> </div>
          <div class="form-group">
            <label for="purchased_from">Purchased From:</label>
            <input type="text" class="form-control" id="purchased_from" name="purchased_from" value="<?= set_value('purchased_from') ?>">
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('purchased_from') ?>
            </small> </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"><?= set_value('description') ?>
</textarea>
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('description') ?>
            </small> </div>
          <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <select class="form-control" id="payment_method" name="payment_method">
              <option value="">Select Payment Method</option>
              <?php foreach ($payment_options as $option): ?>
              <option value="<?= $option['option_name'] ?>" <?= set_select('payment_method', $option['option_name']) ?>>
              <?= $option['option_name'] ?>
              </option>
              <?php endforeach; ?>
            </select>
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('payment_method') ?>
            </small> </div>
          <label for="bill">Bill</label>
          <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="bill" name="bill">
              <label class="custom-file-label" for="bill">Choose file</label>
            </div>
            <div class="input-group-append"> <span class="input-group-text">Upload</span> </div>
          </div>
          <small class="text-danger">
          <?= \Config\Services::validation()->getError('bill') ?>
          </small>
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
<!-- jQuery --> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

<!-- jQuery UI (Datepicker) -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<script type="text/javascript">
// Update the custom file input label with the selected file name
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$(document).ready(function () {
    // Price field live validation
    $('#price').on('input', function() {
        var price = $(this).val();
        if (!isValidPrice(price)) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Purchase date field live validation
    $('#purchase_date').on('input', function() {
        var purchaseDate = $(this).val();
        if (!isValidDate(purchaseDate)) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Initialize datepicker
    $('#purchase_date').datepicker({
        maxDate: '0', // Set max date to today
        dateFormat: 'mm/dd/yy', // Set date format
        changeMonth: true,
        changeYear: true,
        yearRange: 'c-100:c+0' // Allow selection of dates from 100 years ago to today
    });

    // Function to validate price format
    function isValidPrice(price) {
        return /^\d{1,3}(?:,\d{3})*(?:\.\d{2})?$/.test(price);
    }

    // Function to validate date format
    function isValidDate(date) {
        return !/Invalid|NaN/.test(new Date(date).toString());
    }
});
</script>
<?= $this->endSection() ?>
