<?php

namespace App\Models;

use App\Models\BaseModel;

class RoleModel extends BaseModel
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    // Include 'parent_role_id' and 'is_active' in the allowed fields
    protected $allowedFields = ['title', 'parent_role_id', 'is_active'];

public function findAllWithParentTitle()
{
    $builder = $this->db->table($this->table . ' AS r');
    $builder->select('r.id, r.title, r.is_active, parent.title as parent_title');
    $builder->join($this->table . ' AS parent', 'r.parent_role_id = parent.id', 'left'); // Left join to include roles without a parent
    $query = $builder->get();
    
    return $query->getResult(); // Assuming you want an array of objects
}	
	
public function findAllActive()
{
    $builder = $this->db->table($this->table . ' AS r');
    $builder->select('r.id, r.title');
    $builder->where('r.is_active', 1); // Filter active roles
    $query = $builder->get();
    
    return $query->getResult();
}	
	

    // If you're using CodeIgniter's model events or need to do additional processing
    // upon fetching roles, consider adding those methods here. For example,
    // filtering active roles, or automatically handling role hierarchy in queries.
}
