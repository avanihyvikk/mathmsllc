<!-- app/Views/create_job.php -->
<?= $this->extend('layouts/main') ?> <!-- Assuming you have a main layout -->

<?= $this->section('content') ?>
<h2>Create Job Listing</h2>
<form action="<?= base_url('/job/create') ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Job Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <!-- Assuming you fetch $locations and $roles in the controller and pass them to the view -->
    <div class="mb-3">
        <label for="location_id" class="form-label">Location</label>
        <select class="form-select" id="location_id" name="location_id" required>
            <?php foreach ($locations as $location): ?>
                <option value="<?= $location['id'] ?>"><?= $location['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="interview_rounds" class="form-label">Interview Rounds (Select multiple)</label>
        <select multiple class="form-select" id="interview_rounds" name="interview_rounds[]">
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>"><?= $role['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <!-- Add other fields similarly -->
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?= $this->section('content') ?>
