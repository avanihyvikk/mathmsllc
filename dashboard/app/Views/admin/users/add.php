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
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo url('/users') ?>"><?php echo lang('App.users') ?></a></li>
                    <li class="breadcrumb-item active"><?php echo lang('App.new_user') ?></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <?php echo form_open_multipart('users/save', ['class' => 'form-validate', 'autocomplete' => 'off']); ?>
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
                        <input type="text" class="form-control" name="first_name" id="formClient-first_name" required placeholder="First Name"/>
                    </div>
                    <div class="form-group">
                        <label for="formClient-last_name">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="formClient-last_name" required placeholder="Last Name"/>
                    </div>
                    <div class="form-group">
                        <label for="formClient-Contact"><?php echo lang('App.user_contact') ?></label>
                        <input type="text" class="form-control" name="phone" id="formClient-Contact" placeholder="<?php echo lang('App.user_enter_contact') ?>" />
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
                        <label for="formClient-Email"><?php echo lang('App.user_email') ?></label>
                        <input type="email" class="form-control" name="email" data-rule-remote="<?php echo url('users/check') ?>" data-msg-remote="<?php echo lang('App.user_email_exists') ?>" id="formClient-Email" required placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="formClient-Username"><?php echo lang('App.user_username') ?></label>
                        <input type="text" class="form-control" data-rule-remote="<?php echo url('users/check') ?>" data-msg-remote="<?php echo lang('App.user_username_take') ?>" name="username" id="formClient-Username" required placeholder="<?php echo lang('App.user_enter_username') ?>" />
                    </div>
                    <div class="form-group">
                        <label for="formClient-Password"><?php echo lang('App.user_password') ?></label>
                        <input type="password" class="form-control" name="password" minlength="6" id="formClient-Password" required placeholder="<?php echo lang('App.user_password') ?>">
                    </div>
                    <div class="form-group">
                        <label for="formClient-ConfirmPassword"><?php echo lang('App.user_password_confirm') ?></label>
                        <input type="password" class="form-control" name="confirm_password" equalTo="#formClient-Password" id="formClient-ConfirmPassword" required placeholder="<?php echo lang('App.user_password_confirm') ?>">
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
                        <textarea type="text" class="form-control" name="address" id="formClient-Address" placeholder="<?php echo lang('App.user_enter_address') ?>" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="formClient-Role"><?php echo lang('App.user_role') ?></label>
                        <select name="role" id="formClient-Role" class="form-control" required>
                            <option value=""><?php echo lang('App.user_select_role') ?></option>
                            <?php foreach (model('App\Models\RoleModel')->findAll() as $row): ?>
                                <?php $sel = !empty(get('role')) && get('role')==$row->id ? 'selected' : '' ?>
                                <option value="<?php echo $row->id ?>" <?php echo $sel ?>><?php echo $row->title ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="formClient-Status"><?php echo lang('App.user_status') ?></label>
                        <select name="status" id="formClient-Status" class="form-control">
                            <option value="1" selected><?php echo lang('App.user_active') ?></option>
                            <option value="0"><?php echo lang('App.user_inactive') ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="formClient-Locations">Assigned Locations</label>
                        <select name="locations[]" id="formClient-Locations" class="form-control select2" data-dropdown-css-class="select2-red" style="width: 100%;" multiple >
                            <?php foreach ($locations as $location): ?>
                                <option value="<?php echo $location['location_id'] ?>"><?php echo $location['location_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <!-- New form group for selecting manager -->
                    <div class="form-group">
                        <label for="formClient-Manager">Select Employee Manager</label>
                        <select name="manager" id="formClient-Manager" class="form-control" required>
                            <option value="">Select Employee Manager</option>
                            <?php foreach ($allEmployees as $employee): ?>
                                <option value="<?php echo $employee->id ?>"><?php echo $employee->first_name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <!-- End form group for selecting manager -->
                </div>
            </div>
        </div>
    </div>
    <!-- Default card -->
    <div class="card">
        <div class="card-footer">
            <div class="row">
                <div class="col"><a href="<?php echo url('/users') ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger"><?php echo lang('App.cancel') ?></a></div>
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
    });

    function previewImage(input, previewDom) {
        if (input.files && input.files[0]) {
            $(previewDom).show();
            var reader = new FileReader();
            reader.onload = function(e) {
                $(previewDom).find('img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $(previewDom).hide();
        }
    }

    function createUsername(name) {
        return name.toLowerCase()
            .replace(/ /g,'_')
            .replace(/[^\w-]+/g,'');
    }
</script>

<?= $this->endSection() ?>
