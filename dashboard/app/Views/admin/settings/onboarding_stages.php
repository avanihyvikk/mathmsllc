<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo lang('App.settings') ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
          <li class="breadcrumb-item active"><?php echo lang('App.settings') ?></li>
        </ol>
      </div>
    </div>
  </div>
  <!-- /.container-fluid --> 
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-sm-3">
      <?= $this->include('admin/settings/sidebar'); ?>
    </div>
    <?php if (hasPermissions('edit_onboarding_steps')): ?>
    <div class="col-sm-8"> 
      
      <!-- Default card -->
      <div class="card">
        <div class="card-header with-border">
          <h3 class="card-title">Onboarding Stages</h3>
        </div>
        <div class="card-body">
        <!--CHATGPT PUT CODE HERE -->
        
        <form action="<?= base_url('settings/updateStages') ?>" method="POST">
          <?= csrf_field() ?>
          <table id="stagesTable" class="table table-bordered">
            <thead>
              <tr>
                <th>Stage Name</th>
                <th>Stage Order</th>
                <th>Is Active</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($stages as $stage): ?>
              <tr <?php if (!$stage['is_active']) echo 'style="background-color: #f2dede; color: #a94442;"'; ?>>
                <td><input type="text" class="form-control" name="stages[<?= $stage['id']; ?>][stage_name]" value="<?= $stage['stage_name']; ?>"></td>
                <td><input type="number" class="form-control" name="stages[<?= $stage['id']; ?>][stage_order]" value="<?= $stage['stage_order']; ?>"></td>
                <td><select class="form-control" name="stages[<?= $stage['id']; ?>][is_active]">
                    <option value="1" <?= $stage['is_active'] ? 'selected' : ''; ?>>Yes</option>
                    <option value="0" <?= !$stage['is_active'] ? 'selected' : ''; ?>>No</option>
                  </select></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          </div>
          <!-- /.card-body -->
          
          <div class="card-footer">
          <button type="submit" class="btn btn-flat btn-primary"><?php echo lang('App.submit') ?></button>
        </form>
      </div>
      <!-- /.card-footer--> 
      
    </div>
    <!-- /.card --> 
    
  </div>
  </div>
  <?php else: ?>
  <div class="col-sm-8"> 
    
    <!-- Default card -->
    <div class="card">
      <div class="card-header with-border">
        <h3 class="card-title">Onboarding Stages</h3>
      </div>
      <div class="card-body"> 
        
        <table id="stagesTable" class="table table-bordered">
          <thead>
            <tr>
              <th>Stage Name</th>
              <th>Stage Order</th>
              <th>Is Active</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($stages as $stage): ?>
            <tr <?php if (!$stage['is_active']) echo 'style="background-color: #f2dede; color: #a94442;"'; ?>>
              <td><?= $stage['stage_name']; ?></td>
              <td><?= $stage['stage_order']; ?></td>
              <td><?= $stage['is_active'] ? 'Yes' : 'No'; ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
      
      <div class="card-footer"> 
        <!-- No form elements here because user does not have permissions to edit --> 
      </div>
      <!-- /.card-footer--> 
      
    </div>
    <!-- /.card --> 
    
  </div>
  </div>
  <?php endif; ?>
  <div class="row">
    <div class="col-sm-3"> </div>
    <?php if (hasPermissions('add_onboarding_steps')): ?>
    <div class="col-sm-8"> 
      
      <!-- Default card -->
      <div class="card">
        <div class="card-header with-border">
          <h3 class="card-title">Add a New Stage</h3>
        </div>
        <div class="card-body">        
        <form action="<?= base_url('settings/addStage') ?>" method="POST">
          <?= csrf_field() ?>
          <div class="form-group">
            <label for="newStageName">Stage Name</label>
            <input type="text" class="form-control" id="newStageName" name="new_stage_name">
          </div>
          <div class="form-group">
            <label for="newStageOrder">Stage Order</label>
            <input type="number" class="form-control" id="newStageOrder" name="new_stage_order">
          </div>
          
          <!--CHATGPT PUT CODE HERE -->
          </div>
          <!-- /.card-body -->
          
          <div class="card-footer">
          <button type="submit" class="btn btn-flat btn-primary"><?php echo lang('App.submit') ?></button>
        </form>
      </div>
      <!-- /.card-footer--> 
      
    </div>
    <!-- /.card --> 
    
  </div>
  <?php endif ?>
  </div>
</section>
<!-- /.content -->

<?= $this->endSection() ?>
