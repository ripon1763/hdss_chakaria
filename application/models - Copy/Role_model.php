<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Role_model extends CI_Model
{

    function RoleListing($role)
    {
        $this->db->select('roleId, role, active, description');
        $this->db->from('tbl_roles');
		if (!(in_array(1, $role)))
		//if ($role[0] != 1)
		{
		 $this->db->where('roleId !=', 1);
		}
        return $this->db->get('')->result();
        
    }
	
	function addNewRole($insert_data)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_roles', $insert_data);
        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }
    
    function getRoleInfo($role_id)
    {
        $this->db->select('roleId, role, active, description');
        $this->db->from('tbl_roles');
        $this->db->where_in('roleId', $role_id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getRoleMenuUserPerm($role_id)
    {
        $this->db->select('menu_id, menu_name, add, edit');
        $this->db->from('tbl_user_role_menu');
		$this->db->join('tbl_menu','tbl_menu.id = tbl_user_role_menu.menu_id', 'inner');
        $this->db->where_in('role_id', $role_id);
        $query = $this->db->get();
		
		$result = $query->result();
		
       return $query->result();
    }
	
	
		
	function menuTree ($role_id)
	{
		$this->db->select('id, parent_menu_id, menu_name,url,menu_order,icon');
        $this->db->from('tbl_menu');
		$this->db->where('status', 1);
		$this->db->order_by('menu_order');
        $query = $this->db->get('');
		
		$this->db->select('menu_id, add, edit');
        $this->db->from('tbl_user_role_menu');
		$this->db->where_in('role_id', $role_id);
        $query2 = $this->db->get('');
		
        $result2 = $query2->result();
		
        $result = $query->result();
		
		$arrayCategories = array();
		if(!empty($result))
			{
				foreach ($result as $row)
				{
					$arrayCategories[$row->id] = array("parent_menu_id" => $row->parent_menu_id, "menu_name" => $row->menu_name, 'id' => $row->id);  
					
				}
			} 
			
		return $arrayCategories;
	}
	  
    
	function editRole($menuInfo, $role_id)
    {
        $this->db->where('roleId', $role_id);
        $this->db->update('tbl_roles', $menuInfo);
        
        return TRUE;
    }
    

    function DeletePermissionFromRole($role_id)
    {
		
        $this->db->where('role_id', $role_id);
        $this->db->delete('tbl_user_role_menu');
        
        return TRUE;
    }


 
}

  