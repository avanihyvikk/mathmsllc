<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<style>
:root {
--table-header-bg: #f0f0f0;
--table-border-color: #ccc;
--opacity-date: 0.65;
}
.custom-table-header {
    background-color: var(--table-header-bg);
}
th, td {
    text-align: center;
    padding: 8px; /* Increased padding for better readability */
}
.header-cell {
    border-bottom: 2px solid var(--table-border-color);
    background-color: var(--table-header-bg);
    font-weight: bold;
    text-align: left;
}
.date {
    opacity: var(--opacity-date);
}
/* Added for better interactivity */
.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">

<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Blank Page</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Employee Schedule</li>
      </ol>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content"> 
  
<!-- Start Modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Add Shift for <span id="employeeName"></span> on <span id="shiftDate"></span></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="shiftForm">
                    <!-- Hidden input fields for employee ID and date -->
                    <input type="hidden" id="employeeId" name="employeeId" value="">
                    <input type="hidden" id="shiftDate" name="shiftDate" value="">

                    <div class="form-group">
                        <label for="startTime">Start Time</label>
                        <input type="time" class="form-control" id="startTime" name="startTime" required>
                    </div>
                    <div class="form-group">
                        <label for="endTime">End Time</label>
                        <input type="time" class="form-control" id="endTime" name="endTime" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveShift">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal -->
  
  <!-- /.row -->
  <div class="row">
    <div class="col-0"> </div>
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Responsive Hover Table</h3>
          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
       <table class="table table-hover text-nowrap">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Hours</th>
                <?php foreach ($dates as $date): ?>
                    <th><?= $date['day'] ?><br><?= $date['date'] ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['first_name'] . ' ' . $user['last_name'] ?></td>
                    <td>// Total hours logic here</td>
                    <?php foreach ($dates as $date): ?>
                        <td>
                            <?php if (isset($schedules[$user['id']][$date['date']])): ?>
                                <?php $schedule = $schedules[$user['id']][$date['date']]; ?>
                                <a class="btn btn-app" data-toggle="modal" data-target="#editScheduleModal-<?= $schedule['schedule_id'] ?>" style="width: 120px; background-color: #586FF6; color: white;">
                                    Start: <?= $schedule['start_time'] ?><br>
                                    End: <?= $schedule['end_time'] ?>
                                    <!-- Hidden values for total_time & schedule_id -->
                                </a>
                                <!-- Edit Schedule Modal -->
                                <!-- Modal HTML here -->
                            <?php else: ?>
                                <a class="btn btn-app" data-toggle="modal" data-target="#addScheduleModal-<?= $user['id'] . '-' . $date['date'] ?>" style="width: 120px;">
                                    <i class="fa fa-plus-circle text-primary" style="font-size: 17px;"></i>
                                </a>
                                <!-- Add Schedule Modal -->
                                <!-- Modal HTML here -->
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        </div>
        <!-- /.card-body --> 
      </div>
      <!-- /.card --> 
    </div>
    <div class="col-0"> </div>
  </div>
</section>
<!-- /.content -->
<script>
    var csrfToken = "<?= csrf_hash() ?>";
</script>

<?=  $this->endSection() ?>