<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>


<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo lang('App.permissions') ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
          <li class="breadcrumb-item active"><?php echo lang('App.permissions') ?></li>
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
      <h3 class="card-title"><?php echo lang('App.list_all_permissions') ?></h3>

      <div class="card-tools pull-right">
        <?php if (hasPermissions('permissions_add')): ?>
          <a href="<?php echo url('permissions/add') ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo lang('App.create_permission') ?></a>
        <?php endif ?>
      </div>

    </div>
    <div class="card-body">
      <table id="dataTable1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><?php echo lang('App.id') ?></th>
            <th><?php echo lang('App.permission_name') ?></th>
            <th><?php echo lang('App.permission_code') ?></th>
            <th><?php echo lang('App.action') ?></th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($permissions as $row): ?>
            <tr>
              <td width="60"><?php echo $row->id ?></td>
              <td>
                <?php echo $row->title ?>
              </td>
              <td>
                <?php echo $row->code ?>
              </td>
              <td>
                <?php if (hasPermissions('permissions_edit')): ?>
                  <a href="<?php echo url('permissions/edit/'.$row->id) ?>" class="btn btn-sm btn-default" title="<?php echo lang('App.edit_permission') ?>" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                <?php endif ?>
                <?php if (hasPermissions('permissions_delete')): ?>
                  <a href="<?php echo url('permissions/delete/'.$row->id) ?>" class="btn btn-sm btn-default" onclick='return confirm("Do you really want to delete this permissions ? \nIt may cause errors where it is currently being used !!")' title="<?php echo lang('App.delete_permission') ?>" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                <?php endif ?>
              </td>
            </tr>
          <?php endforeach ?>

        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div></div></div>
  <!-- /.card -->

</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
  $('#dataTable1').DataTable()
</script>
<?=  $this->endSection() ?>
