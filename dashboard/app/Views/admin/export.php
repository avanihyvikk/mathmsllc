<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo lang('App.backup') ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
          <li class="breadcrumb-item active"><?php echo lang('App.backup') ?></li>
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
      <h3 class="card-title"><?php echo lang('App.backup_db') ?></h3>
    </div>

    <div class="card-body">
    	<a href="<?php echo url('backup/exportDB') ?>" class="btn btn-lg btn-primary"> <i class="fa fa-download"></i> &nbsp;&nbsp;&nbsp; <?php echo lang('App.backup_generate_message') ?></a>
    </div>
    <!-- /.card-body -->

  </div></div></div>
  <!-- /.card -->

</section>
<!-- /.content -->


<?= $this->endSection() ?>

