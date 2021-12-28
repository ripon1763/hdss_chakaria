<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberEducation extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "memberEducation";
	public $pageTitle = 'Member Education';
	public $pageShortName = 'Member Education';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
        $this->load->model('householdVisit_model','visitModel');
        $this->load->model('memberEducation_model','educationModel');
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
    

    public function addEditEducation($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id_current = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Education' ;
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

            $data['educationRecord'] = $this->educationModel->getEducationDetailsByIdnHousehold($id,$data['household_master_id_sub'],$data['round_master_id']);

            //

            $data['educationtyp'] = $this->modelName->getLookUpList($this->config->item('educationtyp'));
            $data['secularedutyp'] = $this->modelName->getLookUpList($this->config->item('secularedutyp'));
            $data['religiousedutype'] = $this->modelName->getLookUpList($this->config->item('religiousedutype'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/education_edit_details', $data);
            $this->load->view('includes/footer');
        
    }

    function editEducationDetails()
    {
          
            //print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $educationID = $this->input->post('educationID',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('educationType','Education Type','trim|required|numeric');
           // $this->form_validation->set_rules('secularEduType','Secular Education','trim|required|numeric');
           // $this->form_validation->set_rules('religiousEduType','Religious Education','trim|required|numeric');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberEducation/addEditEducation/'. $educationID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#education');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                
                $educationType = $this->input->post('educationType',true);
                $yearOfEdu = $this->input->post('yearOfEdu',true);
               /// $secularEduType = $this->input->post('secularEduType',true);
               // $religiousEduType = $this->input->post('religiousEduType',true);

                if ($educationType == 45)
                {
                    $yearOfEdu = 0;
                }

                $this->db->trans_start();

                try
                { 

                    $IdInfo = array(
                        //'fk_religious_edu'=>$religiousEduType, 
                        //'fk_secular_edu'=>$secularEduType, 
                        'fk_education_type'=>$educationType, 
                        'year_of_education'=>$yearOfEdu, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );

                        
                    $this->educationModel->edit($IdInfo,$educationID);


                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating Education.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Member education updated successfully.');
                
                redirect('householdvisit/education?baseID='.$baseID.'#education');
            }
        
    }


    public function addEducation($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Education' ;
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

            $data['educationtyp'] = $this->modelName->getLookUpList($this->config->item('educationtyp'));
            $data['secularedutyp'] = $this->modelName->getLookUpList($this->config->item('secularedutyp'));
            $data['religiousedutype'] = $this->modelName->getLookUpList($this->config->item('religiousedutype'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/education_add_details', $data);
            $this->load->view('includes/footer');
        
    }

    function addEducationDetails()
    {
          
          //  print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $member_master_id = $this->input->post('member_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('educationType','Education Type','trim|required|numeric');
           // $this->form_validation->set_rules('secularEduType','Secular Education','trim|required|numeric');
           // $this->form_validation->set_rules('religiousEduType','Religious Education','trim|required|numeric');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
    
                redirect('memberEducation/addEducation/'. $member_master_id.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#education');

            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

               $whereHouseholdEdu = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id,'member_master_id'=>$member_master_id);

               $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberEducationTable'))->where($whereHouseholdEdu)->get()->row()->countRow;

               if ($countRow > 0)
               {
                  $this->session->set_flashdata('error', 'Education already exists for this round.');
                  redirect('householdvisit/education?baseID='.$baseID.'#education');
               }

                
                
                $educationType = $this->input->post('educationType',true);
                $yearOfEdu = $this->input->post('yearOfEdu',true);
               // $secularEduType = $this->input->post('secularEduType',true);
              //  $religiousEduType = $this->input->post('religiousEduType',true);

                if ($educationType == 45)
                {
                    $yearOfEdu = 0;
                }

                $round_master_id_entry_round =  $this->getCurrentRound()[0]->id;

                $this->db->trans_start();

                try
                { 


                    $eduUpdate = array(
                                 'is_last_education'=>'No', 
                                 'updateBy'=>$this->vendorId, 
                                 'updatedOn'=>date('Y-m-d H:i:s')

                    );

                    //$this->db->where('round_master_id', $round_master_id);
                    $this->db->where('member_master_id', $member_master_id);
                    $this->db->where('is_last_education', 'Yes');
                    $this->db->update($this->config->item('memberEducationTable'), $eduUpdate);


                    $IdInfo = array(
                        
                       // 'fk_religious_edu'=>$religiousEduType, 
                       // 'fk_secular_edu'=>$secularEduType, 
                        'fk_education_type'=>$educationType, 
                        'year_of_education'=>$yearOfEdu, 
                        'transfer_complete'=>'No',  
                        'is_last_education'=>'Yes',  
                        'member_master_id'=>$member_master_id, 
                        'round_master_id'=>$round_master_id_entry_round, 
                        'household_master_id'=>$household_master_id, 
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );
                        
                    $member_education_id = $this->educationModel->addNew($IdInfo,$this->config->item('memberEducationTable'));

                    $memberUpdate = array(
                                 'fk_education_id_last'=>$member_education_id, 
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
                    $this->session->set_flashdata('error', 'Error occurred while creating Education.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Education created successfully.');
                
                redirect('householdvisit/education?baseID='.$baseID.'#education');
            }
        
    }


   
  
    
    
}

?>