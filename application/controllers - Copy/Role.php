<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Role extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
		$this->load->model('menu_model');
 
		$this->load->model('role_model');
		$this->load->library('pagination');
        $this->isLoggedIn();
		 $menu_key = 'rm';
         $baseID = $this->input->get('baseID',TRUE);
		 $result = $this->loadThisForAccess($this->role,$baseID,$menu_key);
		 if ($result != true) 
		 {
			 redirect('access');
		 }
		
    }

    /**
     * This function used to load the first screen of the user
     */

	public function index()
    {
       
		$this->global['pageTitle'] = $this->config->item('prefix'). ' : Role Management';
		$this->global['menu'] =  $this->menu_model->getMenu($this->role);
	
		
		$data['baseID'] = $this->input->get('baseID', TRUE);
		$data['userRecords'] = $this->role_model->RoleListing($this->role);    
        $this->load->view('includes/header', $this->global);
        $this->load->view('role/index', $data);
        $this->load->view('includes/footer');
    }
	
	function addNew()
    {
        
            $this->load->model('menu_model');
		    $this->global['menu'] =  $this->menu_model->getMenu($this->role);
			$data['baseID'] = $this->input->get('baseID', TRUE);
			$data['menuTree'] = $this->menu_model->menuTree();
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Add New Role';
            $this->load->view('includes/header', $this->global);
            $this->load->view('role/addNew', $data);
            $this->load->view('includes/footer');
        
    }
	
	function addNewRole()
    {
       
           // print_r($this->input->post()); die();
			
			$this->load->library('form_validation');
            
            $this->form_validation->set_rules('role_name','Role Name','trim|required|max_length[255]|xss_clean');
            
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
				$data['baseID'] = $this->input->get('baseID', TRUE);
				$chk = $this->input->post('chk', true);
				$chkAdd = $this->input->post('chkAdd', true);
				$chkEdit = $this->input->post('chkEdit', true);
				if (empty($chk))
				{
				
					 $this->session->set_flashdata('error', 'Please Chose at least one Menu');
					 redirect('role/addNew?baseID='.$data['baseID']);
				}
				
				else
				{
					$role_name = $this->input->post('role_name', true);
					$description = $this->input->post('description', true);
					$active = $this->input->post('active', true);
					$now                = date('Y-m-d H:i:s');
			        $user_id            = $this->vendorId;	
					
					$this->db->trans_start();

					try
					{   
						$insert_roleid = $this->role_model->addNewRole([
																'role'          => $role_name,
																'description'   => $description,
																'active'        => $active,
																'insert_by'     => $user_id,
																'insert_date'   => $now
															]);
															

				        $roleID = $insert_roleid;
						
						$menu_data = [];
						
						for ($i=0; $i < count($chk); $i++)
						{
							     $menu_data[$i] = [
													
													'menu_id'   => $chk[$i],
													'role_id'   => $roleID
												];
							
						}
						
						$this->db->insert_batch('tbl_user_role_menu', $menu_data);
						
						
						if (!empty($chkAdd))
						{
						
							 for ($i=0; $i < count($chkAdd); $i++)
								{
										$where_data[$i] = [
															'menu_id'   => $chkAdd[$i],
															'role_id'   => $roleID
														];
										$add_data[$i] = [
															'add'   => 1
														];
														
								   $this->db->where($where_data[$i]);
								   $this->db->update('tbl_user_role_menu', $add_data[$i]); 
								}
								
								
						}
						
						if (!empty($chkEdit))
						{
						
							 for ($i=0; $i < count($chkEdit); $i++)
								{
										$where_dataEdit[$i] = [
															'menu_id'   => $chkEdit[$i],
															'role_id'   => $roleID
														];
										$edit_data[$i] = [
															'edit'   => 1
														];
														
								   $this->db->where($where_dataEdit[$i]);
								   $this->db->update('tbl_user_role_menu', $edit_data[$i]); 
								}
								
								
						}
						
					}
					catch(Exception $e)
					{
						$this->db->trans_rollback();

						$this->session->set_flashdata('error', 'Error occurred while creating Role.');
					}

					$this->db->trans_commit();

					$this->session->set_flashdata('success', 'New Role created successfully.');

					redirect('role?baseID='.$data['baseID']);


					
				}
				
			}
        
    }
	
	
	function editOld($role_id = NULL)
    {
		
		  
            $data['baseID'] = $this->input->get('baseID', TRUE);
            if($role_id == null)
            {
                redirect('role?baseID='.$data['baseID']);
            }
			
			if (!(in_array(1, $this->role)) and ($role_id == 1))
			{
			    $this->session->set_flashdata('error', "You don't have permission to Access.");
				redirect('role?baseID='.$data['baseID']);
			}
            
            $this->load->model('menu_model');
		    $this->global['menu'] =  $this->menu_model->getMenu($this->role);
			
			
            $data['userInfo'] = $this->role_model->getRoleInfo($role_id);
			
		   
		    $data['menuTree'] = $this->role_model->menuTree($this->role);
			
			$data['userMenuRolePerm'] = $this->role_model->getRoleMenuUserPerm($role_id);
			
			$data['current_role'] = $role_id;
					
			
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Edit Role';
            $this->load->view('includes/header', $this->global);
            $this->load->view('role/editOld', $data);
            $this->load->view('includes/footer');
        
    }
	
	function editRole()
    {
   
            //print_r($this->input->post()); die();
			
			$this->load->library('form_validation');
            
            $this->form_validation->set_rules('role_name','Role Name','trim|required|max_length[255]|xss_clean');
            
			$role_id = $this->input->post('role_id');
            
           if($this->form_validation->run() == FALSE)
            {
                $this->editOld($role_id);
            }
            else
            {
				$data['baseID'] = $this->input->get('baseID', TRUE);
				$chk = $this->input->post('chk', true);
				$chkAdd = $this->input->post('chkAdd', true);
				$chkEdit = $this->input->post('chkEdit', true);
				if (empty($chk))
				{
				
					 $this->session->set_flashdata('error', 'Please Chose at least one Menu');
					 $this->editOld($role_id);
				}
				
				else
				{
					$role_name = $this->input->post('role_name', true);
					$description = $this->input->post('description', true);
					$active = $this->input->post('active', true);
					$now                = date('Y-m-d H:i:s');
			        $user_id            = $this->vendorId;	
					
					$this->db->trans_start();

					try
					{   //addNewRequisition
					
					    $menuInfo = array(
																'role'          => $role_name,
																'description'   => $description,
																'active'        => $active,
																'update_by'     => $user_id,
																'update_date'   => $now
															);

						$this->role_model->editRole($menuInfo, $role_id);
						
						$this->role_model->DeletePermissionFromRole($role_id);
														

				        $roleID = $role_id;
						
						$menu_data = [];
						
						for ($i=0; $i < count($chk); $i++)
						{
							     $menu_data[$i] = [
													
													'menu_id'   => $chk[$i],
													'role_id'   => $roleID
												];
							
						}
						
						$this->db->insert_batch('tbl_user_role_menu', $menu_data);
						
						
						if (!empty($chkAdd))
						{
						
							 for ($i=0; $i < count($chkAdd); $i++)
								{
										$where_data[$i] = [
															'menu_id'   => $chkAdd[$i],
															'role_id'   => $roleID
														];
										$add_data[$i] = [
															'add'   => 1
														];
														
								   $this->db->where($where_data[$i]);
								   $this->db->update('tbl_user_role_menu', $add_data[$i]); 
								}
								
								
						}
						
						if (!empty($chkEdit))
						{
						
							 for ($i=0; $i < count($chkEdit); $i++)
								{
										$where_dataEdit[$i] = [
															'menu_id'   => $chkEdit[$i],
															'role_id'   => $roleID
														];
										$edit_data[$i] = [
															'edit'   => 1
														];
														
								   $this->db->where($where_dataEdit[$i]);
								   $this->db->update('tbl_user_role_menu', $edit_data[$i]); 
								}
								
								
						}
						
					}
					catch(Exception $e)
					{
						$this->db->trans_rollback();

						$this->session->set_flashdata('error', 'Error occurred while creating Role.');
					}

					$this->db->trans_commit();

					$this->session->set_flashdata('success', 'New Role created successfully.');

					redirect('role?baseID='.$data['baseID']);


					
				}
				
			}
    }
	
	
	

}

?>