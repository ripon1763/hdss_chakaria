<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberMarriageEnd extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "memberMarriageEnd";
	public $pageTitle = 'Member Marriage End';
	public $pageShortName = 'Member Marriage End';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
        $this->load->model('householdVisit_model','visitModel');
        $this->load->model('memberMarriage_model','marriageModel');
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
    

    public function addEditMarriageEnd($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id_current = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Marriage End' ;
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

            $data['mendRecordRecord'] = $this->marriageModel->getMarriageEndDetailsByIdnHousehold($id,$data['household_master_id_sub'],$data['round_master_id']);

            //

            $data['marriage_end_typ'] = $this->modelName->getLookUpListNotSpecific($this->config->item('maritalstatustyp'), array('unm','mar'));
            $data['marriage_end_cause'] = $this->modelName->getLookUpList($this->config->item('marriage_end_cause'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/mend_edit_details', $data);
            $this->load->view('includes/footer');
        
    }

    function editMarriageDetails()
    {
          
           // print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $marriageID = $this->input->post('marriageID',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

           
            $this->form_validation->set_rules('fk_marriage_end_type','Member marriage end type','trim|required|numeric');
            $this->form_validation->set_rules('marriage_end_date','Marriage End Date','trim|required');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberMarriageEnd/addEditMarriageEnd/'. $marriageID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#mend');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                
                $fk_marriage_end_type = $this->input->post('fk_marriage_end_type',true);
                $fk_spouse_id = $this->input->post('fk_spouse_id',true);
                $fk_marriage_end_cause_one = $this->input->post('fk_marriage_end_cause_one',true);
                $fk_marriage_end_cause_two = $this->input->post('fk_marriage_end_cause_two',true);
                $fk_marriage_end_cause_three = $this->input->post('fk_marriage_end_cause_three',true);
                $marriage_end_date = $this->input->post('marriage_end_date',true);
                $remarks = $this->input->post('remarks',true);
                $is_event = $this->input->post('is_event',true);
				
				
				if (!empty($marriage_end_date)) {
                    $parts5 = explode('/', $marriage_end_date);
                    $new_marriage_end_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }
				

                $this->db->trans_start();

                try
                { 
				
				    $IdInfo = array(
                        
                        'fk_marriage_end_type'=>$fk_marriage_end_type, 
                        'fk_marriage_end_cause_one'=>$fk_marriage_end_cause_one, 
                        'fk_marriage_end_cause_two'=>$fk_marriage_end_cause_two, 
                        'marriage_end_date'=>$new_marriage_end_date, 
                        'fk_marriage_end_cause_three'=>$fk_marriage_end_cause_three, 
                        'remarks'=>$remarks, 
                        'is_event'=>$is_event, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );
                        
					$this->marriageModel->editEnd($IdInfo,$marriageID);
					
					
					// update member info

                    $memberUpdate = array('fk_marital_status'=>$fk_marriage_end_type, 
					                     'last_marriage_end_date'=>$new_marriage_end_date, 	
										 'updateBy'=>$this->vendorId, 
										 'updatedOn'=>date('Y-m-d H:i:s')

                    );

                    $this->modelName->editList($memberUpdate,$member_master_id,$this->config->item('memberMasterTable'));
					
					
					// update previous spause info
					
					if ($fk_spouse_id > 0)
					{
						    $memberUpdateBrideGroomPrev = array(
                                 'fk_marital_status'=>$fk_marriage_end_type, 
					             'last_marriage_end_date'=>$new_marriage_end_date, 	
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

							);

							$this->modelName->editList($memberUpdateBrideGroomPrev,$fk_spouse_id,$this->config->item('memberMasterTable'));
					}
					

                   
                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating marriage end.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Member Marriage end updated successfully.');
                
                redirect('householdvisit/marriage_end?baseID='.$baseID.'#mend');
            }
        
    }


    public function addMarriageEnd($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Marriage End' ;
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

            //

            //$data['marriage_end_typ'] = $this->modelName->getLookUpList($this->config->item('maritalstatustyp'));
			$data['marriage_end_typ'] = $this->modelName->getLookUpListNotSpecific($this->config->item('maritalstatustyp'), array('unm','mar'));
            $data['marriage_end_cause'] = $this->modelName->getLookUpList($this->config->item('marriage_end_cause'));
          
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/mend_add_details', $data);
            $this->load->view('includes/footer');
        
    }

    function addMarriageDetails()
    {
          
            //print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('fk_marriage_end_type','Member marriage end type','trim|required|numeric');
            $this->form_validation->set_rules('marriage_end_date','Marriage End Date','trim|required');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
    
                redirect('memberMarriageEnd/addMarriageEnd/'. $member_master_id.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#mend');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

               $whereHouseholdmar = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id,'member_master_id'=>$member_master_id);

               $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('marriageEndTable'))->where($whereHouseholdmar)->get()->row()->countRow;

               if ($countRow > 0)
               {
                  $this->session->set_flashdata('error', 'Marriage already exists for this round.');
                  redirect('householdvisit/marriage_end?baseID='.$baseID.'#mend');
               }

                
                
                $fk_marriage_end_type = $this->input->post('fk_marriage_end_type',true);
                $fk_spouse_id = $this->input->post('fk_spouse_id',true);
                $fk_marriage_end_cause_one = $this->input->post('fk_marriage_end_cause_one',true);
                $fk_marriage_end_cause_two = $this->input->post('fk_marriage_end_cause_two',true);
                $fk_marriage_end_cause_three = $this->input->post('fk_marriage_end_cause_three',true);
                $marriage_end_date = $this->input->post('marriage_end_date',true);
                $remarks = $this->input->post('remarks',true);
                $is_event = $this->input->post('is_event',true);
				
				
				if (!empty($marriage_end_date)) {
                    $parts5 = explode('/', $marriage_end_date);
                    $new_marriage_end_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }
				
                $round_master_id_entry_round =  $this->getCurrentRound()[0]->id;

                $this->db->trans_start();

                try
                { 

                    $IdInfo = array(
                        
                        'fk_marriage_end_type'=>$fk_marriage_end_type, 
                        'member_master_id_bride_groom'=>$fk_spouse_id, 
                        'fk_marriage_end_cause_one'=>$fk_marriage_end_cause_one, 
                        'fk_marriage_end_cause_two'=>$fk_marriage_end_cause_two, 
                        'marriage_end_date'=>$new_marriage_end_date, 
                        'fk_marriage_end_cause_three'=>$fk_marriage_end_cause_three, 
                        'remarks'=>$remarks, 
                        'is_event'=>$is_event, 
                        'transfer_complete'=>'No',  
                        'member_master_id'=>$member_master_id, 
                        'round_master_id'=>$round_master_id_entry_round, 
                        'household_master_id'=>$household_master_id, 
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );
                        
                    $this->marriageModel->addNew($IdInfo,$this->config->item('marriageEndTable'));
					
					
					// update member info

                    $memberUpdate = array(
                                 'spouse_code'=>'', 
                                 'fk_spouse_id'=>0, 
                                 'fk_marital_status'=>$fk_marriage_end_type, 
                                 'last_marriage_end_date'=>$new_marriage_end_date, 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

                    );

                    $this->modelName->editList($memberUpdate,$member_master_id,$this->config->item('memberMasterTable'));
					
					// update spause info
					
					if ($fk_spouse_id > 0)
					{
						    $memberUpdateBrideGroom = array(
                                 'spouse_code'=>'', 
                                 'fk_spouse_id'=>0, 
                                 'fk_marital_status'=>$fk_marriage_end_type,
								 'last_marriage_end_date'=>$new_marriage_end_date, 								 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

							);

							$this->modelName->editList($memberUpdateBrideGroom,$fk_spouse_id,$this->config->item('memberMasterTable'));
					}

                    $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_marriage_end'=>1, 
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
                    $this->session->set_flashdata('error', 'Error occurred while creating marriage.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Marriage created successfully.');
                
                redirect('householdvisit/marriage_end?baseID='.$baseID.'#mend');
            }
        
    }


   
  
    
    
}

?>