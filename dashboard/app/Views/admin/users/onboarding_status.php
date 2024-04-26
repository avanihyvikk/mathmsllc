<!-- View: admin/users/onboarding.php -->

<?= $this->extend('admin/layout/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo $user->first_name . ' ' . $user->last_name ?></h1>

      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
          <li class="breadcrumb-item active"><a href="<?php echo url('/users') ?>"><?php echo lang('App.users') ?></a></li>
			<li class="breadcrumb-item active">Onboarding Checklist</li>
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
            <h3 class="card-title p-3">Onboarding Info For <?php echo $user->first_name . ' ' . $user->last_name ?></h3>
            <div class="ml-auto p-2">
              <a class="btn btn-danger" onclick="history.back();"><i class="bi bi-arrow-left"></i> Back</a>

            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
        <thead>
            <tr>
				 <th>ID</th> <!-- Add this line to display the ID -->
				
              <!--  <th>Stage ID</th>-->
                <th>Stage Name</th> <!-- New column for Stage Name -->
                <th>Completed On</th>
                <th>Completed By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($onboardingStages as $stage): ?>
                <tr>
                 <!--   <td><?#= htmlspecialchars($stage['stage_id'], ENT_QUOTES, 'UTF-8') ?></td>-->
                    <td><?= htmlspecialchars($stage['id'], ENT_QUOTES, 'UTF-8') ?></td> <!-- Add this line to display the ID -->
					<td><?= htmlspecialchars($stage['stage_name'] ?? 'Stage name not found', ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <?php if (!empty($stage['completed_on'])): ?>
                            <?= htmlspecialchars(date(setting('datetime_format'), strtotime($stage['completed_on'])), ENT_QUOTES, 'UTF-8') ?>
                        <?php else: ?>
                            <form action="<?= base_url('users/markStageCompleted') ?>" method="post">
								<!-- Change the action URL as per your route -->
								<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                <input type="hidden" name="stage_id" value="<?= $stage['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-success">Mark Completed</button>
                            </form>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($stage['completed_by'])): ?>
                            <?php 
                                // Fetch the user's first name and last name based on their ID
                                $userModel = new \App\Models\UserModel();
                                $completedByUser = $userModel->find($stage['completed_by']);
                            ?>
                            <!-- Display the first name and last name of the user who completed the stage -->
                            <?= $completedByUser->first_name ?? 'Unknown' ?> <?= $completedByUser->last_name ?? '' ?>
                        <?php else: ?>
                            <!-- Display "Not Completed" if completed_by is empty -->
                            Not Completed
                        <?php endif; ?>
                    </td>
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
