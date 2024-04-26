<?php

namespace App\Models;

use App\Models\BaseModel;

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    // protected $useAutoIncrement = true;

    protected $returnType = 'object';
    // protected $useSoftDeletes = false;

    protected $allowedFields = ['first_name', 'last_name', 'username', 'name', 'email', 'password', 'phone', 'address', 'last_login', 'role', 'reset_token', 'status', 'img_type'];

    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';

    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;

    public function assignLocations($data)
    {
        $builder = $this->db->table('assigned_locations');
        return $builder->insertBatch($data);
    }

    public function findAllEmployeesExceptCurrentUser($currentUserId)
    {
        // Fetch all users except the current user
        return $this->where('id !=', $currentUserId)->findAll();
    }

    public function getAllEmployees()
    {

        return $this->findAll();
    }
    //This function allows employees to view other employees who are below them in the hierarchy
    public function getAllEmployeesAllowed()
    {
        $userId = logged('id'); // Retrieve user ID using logged('id')

        // Check if the user has permission to view all employees
        if (hasPermissions('view_all_users')) {
            // User has permission to view all employees
            return $this->findAll();
        } else {
            // Retrieve all employees managed by the user or by users managed by the user
            return $this->db->query("
            WITH RECURSIVE ManagerHierarchy AS (
                SELECT employee_id, manager_id
                FROM manager_user
                WHERE manager_id = $userId

                UNION ALL

                SELECT mu.employee_id, mu.manager_id
                FROM manager_user mu
                INNER JOIN ManagerHierarchy mh ON mu.manager_id = mh.employee_id
            )
            SELECT users.*
            FROM ManagerHierarchy mh
            JOIN users ON mh.employee_id = users.id
        ", [$userId])->getResult();
        }
    }


    public function insertManagerRelationship($data)
    {
        $builder = $this->db->table('manager_user');
        return $builder->insert($data);
    }

    public function getAssignedLocations($userId)
    {
        return $this->db->table('assigned_locations')
            ->where('user_id', $userId)
            ->join('location', 'assigned_locations.location_id = location.location_id')
            ->get()
            ->getResult();
    }
    //user shift schedule task start
    public function getUsersfromLocationids($locationids)
    {
        return $this->db->table('assigned_locations')
            ->select('user_id,GROUP_CONCAT(location_id) AS locations')
            ->whereIn('location_id', $locationids)
            ->groupBy('assigned_locations.user_id')
            ->get()
            ->getResult();
    }
    public function getusersById($userIds)
    {
        return $this->db->table('users')
            ->select('*')
            ->whereIn('id', $userIds)
            ->get()
            ->getResult();
    }
    //user shift schedule task end
    
    //This function gets the manager for an assigned user
    public function getManagerUser($userId)
    {
        return $this->db->table('manager_user')
            ->where('employee_id', $userId)
            ->join('users', 'manager_user.manager_id = users.id')
            ->get()
            ->getResult();
    }
    //This function gets all the users that are managed by a particular user
    public function getUsersManagedBy($managerId)
    {
        return $this->db->table('users')
            ->select('users.*')
            ->join('manager_user', 'manager_user.employee_id = users.id')
            ->where('manager_user.manager_id', $managerId)
            ->get()
            ->getResult();
    }
    //This function gets all managers of a user
    public function getAllManagers($employeeId)
    {
        // SQL query using recursive CTE to fetch all managers
        $query = "
            WITH RECURSIVE ManagerHierarchy AS (
                SELECT employee_id, manager_id
                FROM manager_user
                WHERE employee_id = $employeeId
                
                UNION ALL
                
                SELECT mu.employee_id, mu.manager_id
                FROM manager_user mu
                INNER JOIN ManagerHierarchy mh ON mu.employee_id = mh.manager_id
            )
            SELECT DISTINCT manager_id AS manager_user_id
            FROM ManagerHierarchy;
        ";

        // Execute the query
        $result = $this->db->query($query, [$employeeId])->getResultArray();

        // Extract manager IDs from the result
        $managerIds = array_column($result, 'manager_user_id');

        return $managerIds;
    }



    public function removeAssignedLocations($userId)
    {
        // Assuming 'user_locations' is the name of your table that links users and locations
        $builder = $this->db->table('assigned_locations');
        $builder->where('user_id', $userId);
        $builder->delete();
    }

    public function assignLocation($userId, $locationId)
    {
        $data = [
            'user_id' => $userId,
            'location_id' => $locationId,
        ];
        // Assuming 'user_locations' is the name of your table that links users and locations
        $builder = $this->db->table('assigned_locations');
        $builder->insert($data);
    }

    public function updateManager($userId, $managerId)
    {
        $builder = $this->db->table('manager_user');

        // Check if a manager assignment already exists for the user
        $exists = $builder->where('employee_id', $userId)->countAllResults() > 0;

        if ($exists) {
            // Update existing manager assignment
            $builder->set('manager_id', $managerId);
            $builder->where('employee_id', $userId);
            $builder->update();
        } else {
            // Insert new manager assignment
            $data = [
                'employee_id' => $userId,
                'manager_id' => $managerId,
            ];
            $builder->insert($data);
        }
    }
    public function getManagersAboveRole($roleId)
    {
        // Check if roleId is null, and return an empty result if so
        if ($roleId === null) {
            return [];
        }

        // Fetch managers who are above the selected role using a recursive query
        return $this->db->query("
        WITH RECURSIVE RoleHierarchy AS (
            SELECT id, parent_role_id
            FROM roles
            WHERE id = $roleId  -- Start with the given role ID

            UNION ALL

            SELECT r.id, r.parent_role_id
            FROM roles r
            JOIN RoleHierarchy rh ON r.id = rh.parent_role_id
        )
        SELECT DISTINCT users.*
        FROM users
        JOIN RoleHierarchy rh ON users.role = rh.id
    ")->getResult();
    }
}
