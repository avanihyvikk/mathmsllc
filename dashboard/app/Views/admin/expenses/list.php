<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo lang('App.expenses_expenses') ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url('/') ?>"><?php echo lang('App.home') ?></a></li>
          <li class="breadcrumb-item active"><?php echo lang('App.expenses_expenses') ?></li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

    <!-- Main content -->
<div class="d-flex justify-content-center">
    <!-- Display the alert message -->
    <?php if (session()->has('success')) : ?>
        <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert" style="max-width: 50%;">
            <?= session('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
	<?php if (session()->has('error')) : ?>
        <div id="successAlert" class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 50%;">
            <?= session('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
</div>


    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3"><?php echo lang('App.expenses_expenses') ?></h3>
                <?php if ( hasPermissions('add_expense') ): ?>
				  <div class="ml-auto p-2">
                    
                      <a href="<?php echo url('expenses/add') ?>" class="btn btn-primary btn-sm"><span class="pr-1"><i class="fa fa-plus"></i></span> <?php echo lang('App.expenses_new_expense') ?></a>
                    
                </div>
				  <?php endif ?>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover table-striped">
                  <thead>
                  <tr>
                    <th><?php echo lang('App.expenses_id') ?></th>
                    <th><?php echo lang('App.expenses_item_name') ?></th>
                    <th><?php echo lang('App.expenses_price') ?></th>
                    <th><?php echo lang('App.expenses_employee_name') ?></th>
                    <th><?php echo lang('App.expenses_purchase_from') ?></th>
                    <th><?php echo lang('App.expenses_purchase_date') ?></th>
					  
                    <th><?php echo lang('App.expenses_status') ?></th>
                    <th><?php echo lang('App.expenses_payment_method') ?></th>
					<th><?php echo lang('App.expenses_bill') ?></th>
                    <th><?php echo lang('App.expenses_actions') ?></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($expenses as $expense): ?>
                    <tr>
                      <td width="60"><?php echo $expense['id'] ?></td>
                      <td><?php echo $expense['item_name'] ?></td>
                      <td>$<?php echo $expense['price'] ?></td>
                      <td><?php echo $expense['first_name'] . ' ' . $expense['last_name'] ?></td>
                      <td><?php echo $expense['purchased_from'] ?></td>
                      <td><?php echo date(setting('date_format'), strtotime($expense['purchase_date'])); ?></td>
<?php if (hasPermissions('update_expense_status')): ?>
    <?php if ($expense['status'] == 'Pending' || hasPermissions('edit_after_pending')): ?>
        <td>
            <div class="btn-group">
                <button type="button" class="btn btn-default"><?php echo $expense['status'] ?></button>
                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu">
                    <form action="<?php echo base_url('expenses/updateStatus/'.$expense['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <?php foreach ($expenseStatuses as $status): ?>
                            <button class="dropdown-item" type="submit" name="status" value="<?php echo $status['name'] ?>"><?php echo $status['name'] ?></button>
                        <?php endforeach ?>
                    </form>
                </div>
            </div>
        </td>
    <?php else: ?>
        <td><?php echo $expense['status'] ?></td>
    <?php endif; ?>
<?php else: ?>
    <td><?php echo $expense['status'] ?></td>
<?php endif; ?>

                      <td><?php echo $expense['payment_method'] ?></td>
						
						
						
						
						
						<td>							
							<?php if (!empty($expense['bill'])): ?>
                        <div class="form-group">
                           <a href="<?= base_url('uploads/expenses/' . esc($expense['bill'])); ?>" target="_blank" class="document-link"><i class="fas fa-save"></i> View/Download </a>
                        </div>
                        <?php endif; ?>
</td>
						
<td>
    <div class="dropdown">
        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Actions
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<?php if (hasPermissions('edit_expense')): ?>
    <?php if ($expense['status'] != 'Pending' && hasPermissions('edit_after_pending')): ?>
        <a class="dropdown-item" href="<?= base_url('expenses/edit/'.$expense['id']) ?>"><i class="fas fa-edit"></i> <?= lang('App.expenses_edit_expense') ?></a>
    <?php elseif ($expense['status'] == 'Pending'): ?>
        <a class="dropdown-item" href="<?= base_url('expenses/edit/'.$expense['id']) ?>"><i class="fas fa-edit"></i> <?= lang('App.expenses_edit_expense') ?></a>
    <?php endif; ?>
<?php endif; ?>
            
            <?php if (hasPermissions('view_expense')): ?>
                <a class="dropdown-item" href="<?= base_url('expenses/view/'.$expense['id']) ?>" target="_blank" ><i class="fa fa-eye"></i> <?= lang('App.expenses_view_expense') ?></a>
            <?php endif; ?>
            
            <?php if (hasPermissions('delete_expense')): ?>
    <?php if ($expense['status'] == 'Pending' || hasPermissions('delete_after_pending')): ?>
        <a class="dropdown-item" href="<?= base_url('expenses/delete/'.$expense['id']) ?>"><i class="fa fa-trash"></i> <?= lang('App.expenses_delete_expense') ?></a>
    <?php endif; ?>
<?php endif; ?>

        </div>
    </div>
</td>  </tr>
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

<!-- JavaScript to automatically dismiss the alert after 10 seconds -->
<script>
    $(document).ready(function() {
        // Automatically close the alert after 10 seconds
        setTimeout(function() {
            $('#successAlert').alert('close');
        }, 10000);
    });
</script>
<script src="https://kit.fontawesome.com/1d6f965e68.js" crossorigin="anonymous"></script>
<?=  $this->endSection() ?>
