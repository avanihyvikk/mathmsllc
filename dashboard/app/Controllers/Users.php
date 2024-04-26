<?php
namespace App\Controllers;

use App\Controllers\AdminBaseController;

use App\Models\UserModel;

use App\Models\LocationModel;

use App\Models\ManagerUserModel;

use App\Models\UserOnboardingModel;

use App\Models\RoleModel;

class Users extends AdminBaseController
{

    public $title = 'Users Management';
    public $menu = 'users';


public function index() {
    $this->permissionCheck('users_list');
    $this->updatePageData(['submenu' => 'view_users']);
    $userModel = new UserModel();
    
    // Use the custom model method that considers permissions
    $users = $userModel->getAllEmployeesAllowed();
    
    foreach ($users as &$user) {
        // Fetch manager details
        $managerDetails = $userModel->getManagerUser($user->id);
        $user->manager_full_name = !empty($managerDetails) ? $managerDetails[0]->first_name . ' ' . $managerDetails[0]->last_name : 'No Manager';
        
        // Fetch assigned locations for each user
        $assignedLocations = $userModel->getAssignedLocations($user->id);
        $locationNames = array_map(function ($location) {
            return $location->location_name;
        }, $assignedLocations);
        $user->assigned_locations = implode(', ', $locationNames);
    }
    
    // Retrieve active roles
    $roleModel = new RoleModel();
    $roles = $roleModel->findAllActive();
    
    return view('admin/users/list', compact('users', 'roles'));
}



