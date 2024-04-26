<?php

namespace App\Models;

use CodeIgniter\Model;

class OnboardingStageModel extends Model
	
{
    protected $table = 'onboarding_stages';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['stage_name', 'stage_order', 'is_active'];

    protected $useTimestamps = false;
}