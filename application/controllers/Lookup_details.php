<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Lookup_details extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "lookup_details";
	public $pageTitle = 'Lookup Details Management';
	public $pageShortName = 'Lookup Details';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
		$this->load->model('menu_model','menuModel');
		$this->load->library('pagination');
        $this->isLoggedIn(); 
		 $menu_key = 'lookd';
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
            $baseID = $this->input->get('baseID', TRUE);
		    $this->global['menu'] =  $this->menuModel->getMenu($this->role);
	        
			$this->global['pageTitle'] = $this->config->item('prefix'). ' : ' .$this->pageTitle;
	        $data['pageTitle'] = $this->pageTitle;
			$data['controller'] = $this->controller;
			$data['addMethod'] = 'addNew';
			$data['editMethod'] = 'editOld';
			$data['shortName'] = $this->pageShortName;
			$data['boxTitle'] = 'List';
			
			$data['lookupMasterType'] = $this->modelName->lookupMasterList($this->config->item('lookMasterTable'));
			
			$searchMaster = 0;
			$data['searchMaster'] = 0;
			
			if($this->input->post('Clear'))
			{
				$this->session->unset_userdata('searchMaster'); 
				$data['searchMaster'] = 0;
			}
			
			$searchMaster = $this->input->post('searchMaster',true);
			
			$data['searchMaster'] = $this->session->userdata('searchMaster');
			
			if($this->input->post('search'))
			{
			
			 $this->session->set_userdata('searchMaster', $searchMaster);
		     $data['searchMaster'] = $this->session->userdata('searchMaster');
		    
	        }
			
			if ((!empty($data['searchMaster'])))
			{
				  
				  $data['userRecords'] = $this->modelName->listingDetails($this->config->item('lookDetailsTable'),$data['searchMaster']);
			}
			else{
				
				$data['userRecords'] = $this->modelName->listingDetails($this->config->item('lookDetailsTable'),$data['searchMaster']);
				
			}
            
			$data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
			$data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
	
		    $this->load->view('includes/header', $this->global);
			$this->load->view('includes/script');
			$this->load->view($this->controller.'/index', $data);
			$this->load->view('includes/footer');
		
    }
    

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
      
            $baseID = $this->input->get('baseID', TRUE);
			
			$addPerm  =  $this->getPermission($baseID, $this->role, 'add');
			
			if($addPerm == 0)
            {
                $this->session->set_flashdata('error', "Unauthorized Access");
				redirect($this->controller.'?baseID='.$baseID);
            }
			
		    $this->global['menu'] =  $this->menuModel->getMenu($this->role);
			
			$this->global['pageTitle'] = $this->config->item('prefix'). ' : ' .$this->pageTitle;
	        $data['pageTitle'] = $this->pageTitle;
			$data['controller'] = $this->controller;
			$data['actionMethod'] = 'addNewList';
			$data['shortName'] = $this->pageShortName;
			$data['boxTitle'] = 'Add';
			
			$data['lookupMasterType'] = $this->modelName->lookupMasterList($this->config->item('lookMasterTable'));
			

            $this->load->view('includes/header', $this->global);
            $this->load->view($this->controller.'/addNew',$data);
            $this->load->view('includes/footer');
        
    }
    
    /**
     * This function is used to add new
     */
    function addNewList()
    {
          
			$this->load->library('form_validation');
			
            $this->form_validation->set_rules('name','Name','trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('code','Code','trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('master_id','Lookup Master','trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('display_order','Lookup Master','trim|required|xss_clean');
              
            $baseID = $this->input->get('baseID', TRUE);
           
		   if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
				
                $name = $this->input->post('name',true);
                $active = $this->input->post('active',true);
                $code = $this->input->post('code',true);
                $description = $this->input->post('description',true);
                $master_id = $this->input->post('master_id',true);
                $display_order = $this->input->post('display_order',true);
                $internal_code = $this->input->post('internal_code',true);
				
			

				$IdInfo = array('name'=> $name,'code'=> $code,'active'=>$active,'description'=>$description,
				'lookup_master_id'=>$master_id,'display_order'=>$display_order,'internal_code'=>$internal_code, 
				'insertedBy'=>$this->vendorId, 'insertedOn'=>date('Y-m-d H:i:s'));
				
					
				$result = $this->modelName->addNewList($IdInfo,$this->config->item('lookDetailsTable'));
				
				if($result > 0)
                {
                    $this->session->set_flashdata('success', $this->pageShortName.' created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', $this->pageShortName.' creation failed');
                }
				
                redirect($this->controller.'?baseID='.$baseID);
            }
        
    }

    function editOld($id = NULL)
    {
			$baseID = $this->input->get('baseID', TRUE);
			
            if($id == null)
            {
                $this->session->set_flashdata('error', "Someting went wrong!! Please try Again");
				redirect($this->controller.'?baseID='.$baseID);
            }
			
			$editPerm =  $this->getPermission($baseID, $this->role, 'edit');
			if($editPerm == 0)
            {
                $this->session->set_flashdata('error', "Unauthorized Access");
				redirect($this->controller.'?baseID='.$baseID);
            }
			
            
		    $this->global['menu'] =  $this->menuModel->getMenu($this->role);
			
			$data['lookupMasterType'] = $this->modelName->lookupMasterList($this->config->item('lookMasterTable'));
            $data['userInfo'] = $this->modelName->getListDetailsInfo($id,$this->config->item('lookDetailsTable'));
			
			$this->global['pageTitle'] = $this->config->item('prefix'). ' : ' .$this->pageTitle;
	        $data['pageTitle'] = $this->pageTitle;
			$data['controller'] = $this->controller;
			$data['actionMethod'] = 'editList';
			$data['shortName'] = $this->pageShortName;
			$data['boxTitle'] = 'Edit';
			
			
            $this->load->view('includes/header', $this->global);
            $this->load->view($this->controller.'/editOld', $data);
            $this->load->view('includes/footer');
    }
    
    
    /**
     * This function is used to edit information
     */
    function editList()
    {
            $this->load->library('form_validation');
			
			print_r($this->input->post());
            
            $id = $this->input->post('id');
			$baseID = $this->input->get('baseID', TRUE);
	
            $this->form_validation->set_rules('name','Name','trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('code','Code','trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('master_id','Lookup Master','trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('display_order','Lookup Master','trim|required|xss_clean');
        
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($id);
            }
            else
            {
                
			    $name = $this->input->post('name',true);
                $active = $this->input->post('active',true);
                $code = $this->input->post('code',true);
                $description = $this->input->post('description',true);
                $master_id = $this->input->post('master_id',true);
                $display_order = $this->input->post('display_order',true);
                $internal_code = $this->input->post('internal_code',true);
                
                $IDInfo = array();
                $IDInfo = array( 'name'=> $name,'code'=> $code,'active'=>$active,'description'=>$description,
				'lookup_master_id'=>$master_id,'display_order'=>$display_order,'internal_code'=>$internal_code,
				'updatedBy'=>$this->vendorId, 'updatedOn'=>date('Y-m-d H:i:s'));
                
                $result = $this->modelName->editList($IDInfo, $id,$this->config->item('lookDetailsTable'));
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', $this->pageShortName.' updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', $this->pageShortName.' update failed');
                }
                
				redirect($this->controller.'?baseID='.$baseID);
            }
        
    }
    
    
}

?>