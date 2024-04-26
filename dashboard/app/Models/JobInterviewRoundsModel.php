<?php

namespace App\Models;

use CodeIgniter\Model;

class JobInterviewRoundsModel extends Model
{
    protected $table = 'job_interview_rounds'; // Adjust if you have a different table name
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['job_id', 'role_id'];

    protected $returnType = 'array';

    // Function to insert interview rounds data for a job
    public function insertInterviewRounds($data) {
        // Assuming $data is an array of arrays, each containing 'job_id' and 'role_id'
        foreach ($data as $entry) {
            $this->insert($entry);
        }
    }
}
