<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Round extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "round";
	public $pageTitle = 'Round Management';
	public $pageShortName = 'Round';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
		$this->load->model('menu_model','menuModel');
		$this->load->library('pagination');
        $this->isLoggedIn(); 
		 $menu_key = 'round';
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
            $where = array('active' =>1);

            $data['roundNo'] = $this->db->select('count(roundNo) as roundNo')->from($this->config->item('roundTable'))->where($where)->get()->row()->roundNo;
			
            $data['userRecords'] = $this->modelName->listingRound($this->config->item('roundTable'));
            
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

            $data['slumList'] = $this->modelName->getSlumList($this->config->item('slumTable'));


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
            $this->form_validation->set_rules('startDate','Start Date','trim|required|xss_clean');
              
            $baseID = $this->input->get('baseID', TRUE);
           
		   if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {

                $slumID = $this->input->post('slumID', true);

                if (empty($slumID))
                {
                   $this->session->set_flashdata('error', 'Please select atleast one Slum');
                   redirect($this->controller.'/addNew?baseID='.$baseID);
                }
				
                $startDate = $this->input->post('startDate', true);

                $parts1 = explode('/', $startDate);
                $new_startDate= $parts1[2].'-'.$parts1[1].'-'.$parts1[0];

                $new_enddate = null;

                $endDate = $this->input->post('endDate', true);

                if (!empty($endDate))
                {
                    $parts2 = explode('/', $endDate);
                    $new_enddate = $parts2[2].'-'.$parts2[1].'-'.$parts2[0];

                }

                $active = $this->input->post('active', true);

				

                $this->db->trans_start();

                    try
                    {   
                        
                        $roundNo = $this->db->select('COALESCE(MAX(roundNo),0) roundNo')->from( $this->config->item('roundTable'))->get()->row()->roundNo;


                        $insertBy = $this->vendorId; 
                        $insertDatetime = date('Y-m-d H:i:s');


                        $newRoundNo =  $roundNo + 1;

                        $IdInfo = array(
                            'roundNo'=>$newRoundNo, 
                            'startDate'=>$new_startDate, 
                            'endDate'=>$new_enddate, 
                            'active'=>$active, 
                            'insertedBy'=>$this->vendorId, 
                            'insertedOn'=>date('Y-m-d H:i:s')
                        );


                        $insert_roundid =  $this->modelName->addNewList($IdInfo,$this->config->item('roundTable'));
                                                            

                        $roundID = $insert_roundid;
                        
                        $slum_data = [];
                        
                        for ($i=0; $i < count($slumID); $i++)
                        {
                                 $slum_data[$i] = [
                                                    
                                                    'slumID'   => $slumID[$i],
                                                    'roundID'   => $roundID
                                                ];
                            
                        }
                        
                        $this->db->insert_batch($this->config->item('roundSlumMapTable'), $slum_data);
                        
                        
                        
                        
                    }
                    catch(Exception $e)
                    {
                        $this->db->trans_rollback();

                        $this->session->set_flashdata('error', 'Error occurred while creating Round.');
                    }

                    $this->db->trans_commit();

                    $this->session->set_flashdata('success', 'New Round created successfully.');

			
				
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

            $data['slumList'] = $this->modelName->getSlumList($this->config->item('slumTable'));

            $data['slumRound'] = $this->modelName->getSlumRoundList($this->config->item('roundSlumMapTable'));
            $data['userInfo'] = $this->modelName->getRoundListInfo($id,$this->config->item('roundTable'));
			
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
            
            $id = $this->input->post('id');
			$baseID = $this->input->get('baseID', TRUE);
	
            $this->form_validation->set_rules('startDate','Start Date','trim|required|xss_clean');
        
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($id);
            }
            else
            {
                
                $slumID = $this->input->post('slumID', true);

                if (empty($slumID))
                {
                   $this->session->set_flashdata('error', 'Please select atleast one Slum');
                   redirect($this->controller.'/editOld/'.$id.'?baseID='.$baseID);
                }
                
                $startDate = $this->input->post('startDate', true);

                $parts1 = explode('/', $startDate);
                $new_startDate= $parts1[2].'-'.$parts1[1].'-'.$parts1[0];

                $new_enddate = null;

                $endDate = $this->input->post('endDate', true);

                if (!empty($endDate))
                {
                    $parts2 = explode('/', $endDate);
                    $new_enddate = $parts2[2].'-'.$parts2[1].'-'.$parts2[0];

                }

                $active = $this->input->post('active', true);


                $this->db->trans_start();

                    try
                    {   
                          
                        $roundID = $id;


                        $IdInfo = array(
                            'startDate'=>$new_startDate, 
                            'endDate'=>$new_enddate, 
                            'active'=>$active, 
                            'updatedBy'=>$this->vendorId, 
                            'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->modelName->editList($IdInfo, $id,$this->config->item('roundTable'));

                        $this->modelName->deleteSlumFromRound($roundID, $this->config->item('roundSlumMapTable'));

                              
                        $slum_data = [];
                        
                        for ($i=0; $i < count($slumID); $i++)
                        {
                                 $slum_data[$i] = [
                                                    
                                                    'slumID'   => $slumID[$i],
                                                    'roundID'   => $roundID
                                                ];
                            
                        }
                        
                        $this->db->insert_batch($this->config->item('roundSlumMapTable'), $slum_data);
                        
                        
                        
                        
                    }
                    catch(Exception $e)
                    {
                        $this->db->trans_rollback();

                        $this->session->set_flashdata('error', 'Error occurred while updating Round.');
                    }

                    $this->db->trans_commit();

                    $this->session->set_flashdata('success', 'Round updated successfully.');
                
				    redirect($this->controller.'?baseID='.$baseID);
            }
        
    }
    
    
}

?>