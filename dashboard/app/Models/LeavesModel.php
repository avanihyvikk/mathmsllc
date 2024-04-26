<?php

namespace App\Models;

use CodeIgniter\Model;

class LeavesModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function addLeaveType($data)
    {
        $builder = $this->db->table('leave_types');
        $builder->insert($data);
        return $this->db->insertID(); // Return the ID of the inserted leave type
    }

    public function addLeaveApproval($data)
    {
        $builder = $this->db->table('leave_approvals');
        $builder->insert($data);
        return $this->db->insertID(); // Optionally, you can handle IDs for approvals if needed
    }

    public function addLeaveStep($data)
    {
        $builder = $this->db->table('leave_steps');
        $builder->insert($data);
        return $this->db->insertID(); // Optionally, you can handle IDs for steps if needed
    }

    public function createLeaveProcess($typeData, $approvalData, $stepData)
    {
        $this->db->transStart();

        $leaveTypeId = $this->addLeaveType($typeData); // Directly use the returned ID

        foreach ($approvalData as $approval) {
            if ($approval['can_use'] == 'yes') { // Ensure only 'yes' approvals are processed
                $approval['leave_type_id'] = $leaveTypeId;
                unset($approval['can_use']); // Remove 'can_use' key since it's not part of the table
                $this->addLeaveApproval($approval);
                
                // If approver_roles exist and need separate handling, do so here
            }
        }

        foreach ($stepData as $roleId => $steps) {
            foreach ($steps['years'] as $index => $year) {
                $step = [
                    'leave_type_id' => $leaveTypeId,
                    'role_id' => $roleId, // Make sure role_id is handled if necessary
                    'years' => $year,
                    'leave_days' => $steps['leave_days'][$index]
                ];
                $this->addLeaveStep($step);
            }
        }

        $this->db->transComplete();

        // Check the transaction status
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return false; // Transaction failed
        } else {
            $this->db->transCommit();
            return true; // Transaction succeeded
        }
    }
}