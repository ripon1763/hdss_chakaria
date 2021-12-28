<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberMigrationIn extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "memberMigrationIn";
	public $pageTitle = 'Member Movement';
	public $pageShortName = 'Member Movement';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
        $this->load->model('householdVisit_model','visitModel');
        $this->load->model('memberMigration_model','migrationModel');
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
    

    public function addEditMigration($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id_current = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Movement/Migration In' ;
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

            $data['mminRecordRecord'] = $this->migrationModel->getMigrationInDetailsByIdnHousehold($id,$data['household_master_id_sub'],$data['round_master_id']);


            $data['memberexittyp'] = $this->modelName->getLookUpListSpecific($this->config->item('mementrytyp'), array('intin','min'));
            $data['internal_movement_cause'] = $this->modelName->getLookUpList($this->config->item('internal_movement_cause'));
            $data['movement_group_typ'] = $this->modelName->getLookUpList($this->config->item('movement_group_typ'));
            $data['outside_cause'] = $this->modelName->getLookUpList($this->config->item('migReason'));
            $data['slumlist'] = $this->modelName->getListType($this->config->item('slumTable'));
            $data['countrylist'] = $this->modelName->getListType($this->config->item('countryTable'));
            $data['divisionlist'] = $this->modelName->getListType($this->config->item('divTable'));

          
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/min_edit_details', $data);
            $this->load->view('includes/footer');
        
    }

    function editMigrationDetails()
    {
          
          // print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $migrationID = $this->input->post('migrationID',true);
            $member_master_id = $this->input->post('member_master_id',true);
            $fk_movement_type = $this->input->post('fk_movement_type',true);

            $this->load->library('form_validation');

           
           // $this->form_validation->set_rules('fk_movement_type','Member movement type','trim|required|numeric');
            $this->form_validation->set_rules('movement_date','Movement/migration Date','trim|required');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberMigrationIn/addEditMigration/'. $migrationID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#migin');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                
                 $movement_date = $this->input->post('movement_date',true);
                 $remarks = $this->input->post('remarks',true);
                
                
                $fk_internal_cause = 0;
                $slumID = 0;
                $slumAreaID = 0;
                $househodID = 0;
                $fk_migration_cause = 0;
                $countryID = 0;
                $divisionID = 0;
                $districtID = 0;
                $thanaID = 0;

                // internal in movement
                
                if ($this->config->item('internalMovementIn') == $fk_movement_type) 
                {
                    
                    $fk_internal_cause = $this->input->post('fk_internal_cause',true);
                    $slumID = $this->input->post('slumID',true);
                    $slumAreaID = $this->input->post('slumAreaID',true);
                    $househodID = $this->input->post('househodID',true);
                  
                    

                }
                // migration in movement
                else if ($this->config->item('migrationInMovement') == $fk_movement_type) 
                { 
                    $fk_migration_cause = $this->input->post('fk_migration_cause',true);
                    $countryID = $this->input->post('countryID',true);
                    
                    if($this->config->item('bangladesh') == $countryID) // bangldesh 
                    {
                        $divisionID = ($this->input->post('divisionID', true))? $this->input->post('divisionID', true): 0;
                        $districtID = ($this->input->post('districtID', true))? $this->input->post('districtID', true): 0;
                        $thanaID = ($this->input->post('thanaID', true))? $this->input->post('thanaID', true): 0;
                    } 

                }

                
                if (!empty($movement_date)) {
                    $parts5 = explode('/', $movement_date);
                    $new_movement_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }
                
				

                $this->db->trans_start();

                try
                { 

                    // internal
                    if ($this->config->item('internalMovementIn') == $fk_movement_type) 
                    {
                        $IdInfo = array(
                            
                            'movement_date'=>$new_movement_date, 
                            'fk_internal_cause'=>$fk_internal_cause, 
                            'slumIDFrom'=>$slumID, 
                            'slumAreaIDFrom'=>$slumAreaID, 
                            'household_master_id_move_from'=>$househodID, 
                            'remarks'=>$remarks, 
                            'updateBy'=>$this->vendorId, 
                            'updatedOn'=>date('Y-m-d H:i:s')
                        );
                        
                        $this->migrationModel->editMigrationIn($IdInfo,$migrationID);

                         // member household

                        $whereMigout = array('id' =>$member_master_id);
                        $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereMigout)->get()->row()->member_household_id_last;
                    

                        $memberHouseholdUpdate = array(
                                     'entry_date'=>$new_movement_date,
                                     'updateBy'=>$this->vendorId, 
                                     'updatedOn'=>date('Y-m-d H:i:s')

                        );

                        $this->modelName->editList($memberHouseholdUpdate,$member_household_id_last,$this->config->item('memberHouseholdTable'));
  
                    }

                    // migration in
                   else
                    {

                        $IdInfo = array(
                            
                            'movement_date'=>$new_movement_date, 
                            'fk_migration_cause'=>$fk_migration_cause,
                            'countryIDMoveFrom'=>$countryID, 
                            'divisionIDMoveFrom'=>$divisionID, 
                            'districtIDMoveFrom'=>$districtID, 
                            'thanaIDMoveFrom'=>$thanaID, 
                            'remarks'=>$remarks, 
                            'updateBy'=>$this->vendorId, 
                            'updatedOn'=>date('Y-m-d H:i:s')
                        );
      
                        $this->migrationModel->editMigrationIn($IdInfo,$migrationID);
                    

                        // update member household info

                        $whereMigout = array('id' =>$member_master_id);
                        $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereMigout)->get()->row()->member_household_id_last;
                    

                        $memberHouseholdUpdate = array(
                                     'entry_date'=>$new_movement_date,
                                     'updateBy'=>$this->vendorId, 
                                     'updatedOn'=>date('Y-m-d H:i:s')

                        );

                        $this->modelName->editList($memberHouseholdUpdate,$member_household_id_last,$this->config->item('memberHouseholdTable'));
                    }
                    
                        
                    $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_migration_in'=>1, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->modelName->editList($householdVisit,$visitID,$this->config->item('householdVisitTable'));

                     }
				    
                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating movement/migration in.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Movement/Migration in updated successfully.');
                
                redirect('householdvisit/migin?baseID='.$baseID.'#migin');
            }
        
    }


    public function addMigrationIn()
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Internal/Migration in' ;
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

            //$data['memberInfo'] = $this->memberModel->getListInfo($id, $this->config->item('memberMasterTable'));

			$data['memberexittyp'] = $this->modelName->getLookUpListSpecific($this->config->item('mementrytyp'), array('intin','min'));
            $data['internal_movement_cause'] = $this->modelName->getLookUpList($this->config->item('internal_movement_cause'));
            $data['movement_group_typ'] = $this->modelName->getLookUpList($this->config->item('movement_group_typ'));
            $data['outside_cause'] = $this->modelName->getLookUpList($this->config->item('migReason'));
            $data['slumlist'] = $this->modelName->getListType($this->config->item('slumTable'));
            $data['countrylist'] = $this->modelName->getListType($this->config->item('countryTable'));
            $data['divisionlist'] = $this->modelName->getListType($this->config->item('divTable'));
          
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/min_add_details', $data);
            $this->load->view('includes/footer');
        
    }

    function addMigrationDetails()
    {
          
            // print_r($this->input->post()); die();

            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
           // $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('fk_movement_type','Member movement type','trim|required|numeric');
            $this->form_validation->set_rules('movement_date','Movement/migration Date','trim|required');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
    
                redirect('memberMigrationIn/addMigrationIn?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#migin');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                $fk_movement_type = $this->input->post('fk_movement_type',true);
                $movement_date = $this->input->post('movement_date',true);
                $remarks = $this->input->post('remarks',true);
                
                
                $fk_internal_cause = 0;
                $slumID = 0;
                $slumAreaID = 0;
                $househodID = 0;
                $fk_migration_cause = 0;
                $countryID = 0;
                $divisionID = 0;
                $districtID = 0;
                $thanaID = 0;

                // internal in movement
                
                if ($this->config->item('internalMovementIn') == $fk_movement_type) 
                {
                    
                    $fk_internal_cause = $this->input->post('fk_internal_cause',true);
                    $slumID = $this->input->post('slumID',true);
                    $slumAreaID = $this->input->post('slumAreaID',true);
                    $househodID = $this->input->post('househodID',true);
                    $member_master_id = $this->input->post('member_id',true);



                    $whereHHold = array('id' =>$member_master_id);
                    $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereHHold)->get()->row()->member_household_id_last;

                    $fk_exit_type = $this->db->select('fk_exit_type')->from($this->config->item('memberHouseholdTable'))->where($whereHHold)->get()->row()->fk_exit_type;

                    if ($fk_exit_type != $this->config->item('internalMovement'))
                    {
                          
                          $this->session->set_flashdata('error', 'Selected member is not internal out yet. Please internal out first ');
                          redirect('memberMigrationIn/addMigrationIn?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#migin');
                    }

                    

                }
                // migration in movement
                else if ($this->config->item('migrationInMovement') == $fk_movement_type) 
                { 
                    $fk_migration_cause = $this->input->post('fk_migration_cause',true);

                    $countryID = $this->input->post('countryID',true);
                    $member_master_id = $this->input->post('member_idin',true);


                    
                    if($this->config->item('bangladesh') == $countryID) // bangldesh 
                    {
                        $divisionID = ($this->input->post('divisionID', true))? $this->input->post('divisionID', true): 0;
                        $districtID = ($this->input->post('districtID', true))? $this->input->post('districtID', true): 0;
                        $thanaID = ($this->input->post('thanaID', true))? $this->input->post('thanaID', true): 0;
                    }

                    $flag = 0;


                    $whereHHold = array('id' =>$member_master_id);
                    $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereHHold)->get()->row()->member_household_id_last;

                    $fk_exit_type = $this->db->select('fk_exit_type')->from($this->config->item('memberHouseholdTable'))->where($whereHHold)->get()->row()->fk_exit_type;

                    if ($fk_exit_type == $this->config->item('migrationOutMovement'))
                    {
                          
                        $flag = 1;  
                    }

                    $whereHHoldMem = array('member_master_id' =>$member_master_id);

                       $household_master_id_hhh = $this->db->select('household_master_id')->from($this->config->item('memberHouseholdTable'))->where($whereHHoldMem)->get()->row()->household_master_id;

                    if ($household_master_id_hhh == 0)
                    {
                        $flag = 1;  
                    }


                    if ($flag == 0)
                    {
                        
                         $this->session->set_flashdata('error', 'Selected member is not migration out yet. Please migration out first ');
                        redirect('memberMigrationIn/addMigrationIn?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#migin');
                    }

                }

               $whereHouseholdmar = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id,'member_master_id'=>$member_master_id);

               $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('migrationInTable'))->where($whereHouseholdmar)->get()->row()->countRow;

               if ($countRow > 0)
               {
                  $this->session->set_flashdata('error', 'This Member movement already exists for this round.');
                  redirect('householdvisit/migin?baseID='.$baseID.'#migin');
               }

                
                
				
				if (!empty($movement_date)) {
                    $parts5 = explode('/', $movement_date);
                    $new_movement_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }
				
                $round_master_id_entry_round =  $this->getCurrentRound()[0]->id;


                 

                $this->db->trans_start();

                try
                { 

                     $membercode = $this->getMemberCodebyCID($household_master_id);

                     // internal in

                    if ($this->config->item('internalMovementIn') == $fk_movement_type) 
                    {
                        $IdInfo = array(
                            
                            'fk_movement_type'=>$fk_movement_type, 
                            'movement_date'=>$new_movement_date, 
                            'fk_internal_cause'=>$fk_internal_cause, 
                            'slumIDFrom'=>$slumID, 
                            'slumAreaIDFrom'=>$slumAreaID, 
                            'household_master_id_move_from'=>$househodID, 
                            'remarks'=>$remarks, 
                            'transfer_complete'=>'No',  
                            'member_master_id'=>$member_master_id, 
                            'round_master_id'=>$round_master_id_entry_round, 
                            'household_master_id'=>$household_master_id, 
                            'insertedBy'=>$this->vendorId, 
                            'insertedOn'=>date('Y-m-d H:i:s')
                        );
      
                        $this->migrationModel->addNew($IdInfo,$this->config->item('migrationInTable'));

                         // member household


                        $memberHousehold = array(
                            'household_master_id'=>$household_master_id, 
                            'is_last_household'=>'Yes', 
                            'member_master_id'=>$member_master_id, 
                            'fk_entry_type'=>$fk_movement_type, 
                            'entry_date'=>$new_movement_date, 
                            'round_master_id_entry_round'=>$round_master_id, 
                            'current_indenttification_id'=>$membercode, 
                            'transfer_complete'=>'No',  
                            'insertedBy'=>$this->vendorId, 
                            'insertedOn'=>date('Y-m-d H:i:s')
                        );

                        $member_household_id = $this->modelName->addNewList($memberHousehold,$this->config->item('memberHouseholdTable'));

                        // member master

                        $memberUpdate = array(
                                    'member_household_id_last'=>$member_household_id, 
                                    'household_master_id_hh'=>$household_master_id, 
                                    'fk_relation_with_hhh'=>0, 
                                    'fk_education_id_last'=>0, 
                                    'fk_occupation_id_last'=>0,
                                    'fk_member_relation_id_last'=>0
                        );

                        $this->modelName->editList($memberUpdate,$member_master_id,$this->config->item('memberMasterTable'));

                    }

                    // migration in
                   else
                    {

                        $IdInfo = array(
                            
                            'fk_movement_type'=>$fk_movement_type, 
                            'movement_date'=>$new_movement_date, 
    						'fk_migration_cause'=>$fk_migration_cause,
    						'countryIDMoveFrom'=>$countryID, 
    						'divisionIDMoveFrom'=>$divisionID, 
    						'districtIDMoveFrom'=>$districtID, 
    						'thanaIDMoveFrom'=>$thanaID, 
    						'remarks'=>$remarks, 
                            'transfer_complete'=>'No',  
                            'member_master_id'=>$member_master_id, 
                            'round_master_id'=>$round_master_id_entry_round, 
                            'household_master_id'=>$household_master_id, 
                            'insertedBy'=>$this->vendorId, 
                            'insertedOn'=>date('Y-m-d H:i:s')
                        );
      
                        $this->migrationModel->addNew($IdInfo,$this->config->item('migrationInTable'));
					

    					// update member household info

                        $whereHH = array('id' =>$member_master_id);
                        $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereHH)->get()->row()->member_household_id_last;

                        $memberHouseholdUpdate = array(
                                     'household_master_id'=>$household_master_id, 
                                     'fk_entry_type'=>$fk_movement_type, 
                                     'round_master_id_entry_round'=>$round_master_id_entry_round, 
                                     'current_indenttification_id'=>$membercode, 
                                     'updateBy'=>$this->vendorId, 
                                     'updatedOn'=>date('Y-m-d H:i:s')

                        );

                        $this->modelName->editList($memberHouseholdUpdate,$member_household_id_last,$this->config->item('memberHouseholdTable'));

                        //update member relation

                        $fk_member_relation_id_last = $this->db->select('fk_member_relation_id_last')->from($this->config->item('memberMasterTable'))->where($whereHH)->get()->row()->fk_member_relation_id_last;
                        
                        $memberHRelation = array(
                                     'household_master_id'=>$household_master_id, 
                                     'updateBy'=>$this->vendorId, 
                                     'updatedOn'=>date('Y-m-d H:i:s')

                        );

                        $this->modelName->editList($memberHRelation,$fk_member_relation_id_last,$this->config->item('memberRelationTable'));

                        // // update member education

                        $fk_education_id_last = $this->db->select('fk_education_id_last')->from($this->config->item('memberMasterTable'))->where($whereHH)->get()->row()->fk_education_id_last;
                        

                        $memberEducation = array(
                                     'household_master_id'=>$household_master_id, 
                                     'updateBy'=>$this->vendorId, 
                                     'updatedOn'=>date('Y-m-d H:i:s')

                        );

                        $this->modelName->editList($memberEducation,$fk_education_id_last,$this->config->item('memberEducationTable'));

                        //  // update member occupation

                        $fk_occupation_id_last = $this->db->select('fk_occupation_id_last')->from($this->config->item('memberMasterTable'))->where($whereHH)->get()->row()->fk_occupation_id_last;
                        
                        $memberOccupation = array(
                                     'household_master_id'=>$household_master_id, 
                                     'updateBy'=>$this->vendorId, 
                                     'updatedOn'=>date('Y-m-d H:i:s')

                        );

                        $this->modelName->editList($memberOccupation,$fk_occupation_id_last,$this->config->item('memberOccupationTable'));



                        $memberMaster = array(
                                     'household_master_id_hh'=>$household_master_id, 
                                     'member_code'=>$membercode, 
                                     'updateBy'=>$this->vendorId, 
                                     'updatedOn'=>date('Y-m-d H:i:s')

                        );

                        $this->modelName->editList($memberMaster,$member_master_id,$this->config->item('memberMasterTable'));
                    }
                    
    					
                    $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_migration_in'=>1, 
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
                    $this->session->set_flashdata('error', 'Error occurred while creating movement/migration.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','movement/migration created successfully.');
                
                redirect('householdvisit/migin?baseID='.$baseID.'#migin');
            }
        
    }
	
	
		
	// function addNewMemberSubmit()
 //    {


	//     $baseID = $this->input->get('baseID', TRUE);
	//     echo $memberName = $this->input->post('memberName',TRUE);
	//     echo $birthdate = $this->input->post('birthdate',TRUE);
		
 //      // echo  json_encode($data);
 //      // exit;
 //    }
	 
	

    
    
}

?>