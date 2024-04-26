<!-- app/Views/admin/locations/edit.php -->
<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>View Expense</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">View Expense</li>
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
      <div class="card">
        <div class="card-header">
          <?php if (isset($expense)): ?>
          <div class="row">
            <div class="col">
              <h3 class="card-title">
                <?= esc($expense['first_name'])?>
                's Expense for
                <?= esc($expense['location_name']); ?>
                from
                <?= date(setting('date_format'), strtotime($expense['purchase_date'])); ?>
              </h3>
            </div>
            <?php if (hasPermissions('edit_expense')): ?>
            <div class="col-auto"> <a href="<?= base_url('expenses/edit/'.$expense['id']) ?>" class="btn btn-primary">Edit this Expense</a> </div>
            <?php endif ?>
          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="item_name">Item Name:</label>
            <input type="text" class="form-control" id="item_name" name="item_name" value="<?= esc($expense['item_name']); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price" value="<?= esc($expense['price']); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="purchase_date">Purchase Date:</label>
            <input type="text" class="form-control" id="purchase_date" name="purchase_date" value="<?= date(setting('date_format'), strtotime($expense['purchase_date'])); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="employee">Employee:</label>
            <input type="text" class="form-control" id="employee" name="employee" value="<?= esc($expense['first_name']) . ' ' . esc($expense['last_name']); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="purchased_from">Purchased From:</label>
            <input type="text" class="form-control" id="purchased_from" name="purchased_from" value="<?= esc($expense['purchased_from']); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" readonly><?= esc($expense['description']); ?>
</textarea>
          </div>
          <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <input type="text" class="form-control" id="payment_method" name="payment_method" value="<?= esc($expense['payment_method']); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" class="form-control" id="status" name="status" value="<?= esc($expense['status']); ?>" readonly>
          </div>
          <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?= esc($expense['location_name']); ?>" readonly>
          </div>
          <?php if (!empty($expense['bill'])): ?>
          <p><span class="detail-label">Document:</span> <a href="<?= base_url('uploads/expenses/' . esc($expense['bill'])); ?>" target="_blank" class="document-link">View/Download Document</a> </p>
          <?php endif; ?>
        </div>
        <?php else: ?>
        <p>Expense not found.</p>
        <?php endif; ?>
      </div>
      <!-- /.card-body --> 
    </div>
    <!-- /.card --> 
  </div>
</div>
<?= $this->endSection() ?>
