<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Location</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Blank Page</li>
                </ol>
            </div>
        </div>
        <!-- Add button to go back to the list of locations -->
        <div class="row mb-2">
            <div class="col-sm-12">

				<div class="text-right">
                    <a href="<?= base_url('location') ?>" class="btn btn-success">Back to Location List</a>
                </div>

            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="container">







            <!-- Default card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Leave Type</h3>
                </div>
                <div class="card-body">

    <form id="leaveTypeForm" action="<?= base_url('leaves/storeLeaveType') ?>" method="post">
	<?= csrf_field() ?>
        <div class="form-section" id="section-1">
            <h3>Leave Type Details</h3>
            <div class="form-group">
                <label for="type_name">Leave Name:</label>
                <input type="text" class="form-control" id="type_name" name="type_name" required>
            </div>
            <div class="form-group">
                <label for="effective_after">Starts after (effective after):</label>
                <input type="number" class="form-control" id="effective_after" name="effective_after" required>
                <select class="form-control" id="effective_type" name="effective_type">
                    <option value="days">Days</option>
                    <option value="months">Months</option>
                    <option value="years">Years</option>
                </select>
            </div>
            <div class="form-group">
                <label for="accumulates_after">Starts accumulation (accumulates after):</label>
                <input type="number" class="form-control" id="accumulates_after" name="accumulates_after" required>
                <select class="form-control" id="accumulation_type" name="accumulation_type">
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
            <div class="form-group">
                <label for="expires_after">Expires after:</label>
                <input type="number" class="form-control" id="expires_after" name="expires_after" required>
                <select class="form-control" id="leave_expires_type" name="leave_expires_type">
                    <option value="days">Days</option>
                    <option value="months">Months</option>
                    <option value="years">Years</option>
                </select>
            </div>
            <div class="form-group">
                <label for="unused_leave">What happens to unused leave?</label>
                <select class="form-control" id="unused_leave" name="unused_leave">
                    <option value="paid">Paid out</option>
                    <option value="expires">Expires</option>
                    <option value="rollover">Rollover</option>
                </select>
            </div>
            <div class="form-group">
                <label for="expiration">When does leave expire?</label>
                <select class="form-control" id="expiration" name="expiration">
                    <option value="anniversary">Anniversary</option>
                    <option value="1st of year">1st of Year</option>
                </select>
            </div>
		 <button type="button" class="btn btn-primary next-btn">Next</button>	
        </div>

         <!-- Part 2: Leave Approvals (Dynamically managed) -->
        <div class="form-section" id="section-2" style="display: none;">
            <h3>Leave Approvals</h3>
            <div id="approvalsContainer">
                <!-- Approval roles will be added here dynamically -->
            </div>
		<button type="button" class="btn btn-secondary prev-btn">Previous</button>
        <button type="button" class="btn btn-primary next-btn">Next</button>	
        </div>

        <!-- Part 3: Leave Steps (Dynamically managed) -->
        <div class="form-section" id="section-3" style="display: none;">
            <h3>Leave Steps</h3>
            <div id="stepsContainer">
                <!-- Leave steps will be added here dynamically -->
            </div>
		<button type="button" class="btn btn-secondary prev-btn">Previous</button>
         <button type="submit" class="btn btn-success">Submit</button>	
        </div>

    </form>   
					
					
					
					
					
					
					
					
					
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sections = document.querySelectorAll('.form-section');
    let currentSectionIndex = 0;
    
    const showSection = (index) => {
        sections.forEach((section, i) => {
            section.style.display = i === index ? 'block' : 'none';
        });
    };
    
    document.querySelectorAll('.next-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentSectionIndex < sections.length - 1) {
                currentSectionIndex++;
                showSection(currentSectionIndex);
            }
        });
    });
    
    document.querySelectorAll('.prev-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentSectionIndex > 0) {
                currentSectionIndex--;
                showSection(currentSectionIndex);
            }
        });
    });
    
    showSection(currentSectionIndex); // Initially show the first section
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var roles = <?php echo json_encode($roles); ?>;

    roles.forEach(function(role) {
        addApprovalRow(role);
    });

    function addApprovalRow(role) {
        const container = document.getElementById('approvalsContainer');
        const row = document.createElement('div');
        row.classList.add('form-group', 'approval-row');
        row.innerHTML = `
            <label>${role.title}</label>
            <select class="form-control role-can-use" name="approvals[${role.id}][can_use]">
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>
            <select class="form-control approvals-needed hidden" name="approvals[${role.id}][approvals_needed]">
                <option value="">How many approvals?</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <div class="approver-roles hidden"></div>
        `;
        container.appendChild(row);

        row.querySelector('.role-can-use').addEventListener('change', function() {
            const approvalsNeeded = row.querySelector('.approvals-needed');
            const approverRolesDiv = row.querySelector('.approver-roles');
            if (this.value === 'yes') {
                approvalsNeeded.classList.remove('hidden');
                addLeaveStepSection(role.id); // Call function to add leave step section for this role
            } else {
                approvalsNeeded.classList.add('hidden');
                approverRolesDiv.innerHTML = ''; // Clear approver roles
                removeLeaveStepSection(role.id); // Call function to remove leave step section if exists
            }
        });

        row.querySelector('.approvals-needed').addEventListener('change', function() {
            const approverRolesDiv = row.querySelector('.approver-roles');
            approverRolesDiv.innerHTML = ''; // Clear previous roles
            for (let i = 1; i <= this.value; i++) {
                addApproverRoleSelect(approverRolesDiv, i, role.id);
            }
        });
    }

    function addApproverRoleSelect(container, level, roleId) {
        const select = document.createElement('select');
        select.classList.add('form-control', 'my-2');
        select.name = `approvals[${roleId}][approver_roles][${level}]`;
        const defaultOption = new Option(`Select Level ${level} Approval`, '');
        select.appendChild(defaultOption);
        roles.forEach(function(role) {
            const option = new Option(role.title, role.id);
            select.options.add(option);
        });
        container.appendChild(select);
        container.classList.remove('hidden');
    }

    function addLeaveStepSection(roleId) {
        let stepsContainer = document.getElementById(`stepsContainerForRole${roleId}`);
        if (!stepsContainer) {
            stepsContainer = document.createElement('div');
            stepsContainer.id = `stepsContainerForRole${roleId}`;
            stepsContainer.classList.add('leave-steps-container');
            stepsContainer.innerHTML = `<h4>Leave Steps for ${roles.find(role => role.id === roleId).title}</h4>`;
            document.getElementById('section-3').appendChild(stepsContainer);
            
            // Initial Leave Step for the Role
            addLeaveStep(roleId, stepsContainer);
            
            const addStepBtn = document.createElement('button');
            addStepBtn.type = 'button';
            addStepBtn.textContent = 'Add Leave Step';
            addStepBtn.classList.add('btn', 'btn-info', 'add-step-btn');
            addStepBtn.onclick = () => addLeaveStep(roleId, stepsContainer);
            stepsContainer.appendChild(addStepBtn);
        }
    }

    function removeLeaveStepSection(roleId) {
        const stepsContainer = document.getElementById(`stepsContainerForRole${roleId}`);
        if (stepsContainer) {
            document.getElementById('section-3').removeChild(stepsContainer);
        }
    }

    function addLeaveStep(roleId, container) {
        const newStepDiv = document.createElement('div');
        newStepDiv.classList.add('leave-step');
        newStepDiv.innerHTML = `
            <div class="form-group">
                <label>Year:</label>
                <input type="number" class="form-control" name="steps[${roleId}][years][]" placeholder="Enter year">
            </div>
            <div class="form-group">
                <label>Leave Days:</label>
                <input type="number" class="form-control" name="steps[${roleId}][leave_days][]" placeholder="Enter number of leave days">
            </div>
        `;
        const removeStepBtn = document.createElement('button');
        removeStepBtn.type = 'button';
        removeStepBtn.textContent = 'Remove Leave Step';
        removeStepBtn.classList.add('btn', 'btn-danger', 'remove-step');
        removeStepBtn.onclick = () => container.removeChild(newStepDiv);
        newStepDiv.appendChild(removeStepBtn);

        container.insertBefore(newStepDiv, container.querySelector('.add-step-btn'));
    }
});
</script>

<?= $this->endSection() ?>


