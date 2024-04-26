<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentOptionModel extends Model
{
    protected $table = 'payment_options';
    protected $primaryKey = 'id';
    protected $allowedFields = ['option_name'];
}
