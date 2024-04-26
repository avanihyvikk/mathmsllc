<?php

namespace App\Controllers;
use App\Controllers\AdminBaseController;
use App\Models\JobsModel;
use App\Models\JobInterviewRoundsModel;
use CodeIgniter\Controller;

class JobController extends AdminBaseController
{
    public function index()
    {
		public $title = 'jobs';
    public $menu = 'jobs';
        helper(['form']);
        $data = []; // Prepare data for the view, such as locations and roles

        // Assume you have models or methods to fetch locations and roles:
        $data['locations'] = $locationModel->findAll();
        $data['roles'] = $roleModel->findAll();

        return view('admin/jobs/create_job', $data);
    }

    public function create()
    {
        helper(['form', 'url']);

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            // Define other validation rules
        ];

        if ($this->validate($rules)) {
            $jobsModel = new JobsModel();
            $jobInterviewRoundsModel = new JobInterviewRoundsModel();

            // Capture form data
            $formData = $this->request->getPost();
            $jobId = $jobsModel->insertJob($formData);

            // Process interview rounds if any
            if (!empty($formData['interview_rounds'])) {
                $interviewRoundsData = [];
                foreach ($formData['interview_rounds'] as $role_id) {
                    $interviewRoundsData[] = ['job_id' => $jobId, 'role_id' => $role_id];
                }
                $jobInterviewRoundsModel->insertInterviewRounds($interviewRoundsData);
            }

            // Redirect or show success message
            return redirect()->to('/')->with('message', 'Job created successfully');
        } else {
            // If validation fails, reload the form with errors and old input values
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}
