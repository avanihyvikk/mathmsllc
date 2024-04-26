<?php

namespace App\Models;

use CodeIgniter\Model;

class JobsModel extends Model
{
    protected $table = 'jobs'; // Database table name
    protected $primaryKey = 'id'; // Primary key of the table

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'title', 'location_id', 'start_date', 'end_date', 'total_openings',
        'status', 'hiring_manager_id', 'job_type', 'experience',
        'salary_display_type', 'min_pay', 'max_pay', 'rate',
        'exact_amount', 'job_description', 'disclose_salary',
        'resume_required', 'dob_required'
    ];

    protected $returnType = 'array';

    // Use this function to insert a new job and get its ID
    public function insertJob($data) {
        $this->insert($data);
        return $this->getInsertID();
    }
}