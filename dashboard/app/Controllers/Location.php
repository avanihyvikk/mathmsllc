<?php

namespace App\Controllers;

use App\Controllers\AdminBaseController;
use App\Models\LocationModel;
use App\Models\UserModel; // Make sure to import the UserModel

class location extends AdminBaseController
{
	public $title = 'location';
    public $menu = 'location';
	
    public function index()
{
    $this->updatePageData(['submenu' => 'view_location']);
    $this->permissionCheck('view_location');   
    
    // Load the necessary models
    $locationModel = new LocationModel();
    $userModel = new UserModel();
    
    // Fetch all locations and users
    $locations = $locationModel->findAll();
    $users = $userModel->findAll();
    
    // Pass location and user data to the view
    return view('admin/locations/list', ['locations' => $locations, 'users' => $users]);
}
	
		public function add()
	{
        $this->updatePageData([ 'submenu' => 'add_location' ]);
		$this->permissionCheck('add_location');

        // Fetch list of users
        $userModel = new UserModel();
        $users = $userModel->findAll(); // Assuming you want to fetch all users
		
		

        // Pass the list of users to the view
        return view('admin/locations/add', ['users' => $users]);
	}

    public function addLocation()
{
    helper(['form']);

    if ($this->request->getMethod() === 'post') {
        $model = new LocationModel();

        // Check if the location name already exists in the database
        $existingLocation = $model->where('location_name', $this->request->getPost('location_name'))->first();

        if ($existingLocation) {
            // Location name already exists, return with an error message
            return $this->response->setJSON(['success' => false, 'message' => 'Location name already exists.']);
        }

        // Location name is unique, proceed with insertion
        $data = [
            'location_name' => $this->request->getPost('location_name'),
            'address_street' => $this->request->getPost('address_street'),
            'address_city' => $this->request->getPost('address_city'),
            'address_state' => $this->request->getPost('address_state'),
            'address_zip' => $this->request->getPost('address_zip'),
            'address_country' => $this->request->getPost('address_country'),
            'manager_id' => $this->request->getPost('manager_id'),
        ];

        $model->insert($data);

        // Return success response
        return $this->response->setJSON(['success' => true, 'message' => 'Location added successfully']);
    }

    // If the request method is not POST, return empty response
    return $this->response->setJSON([]);
	}

	
	public function edit($locationId)
{
	$this->permissionCheck('edit_location');
    // Create an instance of the LocationModel
    $locationModel = new LocationModel();

    // Find the location by ID
    $location = $locationModel->find($locationId);
    
    // Check if the location exists
    if (!$location) {
        // Location not found, handle error (e.g., redirect or display error message)
    }
    
    // Fetch list of users
        $userModel = new UserModel();
        $users = $userModel->findAll(); // Assuming you want to fetch all users

    // Pass the location data and list of users to the view for editing
    return view('admin/locations/edit', ['location' => $location, 'users' => $users]);
}
public function updateLocation()
{
    // Load necessary helpers
    helper(['form', 'url']);

    // Define validation rules
    $validationRules = [
        'location_id' => 'required|numeric',
        'location_name' => 'required',
        'address_street' => 'required',
        'address_city' => 'required',
        'address_state' => 'required|min_length[2]|max_length[2]|alpha',
        'address_zip' => 'required|exact_length[5]|numeric',
        'address_country' => 'required',
        'manager_id' => 'required|numeric',
    ];

    // Validate the form data
    if (!$this->validate($validationRules)) {
        // If validation fails, return validation errors
        return $this->failValidationErrors($this->validator->getErrors());
    }

    // Retrieve form data
    $locationId = $this->request->getVar('location_id');
    $locationName = $this->request->getVar('location_name');
    $addressStreet = $this->request->getVar('address_street');
    $addressCity = $this->request->getVar('address_city');
    $addressState = $this->request->getVar('address_state');
    $addressZip = $this->request->getVar('address_zip');
    $addressCountry = $this->request->getVar('address_country');
    $managerId = $this->request->getVar('manager_id');

    // Prepare location data
    $locationData = [
        'location_name' => $locationName,
        'address_street' => $addressStreet,
        'address_city' => $addressCity,
        'address_state' => $addressState,
        'address_zip' => $addressZip,
        'address_country' => $addressCountry,
        'manager_id' => $managerId,
    ];

    // Load the LocationModel
    $locationModel = new LocationModel();

    // Find the location by ID
    $location = $locationModel->find($locationId);

    // Check if the location exists
    if (!$location) {
        // If location does not exist, return 404 Not Found error
        return $this->failNotFound('Location not found.');
    }

    // Update the location
    if (!$locationModel->update($locationId, $locationData)) {
        // If update fails, return 500 Internal Server Error
        return $this->failServerError('Failed to update location.');
    }

    // Return success response
    return $this->response->setJSON(['success' => true, 'message' => 'Location updated successfully.']);
	
}
	
	
	

	
	

public function listLocations()
{
    $locationModel = new LocationModel();
    $locations = $locationModel->findAll();

    // Pass location data to the view
    return view('admin/locations/list', ['locations' => $locations]);
}
}