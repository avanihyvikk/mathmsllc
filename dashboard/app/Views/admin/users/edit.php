<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->

<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo lang('App.users') ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><?php echo lang('App.home') ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo url('/users') ?>"><?php echo lang('App.users') ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('App.edit_user') ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<!-- Main content -->

<!-- Main content -->
<section class="content">

<?php echo form_open_multipart('users/update/'.$user->id, [ 'class' => 'form-validate', 'autocomplete' => 'off' ]); ?>

  <div class="row">
    <div class="col-sm-6">
      <!-- Default card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?php echo lang('App.user_basic') ?></h3>
        </div>
        <div class="card-body">
		  
		  <div class="form-group">
            <label for="formClient-first_name">First Name</label>
            <input type="text" class="form-control" name="first_name" id="formClient-first_name" required placeholder="<?php echo lang('App.user_enter_name') ?>" value="<?php echo $user->first_name ?>" autofocus />
          </div>
		  
		  <div class="form-group">
            <label for="formClient-last_name">Last Name</label>
            <input type="text" class="form-control" name="last_name" id="formClient-last_name" required placeholder="<?php echo lang('App.user_enter_name') ?>" value="<?php echo $user->last_name ?>" autofocus />
          </div>

          
          <div class="form-group">
            <label for="formClient-Contact"><?php echo lang('App.user_contact') ?></label>
            <input type="text" class="form-control" name="phone" id="formClient-Contact" placeholder="<?php echo lang('App.user_enter_contact') ?>" value="<?php echo $user->phone ?>" />
          </div>

        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->

      <!-- Default card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?php echo lang('App.user_login_details') ?></h3>
        </div>
        <div class="card-body">

          <div class="form-group">
            <label for="formClient-Username"><?php echo lang('App.user_username') ?></label>
            <input type="text" class="form-control" data-rule-remote="<?php echo url('users/check?notId='.$user->id) ?>" data-msg-remote="<?php echo lang('App.user_username_take') ?>" name="username" id="formClient-Username" required placeholder="<?php echo lang('App.user_enter_username') ?>"  value="<?php echo $user->username ?>"/>
          </div>

          <div class="form-group">
            <label for="formClient-Email">Email</label>
            <input type="email" class="form-control" name="email" data-rule-remote="<?php echo url('users/check?notId='.$user->id) ?>" data-msg-remote="<?php echo lang('App.user_email_exists') ?>" id="formClient-Email" required placeholder="<?php echo lang('App.user_enter_email') ?>"  value="<?php echo $user->email ?>">
          </div>

          <div class="form-group">
            <label for="password"><?php echo lang('App.user_password') ?></label>
            <input type="password" class="form-control" minlength="6" name="password" id="password" placeholder="Password" />
            <p class="help-block"><?php echo lang('App.user_password_leave_blank') ?></p>
          </div>

          <div class="form-group">
            <label for="formClient-ConfirmPassword"><?php echo lang('App.user_password_confirm') ?></label>
            <input type="password" class="form-control" minlength="6" equalTo="#password" name="confirm_password" id="formClient-ConfirmPassword" placeholder="<?php echo lang('App.user_password_confirm') ?>" />
          </div>

        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->
      
    </div>
    <div class="col-sm-6">
      <!-- Default card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?php echo lang('App.user_other_details') ?></h3>
        </div>
        <div class="card-body">

          <div class="form-group">
            <label for="formClient-Address"><?php echo lang('App.user_address') ?></label>
            <textarea type="text" class="form-control" name="address" id="formClient-Address" placeholder="<?php echo lang('App.user_enter_address') ?>" rows="3"><?php echo $user->address ?></textarea>

          </div>

          <div class="form-group">
            <label for="formClient-Role"><?php echo lang('App.user_role') ?></label>
            <select name="role" id="formClient-Role" class="form-control select2" required>
              <option value=""><?php echo lang('App.user_select_role') ?></option>
              <?php foreach (model('App\Models\RoleModel')->findAll() as $row): ?>
                <?php $sel = !empty($user->role) && $user->role==$row->id ? 'selected' : '' ?>
                <option value="<?php echo $row->id ?>" <?php echo $sel ?>><?php echo $row->title ?></option>
              <?php endforeach ?>
            </select>
          </div>

          <?php if (logged('id')!=$user->id): ?>
            
          <?php endif ?>
          <div class="form-group">
            <label for="formClient-Status"><?php echo lang('App.user_status') ?></label>
            <select name="status" id="formClient-Status" class="form-control" <?php echo logged('id')==$user->id ? 'disabled' : '' ?>>
              <?php $sel = $user->status==1 ? 'selected' : '' ?>
              <option value="1" <?php echo $sel ?>><?php echo lang('App.user_active') ?></option>
              <?php $sel = $user->status==0 ? 'selected' : '' ?>
              <option value="0" <?php echo $sel ?>><?php echo lang('App.user_inactive') ?></option>
            </select>
          </div>
		  
