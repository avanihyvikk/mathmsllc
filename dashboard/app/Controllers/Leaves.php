<?php

namespace App\Controllers;
use App\Controllers\AdminBaseController;
use App\Models\LeavesModel;
use CodeIgniter\Controller;

class Leaves extends AdminBaseController
{
	public $title = 'Leave Management';
    public $menu = 'leave';
    protected $leavesModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->leavesModel = new LeavesModel();
    }

    public function index()
    {
		$roleModel = new \App\Models\RoleModel(); // Adjust with your actual model
		$data['roles'] = $roleModel->findAll();
        // Load the form view
        return view('admin/leave/add_leave_type', $data);
    }

   public function storeLeaveType()
{
	log_message('debug', print_r($this->request->getPost(), true));
    helper(['form', 'url']);

    $input = $this->validate([
        'type_name' => 'required|string',
        'effective_after' => 'required|numeric',
        'effective_type' => 'required|string',
        'accumulates_after' => 'required|numeric',
        'accumulation_type' => 'required|string',
        'expires_after' => 'required|numeric',
        'leave_expires_type' => 'required|string',
        'unused_leave' => 'required|string',
        'expiration' => 'required|string',
        // Ensure you validate dynamic fields as needed
    ]);

    if (!$input) {
        // Validation failed
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    } else {
        // Validation passed
        $typeData = [
            'type_name' => $this->request->getPost('type_name'),
            'effective_after' => $this->request->getPost('effective_after'),
            'effective_type' => $this->request->getPost('effective_type'),
            'accumulates_after' => $this->request->getPost('accumulates_after'),
            'accumulation_type' => $this->request->getPost('accumulation_type'),
            'expires_after' => $this->request->getPost('expires_after'),
            'leave_expires_type' => $this->request->getPost('leave_expires_type'),
            'unused_leave' => $this->request->getPost('unused_leave'),
            'expiration' => $this->request->getPost('expiration'),
        ];

        $leaveTypeId = $this->leavesModel->addLeaveType($typeData);

        if ($leaveTypeId) {
            $approvalData = $this->request->getPost('approvals');
            $stepData = $this->request->getPost('steps');

            // Insert approval data
            foreach ($approvalData as $role_id => $approval) {
                if ($approval['can_use'] === 'yes') {
                    $approvalEntry = [
                        'leave_type_id' => $leaveTypeId,
                        'role_id' => $role_id,
                        'approvals_needed' => $approval['approvals_needed']
                    ];
					foreach ($approvalData as $approval) {
    if ($approval['can_use'] === 'yes') {
        // Remove 'can_use' and any other non-column data from $approval before insertion
        unset($approval['can_use']);

        // Now $approval only contains data corresponding to actual columns in your table
        $this->leavesModel->addLeaveApproval($approval);
    }
}
                    $this->leavesModel->addLeaveApproval($approval);

                    // Handle approver roles if provided
                    if (isset($approval['approver_roles'])) {
                        foreach ($approval['approver_roles'] as $level => $approver_role_id) {
                            $approverRoleEntry = [
                                'leave_type_id' => $leaveTypeId,
                                'role_id' => $role_id,
                                'approver_role_id' => $approver_role_id,
                                'level' => $level
                            ];
                            // Assuming a method exists for inserting individual approver roles
                            $this->leavesModel->insertApproverRole($approverRoleEntry);
                        }
                    }
                }
            }

            // Insert step data
            foreach ($stepData as $role_id => $steps) {
                foreach ($steps['years'] as $index => $year) {
                    $stepEntry = [
                        'leave_type_id' => $leaveTypeId,
                        'role_id' => $role_id,
                        'years' => $year,
                        'leave_days' => $steps['leave_days'][$index]
                    ];
                    $this->leavesModel->insertLeaveStep($stepEntry);
                }
            }

            return redirect()->to('/successPage'); // Adjust as necessary
        } else {
            // Insert failed
            return redirect()->back()->withInput()->with('error', 'Failed to add leave type.');
        }
    }
}
}
