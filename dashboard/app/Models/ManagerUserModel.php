<?php

namespace App\Models;

use CodeIgniter\Model;

class ManagerUserModel extends Model
{
    protected $table = 'manager_user'; // Adjust this according to your actual table name
    protected $primaryKey = 'id'; // Adjust this according to your actual primary key column name
    protected $allowedFields = ['employee_id', 'manager_id']; // Adjust this according to your actual fields

    // You may need to define other configurations like timestamps, etc. based on your table structure

    // Add any custom methods if needed
}
