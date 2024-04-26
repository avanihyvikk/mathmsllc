<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseModel extends Model
{
    protected $table = 'expenses'; // Set the table associated with this model
    protected $primaryKey = 'id'; // Set the primary key field name
    protected $allowedFields = [
        'item_name', 'price', 'purchase_date', 'employee_id', 'purchased_from', 'description', 
        'payment_method', 'bill', 'status', 'added_by', 'last_updated_by', 'approver_id', 
        'created_at', 'updated_at', 'location_id'
    ]; // Fields that are allowed to be mass assigned

	
    // Get all expenses with user information
    public function get_all_expenses_with_user_info()
    {
        $userId = logged('id'); // Retrieve user ID using logged('id')

        // Check if the user has permission to view all expenses
        if (hasPermissions('view_all_expenses')) {
            // User has permission to view all expenses
            return $this->select('expenses.*, users.first_name, users.last_name')
                        ->join('users', 'users.id = expenses.employee_id')
                        ->findAll();
		} elseif (hasPermissions('view_managed_employee_expenses')) {
        // User can view expenses for managed employees
        $userModel = new \App\Models\UserModel(); // Ensure correct namespace
        $managedEmployees = $userModel->getAllEmployeesAllowed();

        $managedEmployeeIds = array_map(function($employee) {
            return $employee->id;
        }, $managedEmployees);

        // Debug: Ensure user's own ID is in the list
        if (!in_array($userId, $managedEmployeeIds)) {
            $managedEmployeeIds[] = $userId; // Include user's own ID
        }

        // User can view their own expenses and those of managed employees
        return $baseQuery->whereIn('employee_id', $managedEmployeeIds)->findAll();
			
			
        } else {
            // User can only view their own expenses
            return $this->select('expenses.*, users.first_name, users.last_name')
                        ->join('users', 'users.id = expenses.employee_id')
                        ->where('employee_id', $userId)
                        ->findAll();
        }
    }	


    // Get a single expense by ID
    public function get_expense_by_id($id)
    {
        return $this->find($id);
    }

    public function getManagedEmployees($userId)
{
    // Retrieve managed employees as before
    $managedEmployees = $this->db->table('manager_user')
                        ->select('users.id, users.first_name, users.last_name')
                        ->join('users', 'users.id = manager_user.employee_id')
                        ->where('manager_user.manager_id', $userId)
                        ->get()
                        ->getResult();

    // Additionally, retrieve the logged-in employee's information
    // Assuming 'users' table contains the logged-in user's data
    $loggedInEmployee = $this->db->table('users')
                        ->select('id, first_name, last_name')
                        ->where('id', $userId)
                        ->get()
                        ->getFirstRow();

    if ($loggedInEmployee) {
        // Prepend the logged-in employee to the managedEmployees array
        array_unshift($managedEmployees, $loggedInEmployee);
    }

    return $managedEmployees;
}


    // Function to get assigned locations
    public function getAssignedLocations()
    {
        // Retrieve user ID using logged('id')
        $userId = logged('id');

        // Fetch assigned location names for the user using JOIN
        $assignedLocations = $this->db
            ->table('assigned_locations')
            ->select('location.location_id, location.location_name')
            ->join('location', 'location.location_id = assigned_locations.location_id')
            ->where('assigned_locations.user_id', $userId)
            ->get()
            ->getResult();

        return $assignedLocations;
    }
	
	public function updateStatus($expenseId, $status)
{
    // Use the Query Builder to update the status in the database
    $this->db->table('expenses')
             ->set('status', $status)
             ->where('id', $expenseId)
             ->update();
}
public function getExpenseDetailsWithUserAndLocationName($id)
{
    return $this->asArray()
                ->select('expenses.*, users.first_name, users.last_name, location.location_name')
                ->join('users', 'users.id = expenses.employee_id')
                ->join('location', 'location.location_id = expenses.location_id')
                ->where('expenses.id', $id)
                ->first();
}
public function updateExpense($expenseId, $itemName, $price, $purchaseDate, $purchasedFrom, $description, $paymentMethod, $status)
{
    // Use the Query Builder to update the expense record
    $data = [
        'item_name' => $itemName,
        'price' => $price,
        'purchase_date' => $purchaseDate,
        'purchased_from' => $purchasedFrom,
        'description' => $description,
        'payment_method' => $paymentMethod,
        'status' => $status
    ];

    // You may need to adjust this according to your database schema
    $this->db->table('expenses')->where('id', $expenseId)->update($data);

    // Check if the update was successful
    if ($this->db->affectedRows() > 0) {
        return true;
    } else {
        return false;
    }
}

    // The insert_expense, update_expense, and delete_expense methods can utilize the built-in
    // insert, update, and delete methods provided by CodeIgniter\Model.
    // For example, to insert a new expense, you can directly use:
    // $model->insert($data);

    // Similarly, update and delete operations can be performed with:
    // $model->update($id, $data);
    // $model->delete($id);
}