<div class="form-group">
    <label for="formClient-Locations">Assigned Locations</label>
    <select name="locations[]" id="formClient-Locations" class="form-control select2" data-dropdown-css-class="select2-red" style="width: 100%;" multiple>
        <?php 
            // Convert assigned locations string to an array
            $assignedLocationsArray = explode(', ', $user->assigned_locations);
        ?>
        <?php foreach ($locations as $location): ?>
		
            <?php 
                // Check if the current location name is in the assigned locations array
                $isSelected = in_array($location['location_name'], $assignedLocationsArray) ? 'selected' : ''; 
            ?>
            <option value="<?php echo $location['location_id'] ?>" <?php echo $isSelected ?>>
                <?php echo $location['location_name'] ?>
            </option>
        <?php endforeach ?>
    </select>
</div>
			<?php
	$loggedInUserId = $user->id;
					?>
<!-- New form group for selecting manager -->
<div class="form-group">
    <label for="formClient-Manager">Select Employee Manager</label>
   <select name="manager" id="formClient-Manager" class="form-control"<?php if ($loggedInUserId == 1) echo ''; else echo ' required'; ?>>

        <option value="">Select Employee Manager</option>
        <?php foreach ($allEmployees as $employee): ?>
            <?php
                $fullName = $employee->first_name . ' ' . $employee->last_name;
                // Check if the current employee is the logged-in user
                $isCurrentUser = ($employee->id == $loggedInUserId);
            ?>
            <?php if (!$isCurrentUser): ?>
                <option value="<?php echo $employee->id ?>" <?php echo ($fullName == $user->manager_full_name) ? 'selected' : ''; ?>>
                    <?php echo $fullName ?>
                </option>
            <?php endif; ?>
        <?php endforeach ?>
    </select>
</div>
<!-- End form group for selecting manager -->

        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->
   

    </div>
  </div>

  <!-- Default card -->
  <div class="card">
    <div class="card-footer">
      <div class="row">
        <div class="col"><a href="<?php echo base_url() ?>/users/view/<?php echo $user->id ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger"><?php echo lang('App.cancel') ?></a></div>
        <div class="col text-right"><button type="submit" class="btn btn-flat btn-primary"><?php echo lang('App.submit') ?></button></div>
      </div>
    </div>
    <!-- /.card-footer-->

  </div>
  <!-- /.card -->
<?php echo form_close(); ?>

</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('js') ?>


<script>
  $(document).ready(function() {
    $('.form-validate').validate();

      //Initialize Select2 Elements
    $('.select2').select2()

  })

  function previewImage(input, previewDom) {

    if (input.files && input.files[0]) {

      $(previewDom).show();

      var reader = new FileReader();

      reader.onload = function(e) {
        $(previewDom).find('img').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }else{
      $(previewDom).hide();
    }

  }

</script>

<?=  $this->endSection() ?>

