<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberMigrationOut extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "memberMigrationOut";
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
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Migration Out' ;
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

            $data['moutRecordRecord'] = $this->migrationModel->getMigrationOutDetailsByIdnHousehold($id,$data['household_master_id_sub'],$data['round_master_id']);


            $data['memberexittyp'] = $this->modelName->getLookUpListNotSpecific($this->config->item('member_exit_typ'), array('dth','ext'));
            $data['internal_movement_cause'] = $this->modelName->getLookUpList($this->config->item('internal_movement_cause'));
            $data['movement_group_typ'] = $this->modelName->getLookUpList($this->config->item('movement_group_typ'));
            $data['outside_cause'] = $this->modelName->getLookUpList($this->config->item('outside_cause'));
            $data['slumlist'] = $this->modelName->getListType($this->config->item('slumTable'));
            $data['countrylist'] = $this->modelName->getListType($this->config->item('countryTable'));
            $data['divisionlist'] = $this->modelName->getListType($this->config->item('divTable'));
          
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/mout_edit_details', $data);
            $this->load->view('includes/footer');
        
    }

    function editMigrationDetails()
    {
          
          // print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $migrationID = $this->input->post('migrationID',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

           
            $this->form_validation->set_rules('fk_movement_type','Member movement type','trim|required|numeric');
            $this->form_validation->set_rules('movement_date','Movement/migration Date','trim|required');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberMigrationOut/addEditMigration/'. $migrationID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#migout');

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
                $fk_type_of_group = 0;
                $fk_outside_cause_individual = 0;
                $fk_outside_cause_group = 0;
                $countryID = 0;
                $divisionID = 0;
                $districtID = 0;
                $thanaID = 0;
                
                if ($this->config->item('internalMovement') == $fk_movement_type) // internal movement
                {
                    $fk_internal_cause = $this->input->post('fk_internal_cause',true);
                    $slumID = $this->input->post('slumID',true);
                    $slumAreaID = $this->input->post('slumAreaID',true);
                    $househodID = $this->input->post('househodID',true);
                }
                else if ($this->config->item('migrationOutMovement') == $fk_movement_type) // migration movement
                { 
                    $fk_type_of_group = $this->input->post('fk_type_of_group',true);
                    $fk_outside_cause_individual = ($this->input->post('fk_outside_cause_individual', true))? $this->input->post('fk_outside_cause_individual', true): 0;
                    $fk_outside_cause_group = ($this->input->post('fk_outside_cause_group', true))? $this->input->post('fk_outside_cause_group', true): 0;
                    $countryID = $this->input->post('countryID',true);
                    
                    if($this->config->item('bangladesh') == $countryID) // bangldesh 
                    {
                        $divisionID = ($this->input->post('divisionID', true))? $this->input->post('divisionID', true): 0;
                        $districtID = ($this->input->post('districtID', true))? $this->input->post('districtID', true): 0;
                        $thanaID = ($this->input->post('thanaID', true))? $this->input->post('thanaID', true): 0;
                    }
                }
                else
                {
                }
                
                
                if (!empty($movement_date)) {
                    $parts5 = explode('/', $movement_date);
                    $new_movement_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }
				

                $this->db->trans_start();

                try
                { 
				

                     $IdInfo = array(
                        
                        'fk_movement_type'=>$fk_movement_type, 
                        'movement_date'=>$new_movement_date, 
                        'fk_internal_cause'=>$fk_internal_cause, 
                        'slumIDTo'=>$slumID, 
                        'slumAreaIDTo'=>$slumAreaID, 
                        'household_master_id_move_to'=>$househodID, 
                        'fk_type_of_group'=>$fk_type_of_group, 
                        'fk_outside_cause_individual'=>$fk_outside_cause_individual, 
                        'fk_outside_cause_group'=>$fk_outside_cause_group, 
                        'countryIDMoveTo'=>$countryID, 
                        'divisionIDMoveTo'=>$divisionID, 
                        'districtIDMoveTo'=>$districtID, 
                        'thanaIDMoveTo'=>$thanaID, 
                        'remarks'=>$remarks, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );
                        
					$this->migrationModel->editMigrationOut($IdInfo,$migrationID);
					
					
					// update member household info

                    $whereMigout = array('id' =>$member_master_id);
                    $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereMigout)->get()->row()->member_household_id_last;
                    

                    $memberHouseholdUpdate = array(
                                 'fk_exit_type'=>$fk_movement_type, 
                                 'exit_date'=>$new_movement_date,
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

                    );

                    $this->modelName->editList($memberHouseholdUpdate,$member_household_id_last,$this->config->item('memberHouseholdTable'));
  
                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating movement/migration out.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Movement/Migration out updated successfully.');
                
                redirect('householdvisit/migout?baseID='.$baseID.'#migout');
            }
        
    }


    public function addMigrationOut($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Migration Out' ;
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

 

			$data['memberexittyp'] = $this->modelName->getLookUpListNotSpecific($this->config->item('member_exit_typ'), array('dth','ext'));
            $data['internal_movement_cause'] = $this->modelName->getLookUpList($this->config->item('internal_movement_cause'));
            $data['movement_group_typ'] = $this->modelName->getLookUpList($this->config->item('movement_group_typ'));
            $data['outside_cause'] = $this->modelName->getLookUpList($this->config->item('outside_cause'));
            $data['slumlist'] = $this->modelName->getListType($this->config->item('slumTable'));
            $data['countrylist'] = $this->modelName->getListType($this->config->item('countryTable'));
            $data['divisionlist'] = $this->modelName->getListType($this->config->item('divTable'));
          
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/mout_add_details', $data);
            $this->load->view('includes/footer');
        
    }

    function addMigrationDetails()
    {
          
            //print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('fk_movement_type','Member movement type','trim|required|numeric');
            $this->form_validation->set_rules('movement_date','Movement/migration Date','trim|required');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
    
                redirect('memberMigrationOut/addMigrationOut/'. $member_master_id.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#migout');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

               $whereHouseholdmar = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id,'member_master_id'=>$member_master_id);

               $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('migrationOutTable'))->where($whereHouseholdmar)->get()->row()->countRow;

               if ($countRow > 0)
               {
                  $this->session->set_flashdata('error', 'This Member movement already exists for this round.');
                  redirect('householdvisit/migout?baseID='.$baseID.'#migout');
               }

                
                
                $fk_movement_type = $this->input->post('fk_movement_type',true);
                $movement_date = $this->input->post('movement_date',true);
				
				
                $remarks = $this->input->post('remarks',true);
				
				
                $fk_internal_cause = 0;
				$slumID = 0;
				$slumAreaID = 0;
				$househodID = 0;
				$fk_type_of_group = 0;
				$fk_outside_cause_individual = 0;
				$fk_outside_cause_group = 0;
				$countryID = 0;
				$divisionID = 0;
				$districtID = 0;
				$thanaID = 0;
				
				if ($this->config->item('internalMovement') == $fk_movement_type) // internal movement
				{
					$fk_internal_cause = $this->input->post('fk_internal_cause',true);
					$slumID = $this->input->post('slumID',true);
					$slumAreaID = $this->input->post('slumAreaID',true);
					$househodID = $this->input->post('househodID',true);
				}
				else if ($this->config->item('migrationOutMovement') == $fk_movement_type) // migration movement
				{ 
					$fk_type_of_group = $this->input->post('fk_type_of_group',true);
					$fk_outside_cause_individual = ($this->input->post('fk_outside_cause_individual', true))? $this->input->post('fk_outside_cause_individual', true): 0;
					$fk_outside_cause_group = ($this->input->post('fk_outside_cause_group', true))? $this->input->post('fk_outside_cause_group', true): 0;
					$countryID = $this->input->post('countryID',true);
					
					if($this->config->item('bangladesh') == $countryID) // bangldesh 
					{
						$divisionID = ($this->input->post('divisionID', true))? $this->input->post('divisionID', true): 0;
						$districtID = ($this->input->post('districtID', true))? $this->input->post('districtID', true): 0;
						$thanaID = ($this->input->post('thanaID', true))? $this->input->post('thanaID', true): 0;
					}
				}
				else
				{
				}
				
				
				if (!empty($movement_date)) {
                    $parts5 = explode('/', $movement_date);
                    $new_movement_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }
				
                $round_master_id_entry_round =  $this->getCurrentRound()[0]->id;

                $this->db->trans_start();

                try
                { 

                    $IdInfo = array(
                        
                        'fk_movement_type'=>$fk_movement_type, 
                        'movement_date'=>$new_movement_date, 
                        'fk_internal_cause'=>$fk_internal_cause, 
                        'slumIDTo'=>$slumID, 
                        'slumAreaIDTo'=>$slumAreaID, 
                        'household_master_id_move_to'=>$househodID, 
						'fk_type_of_group'=>$fk_type_of_group, 
						'fk_outside_cause_individual'=>$fk_outside_cause_individual, 
						'fk_outside_cause_group'=>$fk_outside_cause_group, 
						'countryIDMoveTo'=>$countryID, 
						'divisionIDMoveTo'=>$divisionID, 
						'districtIDMoveTo'=>$districtID, 
						'thanaIDMoveTo'=>$thanaID, 
						'remarks'=>$remarks, 
                        'transfer_complete'=>'No',  
                        'member_master_id'=>$member_master_id, 
                        'round_master_id'=>$round_master_id_entry_round, 
                        'household_master_id'=>$household_master_id, 
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );
                        
                    $this->migrationModel->addNew($IdInfo,$this->config->item('migrationOutTable'));
					
					
					$whereMigout = array('id' =>$member_master_id);
                    $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereMigout)->get()->row()->member_household_id_last;
					
					
					// update member household info

                    $memberHouseholdUpdate = array(
                                 'fk_exit_type'=>$fk_movement_type, 
                                 'exit_date'=>$new_movement_date,
                                 'round_master_id_exit_round'=>$round_master_id_entry_round, 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

                    );

                    $this->modelName->editList($memberHouseholdUpdate,$member_household_id_last,$this->config->item('memberHouseholdTable'));
					


                    $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_migration_out'=>1, 
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
                    $this->session->set_flashdata('error', 'Error occurred while creating migration.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Migration created successfully.');
                
                redirect('householdvisit/migout?baseID='.$baseID.'#migout');
            }
        
    }


   
  
    
    
}

?>