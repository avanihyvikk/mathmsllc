<?php

namespace App\Controllers;
use App\Controllers\AdminBaseController;
use App\Models\ExpenseModel;
use App\Models\PaymentOptionModel;
use App\Models\ExpenseStatusModel;
use App\Models\UserModel; // Add this line to import the UserModel
use App\Models\LocationModel; // Import the LocationModel


class Expenses extends AdminBaseController
{
	public $title = 'Expenses';
    public $menu = 'expenses';
    protected $expenseModel;
    protected $userModel; // Declare the userModel property
    protected $locationModel; // Declare the locationModel property
	protected $expenseStatusModel;
    
    public function __construct()
    {
        // Instantiate the ExpenseModel
        $this->expenseModel = new ExpenseModel();
        // Instantiate the UserModel
        $this->userModel = new UserModel(); // Instantiate UserModel
        // Instantiate the LocationModel
        $this->locationModel = new LocationModel(); // Instantiate LocationModel
		$this->expenseStatusModel = new \App\Models\ExpenseStatusModel();
    }

   // Method to display the expense list
    public function index()
    {
		$this->updatePageData(['submenu' => 'view_expenses']);
    	$this->permissionCheck('view_expense_module'); 
        // Retrieve the current user's ID from session
        $userId = session()->get('user_id');

        // Get all expenses with user information
        $data['expenses'] = $this->expenseModel->get_all_expenses_with_user_info($userId);

        // Fetch expense statuses from the database
        $expenseStatuses = $this->expenseStatusModel->findAll(); // Use expenseStatusModel to fetch statuses

        // Pass expense statuses to the view data
        $data['expenseStatuses'] = $expenseStatuses;

        // Return the view with data
        return view('admin/expenses/list', $data);
    }

