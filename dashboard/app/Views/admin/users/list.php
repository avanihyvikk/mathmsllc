<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo lang('App.users') ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
          <li class="breadcrumb-item active"><?php echo lang('App.users') ?></li>
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
                <h3 class="card-title p-3"><?php echo lang('App.users') ?></h3>
<div class="ml-auto p-2">
    <?php if (hasPermissions('users_add')): ?>
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo lang('App.new_user') ?>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <?php foreach ($roles as $role): ?>
                    <a class="dropdown-item text-truncate" href="<?php echo url('users/add') . '?role=' . $role->id ?>" title="<?php echo $role->title ?>"><?php echo $role->title ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif ?>
</div>

              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover table-striped">
                  <thead>
                  <tr>
                    <th><?php echo lang('App.id') ?></th>
                    
                    <th><?php echo lang('App.user_name') ?></th>
                    <th><?php echo lang('App.user_email') ?></th>
                    <th><?php echo lang('App.user_role') ?></th>
					<th>Locations</th>
					<th>Manager</th>
                    <th><?php echo lang('App.user_last_login') ?></th>
                    
					<th><?php echo lang('App.user_status') ?></th>
                    <?php if (hasPermissions('users_delete') || hasPermissions('users_view') || hasPermissions('users_edit')): ?>
					<th><?php echo lang('App.action') ?></th>
					<?php endif ?>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($users as $row): ?>
                    <tr>
                      <td width="60"><?php echo $row->id ?></td>
                      
                      <td>
                        <?php echo $row->first_name . ' ' . $row->last_name ?>
                      </td>
                      <td><?php echo $row->email ?></td>
                      <td><?php echo ucfirst(model('App\Models\RoleModel')->getRowById($row->role, 'title')) ?></td>
                      <td><?php echo htmlspecialchars($row->assigned_locations); ?></td>
					  <td><?php echo $row->manager_full_name; ?></td> <!-- Displaying the manager's full name -->

					  
					  <td><?php echo ($row->last_login!='0000-00-00 00:00:00')?date( setting('date_format'), strtotime($row->last_login)):'No Record' ?></td>
                      
<td>
  <?php if (hasPermissions('deactivate_user')): ?>
    <?php if (logged('id') == $row->id): ?>
      <!-- Display the correct status text for the current logged-in user based on their status, even if the checkbox is disabled -->
      <input type="checkbox" name="my-checkbox" disabled data-bootstrap-switch data-off-color="secondary" data-on-color="success" 
      data-off-text="<?php echo lang('App.user_inactive') ?>" data-on-text="<?php echo lang('App.user_active') ?>"
      <?php echo ($row->status) ? 'checked' : '' ?>> <!-- Ensure this line is added to maintain status -->
    <?php else: ?>
      <!-- For other users, allow status change if the logged-in user has the right permissions -->
      <input type="checkbox" name="my-checkbox" onchange="updateUserStatus('<?php echo $row->id ?>', $(this).is(':checked'))" 
      <?php echo ($row->status) ? 'checked' : '' ?> data-bootstrap-switch data-off-color="secondary" data-on-color="success" 
      data-off-text="<?php echo lang('App.user_inactive') ?>" data-on-text="<?php echo lang('App.user_active') ?>">
    <?php endif; ?>
  <?php else: ?>
    <!-- If the user does not have permissions, show the correct status text for the disabled checkbox based on the user's status -->
    <input type="checkbox" name="my-checkbox" disabled data-bootstrap-switch data-off-color="secondary" data-on-color="success" 
    data-off-text="<?php echo lang('App.user_inactive') ?>" data-on-text="<?php echo lang('App.user_active') ?>"
    <?php echo ($row->status) ? 'checked' : '' ?>> <!-- Ensure this line is added to reflect actual status -->
  <?php endif; ?>
</td>


                      <td>
                        <?php if (hasPermissions('users_edit')): ?>
                          <a href="<?php echo url('users/edit/'.$row->id) ?>" class="btn btn-sm btn-primary" title="<?php echo lang('App.edit_user') ?>" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                        <?php endif ?>
                        <?php if (hasPermissions('users_view')): ?>
                          <a href="<?php echo url('users/view/'.$row->id) ?>" class="btn btn-sm btn-info" title="<?php echo lang('App.view_user') ?>" data-toggle="tooltip"><i class="fa fa-eye"></i></a>
                        <?php endif ?>
                        <?php if (hasPermissions('users_delete')): ?>
                          <?php if ($row->id!=1 && logged('id')!=$row->id): ?>
                            <a href="<?php echo url('users/delete/'.$row->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Do you really want to delete this user ?')" title="<?php echo lang('App.delete_user') ?>" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                          <?php else: ?>
                            <a href="#" class="btn btn-sm btn-danger" title="<?php echo lang('App.delete_user_cannot') ?>" data-toggle="tooltip" disabled><i class="fa fa-trash"></i></a>
                          <?php endif ?>
                        <?php endif ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
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

<script>
window.updateUserStatus = (id, status) => {
  $.get( '<?php echo url('users/change_status') ?>/'+id, {
    status: status
  }, (data, status) => {
    if (data=='done') {
      // code
    }else{
      alert('<?php echo lang('App.user_unable_change_status') ?>');
    }
  })
}
</script>
<?=  $this->endSection() ?>