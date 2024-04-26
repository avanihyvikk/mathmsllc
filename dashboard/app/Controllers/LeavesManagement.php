<?php

namespace App\Controllers;

use App\Models\LeavesModel;
use CodeIgniter\Controller;

class LeaveManagement extends Controller
{
    protected $leavesModel;

    public function __construct()
    {
        // Load the model
        $this->leavesModel = new LeavesModel();
    }

    public function addLeaveTypeForm()
    {
        // Load the form view
        return view('admin/leave/add_leave_type');
    }

    public function storeLeaveType()
    {
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
            // Add validation rules for your dynamic fields
        ]);

        if (!$input) {
            // Validation failed
            return view('leave/add_leave_type', [
                'validation' => $this->validator
            ]);
        } else {
            // Validation passed
            $typeData = [
                // Capture form data for leave_types
            ];

            $approvalData = $this->request->getPost('approvals');
            $stepData = $this->request->getPost('steps');

            if ($this->leavesModel->createLeaveProcess($typeData, $approvalData, $stepData)) {
                // Process successful
                return redirect()->to('/successPage');
            } else {
                // Process failed
                return redirect()->back()->withInput();
            }
        }
    }
}
