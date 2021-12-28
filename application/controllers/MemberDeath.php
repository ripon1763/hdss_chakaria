<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberDeath extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "MemberDeath";
	public $pageTitle = 'Member Death';
	public $pageShortName = 'Member Death';
	
	 
    public function __construct()
    {
        parent::__construct();
		    $this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
        $this->load->model('householdVisit_model','visitModel');
        $this->load->model('memberDeath_model','deathModel');
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
    

    public function addEditDeath($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id_current = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Death' ;
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

            $data['deathRecord'] = $this->deathModel->getDeathDetailsByIdnHousehold($id,$data['household_master_id_sub'],$data['round_master_id']);

            //

            $data['member_death_cause'] = $this->modelName->getLookUpList($this->config->item('member_death_cause'));
            $data['member_death_place'] = $this->modelName->getLookUpList($this->config->item('member_death_place'));
            $data['type_of_death'] = $this->modelName->getLookUpList($this->config->item('type_of_death'));
            $data['death_confirm_by'] = $this->modelName->getLookUpList($this->config->item('death_confirm_by'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/death_edit_details', $data);
            $this->load->view('includes/footer');
        
    }

    function editDeathDetails()
    {
          
            //print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $deathID = $this->input->post('deathID',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('deathDate','Death Date','trim|required');
            $this->form_validation->set_rules('fk_death_place','Relation','trim|required|numeric');
            $this->form_validation->set_rules('fk_death_cause','Relation','trim|required|numeric');
            $this->form_validation->set_rules('fk_death_type','Relation','trim|required|numeric');
            $this->form_validation->set_rules('fk_death_confirmby','Relation','trim|required|numeric');
           
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberDeath/addEditDeath/'. $deathID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#death');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                
                $fk_death_place = $this->input->post('fk_death_place',true);
                $fk_death_cause = $this->input->post('fk_death_cause',true);
                $fk_death_type = $this->input->post('fk_death_type',true);
                $fk_death_confirmby = $this->input->post('fk_death_confirmby',true);
                $deathtime = $this->input->post('deathtime',true);
                $deathDate = $this->input->post('deathDate',true);

                $new_deathDate = null;

                if (!empty($deathDate)) {
                    $parts3 = explode('/', $deathDate);
                    $new_deathDate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }

                $this->db->trans_start();

                try
                { 



                  $whereMemember = array('id' =>$member_master_id);
                  $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereMemember)->get()->row()->member_household_id_last;

                   //member household 

                    $dethUpdate = array(
                                 'exit_date'=> $new_deathDate, 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

                    );

                    $this->db->where('id', $member_household_id_last);
                    $this->db->where('member_master_id', $member_master_id);
                    $this->db->update($this->config->item('memberHouseholdTable'), $dethUpdate);


                    $IdInfo = array(
                        
                        'death_date'=>$new_deathDate, 
                        'fk_death_place'=>$fk_death_place, 
                        'fk_death_cause'=>$fk_death_cause, 
                        'fk_death_type'=>$fk_death_type, 
                        'fk_death_confirmby'=>$fk_death_confirmby, 
                        'transfer_complete'=>'No',  
                        'death_time'=>$deathtime,  
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );
                        
                    $this->deathModel->edit($IdInfo,$deathID);
					
					
					$memberUpdate = array(
                                'is_died'=>1, 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')
                    );

                    $this->modelName->editList($memberUpdate,$member_master_id,$this->config->item('memberMasterTable'));

                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating Death.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Member Death updated successfully.');
                
                redirect('householdvisit/death?baseID='.$baseID.'#death');
            }
        
    }


    public function addDeath($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Death' ;
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

            $data['member_death_cause'] = $this->modelName->getLookUpList($this->config->item('member_death_cause'));
            $data['member_death_place'] = $this->modelName->getLookUpList($this->config->item('member_death_place'));
            $data['type_of_death'] = $this->modelName->getLookUpList($this->config->item('type_of_death'));
            $data['death_confirm_by'] = $this->modelName->getLookUpList($this->config->item('death_confirm_by'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/death_add_details', $data);
            $this->load->view('includes/footer');
        
    }

    function addDeathDetails()
    {
          
          //  print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('deathDate','Death Date','trim|required');
            $this->form_validation->set_rules('fk_death_place','Relation','trim|required|numeric');
            $this->form_validation->set_rules('fk_death_cause','Relation','trim|required|numeric');
            $this->form_validation->set_rules('fk_death_type','Relation','trim|required|numeric');
            $this->form_validation->set_rules('fk_death_confirmby','Relation','trim|required|numeric');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
    
                redirect('memberDeath/addDeath/'. $member_master_id.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#death');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

               $whereHouseholddeath = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id,'member_master_id'=>$member_master_id);

               $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('deathTable'))->where($whereHouseholddeath)->get()->row()->countRow;

               if ($countRow > 0)
               {
                  $this->session->set_flashdata('error', 'Death already exists for this round.');
                  redirect('householdvisit/death?baseID='.$baseID.'#death');
               }

                
                
                $fk_death_place = $this->input->post('fk_death_place',true);
                $fk_death_cause = $this->input->post('fk_death_cause',true);
                $fk_death_type = $this->input->post('fk_death_type',true);
                $fk_death_confirmby = $this->input->post('fk_death_confirmby',true);
                $deathtime = $this->input->post('deathtime',true);
                $deathDate = $this->input->post('deathDate',true);

                $new_deathDate = null;

                if (!empty($deathDate)) {
                    $parts3 = explode('/', $deathDate);
                    $new_deathDate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }

                $round_master_id_entry_round =  $this->getCurrentRound()[0]->id;

                $this->db->trans_start();

                try
                { 




                  $whereMemember = array('id' =>$member_master_id);
                  $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereMemember)->get()->row()->member_household_id_last;
                  

                  $whereExit = array('code' =>$this->config->item('exitTypeDeath'));

                  $lookExitTypeID = $this->db->select('id')->from($this->config->item('lookDetailsTable'))->where($whereExit)->get()->row()->id;


                   //member household 

                    $dethUpdate = array(
                                 'exit_date'=> $new_deathDate, 
                                 'fk_exit_type'=>$lookExitTypeID, 
                                 'round_master_id_exit_round'=>$round_master_id_entry_round, 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

                    );

                    $this->db->where('id', $member_household_id_last);
                    $this->db->where('member_master_id', $member_master_id);
                    $this->db->update($this->config->item('memberHouseholdTable'), $dethUpdate);

                    // death
                    $IdInfo = array(
                        
                        'death_date'=>$new_deathDate, 
                        'fk_death_place'=>$fk_death_place, 
                        'fk_death_cause'=>$fk_death_cause, 
                        'fk_death_type'=>$fk_death_type, 
                        'fk_death_confirmby'=>$fk_death_confirmby, 
                        'transfer_complete'=>'No',  
                        'death_time'=>$deathtime,  
                        'member_master_id'=>$member_master_id, 
                        'round_master_id'=>$round_master_id_entry_round, 
                        'household_master_id'=>$household_master_id, 
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );
                        
                   $this->deathModel->addNew($IdInfo,$this->config->item('deathTable'));
				   
				   
				   $memberUpdate = array(
                                'is_died'=>1, 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')
                    );

                    $this->modelName->editList($memberUpdate,$member_master_id,$this->config->item('memberMasterTable'));



                     $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_death'=>1, 
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
                    $this->session->set_flashdata('error', 'Error occurred while creating death.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Death created successfully.');
                
                redirect('householdvisit/death?baseID='.$baseID.'#death');
            }
        
    }


   
  
    
    
}

?>