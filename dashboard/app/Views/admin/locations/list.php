<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Location Data</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Location Data</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Location Data Table</h3>
			  <div class="ml-auto p-2">
                    <?php if (hasPermissions('add_location')): ?>
                      <a href="<?php echo url('location/add') ?>" class="btn btn-primary btn-sm"><span class="pr-1"><i class="fa fa-plus"></i></span>Add Location</a>
                    <?php endif ?>
                </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="location_table" class="table table-bordered table-hover table-striped">
              <thead>
				  
                <tr>
                  <th>Location Name</th>
                  <th>Street Address</th>
                  <th>City</th>
                  <th>State</th>
                  <th>ZIP Code</th>
                  <th>Country</th>
                  <th>Manager</th>
                  <?php if ( hasPermissions('edit_location') ): ?>
                  <th>Action</th> <!-- New column for action buttons -->
                  <?php endif ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($locations as $location) : ?>
                <tr>
                  <td><?= $location['location_name'] ?></td>
                  <td><?= $location['address_street'] ?></td>
                  <td><?= $location['address_city'] ?></td>
                  <td><?= $location['address_state'] ?></td>
                  <td><?= $location['address_zip'] ?></td>
                  <td><?= $location['address_country'] ?></td>
				  <td>
    <?php
    // Check if the location array has a 'manager_id' key
    if (isset($location['manager_id'])) {
        // Fetch manager details based on manager_id
        $managerId = $location['manager_id'];
        // Loop through the users array to find the manager
        foreach ($users as $user) {
            if ($user->id == $managerId) {
                echo $user->first_name . ' ' . $user->last_name;
                break; // Stop looping once manager is found
            }
        }
    } else {
        echo 'No Manager Assigned';
    }
    ?>
</td>
                  
                  <?php if ( hasPermissions('edit_location') ): ?>
                  <td>
                    <a href="<?= base_url('location/edit/' . $location['location_id']) ?>" class="btn btn-primary">Edit</a>
                  </td>
                  <?php endif ?>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
