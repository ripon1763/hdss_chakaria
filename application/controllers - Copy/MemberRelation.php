<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberRelation extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "MemberRelation";
	public $pageTitle = 'Member Relation';
	public $pageShortName = 'Member Relation';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
        $this->load->model('householdVisit_model','visitModel');
        $this->load->model('memberRelation_model','relationModel');
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
    

    public function addEditRelation($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id_current = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Relation' ;
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

            $data['relationRecord'] = $this->relationModel->getRelationDetailsByIdnHousehold($id,$data['household_master_id_sub'],$data['round_master_id']);

            //

            $data['relationhhh'] = $this->modelName->getLookUpList($this->config->item('relationhhh'));
            $data['hh_change_reason'] = $this->modelName->getLookUpList($this->config->item('hh_change_reason'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/relation_edit_details', $data);
            $this->load->view('includes/footer');
        
    }

    function editRelationDetails()
    {
          
            //print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $relationID = $this->input->post('relationID',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('relationType','Relation','trim|required|numeric');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberRelation/addEditRelation/'. $relationID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#relation');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                
                $relationType = $this->input->post('relationType',true);
                $fk_hhh_cause = $this->input->post('fk_hhh_cause',true);
                $hhdate = $this->input->post('hhdate',true);

                $new_hhdate = null;

                if (!empty($hhdate)) {
                    $parts3 = explode('/', $hhdate);
                    $new_hhdate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }

                $this->db->trans_start();

                try
                { 




                 $hhcode = $this->getLookUpDetailCode($relationType)[0]->internal_code;

                 if ($hhcode == $this->config->item('household_head_code'))
                 {
                       $head = $this->getActiveHeadDetails($household_master_id, $relationType);

                       if (!empty($head))
                       {

                          if ($head[0]->member_master_id != $member_master_id)
                          {

                            $this->session->set_flashdata('error', 'An active head of this household already exist. Plz select something different as relation to head.');
                            redirect('householdvisit/relation?baseID='.$baseID.'#relation');
                          }

 
                       }
                 }


                  $whereHouseholdMaster = array('id' =>$household_master_id);
                  $member_master_id_last_head = $this->db->select('member_master_id_last_head')->from($this->config->item('householdMasterTable'))->where($whereHouseholdMaster)->get()->row()->member_master_id_last_head;


                   // household head

                   if ($hhcode == $this->config->item('household_head_code'))
                     {


                        if ($member_master_id_last_head != $member_master_id)
                        {

                             $householdMasterNew = array(
                                'member_master_id_last_head'=>$member_master_id, 
                                'transfer_complete'=>'No',  
                                'updateBy'=>$this->vendorId, 
                                'updatedOn'=>date('Y-m-d H:i:s')
                            );

                             $this->modelName->editList($householdMasterNew,$household_master_id,$this->config->item('householdMasterTable'));

                             $householdHeadUpdate = array(
                                    'is_last_head'=>'No', 
                                    'transfer_complete'=>'No',  
                                    'updateBy'=>$this->vendorId, 
                                    'updatedOn'=>date('Y-m-d H:i:s')
                                );

                                $this->db->where('household_master_id', $household_master_id);
                                $this->db->where('is_last_head', 'Yes');
                                $this->db->update($this->config->item('memberHeadTable'), $householdHeadUpdate);


                                $whereHouseholdhead = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                                $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberHeadTable'))->where($whereHouseholdhead)->get()->row()->countRow;

                                if ($countRow > 0)
                                 {

                                    $headID = $this->db->select('id')->from($this->config->item('memberHeadTable'))->where($whereHouseholdhead)->get()->row()->id;

                                    $householdHeadup = array(
                                        'member_master_id'=>$member_master_id, 
                                        'change_date'=>$new_hhdate, 
                                        'fk_hhh_cause'=>$fk_hhh_cause, 
                                        'is_last_head'=>'Yes', 
                                        'transfer_complete'=>'No',  
                                        'updateBy'=>$this->vendorId, 
                                        'updatedOn'=>date('Y-m-d H:i:s')
                                    );

                                     $this->modelName->editList($householdHeadup,$headID,$this->config->item('memberHeadTable'));

                                 }
                                 else
                                 {

                                    $householdHeadNew = array(
                                        'member_master_id'=>$member_master_id, 
                                        'household_master_id'=>$household_master_id, 
                                        'round_master_id'=>$round_master_id, 
                                        'fk_hhh_cause'=>$fk_hhh_cause, 
                                        'change_date'=>$new_hhdate, 
                                        'is_last_head'=>'Yes', 
                                        'transfer_complete'=>'No',  
                                        'insertedBy'=>$this->vendorId, 
                                        'insertedOn'=>date('Y-m-d H:i:s')
                                    );

                                    $this->modelName->addNewList($householdHeadNew,$this->config->item('memberHeadTable'));


                                 }

                                   
    
                        }

                     }
                     else if ($member_master_id_last_head == $member_master_id)
                     {

                         //update household_head

                        $householdHeadUpdate = array(
                            'is_last_head'=>'No', 
                            'transfer_complete'=>'No',  
                            'updateBy'=>$this->vendorId, 
                            'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->db->where('household_master_id', $household_master_id);
                        $this->db->where('is_last_head', 'Yes');
                        $this->db->update($this->config->item('memberHeadTable'), $householdHeadUpdate);


                        // delete household head
                        $this->db->where('household_master_id', $member_master_id_last_head);
                        $this->db->where('round_master_id', $round_master_id);
                        $this->db->delete($this->config->item('memberHeadTable'));


                         $householdMaster = array(
                            'member_master_id_last_head'=>0, 
                            'transfer_complete'=>'No',  
                            'updateBy'=>$this->vendorId, 
                            'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->modelName->editList($householdMaster,$household_master_id,$this->config->item('householdMasterTable'));



                     }


                    $IdInfo = array(
                                        'fk_relation'=>$relationType, 
                                        'updateBy'=>$this->vendorId, 
                                        'updatedOn'=>date('Y-m-d H:i:s')
                                    );
                     
                    $this->relationModel->edit($IdInfo,$relationID);


                    $memberInfo = array(
                                        'fk_relation_with_hhh'=>$relationType, 
                                        'updateBy'=>$this->vendorId, 
                                        'updatedOn'=>date('Y-m-d H:i:s')
                                    );
                     
                     $this->modelName->editList($memberInfo,$member_master_id, $this->config->item('memberMasterTable'));


                     $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_relation'=>1, 
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
                    $this->session->set_flashdata('error', 'Error occurred while updating Relation.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Member Relation updated successfully.');
                
                redirect('householdvisit/relation?baseID='.$baseID.'#relation');
            }
        
    }


    public function addRelation($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Relation' ;
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

            $data['relationhhh'] = $this->modelName->getLookUpList($this->config->item('relationhhh'));
            $data['hh_change_reason'] = $this->modelName->getLookUpList($this->config->item('hh_change_reason'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/relation_add_details', $data);
            $this->load->view('includes/footer');
        
    }

    function addRelationDetails()
    {
          
          //  print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('relationType','Relation','trim|required|numeric');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
    
                redirect('memberRelation/addRelation/'. $member_master_id.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#occupation');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

               $whereHouseholdOccu = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id,'member_master_id'=>$member_master_id);

               $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberRelationTable'))->where($whereHouseholdOccu)->get()->row()->countRow;

               if ($countRow > 0)
               {
                  $this->session->set_flashdata('error', 'Relation already exists for this round.');
                  redirect('householdvisit/relation?baseID='.$baseID.'#relation');
               }

                
                
                $relationType = $this->input->post('relationType',true);
                $fk_hhh_cause = $this->input->post('fk_hhh_cause',true);
                $hhdate = $this->input->post('hhdate',true);

                $new_hhdate = null;

                if (!empty($hhdate)) {
                    $parts3 = explode('/', $hhdate);
                    $new_hhdate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }

                $round_master_id_entry_round =  $this->getCurrentRound()[0]->id;

                $this->db->trans_start();

                try
                { 



                $hhcode = $this->getLookUpDetailCode($relationType)[0]->internal_code;

                 if ($hhcode == $this->config->item('household_head_code'))
                 {
                       $head = $this->getActiveHeadDetails($household_master_id, $relationType);

                       if (!empty($head))
                       {

                          if ($head[0]->member_master_id != $member_master_id)
                          {

                            $this->session->set_flashdata('error', 'An active head of this household already exist. Plz select something different as relation to head.');
                            redirect('householdvisit/relation?baseID='.$baseID.'#relation');
                          }

 
                       }
                 }


                  $whereHouseholdMaster = array('id' =>$household_master_id);
                  $member_master_id_last_head = $this->db->select('member_master_id_last_head')->from($this->config->item('householdMasterTable'))->where($whereHouseholdMaster)->get()->row()->member_master_id_last_head;


                   // household head

                   if ($hhcode == $this->config->item('household_head_code'))
                     {


                        if ($member_master_id_last_head != $member_master_id)
                        {

                             $householdMasterNew = array(
                                'member_master_id_last_head'=>$member_master_id, 
                                'transfer_complete'=>'No',  
                                'updateBy'=>$this->vendorId, 
                                'updatedOn'=>date('Y-m-d H:i:s')
                            );

                             $this->modelName->editList($householdMasterNew,$household_master_id,$this->config->item('householdMasterTable'));

                             $householdHeadUpdate = array(
                                    'is_last_head'=>'No', 
                                    'transfer_complete'=>'No',  
                                    'updateBy'=>$this->vendorId, 
                                    'updatedOn'=>date('Y-m-d H:i:s')
                                );

                                $this->db->where('household_master_id', $household_master_id);
                                $this->db->where('is_last_head', 'Yes');
                                $this->db->update($this->config->item('memberHeadTable'), $householdHeadUpdate);


                                $whereHouseholdhead = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                                $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberHeadTable'))->where($whereHouseholdhead)->get()->row()->countRow;

                                if ($countRow > 0)
                                 {

                                    $headID = $this->db->select('id')->from($this->config->item('memberHeadTable'))->where($whereHouseholdhead)->get()->row()->id;

                                    $householdHeadup = array(
                                        'member_master_id'=>$member_master_id, 
                                        'fk_hhh_cause'=>$fk_hhh_cause, 
                                        'change_date'=>$new_hhdate, 
                                        'is_last_head'=>'Yes', 
                                        'transfer_complete'=>'No',  
                                        'updateBy'=>$this->vendorId, 
                                        'updatedOn'=>date('Y-m-d H:i:s')
                                    );

                                     $this->modelName->editList($householdHeadup,$headID,$this->config->item('memberHeadTable'));

                                 }
                                 else
                                 {

                                    $householdHeadNew = array(
                                        'member_master_id'=>$member_master_id, 
                                        'household_master_id'=>$household_master_id, 
                                        'round_master_id'=>$round_master_id, 
                                        'fk_hhh_cause'=>$fk_hhh_cause, 
                                        'change_date'=>$new_hhdate, 
                                        'is_last_head'=>'Yes', 
                                        'transfer_complete'=>'No',  
                                        'insertedBy'=>$this->vendorId, 
                                        'insertedOn'=>date('Y-m-d H:i:s')
                                    );

                                    $this->modelName->addNewList($householdHeadNew,$this->config->item('memberHeadTable'));


                                 }

                                   
    
                        }

                     }
                     else if ($member_master_id_last_head == $member_master_id)
                     {

                         //update household_head

                        $householdHeadUpdate = array(
                            'is_last_head'=>'No', 
                            'transfer_complete'=>'No',  
                            'updateBy'=>$this->vendorId, 
                            'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->db->where('household_master_id', $household_master_id);
                        $this->db->where('is_last_head', 'Yes');
                        $this->db->update($this->config->item('memberHeadTable'), $householdHeadUpdate);


                        // delete household head
                        $this->db->where('household_master_id', $member_master_id_last_head);
                        $this->db->where('round_master_id', $round_master_id);
                        $this->db->delete($this->config->item('memberHeadTable'));


                         $householdMaster = array(
                            'member_master_id_last_head'=>0, 
                            'transfer_complete'=>'No',  
                            'updateBy'=>$this->vendorId, 
                            'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->modelName->editList($householdMaster,$household_master_id,$this->config->item('householdMasterTable'));



                     }

                    // update  relation table


                    $relUpdate = array(
                                 'is_last_relation'=>'No', 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

                    );

                    //$this->db->where('round_master_id', $round_master_id);
                    $this->db->where('member_master_id', $member_master_id);
                    $this->db->where('is_last_relation', 'Yes');
                    $this->db->update($this->config->item('memberRelationTable'), $relUpdate);


                    $IdInfo = array(
                        
                        'fk_relation'=>$relationType, 
                        'transfer_complete'=>'No',  
                        'is_last_relation'=>'Yes',  
                        'member_master_id'=>$member_master_id, 
                        'round_master_id'=>$round_master_id_entry_round, 
                        'household_master_id'=>$household_master_id, 
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );
                        
                    $member_relation_id = $this->relationModel->addNew($IdInfo,$this->config->item('memberRelationTable'));

                    $memberUpdate = array(
                                 'fk_member_relation_id_last'=>$member_relation_id, 
                                 'fk_relation_with_hhh'=>$relationType, 
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
                        'any_relation'=>1, 
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
                    $this->session->set_flashdata('error', 'Error occurred while creating Relation.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Relation created successfully.');
                
                redirect('householdvisit/relation?baseID='.$baseID.'#relation');
            }
        
    }


   
  
    
    
}

?>