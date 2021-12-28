<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Menu extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
		$this->load->model('menu_model');
		$this->load->library('pagination');
        $this->isLoggedIn();  
		 $menu_key = 'mm';
         $baseID = $this->input->get('baseID',TRUE);
		 $result = $this->loadThisForAccess($this->role,$baseID, $menu_key);
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
		    $this->global['menu'] =  $this->menu_model->getMenu($this->role);
	        $this->global['pageTitle'] = $this->config->item('prefix'). ' : Menu List';
            $data['userRecords'] = $this->menu_model->getMenuList();
			$data['baseID'] = $this->input->get('baseID', TRUE);
			
		    $this->load->view('includes/header', $this->global);
			$this->load->view('includes/script');
			$this->load->view('menu/index', $data);
			$this->load->view('includes/footer');
			
		
		
    }
    
    /**
     * This function is used to load the user list
     */
    function itemListing()
    {
       
		$searchText = $this->input->post('searchText');
		$data['searchText'] = $searchText;
		
		$this->load->library('pagination');
		
		$count = $this->item_model->itemListingCount($searchText);

		$returns = $this->paginationCompress ( "item/itemListing/", $count, 5 );
		
		$data['userRecords'] = $this->item_model->itemListing($searchText, $returns["page"], $returns["segment"]);
		$this->load->model('menu_model');
		$this->global['menu'] =  $this->menu_model->getMenu();
		
		$this->load->view('includes/header', $this->global);
		$this->load->view('unit/index', $data);
		$this->load->view('includes/footer');
        
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
       
            $this->load->model('menu_model');
		    $this->global['menu'] =  $this->menu_model->getMenu($this->role);
			$data['menuList'] = $this->menu_model->menuListing();
			$data['menuListDropdown'] = $this->menu_model->menuTreeDropdown();
			$data['baseID'] = $this->input->get('baseID', TRUE);
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Add New Menu';
            $this->load->view('includes/header', $this->global);
            $this->load->view('menu/addNew', $data);
            $this->load->view('includes/footer');
        
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewMenu()
    {
   
		$this->load->library('form_validation');
		
	   // $this->form_validation->set_rules('unit_code','Unit Code','trim|required|max_length[128]|xss_clean');
		$this->form_validation->set_rules('menu_name','Menu Name','trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('menu_url','Menu URL','trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('menu_key','Menu Key','trim|required|max_length[255]|xss_clean');
		
		  
		
		if($this->form_validation->run() == FALSE)
		{
			$this->addNew();
		}
		else
		{
			$data['baseID'] = $this->input->get('baseID', TRUE);           
			$menu_name = $this->input->post('menu_name', TRUE);
			
			$description = $this->input->post('description', TRUE);
			$parent_menu_id = $this->input->post('parent_id', TRUE);
			$url = $this->input->post('menu_url', TRUE);
			
			$status = $this->input->post('active', TRUE);
			$icon = $this->input->post('menu_icon', TRUE);
			
			$menu_key = $this->input->post('menu_key', TRUE);
			
			$get_data = $this->db->get_where('tbl_menu', ['parent_menu_id' => $parent_menu_id]);

			$count = $get_data->num_rows();
			
			$menuOrder = $count + 1;
		
			 
				
			$MenuInfo = array('menu_name'=>$menu_name,'menu_key'=>$menu_key,'description'=>$description,'url'=>$url, 'icon'=>$icon, 'parent_menu_id'=>$parent_menu_id,'menu_order'=>$menuOrder, 'status'=>$status, 'insert_by'=>$this->vendorId, 'insert_date'=>date('Y-m-d H:i:s'));
				
			$result = $this->menu_model->addNewMenu($MenuInfo);
			
			if($result > 0)
			{
				$this->session->set_flashdata('success', 'New Menu created successfully');
			}
			else
			{
				$this->session->set_flashdata('error', 'Menu creation failed');
			}
			
				
			redirect('menu?baseID='.$data['baseID']);
		}
        
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($menu_id = NULL)
    {
       
		if($menu_id == null)
		{
			redirect('menu');
		}
		
		$this->load->model('menu_model');
		$this->global['menu'] =  $this->menu_model->getMenu($this->role);
		$data['userInfo'] = $this->menu_model->getMenuInfo($menu_id);
		$data['baseID'] = $this->input->get('baseID', TRUE);
		//$data['unit'] = $this->item_model->getUnits();
		$data['menuList'] = $this->menu_model->menuListing();
		$this->global['pageTitle'] = $this->config->item('prefix'). ' : Edit Menu';
		$this->load->view('includes/header', $this->global);
		$this->load->view('menu/editOld', $data);
		$this->load->view('includes/footer');
        
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editMenu()
    {
        
            $this->load->library('form_validation');
            
            $menu_id = $this->input->post('menu_id');
            		
			$this->form_validation->set_rules('menu_name','Menu Name','trim|required|max_length[255]|xss_clean');
			$this->form_validation->set_rules('menu_url','Menu URL','trim|required|max_length[255]|xss_clean');
			
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($menu_id);
            }
            else
            {
                $data['baseID'] = $this->input->get('baseID', TRUE);
              //  $unit_code = $this->input->post('unit_code');
                $menu_name = $this->input->post('menu_name', TRUE);
				$description = $this->input->post('description', TRUE);
				$parent_menu_id = $this->input->post('parent_id', TRUE);
				$url = $this->input->post('menu_url', TRUE);
                $status = $this->input->post('active', TRUE);
				$icon = $this->input->post('menu_icon', TRUE);
				 
                $MenuInfo = array();
                
               		
                $MenuInfo = array( 'menu_name'=>$menu_name, 'description'=>$description,'url'=>$url, 'icon'=>$icon, 'parent_menu_id'=>$parent_menu_id, 'status'=>$status, 'update_by'=>$this->vendorId, 'update_date'=>date('Y-m-d H:i:s'));
                
                $result = $this->menu_model->editMenu($MenuInfo, $menu_id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Menu updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Menu update failed');
                }
                
				
				redirect('menu?baseID='.$data['baseID']);
            }
        
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteMenu($id = null)
    {
         
		 $data['baseID'] = $this->input->get('baseID', TRUE);
			 
		 $get_data = $this->db->get_where('tbl_user_role_menu', ['menu_id' => $id]);
		 $count = $get_data->num_rows();
		 
		 if ($count > 0)
		 {
			 
			 $this->session->set_flashdata('error', 'You cannot delete this menu because this menu is already assigned');
			 redirect('menu?baseID='.$data['baseID']);
		 }
		 
		 $get_data2 = $this->db->get_where('tbl_menu', ['parent_menu_id' => $id]);
		 $countParent = $get_data2->num_rows();
		
		 
		 if ($countParent > 0)
		 {
			 
			 $this->session->set_flashdata('error', 'You cannot delete this menu because this menu has child');
			 redirect('menu?baseID='.$data['baseID']);
		 }
			
		 $result = $this->menu_model->deleteMenu($id);
		
		 if($result == true)
			{
				$this->session->set_flashdata('success', 'Menu Deleted successfully');
				redirect('menu?baseID='.$data['baseID']);
			}
			else
			{
				$this->session->set_flashdata('error', 'Menu Deletion failed');
				redirect('menu?baseID='.$data['baseID']);
			}
			
			
        
    }
    
    
}

?>