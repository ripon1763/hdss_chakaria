<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberOccupation extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "memberOccupation";
	public $pageTitle = 'Member Occupation';
	public $pageShortName = 'Member Occupation';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
        $this->load->model('householdVisit_model','visitModel');
        $this->load->model('memberOccupation_model','occupationModel');
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
    

    public function addEditOccupation($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id_current = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Occupation' ;
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

            $data['occupationRecord'] = $this->occupationModel->getOccupationDetailsByIdnHousehold($id,$data['household_master_id_sub'],$data['round_master_id']);

            //

            $data['occupationtyp'] = $this->modelName->getLookUpList($this->config->item('occupationtyp'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/occupation_edit_details', $data);
            $this->load->view('includes/footer');
        
    }

    function editOccupationDetails()
    {
          
            //print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $occupationID = $this->input->post('occupationID',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('occupationType','Main Occupation','trim|required|numeric');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberOccupation/addEditOccupation/'. $occupationID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#occupation');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                
                $occupationType = $this->input->post('occupationType',true);
                $main_occupation_oth = $this->input->post('main_occupation_oth',true);

                $this->db->trans_start();

                try
                { 

                    $IdInfo = array(
                        'fk_main_occupation'=>$occupationType, 
                        'main_occupation_oth'=>$main_occupation_oth, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );

                        
                    $this->occupationModel->edit($IdInfo,$occupationID);


                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating occupation.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Member occupation updated successfully.');
                
                redirect('householdvisit/occupation?baseID='.$baseID.'#occupation');
            }
        
    }


    public function addOccupation($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Occupation' ;
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

            $data['occupationtyp'] = $this->modelName->getLookUpList($this->config->item('occupationtyp'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/occupation_add_details', $data);
            $this->load->view('includes/footer');
        
    }

    function addOccupationDetails()
    {
          
          //  print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('occupationType','Occupation','trim|required|numeric');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
    
                redirect('memberOccupation/addOccupation/'. $member_master_id.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#occupation');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

               $whereHouseholdOccu = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id,'member_master_id'=>$member_master_id);

               $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberOccupationTable'))->where($whereHouseholdOccu)->get()->row()->countRow;

               if ($countRow > 0)
               {
                  $this->session->set_flashdata('error', 'Occupation already exists for this round.');
                  redirect('householdvisit/occupation?baseID='.$baseID.'#occupation');
               }

                
                
                $occupationType = $this->input->post('occupationType',true);
                $main_occupation_oth = $this->input->post('main_occupation_oth',true);

                $round_master_id_entry_round =  $this->getCurrentRound()[0]->id;

                $this->db->trans_start();

                try
                { 


                    $occuUpdate = array(
                                 'is_last_occupation'=>'No', 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

                    );

                    //$this->db->where('round_master_id', $round_master_id);
                    $this->db->where('member_master_id', $member_master_id);
                    $this->db->where('is_last_occupation', 'Yes');
                    $this->db->update($this->config->item('memberOccupationTable'), $occuUpdate);


                    $IdInfo = array(
                        
                        'fk_main_occupation'=>$occupationType, 
                        'main_occupation_oth'=>$main_occupation_oth, 
                        'transfer_complete'=>'No',  
                        'is_last_occupation'=>'Yes',  
                        'member_master_id'=>$member_master_id, 
                        'round_master_id'=>$round_master_id_entry_round, 
                        'household_master_id'=>$household_master_id, 
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );
                        
                    $member_occupation_id = $this->occupationModel->addNew($IdInfo,$this->config->item('memberOccupationTable'));

                    $memberUpdate = array(
                                 'fk_occupation_id_last'=>$member_occupation_id, 
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
                        'any_occupation'=>1, 
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
                    $this->session->set_flashdata('error', 'Error occurred while creating Occupation.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Occupation created successfully.');
                
                redirect('householdvisit/occupation?baseID='.$baseID.'#occupation');
            }
        
    }


   
  
    
    
}

?>