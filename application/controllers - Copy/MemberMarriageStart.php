<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberMarriageStart extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "memberMarriageStart";
	public $pageTitle = 'Member Marriage Start';
	public $pageShortName = 'Member Marriage Start';
	
	 
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
    

    public function addEditMarriageStart($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id_current = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Marriage Start' ;
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

            $data['mstartRecordRecord'] = $this->marriageModel->getMarriageStartDetailsByIdnHousehold($id,$data['household_master_id_sub'],$data['round_master_id']);

            //

            $data['maritalstatustyp'] = $this->modelName->getLookUpList($this->config->item('maritalstatustyp'));
            $data['marriage_order'] = $this->modelName->getLookUpList($this->config->item('marriage_order'));
            $data['marriage_registration'] = $this->modelName->getLookUpList($this->config->item('marriage_registration'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/mstart_edit_details', $data);
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

           
            $this->form_validation->set_rules('fk_member_premarital_status','Member previous marital status','trim|required|numeric');
            $this->form_validation->set_rules('fk_member_marital_order','Member marital order','trim|required|numeric');
            $this->form_validation->set_rules('fk_bri_gem_premarital_status','Bride/Groom previous marital status','trim|required|numeric');
            $this->form_validation->set_rules('fk_bri_gem_marital_order','Bride/Groom marital order','trim|required|numeric');
            $this->form_validation->set_rules('marriage_date','Marriage Date','trim|required');
            $this->form_validation->set_rules('fk_kazi_registered','Kazi registered','trim|required|numeric');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberMarriageStart/addEditMarriageStart/'. $marriageID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#mstart');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                
                $fk_member_premarital_status = $this->input->post('fk_member_premarital_status',true);
                $fk_member_marital_order = $this->input->post('fk_member_marital_order',true);
                $fk_bri_gem_premarital_status = $this->input->post('fk_bri_gem_premarital_status',true);
                $fk_bri_gem_marital_order = $this->input->post('fk_bri_gem_marital_order',true);
                $marriage_date = $this->input->post('marriage_date',true);
                $fk_kazi_registered = $this->input->post('fk_kazi_registered',true);
                $remarks = $this->input->post('remarks',true);
                $is_event = $this->input->post('is_event',true);
				
                $prev_spause_id = $this->input->post('prev_spause_id',true);
				
				
				if (!empty($marriage_date)) {
                    $parts5 = explode('/', $marriage_date);
                    $new_marriage_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }
				
                $member_id = $this->input->post('member_id',true);
				
				$member_code = '';
				$member_code_spause = '';
				$bride_groom_id = 0;
                
                $member_master_id_bride_groom = $this->input->post('member_master_id_bride_groom',true);
                $full_code = $this->input->post('full_code',true);
				
				if (!empty($full_code))
				{
					$member_code = $this->input->post('member_code',true);
					$bride_groom_id = $this->input->post('member_id',true);
					
					$wherememberCode = array('id'=>$member_master_id);
				    $member_code_spause = $this->db->select('member_code')->from($this->config->item('memberMasterTable'))->where($wherememberCode)->get()->row()->member_code;
							
				}

                $this->db->trans_start();

                try
                { 
				
				    $IdInfo = array(
                        
                        'fk_member_premarital_status'=>$fk_member_premarital_status, 
                        'fk_member_marital_order'=>$fk_member_marital_order, 
                        'fk_bri_gem_premarital_status'=>$fk_bri_gem_premarital_status, 
                        'fk_bri_gem_marital_order'=>$fk_bri_gem_marital_order, 
                        'marriage_date'=>$new_marriage_date, 
                        'fk_kazi_registered'=>$fk_kazi_registered, 
                        'member_master_id_bride_groom'=>$bride_groom_id, 
                        'remarks'=>$remarks, 
                        'is_event'=>$is_event, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );
                        
					$this->marriageModel->edit($IdInfo,$marriageID);
					
					
					// update member info

                    $memberUpdate = array(
                                 'spouse_code'=>$member_code, 
                                 'fk_spouse_id'=>$bride_groom_id, 
                                 'fk_marital_status'=>$this->config->item('maritalStatusMarried'), 
								 'last_marriage_date'=>$new_marriage_date, 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

                    );

                    $this->modelName->editList($memberUpdate,$member_master_id,$this->config->item('memberMasterTable'));
					
					
					// update previous spause info
					
					if ($prev_spause_id > 0)
					{
						    $memberUpdateBrideGroomPrev = array(
                                 'spouse_code'=>'', 
                                 'fk_spouse_id'=>0, 
                                 'fk_marital_status'=>$this->config->item('maritalStatusUnMarried'), 
								 'last_marriage_date'=> null, 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

							);

							$this->modelName->editList($memberUpdateBrideGroomPrev,$prev_spause_id,$this->config->item('memberMasterTable'));
					}
					
					// update spause info
					
					if ($bride_groom_id > 0)
					{
						    $memberUpdateBrideGroom = array(
                                 'spouse_code'=>$member_code_spause, 
                                 'fk_spouse_id'=>$member_master_id, 
                                 'fk_marital_status'=>$this->config->item('maritalStatusMarried'), 
								 'last_marriage_date'=>$new_marriage_date, 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

							);

							$this->modelName->editList($memberUpdateBrideGroom,$bride_groom_id,$this->config->item('memberMasterTable'));
					}

                   
                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating marriage start.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Member Marriage updated successfully.');
                
                redirect('householdvisit/marriage_start?baseID='.$baseID.'#mstart');
            }
        
    }


    public function addMarriageStart($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Marriage Start' ;
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

            $data['maritalstatustyp'] = $this->modelName->getLookUpList($this->config->item('maritalstatustyp'));
            $data['marriage_order'] = $this->modelName->getLookUpList($this->config->item('marriage_order'));
            $data['marriage_registration'] = $this->modelName->getLookUpList($this->config->item('marriage_registration'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/mstart_add_details', $data);
            $this->load->view('includes/footer');
        
    }

    function addMarriageDetails()
    {
          
            //print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('fk_member_premarital_status','Member previous marital status','trim|required|numeric');
            $this->form_validation->set_rules('fk_member_marital_order','Member marital order','trim|required|numeric');
            $this->form_validation->set_rules('fk_bri_gem_premarital_status','Bride/Groom previous marital status','trim|required|numeric');
            $this->form_validation->set_rules('fk_bri_gem_marital_order','Bride/Groom marital order','trim|required|numeric');
            $this->form_validation->set_rules('marriage_date','Marriage Date','trim|required');
            $this->form_validation->set_rules('fk_kazi_registered','Kazi registered','trim|required|numeric');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
    
                redirect('memberMarriageStart/addMarriageStart/'. $member_master_id.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#mstart');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

               $whereHouseholdmar = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id,'member_master_id'=>$member_master_id);

               $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('marriageStartTable'))->where($whereHouseholdmar)->get()->row()->countRow;

               if ($countRow > 0)
               {
                  $this->session->set_flashdata('error', 'Marriage already exists for this round.');
                  redirect('householdvisit/marriage_start?baseID='.$baseID.'#mstart');
               }

                
                
                $fk_member_premarital_status = $this->input->post('fk_member_premarital_status',true);
                $fk_member_marital_order = $this->input->post('fk_member_marital_order',true);
                $fk_bri_gem_premarital_status = $this->input->post('fk_bri_gem_premarital_status',true);
                $fk_bri_gem_marital_order = $this->input->post('fk_bri_gem_marital_order',true);
                $marriage_date = $this->input->post('marriage_date',true);
                $fk_kazi_registered = $this->input->post('fk_kazi_registered',true);
                $remarks = $this->input->post('remarks',true);
                $is_event = $this->input->post('is_event',true);
				
				
				if (!empty($marriage_date)) {
                    $parts5 = explode('/', $marriage_date);
                    $new_marriage_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }
				
                $member_id = $this->input->post('member_id',true);
				
				$member_code = '';
				$member_code_spause = '';
				$bride_groom_id = 0;
                
                $member_master_id_bride_groom = $this->input->post('member_master_id_bride_groom',true);
                $full_code = $this->input->post('full_code',true);
				
				if ($member_master_id_bride_groom > 0)
				{
					$member_code = $this->input->post('member_code',true);
					$bride_groom_id = $this->input->post('member_master_id_bride_groom',true);
					
					$wherememberCode = array('id'=>$member_master_id);
				    $member_code_spause = $this->db->select('member_code')->from($this->config->item('memberMasterTable'))->where($wherememberCode)->get()->row()->member_code;
							
				}

                $round_master_id_entry_round =  $this->getCurrentRound()[0]->id;

                $this->db->trans_start();

                try
                { 

                    $IdInfo = array(
                        
                        'fk_member_premarital_status'=>$fk_member_premarital_status, 
                        'fk_member_marital_order'=>$fk_member_marital_order, 
                        'fk_bri_gem_premarital_status'=>$fk_bri_gem_premarital_status, 
                        'fk_bri_gem_marital_order'=>$fk_bri_gem_marital_order, 
                        'marriage_date'=>$new_marriage_date, 
                        'fk_kazi_registered'=>$fk_kazi_registered, 
                        'member_master_id_bride_groom'=>$bride_groom_id, 
                        'remarks'=>$remarks, 
                        'is_event'=>$is_event, 
                        'transfer_complete'=>'No',  
                        'member_master_id'=>$member_master_id, 
                        'round_master_id'=>$round_master_id_entry_round, 
                        'household_master_id'=>$household_master_id, 
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );
                        
                    $this->marriageModel->addNew($IdInfo,$this->config->item('marriageStartTable'));
					
					
					// update member info

                    $memberUpdate = array(
                                 'spouse_code'=>$member_code, 
                                 'fk_spouse_id'=>$bride_groom_id, 
                                 'fk_marital_status'=>$this->config->item('maritalStatusMarried'), 
                                 'last_marriage_date'=>$new_marriage_date, 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

                    );

                    $this->modelName->editList($memberUpdate,$member_master_id,$this->config->item('memberMasterTable'));
					
					// update spause info
					
					if ($bride_groom_id > 0)
					{
						    $memberUpdateBrideGroom = array(
                                 'spouse_code'=>$member_code_spause, 
                                 'fk_spouse_id'=>$member_master_id, 
                                 'fk_marital_status'=>$this->config->item('maritalStatusMarried'), 
								 'last_marriage_date'=>$new_marriage_date, 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

							);

							$this->modelName->editList($memberUpdateBrideGroom,$bride_groom_id,$this->config->item('memberMasterTable'));
					}

                    $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_marriage_start'=>1, 
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
                
                redirect('householdvisit/marriage_start?baseID='.$baseID.'#mstart');
            }
        
    }


   
  
    
    
}

?>