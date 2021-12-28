<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Slum_area extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "slum_area";
	public $pageTitle = 'Slum Area Management';
	public $pageShortName = 'Slum Area';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
		$this->load->model('menu_model','menuModel');
		$this->load->library('pagination');
        $this->isLoggedIn(); 
		 $menu_key = 'slma';
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
			
			
            $data['userRecords'] = $this->modelName->listingSlumArea($this->config->item('slumAreaTable'));
            
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
			
			
			$data['slum'] = $this->modelName->getListType($this->config->item('slumTable'));

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
            $this->form_validation->set_rules('name','Slum Area Name','trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('code','Slum Area Code','trim|required|max_length[10]|xss_clean');
            $this->form_validation->set_rules('slumID','Slum Name','trim|required|numeric|xss_clean');
              
            $baseID = $this->input->get('baseID', TRUE);
           
		   if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
				
                $name = $this->input->post('name',true);
                $code = $this->input->post('code',true);
                $active = $this->input->post('active',true);
                $slumID = $this->input->post('slumID',true);

				$IdInfo = array('name'=>$name,'code'=>$code,'slumID'=>$slumID, 'active'=>$active, 'insertedBy'=>$this->vendorId, 'insertedOn'=>date('Y-m-d H:i:s'));
					
				$result = $this->modelName->addNewList($IdInfo,$this->config->item('slumAreaTable'));
				
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
		    $data['slum'] = $this->modelName->getListType($this->config->item('slumTable'));
            $data['userInfo'] = $this->modelName->getListInfoSlumArea($id,$this->config->item('slumAreaTable'));
			
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
            
            $id = $this->input->post('id');
			$baseID = $this->input->get('baseID', TRUE);
	
            $this->form_validation->set_rules('name','Slum Area Name','trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('code','Slum Area Code','trim|required|max_length[10]|xss_clean');
			$this->form_validation->set_rules('slumID','Slum Name','trim|required|numeric|xss_clean');
        
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($id);
            }
            else
            {
                
			    $name = $this->input->post('name',true);
			    $code = $this->input->post('code',true);
                $active = $this->input->post('active',true);
                $slumID = $this->input->post('slumID',true);
                
                $IDInfo = array();
                $IDInfo = array( 'name'=> $name,'code'=> $code,'slumID'=> $slumID,
										'active'=>$active,'updatedBy'=>$this->vendorId, 'updatedOn'=>date('Y-m-d H:i:s'));
                
                $result = $this->modelName->editList($IDInfo, $id,$this->config->item('slumAreaTable'));
                
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