    // Method to display the add expense form
public function add()
{
	$this->updatePageData(['submenu' => 'add_expenses']);
    $this->permissionCheck('add_expense'); 
    // Retrieve managed employees for the current user
    $userId = logged('id');
    $managedEmployees = $this->expenseModel->getManagedEmployees($userId);

    // Retrieve assigned locations for the current user
    $assignedLocations = $this->expenseModel->getAssignedLocations($userId);
    
    // Retrieve payment options from the database
    $paymentOptionModel = new PaymentOptionModel();
    $paymentOptions = $paymentOptionModel->findAll(); // Assuming findAll() retrieves all payment options
    
    // Pass managed employees, assigned locations, and payment options to the view
    $data = [
        'managedEmployees' => $managedEmployees,
        'assignedLocations' => $assignedLocations,
        'payment_options' => $paymentOptions,
		'userId' => $userId // Include this line
    ];

    // Load the view to add expense
    return view('admin/expenses/add', $data);
}


public function store()
{
	
    $this->permissionCheck('add_expense'); 
    // Retrieve user ID using logged('id')
    $userId = logged('id');

    // Set validation rules
    $validationRules = [
        'item_name' => 'required',
        'price' => 'required|regex_match[/^\d{1,3}(?:,\d{3})*(?:\.\d{2})?$/]', // Price must be in currency format
        'purchase_date' => 'required|valid_date', // Purchase date must be a valid date
        'employee_id' => 'required',
        'location_id' => 'required', // Add validation for location_id
        'purchased_from' => 'required',
        'description' => 'required',
        'payment_method' => 'required'
    ];

    // Run validation
    if (!$this->validate($validationRules)) {
        // If validation fails, redirect back to the form with input data and error messages
        return redirect()->back()->withInput()->with('notifyError', $this->validator->listErrors());
    }

    // Retrieve form data
    $item_name = $this->request->getPost('item_name');
    $price = $this->request->getPost('price');
    $purchase_date = $this->request->getPost('purchase_date');
    $employee_id = $this->request->getPost('employee_id');
    $location_id = $this->request->getPost('location_id');
    $purchased_from = $this->request->getPost('purchased_from');
    $description = $this->request->getPost('description');
    $payment_method = $this->request->getPost('payment_method');

		 // Convert purchase_date from the form format to yy-mm-dd format
    $dateObject = \DateTime::createFromFormat('m/d/Y', $purchase_date);
    if ($dateObject) {
        $formattedPurchaseDate = $dateObject->format('Y-m-d');
    } else {
        return redirect()->back()->withInput()->with('notifyError', 'Invalid purchase date format.');
    }
	
    // Check if purchase date is today or before today
    $today = date('Y-m-d');
    if ($purchase_date > $today) {
        return redirect()->back()->withInput()->with('notifyError', 'Purchase date must be today or before today');
    }
	


// Handle file upload
$file = $this->request->getFile('bill');
$bill = null;



// Handle file upload
$file = $this->request->getFile('bill');
$bill = null;

// Define allowed MIME types
$allowedMimeTypes = [
    'image/jpeg', 'image/png', 'image/gif', // Images
    'application/pdf', // PDF
    'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Word
    'text/plain', // Text files
    'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // Excel
    'text/csv' // CSV
];

// Define disallowed MIME types
$disallowedMimeTypes = [
    'application/sql', // SQL
    'text/sql' // SQL
];

if ($file->isValid() && !$file->hasMoved()) {
    // Check if the file's MIME type is not in the list of disallowed MIME types
    if (!in_array($file->getMimeType(), $disallowedMimeTypes)) {
        // Check if the file's MIME type is in the list of allowed MIME types
        if (in_array($file->getMimeType(), $allowedMimeTypes)) {
            // Specify the new upload path relative to the public directory
            $uploadPath = FCPATH . 'uploads/expenses';

            // Ensure the directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Move the uploaded file to the specified directory
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $bill = $newName;
        } else {
            // Handle the error for disallowed file types
            // You might want to log this error or notify the user
            return redirect()->back()->with('notifyError', 'File type not allowed.');
        }
    } else {
        // Handle the error for disallowed file types
        // You might want to log this error or notify the user
        return redirect()->back()->with('notifyError', 'File type not allowed.');
    }
}




    // Prepare data for insertion
    $data = [
        'item_name' => $item_name,
        'price' => $price,
        'purchase_date' => $formattedPurchaseDate,
        'employee_id' => $employee_id,
        'location_id' => $location_id,
        'purchased_from' => $purchased_from,
        'description' => $description,
        'payment_method' => $payment_method,
        'bill' => $bill,
        'status' => 'Pending',
        'added_by' => $userId,
        'last_updated_by' => $userId,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    // Insert data into database
    $this->expenseModel->insert($data);

    // Redirect back to expenses list with success message
    return redirect()->to(base_url('expenses'))->with('notifySuccess', 'Expense added successfully.');
	// After redirecting to expenses list with success message

}

public function delete($id)
{
    // Load the ExpenseModel
    $expenseModel = new ExpenseModel();

    // Fetch the expense record by ID
    $expense = $expenseModel->get_expense_by_id($id);

    // Check if expense exists
    if (!$expense) {
        // If the expense doesn't exist, redirect back with an error message
        return redirect()->to(base_url('expenses'))->with('notifyError', 'Expense not found.');
    }

    // Determine if user has permission to delete the expense
    $hasDeletePermission = hasPermissions('delete_expense');
    $isPending = $expense['status'] === 'Pending';
    $hasEditAfterApprovedPermission = hasPermissions('delete_after_pending');

    // Check permissions
    if ($hasDeletePermission && ($isPending || $hasEditAfterApprovedPermission)) {
        // Attempt to delete the expense record
        if ($expenseModel->delete($id)) {
            // If deletion is successful, redirect back to the expenses list with a success message
            return redirect()->to(base_url('expenses'))->with('notifySuccess', 'Expense deleted successfully.');
        } else {
            // If deletion fails, redirect back with an error message
            return redirect()->to(base_url('expenses'))->with('notifyError', 'Failed to delete expense.');
        }
    } else {
        // If user lacks permissions, redirect back with a permission error message
        return redirect()->to(base_url('expenses'))->with('notifyError', 'You do not have permission to try this. Your activity has been logged and reported to the admin.');
    }
}
	

public function updateStatus($expenseId)
{
	
    $this->permissionCheck('edit_expense');
    $status = $this->request->getPost('status');
    $this->expenseModel->updateStatus($expenseId, $status);
    // You may add additional logic here, such as redirecting to the expenses list
	return redirect()->to(base_url('expenses'))->with('notifySuccess', 'Status Updated Successfully.');
	// After redirecting to expenses list with success message
}
public function view($id = null)
{
	$this->updatePageData(['submenu' => 'view_expenses']);
    $this->permissionCheck('view_expense');
    // Fetch the expense, user details, and location name by expense ID
    $expense = $this->expenseModel->getExpenseDetailsWithUserAndLocationName($id);

    if (!$expense) {
        return redirect()->to(base_url('expenses'))->with('notifyError', 'Expense not found.');
    }

    $data = [
        'expense' => $expense,
    ];

    return view('admin/expenses/view', $data);
}

public function edit($id = null)
{
    $this->updatePageData(['submenu' => 'edit_expenses']);

    // Initially, ensure the user has the basic permission to edit expenses
    $this->permissionCheck('edit_expense');

    // Fetch the expense, user details, and location name by expense ID
    $expense = $this->expenseModel->getExpenseDetailsWithUserAndLocationName($id);

    if (!$expense) {
        return redirect()->to(base_url('expenses'))->with('notifyError', 'Expense not found.');
    }

    // Check permissions based on the expense's status
    $canEdit = $expense['status'] === 'Pending' || hasPermissions('edit_after_approved');

    if (!$canEdit) {
        // Redirect with an error if the user does not have the right to edit this expense based on its status and user permissions
        return redirect()->to(base_url('expenses'))->with('notifyError', 'You do not have the required permissions to edit this expense.');
    }

    // Proceed with fetching additional data needed for the view
    $paymentOptionModel = new \App\Models\PaymentOptionModel(); // Ensure you use the correct namespace
    $paymentOptions = $paymentOptionModel->findAll();

    $expenseStatuses = $this->expenseStatusModel->findAll(); // Use expenseStatusModel to fetch statuses

    // Prepare data to be passed to the view
    $data = [
        'expense' => $expense,
        'paymentOptions' => $paymentOptions, // Add payment options to the data array
        'expenseStatuses' => $expenseStatuses,
    ];

    // Load the view and pass the data array
    return view('admin/expenses/edit', $data);
}


public function update()
{
    $this->permissionCheck('edit_expense');
    // Set validation rules
    $validationRules = [
        'item_name' => 'required',
        'price' => 'required|regex_match[/^\d{1,3}(?:,\d{3})*(?:\.\d{2})?$/]', // Price must be in currency format
        'purchase_date' => 'required|valid_date', // Purchase date must be a valid date
        'purchased_from' => 'required',
        'description' => 'required',
        'payment_method' => 'required',
        'status' => 'required' // Add validation rule for status
    ];

    // Run validation
    if (!$this->validate($validationRules)) {
        // If validation fails, redirect back to the form with input data and error messages
        return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
    }

    // Retrieve form data
    $expenseId = $this->request->getPost('expense_id');
    $itemName = $this->request->getPost('item_name');
    $price = $this->request->getPost('price');
    $purchaseDate = $this->request->getPost('purchase_date');
    $purchasedFrom = $this->request->getPost('purchased_from');
    $description = $this->request->getPost('description');
    $paymentMethod = $this->request->getPost('payment_method');
    $status = $this->request->getPost('status');

    // Convert purchase_date from mm-dd-yy to yy-mm-dd format
    $dateObject = \DateTime::createFromFormat('m/d/Y', $purchaseDate);
    if ($dateObject) { // Check if date conversion is successful
        $formattedPurchaseDate = $dateObject->format('Y-m-d');
    } else {
        // Handle error, the date format could not be converted
        return redirect()->back()->withInput()->with('notifyError', 'Invalid purchase date format.');
    }
    
    // Update the expense in the database using the model method
    $result = $this->expenseModel->updateExpense($expenseId, $itemName, $price, $formattedPurchaseDate, $purchasedFrom, $description, $paymentMethod, $status);

    if ($result) {
        // Redirect to a success page or reload the edit page with a success message
        return redirect()->to(base_url('expenses'))->with('notifySuccess', 'Expense updated successfully.');
    } else {
        // Redirect back to the edit page with an error message
        return redirect()->back()->withInput()->with('notifyError', 'Failed to update expense. Please try again.');
    }
}



}
