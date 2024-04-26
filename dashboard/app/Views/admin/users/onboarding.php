<!-- View: admin/users/onboarding.php -->

<?= $this->extend('admin/layout/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Onboarding Overview</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
          <li class="breadcrumb-item active"><a href="<?php echo url('/users') ?>"><?php echo lang('App.users') ?></a></li>
			<li class="breadcrumb-item active">Onboarding Overview</li>
		
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
            <h3 class="card-title p-3">Onboarding Overview</h3>
            <div class="ml-auto p-2">
              <a href="<?php echo base_url() ?>" class="btn btn-danger">Back to Home</a>
            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <table id="userTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>User ID</th>
				  <th>Full Name</th>
                  <th>First Name</th>
                  <th>Last Name</th>
				  <th>Onboarding Task Completed</th>
                  <th>Onboarding Task Assigned</th>
                  <th>Progress</th> <!-- New column for progress bar -->
                  <th>Percentage Completed</th> <!-- New column for percentage -->
				  <th>Details</th>	
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user): ?>
                  <tr>
                    <td><?= $user['user_id'] ?></td>
					<td><?= $user['first_name'] ?> <?= $user['last_name'] ?> </td>
                    <td><?= $user['first_name'] ?></td>
                    <td><?= $user['last_name'] ?></td>
                    <td><?= $user['total_stages_completed'] ?></td>
					  <td><?= $user['total_stages_assigned'] ?></td>
					  
                    
                    <td>
                      <?php 
                        $percentage = $user['percentage_completed'];
                        $progressClass = '';
                        if ($percentage >= 0 && $percentage < 70) {
                          $progressClass = 'bg-danger';
                        } elseif ($percentage >= 70 && $percentage < 100) {
                          $progressClass = 'bg-warning';
                        } else {
                          $progressClass = 'bg-success';
                        }
                      ?>
                      <div class="progress">
                        <div class="progress-bar <?= $progressClass ?>" style="width: <?= $percentage ?>%"></div>
                      </div>
                    </td>
                    <td>
                      <?php 
                        if ($percentage >= 0 && $percentage < 70) {
                          echo '<span class="badge bg-danger">' . $percentage . '%</span>';
                        } elseif ($percentage >= 70 && $percentage < 100) {
                          echo '<span class="badge bg-warning">' . $percentage . '%</span>';
                        } else {
                          echo '<span class="badge bg-success">' . $percentage . '%</span>';
                        }
                      ?>
                    </td>
					  <td><a class="btn btn-primary btn-sm" href="<?php echo url('users/onboard_status/' . $user['user_id']); ?>">View / Edit</a></td>





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
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- DataTables -->
<script>
  $(function () {
    $("#userTable").DataTable();
  });
</script>
<?= $this->endSection() ?>