	public function add()
{
    $this->permissionCheck('users_add');
    
    // Fetch list of locations
    $locations = (new LocationModel)->findAll();
	 // Fetch all employees
    $allEmployees = (new UserModel)->getAllEmployees();

    return view('admin/users/add', ['locations' => $locations, 'allEmployees' => $allEmployees]);
}

public function save()
{
    $this->permissionCheck('users_add');
    postAllowed();

    // Get the input data from the form
    $userData = [
        'first_name' => post('first_name'),
        'last_name' => post('last_name'),      
        'role' => post('role'),
       // 'name' => post('name'),
        'username' => post('username'),
        'email' => post('email'),
        'phone' => post('phone'),
        'address' => post('address'),
        'status' => (int) post('status'),
        'password' => hash("sha256", post('password')),
    ];

    // Create the user and get the user ID
    $userModel = new UserModel();
    $userId = $userModel->insert($userData);
	$onboardingStages = model('App\Models\OnboardingStageModel')->findAll();
	
	// Insert user into user_onboarding_stages table for each onboarding stage
if (!empty($onboardingStages)) {
    foreach ($onboardingStages as $stage) {
        $userOnboardingData = [
            'user_id' => $userId,
            'stage_id' => $stage['id'], // Assuming 'id' is the primary key of onboarding stages table
            // Include other fields from onboarding stages table if needed
        ];
        model('App\Models\UserOnboardingModel')->insert($userOnboardingData);
    }
}
	
	
	
	
	
    // Handle assigned locations
    $selectedLocations = $this->request->getPost('locations'); // Get the selected location IDs from the form

    // Save assigned locations
    if (!empty($selectedLocations)) {
        // Prepare data for insertion into the pivot table (assuming it's named user_location)
        $userLocationData = [];
        foreach ($selectedLocations as $locationId) {
            $userLocationData[] = [
                'user_id' => $userId,
                'location_id' => $locationId,
            ];
        }
        // Insert data into the pivot table
        $userModel->assignLocations($userLocationData);
    }

    // Handle manager relationship
    $managerId = $this->request->getPost('manager');
    if (!empty($managerId)) {
        // Insert data into the manager_user table
        $managerUserData = [
            'employee_id' => $userId,
            'manager_id' => $managerId,
        ];
        $userModel->insertManagerRelationship($managerUserData);
    }

    // Log the activity
    model('App\Models\ActivityLogModel')->add('New User $' . $userId . ' Created by User:' . logged('name'), logged('id'));

    // Redirect to the user list page with a success message
    return redirect()->to('users')->with('notifySuccess', 'New User Created Successfully');
}

	
public function edit($id)
{
    $this->permissionCheck('users_edit');
    
    $userModel = new UserModel();
    $locationModel = new LocationModel();

    // Fetch user details
    $user = $userModel->getById($id);
    
    // Fetch manager details for the user being edited
    $managerDetails = $userModel->getManagerUser($user->id);
    $user->manager_full_name = !empty($managerDetails) ? $managerDetails[0]->first_name . ' ' . $managerDetails[0]->last_name : 'No Manager';
    
    // Fetch assigned locations for the user being edited
    $assignedLocations = $userModel->getAssignedLocations($user->id);
    $locationNames = array_map(function ($location) {
        return $location->location_name;
    }, $assignedLocations);
    $user->assigned_locations = implode(', ', $locationNames);

    // Fetch list of locations
    $locations = $locationModel->findAll();

    // Fetch all employees, excluding the current user to avoid assigning an employee as their own manager
    $allEmployees = $userModel->findAll();

    return view('admin/users/edit', compact('user', 'locations', 'allEmployees'));
}

	
	public function update($id)
{
    $this->permissionCheck('users_edit');
    postAllowed();

    $data = [
        'first_name' => post('first_name'),
        'last_name' => post('last_name'),
        'role' => post('role'),
        'username' => post('username'),
        'email' => post('email'),
        'phone' => post('phone'),
        'address' => post('address'),
    ];

    $password = post('password');
    if(logged('id') != $id)
        $data['status'] = post('status') == 1;

    if (!empty($password))
        $data['password'] = hash("sha256", $password);

    // Update basic user information
    $userModel = new UserModel();
    $userModel->update($id, $data);

    // Handle assigned locations
    $selectedLocations = $this->request->getPost('locations');
    if (!empty($selectedLocations)) {
        // Remove existing assignments
        $userModel->removeAssignedLocations($id);
        
        // Add new assignments
        foreach ($selectedLocations as $locationId) {
            $userModel->assignLocation($id, $locationId);
        }
    }

    // Handle manager relationship
    $managerId = $this->request->getPost('manager');
    if (!empty($managerId)) {
        // Assuming you have a method to update manager in your UserModel
        $userModel->updateManager($id, $managerId);
    }

    // Logging and redirection
    model('App\Models\ActivityLogModel')->add("User #$id Updated by User:".logged('name'));
    return redirect()->to('users')->with('notifySuccess', 'User Updated Successfully');
}


public function view($id)
{
    $this->permissionCheck('users_view');

    $userModel = new UserModel();
    $user = $userModel->getById($id);

	$user->role = model('App\Models\RoleModel')->getByWhere([
        'id' => $user->role
    ])[0];
    $user->activity = model('App\Models\ActivityLogModel')->getByWhere([
        'user' => $id
    ], ['order' => ['id', 'desc']]);

    // Fetch manager's full name
    $managerDetails = $userModel->getManagerUser($id);
    $user->manager_full_name = !empty($managerDetails) ? $managerDetails[0]->first_name . ' ' . $managerDetails[0]->last_name : 'No Manager';

    // Fetch and compile assigned locations' names
    $assignedLocations = $userModel->getAssignedLocations($id);
    $locationNames = [];
    foreach ($assignedLocations as $location) {
        $locationNames[] = $location->location_name;
    }
    $user->assigned_locations = implode(', ', $locationNames);
  // Pass the onboarding stages to the view
    return view('admin/users/view', compact('user'));
}
	
public function displayOnboardingStages($userId)
{
    $userOnboardingModel = new \App\Models\UserOnboardingModel();

    // Fetch onboarding stages for the specified user ID
    $onboardingStages = $userOnboardingModel
        ->where('user_id', $userId)
        ->findAll();
}


	public function check()
	{
		$email = !empty(get('email')) ? get('email') : false;
		$username = !empty(get('username')) ? get('username') : false;
		$notId = !empty(get('notId')) ? get('notId') : 0;

		if($email)
			$exists = count((new UserModel)->getByWhere([
					'email' => $email,
					'id !=' => $notId,
				])) > 0 ? true : false;

		if($username)
			$exists = count((new UserModel)->getByWhere([
					'username' => $username,
					'id !=' => $notId,
				])) > 0 ? true : false;

		echo $exists ? 'false' : 'true';
	}

	public function change_status($id)
	{
		(new UserModel)->update($id, ['status' => get('status') == 'true' ? 1 : 0 ]);
		echo 'done';
	}

