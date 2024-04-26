<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
    protected $table = 'location';
    protected $primaryKey = 'location_id';
    protected $allowedFields = ['location_name', 'address_street', 'address_city', 'address_state', 'address_zip', 'address_country', 'manager_id'];
}
