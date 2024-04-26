<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseStatusModel extends Model
{
    protected $table = 'expense_status';
    protected $primaryKey = 'id';

    // Optionally, you can define additional settings such as timestamps, validation rules, etc.
}
