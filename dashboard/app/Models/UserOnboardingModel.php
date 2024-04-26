<?php

namespace App\Models;

use CodeIgniter\Model;

class UserOnboardingModel extends Model
{
    protected $table = 'user_onboarding_stages';
	protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'stage_id', 'completed_on', 'completed_by'];
	
public function getOnboardingStagesWithNames($userId) {
    return $this->select('user_onboarding_stages.*, onboarding_stages.stage_name')
                ->join('onboarding_stages', 'user_onboarding_stages.stage_id = onboarding_stages.id', 'left')
                ->where('user_onboarding_stages.user_id', $userId)
                ->orderBy('onboarding_stages.stage_order', 'ASC')
                ->findAll();
}
}