	public function delete($id)
	{

        $this->permissionCheck('users_delete');

		if($id!==1 && $id!=logged('id')){ }else{
			return redirect()->to('users');
		}

		(new UserModel)->delete($id);

		model('App\Models\ActivityLogModel')->add("User #$id Deleted by User:".logged('name'));
		
		return redirect()->to('users')->with('notifySuccess', 'User has been Deleted Successfully');

	}
	public function onboarding()
{
	$this->permissionCheck('view_onboarding_overview');	
	$this->updatePageData([ 'submenu' => 'user_onboarding' ]);	
    // Load the UserOnboardingModel
    $userOnboardingModel = new \App\Models\UserOnboardingModel();

    // Load the UserModel
    $userModel = new \App\Models\UserModel();

    // Fetch unique user IDs from the database
    $userIds = $userOnboardingModel->distinct()->findColumn('user_id');

    // Prepare an array to store user data
    $users = [];

    // Loop through each user ID
    foreach ($userIds as $userId) {
        // Fetch user details (first_name and last_name) from the UserModel
        $userDetails = $userModel->find($userId);

        // Calculate total stages assigned for the user
        $totalStagesAssigned = $userOnboardingModel
            ->where('user_id', $userId)
            ->countAllResults();

        // Calculate total stages completed for the user
        $totalStagesCompleted = $userOnboardingModel
            ->where('user_id', $userId)
            ->where('completed_on IS NOT NULL')
            ->countAllResults();

        // Calculate percentage of total completed
        $percentageCompleted = ($totalStagesAssigned > 0) ? ($totalStagesCompleted / $totalStagesAssigned) * 100 : 0;

        // Prepare data for the user
        $userData = [
            'user_id' => $userId,
            'first_name' => $userDetails->first_name, // Use object syntax to access properties
            'last_name' => $userDetails->last_name,   // Use object syntax to access properties
            'total_stages_assigned' => $totalStagesAssigned,
            'total_stages_completed' => $totalStagesCompleted,
            'percentage_completed' => number_format($percentageCompleted, 2) // Format percentage to two decimal places
        ];

        // Add user data to the users array
        $users[] = $userData;
    }

    // Load the view and pass the data
    return view('admin/users/onboarding', ['users' => $users]);
}
	
	
	
	public function onboard_status($id)
{
    $this->permissionCheck('users_view');

    $userModel = new UserModel();
    $user = $userModel->getById($id);
	$userOnboardingModel = new \App\Models\UserOnboardingModel();
    $onboardingStages = $userOnboardingModel->getOnboardingStagesWithNames($id);
    // Fetch and compile assigned locations' names
    $assignedLocations = $userModel->getAssignedLocations($id);
    $locationNames = [];
    foreach ($assignedLocations as $location) {
        $locationNames[] = $location->location_name;
    }
    $user->assigned_locations = implode(', ', $locationNames);
  // Pass the onboarding stages to the view
    return view('admin/users/onboarding_status', compact('user', 'onboardingStages'));
}
	
	public function markStageCompleted()
{
    // Check if the request method is POST
    if ($this->request->getMethod() === 'post') {
        // Get the stage_id from the form submission
        $stageId = $this->request->getPost('stage_id');

        // Check if the stage_id is valid
        if (!empty($stageId)) {
            // Load the UserOnboardingModel
            $userOnboardingModel = new \App\Models\UserOnboardingModel();

            // Find the onboarding stage by its primary key (ID)
            $onboardingStage = $userOnboardingModel->find($stageId);
			$userID = logged('id');
            // Check if the onboarding stage exists
            if (!empty($onboardingStage)) {
                // Update the completed_on and completed_by fields
                $onboardingStage['completed_on'] = date('Y-m-d');
                $onboardingStage['completed_by'] = $userID; // Replace $user->id with the logic to get the logged-in user's ID

                // Save the changes to the database
                $userOnboardingModel->save($onboardingStage);

                // Redirect back to the onboarding page with a success message
                return redirect()->back()->with('notifySuccess', 'Stage marked as completed successfully.');
            } else {
                // Redirect back to the onboarding page with an error message
                return redirect()->back()->with('notifyError', 'Invalid onboarding stage ID.');
            }
        } else {
            // Redirect back to the onboarding page with an error message
            return redirect()->back()->with('notifyError', 'Stage ID is required.');
        }
    } else {
        // Redirect back to the onboarding page with an error message
        return redirect()->back()->with('notifyError', 'Invalid request method.');
    }
}
}
