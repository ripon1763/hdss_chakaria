<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class menu_model extends CI_Model
{
   
	
	function getMenu($roleId = null)
    {
        
		$this->db->select('DISTINCT(menu_id)');
        $this->db->from('tbl_user_role_menu');
		$this->db->where_in('role_id', $roleId);
        $ArryQuery = $this->db->get();
        
		$menu_data = [];
		if($ArryQuery->num_rows() > 0)
		{
		  foreach ($ArryQuery->result() as $row)
		  {
             $menu_data[] = $row->menu_id;
		  }
		}
		 
		//print_r($menu_data); die();
		
		$this->db->select('id as menu_item_id, menu_key, parent_menu_id as menu_parent_id, menu_name as menu_item_name,url,menu_order,icon');
        $this->db->from('tbl_menu');
		$this->db->where('status', 1);
		if (!empty($menu_data))
		{
		 $this->db->where_in('id', $menu_data);
		}
		
		$this->db->order_by('menu_order');
        $query = $this->db->get();
        
        $result = $query->result();
		
		  $refs = array();
          $list = array();
          if(!empty($result))
			{
				foreach ($result as $uf)
				{
					 
					    $thisref = &$refs[ $uf->menu_item_id ];
						$thisref['menu_item_id'] = $uf->menu_item_id;
						$thisref['menu_parent_id'] = $uf->menu_parent_id;
						$thisref['menu_item_name'] = $uf->menu_item_name;
						$thisref['url'] = $uf->url;
						$thisref['icon'] = $uf->icon;
						if ($uf ->menu_parent_id == 0)
						{
							$list[ $uf ->menu_item_id ] = &$thisref;
						}
						else
						{
							$refs[ $uf->menu_parent_id ]['children'][ $uf->menu_item_id ] = &$thisref;
						}


				}
			} 

           return $list;
			
    }
	
	
	
	
	function menuTree ()
	{
		$this->db->select('id, parent_menu_id, menu_name,url,menu_order,icon');
        $this->db->from('tbl_menu');
		$this->db->where('status', 1);
		$this->db->order_by('menu_order');
        $query = $this->db->get('');
	
        
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
	
	
	function getMenuList()
    {
        $this->db->select('a.id, a.parent_menu_id, a.menu_name,a.url,a.menu_order,a.icon, a.status, b.menu_name as parent_menu_name, a.menu_key');
        $this->db->from('tbl_menu as a');
		$this->db->join('tbl_menu as b', 'a.parent_menu_id=b.id', 'left');
		$this->db->order_by('a.menu_order');
		$query = $this->db->get();

        return $query->result();
		
	}
	
	 function menuListing()
	 {
		$this->db->select('id, menu_name,menu_order');
        $this->db->from('tbl_menu');
		$this->db->where('status', 1);
		$this->db->order_by('menu_order', 'asc');
        $query = $this->db->get();
		return $query->result();
	 }
	  
	function addNewMenu($MenuInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_menu', $MenuInfo);
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	function menuTreeDropdown()
	 {
		$this->db->select('id, menu_name as name,parent_menu_id as parent');
        $this->db->from('tbl_menu');
		$this->db->where('status', 1);
		$this->db->order_by('menu_order', 'asc');
        $query = $this->db->get();
		return $query->result_array();
	 }
	 
	function getMenuInfo($menu_id)
    {
        $this->db->select('id, menu_name, parent_menu_id, url, menu_order, status, level, icon,description, menu_key');
        $this->db->from('tbl_menu');
        $this->db->where('id', $menu_id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function editMenu($MenuInfo, $menu_id)
    {
        $this->db->where('id', $menu_id);
        $this->db->update('tbl_menu', $MenuInfo);
        
        return TRUE;
    }
	
	function deleteMenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_menu');
        
        return TRUE;
    }
	
	
    
	 
	

}

  