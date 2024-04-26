<!-- app/Views/admin/locations/edit.php -->
<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Expense</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Edit Expense</li>
        </ol>
      </div>
    </div>
	  <!-- Add button to go back to the list of locations -->
    <div class="row mb-2">
      <div class="col-sm-12">
        <?php if ( hasPermissions('view_expense_module') ): ?>
        <div class="text-right"> <a href="<?= base_url('expenses') ?>" class="btn btn-success">Back to Expense List</a> </div>
        <?php endif ?>
      </div>
    </div>
  </div>
  <!-- /.container-fluid --> 
</section>
<div class="row justify-content-center">
  <div class="col-sm-6">   
  <div class="container"> 
    <!-- Editable form for expense details -->
    <div class="card">
      <div class="card-header">
        <?php if (isset($expense)): ?>
        <h3 class="card-title">Editing
          <?= esc($expense['first_name']) ?>
          's Expense</h3>
      </div>
      <div class="card-body">
        <form action="<?= base_url('expenses/update') ?>" method="post">
          <?= csrf_field() ?>
          <input type="hidden" name="expense_id" value="<?= esc($expense['id']); ?>">
          <div class="form-group">
            <label for="item_name">Item Name:</label>
            <input type="text" class="form-control" id="item_name" name="item_name" value="<?= esc($expense['item_name']); ?>">
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('item_name') ?>
            </small> </div>
          <label for="price">Price:</label>
          <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text">$</span> </div>
            <input type="text" class="form-control" id="price" name="price" value="<?= esc($expense['price']); ?>">
          </div>
          <small class="text-danger">
          <?= \Config\Services::validation()->getError('price') ?>
          </small>
          <p>
          <div class="form-group">
            <label for="purchase_date">Purchase Date:</label>
            <input type="text" class="form-control" id="purchase_date" name="purchase_date" value="<?= date(setting('date_format'), strtotime($expense['purchase_date'])); ?>">
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('purchase_date') ?>
            </small> </div>
          <div class="form-group">
            <label for="employee">Employee:</label>
            <input type="text" class="form-control" id="employee" name="employee" value="<?= esc($expense['first_name']) . ' ' . esc($expense['last_name']); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="purchased_from">Purchased From:</label>
            <input type="text" class="form-control" id="purchased_from" name="purchased_from" value="<?= esc($expense['purchased_from']); ?>">
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('purchased_from') ?>
            </small> </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"><?= esc($expense['description']); ?>
</textarea>
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('description') ?>
            </small> </div>
          <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <select class="form-control" id="payment_method" name="payment_method">
              <?php foreach ($paymentOptions as $option): ?>
              <option value="<?= esc($option['option_name']); ?>" <?= esc($expense['payment_method']) == $option['option_name'] ? 'selected' : ''; ?>>
              <?= esc($option['option_name']); ?>
              </option>
              <?php endforeach; ?>
            </select>
            <small class="text-danger">
            <?= \Config\Services::validation()->getError('payment_method') ?>
            </small> </div>
          <?php if ( hasPermissions('update_expense_status') ): ?>
          <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" id="status" name="status">
              <?php foreach ($expenseStatuses as $status): ?>
              <option value="<?php echo $status['name'] ?>"><?php echo $status['name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <?php else: ?>
          <div class="form-group">
            <label for="employee">Status:</label>
            <input type="text" class="form-control" id="status" name="status" value="<?php echo $expense['status'] ?>" readonly>
          </div>
          <?php endif ?>
          <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?= esc($expense['location_name']); ?>" readonly>
          </div>
          <!-- Document Link (if applicable) -->
          <?php if (!empty($expense['bill'])): ?>
          <div class="form-group">
            <label>Document:</label>
            <a href="<?= base_url('uploads/expenses/' . esc($expense['bill'])); ?>" target="_blank" class="document-link">View/Download Document</a> </div>
          <?php endif; ?>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
        <?php else: ?>
        <p>Expense not found.</p>
        <?php endif; ?>
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
	
	

    $(document).ready(function() {
        // Automatically close the alert after 10 seconds
        setTimeout(function() {
            $('#successAlert').alert('close');
        }, 10000);
    });
	
	
	
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
