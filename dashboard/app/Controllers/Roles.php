<?php
namespace App\Controllers;

use App\Controllers\AdminBaseController;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;

class Roles extends AdminBaseController
{

    public $title = 'Roles Management';
    public $menu = 'settings';

public function index()
{
    $this->permissionCheck('roles_list');
    $this->updatePageData(['submenu' => 'roles']);
    
    // Use the new method to fetch roles with their parent title
    $roles = (new RoleModel)->findAllWithParentTitle();
    
    return view('admin/roles/list', compact('roles'));
}

	public function add()
	{
		$this->permissionCheck('roles_add');
		$this->updatePageData([ 'submenu' => 'roles' ]);
		return view('admin/roles/add');
	}

	public function save()
	{

		$this->permissionCheck('roles_add');
		
		postAllowed();

		$role = (new RoleModel)->create([
			'title' => post('name'),
		]);

		$Data = [];
		foreach (post('permission') as $permission) {
			array_push($Data, [
				'role' => $role,
				'permission' => $permission,
			]);
		}

		(new RolePermissionModel)->createBatch($Data);

		model('App\Models\ActivityLogModel')->add("New Role #$role Created by User: #".logged('id'));

        return redirect()->to('roles')->with('notifySuccess', 'New Role Created Successfully');

	}

	public function edit($id)
	{
		$this->permissionCheck('roles_edit');
		$this->updatePageData([ 'submenu' => 'roles' ]);
		$role = (new RoleModel)->getById($id);
		$permissions = (new RolePermissionModel)->getByWhere([
			'role' => $role->id
		]);

		$_permissions = array_map(function($data)
		{
			return $data->permission;
		}, $permissions);

		$role_permissions = $_permissions;
		return view('admin/roles/edit', compact('role', 'role_permissions', 'permissions'));
	}


	public function update($id)
	{

		// $this->permissionCheck('roles_edit');
		
		postAllowed();

		$data = [
			'title' => post('name'),
		];

		if(!empty($password = post('password')))
			$data['password'] = hash( "sha256", $password );

		(new RoleModel)->update($id, $data);
        $role = $id;
        
		// Data which will be added
		$Data = [];
		foreach (post('permission') as $permission) {
			if( !empty((new RolePermissionModel)->getByWhere([ 'role' => $id, 'permission' => $permission ])) ){ }else{
				array_push($Data, [
					'role' => $role,
					'permission' => $permission,
				]);
			}
		}

		if(!empty($Data))
			(new RolePermissionModel)->createBatch($Data);

		$all_permissions = (new RolePermissionModel)->getByWhere([
			'role' =>  $role
		]);

		if(!empty($all_permissions)){
			// Permissions which will be deleted
			foreach ($all_permissions as $data) {
				
				if(!in_array($data->permission, post('permission'))){
					(new RolePermissionModel)->delete($data->id);
				}
			
			}
		}
		
		model('App\Models\ActivityLogModel')->add("Role #$role Updated by User: #".logged('id'));

        return redirect()->to('roles')->with('notifySuccess', 'User Role has been Updated Successfully');

	}
public function toggle_status($id)
{
    $this->permissionCheck('roles_toggle_status');
    
    $roleModel = new RoleModel();
    $role = $roleModel->find($id);
    
    if (!$role) {
        // Handle the case where the role doesn't exist
        return redirect()->to('/roles')->with('error', lang('App.role_not_found'));
    }
    
    $newStatus = !$role->is_active;
    $roleModel->update($id, ['is_active' => $newStatus]);
    
    // Redirect back with a success message
    return redirect()->to('/roles')->with('message', lang('App.role_status_updated'));
}	

}

/* End of file Roles.php */
/* Location: ./application/controllers/Roles.php */