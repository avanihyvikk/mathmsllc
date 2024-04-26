<?php
namespace App\Controllers;

use App\Controllers\AdminBaseController;
use App\Models\SettingModel;
use App\Models\EmailTemplateModel;
use App\Models\OnboardingStageModel;


class Settings extends AdminBaseController
{

    public $title = 'Settings';
    public $menu = 'settings';

	public function index()
	{
		$this->general();
	}

	public function general()
	{
		$this->permissionCheck('general_settings');
		
		$this->updatePageData([ 'submenu' => 'general' ]);

		return view('admin/settings/general');
	}
	

	public function generalUpdate()
	{

		$this->permissionCheck('general_settings');

		postAllowed();

        $setting = new SettingModel();

		$setting->updateByKey('date_format', post('date_format'));
		$setting->updateByKey('datetime_format', post('datetime_format'));
		$setting->updateByKey('google_recaptcha_enabled', post('google_recaptcha_enabled') == 'ok' ? 1 : 0 );
		$setting->updateByKey('google_recaptcha_sitekey', post('google_recaptcha_sitekey'));
		$setting->updateByKey('google_recaptcha_secretkey', post('google_recaptcha_secretkey'));
		$setting->updateByKey('timezone', post('timezone'));
		$setting->updateByKey('default_lang', post('default_lang'));
        // user shift schedule task start
        $setting->updateByKey('week_starts_on', post('week_starts_on'));
        $setting->updateByKey('event_time_format', post('event_time_format'));
        // user shift schedule task end
		model('App\Models\ActivityLogModel')->add("Company Settings Updated by User: #".logged('id'));
        
        return redirect()->to('settings/general')->with('notifySuccess', 'Settings has been Updated Successfully');
	}

	public function company()
	{
		$this->permissionCheck('company_settings');

		$this->updatePageData([ 'submenu' => 'company' ]);

		return view('admin/settings/company');
	}

	public function companyUpdate()
	{

		$this->permissionCheck('company_settings');

		postAllowed();

		$setting = new SettingModel();
		
		$setting->updateByKey('company_name', post('company_name'));
		$setting->updateByKey('company_email', post('company_email'));

		model('App\Models\ActivityLogModel')->add("Company Settings Updated by User: #".logged('id'));
		
		redirect('settings/company');

        return redirect()->to('settings/company')->with('notifySuccess', ' Settings has been Updated Successfully');
	}

	public function login_theme()
	{
		$this->permissionCheck('login_theme');
		$this->updatePageData([ 'submenu' => 'login_theme' ]);
		return view('admin/settings/login_theme', $this->page_data);
	}

	public function loginthemeUpdate()
	{

		$this->permissionCheck('login_theme');

		postAllowed();
		
		(new SettingModel)->updateByKey('login_theme', post('login_theme'));

		if (!empty($_FILES['image']['name'])) {

			$path = $_FILES['image']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$this->uploadlib->initialize([
				'file_name' => 'login-bg.'.$ext
			]);
			$image = $this->uploadlib->uploadImage('image');

			if($image['status']){
				(new SettingModel)->updateByKey('bg_img_type', $ext);
			}

            model('App\Models\ActivityLogModel')->add("Login Theme Updated by User: #".logged('id'));

		}
            
        return redirect()->to('settings/company')->with('notifySuccess', 'Settings has been Updated Successfully');
	}

	public function email_templates()
	{
		$this->permissionCheck('email_templates');
		$this->updatePageData([ 'submenu' => 'email_templates' ]);
		return view('admin/settings/email_templates/list');
	}

	public function edit_email_templates($id)
	{
		$this->permissionCheck('email_templates');
		$this->updatePageData([ 'submenu' => 'email_templates' ]);
		$template = (new EmailTemplateModel)->getById($id);
		return view('admin/settings/email_templates/edit', compact('template'));
	}

	public function update_email_templates($id)
	{

		$this->permissionCheck('login_theme');

		postAllowed();
		
		(new EmailTemplateModel)->update($id, [
			// 'code'	=>	post('code'),
			'name'	=>	post('name'),
			'data'	=>	post('data'),
		]);

		model('App\Models\ActivityLogModel')->add("Email Template Updated by User: #".logged('id'));

        return redirect()->to('settings/email_templates')->with('notifySuccess', 'Email Template has been Updated Successfully');
	}
	public function onboarding()
{
	$this->updatePageData([ 'submenu' => 'onboarding' ]);
	$this->permissionCheck('view_onboarding_steps');	
    $onboardingStageModel = new OnboardingStageModel();
    $data['stages'] = $onboardingStageModel->orderBy('stage_order', 'ASC')->findAll();

    return view('admin/settings/onboarding_stages', $data);
}
	 public function updateStages()
{
		 $this->permissionCheck('edit_onboarding_steps');
		 var_dump($this->request->getPost('stages'));
		  log_message('debug', 'Form data: ' . print_r($this->request->getPost('stages'), true));
    $onboardingStageModel = new OnboardingStageModel();

    // Iterate through the submitted stages
    foreach ($this->request->getPost('stages') as $stageId => $stageData) {
        // Update each stage in the database
        if (!$onboardingStageModel->update($stageId, $stageData)) {
    // Handle error (e.g., log error, show error message)
    die("Error updating stage with ID: $stageId");
}
    }

    // Redirect with success message
    return redirect()->to('settings/onboarding')->with('notifySuccess', 'Onboarding Steps Updated.');
}
	public function addStage()
{
	$this->permissionCheck('add_onboarding_steps');
    // Check for POST request
    if ($this->request->getMethod() === 'post') {
        // Get the posted data
        $newStageName = $this->request->getPost('new_stage_name');
        $newStageOrder = $this->request->getPost('new_stage_order');
        $newStageActive = $this->request->getPost('new_stage_active');

        // Validation can be added here if needed

        // Insert the new stage into the database
        $onboardingStageModel = new OnboardingStageModel();
        $onboardingStageModel->insert([
            'stage_name' => $newStageName,
            'stage_order' => $newStageOrder,
            'is_active' => 1, // Always set to 1 for "Yes"
        ]);

        // Redirect back to the settings page with a success message
        return redirect()->to('settings/onboarding')->with('notifySuccess', 'New stage added successfully.');
    } else {
        // If the request method is not POST, redirect back to the settings page
        return redirect()->to('settings/onboarding')->with('notifyError', 'Invalid request method.');
    }
}


}

/* End of file Settings.php */
/* Location: ./application/controllers/Settings.php */