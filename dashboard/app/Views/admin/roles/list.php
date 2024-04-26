<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo lang('App.roles') ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
          <li class="breadcrumb-item active"><?php echo lang('App.roles') ?></li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="row">

    <div class="col-sm-3">
      <?php // die(var_dump($_page->menu)) ?>

      <?= $this->include('admin/settings/sidebar'); ?>

    </div>
    <div class="col-sm-9">
  <!-- Default card -->
  <div class="card">
    <div class="card-header with-border">
      <h3 class="card-title"><?php echo lang('App.list_roles') ?></h3>

      <div class="card-tools pull-right">
        <a href="<?php echo url('roles/add') ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus pr-1"></i> <?php echo lang('App.create_role') ?></a>
      </div>

    </div>
    <div class="card-body">
      <table id="dataTable1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><?php echo lang('App.id'); ?></th>
            <th><?php echo lang('App.role_name'); ?></th>
            <th>Reports To</th>
            <th>Status</th> <!-- New column for status -->
            <th><?php echo lang('App.action'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($roles as $row): ?>
        <tr>
            <td width="60"><?php echo $row->id; ?></td>
            <td><?php echo $row->title; ?></td>
            <td><?php echo $row->parent_title ?: 'N/A'; ?></td>
            <td>
                <?php echo $row->is_active ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?>
            </td>
            <td>
                <?php if (hasPermissions('roles_edit')): ?>
                <a href="<?php echo url('roles/edit/'.$row->id); ?>" class="btn btn-sm btn-default" title="Edit User Role" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                <?php endif; ?>
                <?php if (hasPermissions('roles_toggle_status')): ?>
                <!-- Toggle button for activating/deactivating the role -->
                <a href="<?php echo url('roles/toggle_status/'.$row->id); ?>" class="btn btn-sm <?php echo $row->is_active ? 'btn-warning' : 'btn-info'; ?>" title="<?php echo $row->is_active ? 'Deactivate' : 'Activate'; ?> User Role" data-toggle="tooltip">
                    <i class="fas <?php echo $row->is_active ? 'fa-toggle-on' : 'fa-toggle-off'; ?>"></i>
                </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    </div>
    <!-- /.card-body -->
  </div>
		 </div>
	   </div>
  <!-- /.card -->

</section>
<!-- /.content -->


<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
  $('#dataTable1').DataTable()
</script>
<?=  $this->endSection() ?>
