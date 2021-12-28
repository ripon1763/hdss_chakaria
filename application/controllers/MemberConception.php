<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberConception extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "memberConception";
	public $pageTitle = 'Member Conception';
	public $pageShortName = 'Member Conception';
	
	 
    public function __construct()
    {
        parent::__construct();
		    $this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
        $this->load->model('householdVisit_model','visitModel');
        $this->load->model('memberConception_model','conceptionModel');
    		$this->load->model('menu_model','menuModel');
    		$this->load->library('pagination');
            $this->isLoggedIn(); 
    		 $menu_key = 'visit';
             $baseID = $this->input->get('baseID',TRUE);
    		 $result = $this->loadThisForAccess($this->role,$baseID,$menu_key);
    		 if ($result != true) 
    		 {
    			 redirect('access');
    		 }
			
    }
    

    public function addEditConception($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id_current = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Conception' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;


            if ($this->getCurrentRound()[0]->active == 0)
            {

              $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
              redirect($this->controller.'?baseID='.$baseID);
            }

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;

            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if ($household_master_id_current != $household_master_id_current)
            {

                 $this->session->set_flashdata('error', 'You can not change household ID. This strictly prohibited.');
                 redirect('householdvisit/visit?baseID='.$baseID);
            }
          
            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['conspRecord'] = $this->conceptionModel->getConceptionDetailsByIdnHousehold($id,$data['household_master_id_sub'],$data['round_master_id']);

            //

            $data['conception_plan'] = $this->modelName->getLookUpList($this->config->item('conception_plan'));
            $data['conception_order'] = $this->modelName->getLookUpList($this->config->item('conception_order'));
            $data['consp_follow_up_status'] = $this->modelName->getLookUpList($this->config->item('consp_follow_up_status'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/conception_edit_details', $data);
            $this->load->view('includes/footer');
        
    }

    function editConceptionDetails()
    {
          
            //print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $conceptionID = $this->input->post('conceptionID',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('conception_date','Conception Date','trim|required');
            $this->form_validation->set_rules('fk_conception_plan','Conception plan','trim|required|numeric');
            $this->form_validation->set_rules('fk_conception_order','Conception order','trim|required|numeric');
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberConception/addEditConception/'. $conceptionID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#consp');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                
            	$fk_conception_plan = $this->input->post('fk_conception_plan',true);
                $fk_conception_order = $this->input->post('fk_conception_order',true);
                $conception_date = $this->input->post('conception_date',true);
               // $fk_conception_followup_status = $this->input->post('fk_conception_followup_status',true);
				
				
			   

                $new_conception_date = null;

                if (!empty($conception_date)) {
                    $parts3 = explode('/', $conception_date);
                    $new_conception_date = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }
				
				

                $this->db->trans_start();

                try
                { 
				
				
				   // $whereHouseholdCons = array('fk_conception_order' =>$fk_conception_order,'member_master_id'=>$member_master_id);
				   // $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('conceptionTable'))->where($whereHouseholdCons)->get()->row()->countRow;
				   // if ($countRow > 1)
				   // {
					   // $this->session->set_flashdata('error', 'Same conception order already exists. Please select another.');
					   // redirect('memberConception/addEditConception/'. $conceptionID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#consp');
				   // }
				   
					// $whereHouseholdConsDate = array('conception_date' =>$new_conception_date,'member_master_id'=>$member_master_id);

					// $countRowDate = $this->db->select('count(id) as countRowDate')->from($this->config->item('conceptionTable'))->where($whereHouseholdConsDate)->get()->row()->countRowDate;

					// if ($countRowDate > 1)
					// {
					  // $this->session->set_flashdata('error', 'Same conception date already exists. Please select another date.');
					  // redirect('memberConception/addEditConception/'. $conceptionID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#consp');

					// }

                    $IdInfo = array(
                        
                        'conception_date'=>$new_conception_date, 
                        'fk_conception_plan'=>$fk_conception_plan, 
                        'fk_conception_order'=>$fk_conception_order, 
                       // 'fk_conception_followup_status'=>$fk_conception_followup_status, 
                        'transfer_complete'=>'No',  
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );
					
					
                        
                    $this->conceptionModel->edit($IdInfo,$conceptionID);



                     $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_concepton'=>1, 
                        'transfer_complete'=>'No',  
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->modelName->editList($householdVisit,$visitID,$this->config->item('householdVisitTable'));

                     }
                 
                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating Conception.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Member Conception updated successfully.');
                
                redirect('householdvisit/conception?baseID='.$baseID.'#consp');
            }
        
    }


    public function addConception($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Conception' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;


            if ($this->getCurrentRound()[0]->active == 0)
            {

              $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
              redirect($this->controller.'?baseID='.$baseID);
            }

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;

            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if ($household_master_id_current != $household_master_id_current)
            {

                 $this->session->set_flashdata('error', 'You can not change household ID. This strictly prohibited.');
                 redirect('householdvisit/visit?baseID='.$baseID);
            }
          
            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['memberInfo'] = $this->memberModel->getListInfo($id, $this->config->item('memberMasterTable'));
            $data['conceptionInfo'] = $this->conceptionModel->getmemberConception($id);

           

            $data['conception_plan'] = $this->modelName->getLookUpList($this->config->item('conception_plan'));
            $data['conception_order'] = $this->modelName->getLookUpList($this->config->item('conception_order'));
            $data['consp_follow_up_status'] = $this->modelName->getLookUpList($this->config->item('consp_follow_up_status'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/conception_add_details', $data);
            $this->load->view('includes/footer');
        
    }

    function addConceptionDetails()
    {
          
           // print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('conception_date','Conception Date','trim|required');
            $this->form_validation->set_rules('fk_conception_plan','Conception plan','trim|required|numeric');
            $this->form_validation->set_rules('fk_conception_order','Conception order','trim|required|numeric');

           
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
    
                redirect('memberConception/addConception/'. $member_master_id.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#consp');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }
			   
			   
			   
			    $fk_conception_plan = $this->input->post('fk_conception_plan',true);
                $fk_conception_order = $this->input->post('fk_conception_order',true);
                $conception_date = $this->input->post('conception_date',true);

               $whereHouseholdCons = array('fk_conception_order' =>$fk_conception_order,'member_master_id'=>$member_master_id);

               $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('conceptionTable'))->where($whereHouseholdCons)->get()->row()->countRow;

               if ($countRow > 0)
               {
                  $this->session->set_flashdata('error', 'Same conception order already exists. Please select another.');
                  redirect('memberConception/addConception/'. $member_master_id.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#consp');
               }
			   
			  
                $new_conception_date = null;

                if (!empty($conception_date)) {
                    $parts3 = explode('/', $conception_date);
                    $new_conception_date = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }
				
				
				$whereHouseholdConsDate = array('conception_date' =>$new_conception_date,'member_master_id'=>$member_master_id);

                $countRowDate = $this->db->select('count(id) as countRowDate')->from($this->config->item('conceptionTable'))->where($whereHouseholdConsDate)->get()->row()->countRowDate;

                if ($countRowDate > 0)
                {
                  $this->session->set_flashdata('error', 'Same conception date already exists. Please select another date.');
                  redirect('memberConception/addConception/'. $member_master_id.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#consp');
                }

                $round_master_id_entry_round =  $this->getCurrentRound()[0]->id;

                $this->db->trans_start();

                try
                { 

                    $conceptionFollowpID = $this->config->item('conceptionFollowpID');

                    $IdInfo = array(
                        
                        'conception_date'=>$new_conception_date, 
                        'fk_conception_plan'=>$fk_conception_plan, 
                        'fk_conception_order'=>$fk_conception_order, 
                        'fk_conception_followup_status'=>$conceptionFollowpID, 
                        'transfer_complete'=>'No',  
                        'member_master_id'=>$member_master_id, 
                        'round_master_id'=>$round_master_id_entry_round, 
                        'household_master_id'=>$household_master_id, 
                        'household_master_id_on_conception'=>$household_master_id, 
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );
					
					
                        
                    $this->conceptionModel->addNew($IdInfo,$this->config->item('conceptionTable'));



                     $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_concepton'=>1, 
                        'transfer_complete'=>'No',  
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->modelName->editList($householdVisit,$visitID,$this->config->item('householdVisitTable'));

                     }

                   
                    
                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while creating conception.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','conception created successfully.');
                
                redirect('householdvisit/conception?baseID='.$baseID.'#consp');
            }
        
    }


   
  
    
    
}

?>