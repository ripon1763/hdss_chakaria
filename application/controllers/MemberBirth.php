<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberBirth extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "memberBirth";
	public $pageTitle = 'Member Birth';
	public $pageShortName = 'Member Birth';
	
	 
    public function __construct()
    {
        parent::__construct();
		    $this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
        $this->load->model('householdVisit_model','visitModel');
        $this->load->model('memberPregnancy_model','pregnancyModel');
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
    

    public function addEditBirth($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id_current = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Birth' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';



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

            $data['memberRecord'] = $this->memberModel->getMemberDetailsByIdnHousehold($id,$data['household_master_id_sub']);

            $data['femaleList'] = $this->memberModel->getMemberMasterFemalePresentListByHouseholdIds($data['household_master_id_sub'],$this->config->item('femaleSexCode'));
            $data['maleList'] = $this->memberModel->getMemberMasterFemalePresentListByHouseholdIds($data['household_master_id_sub'],$this->config->item('femaleSexCodeMale'));
            

           
            $data['entryType'] = $this->modelName->getLookUpListSpecific($this->config->item('mementrytyp'), array('bir'));
            $data['maritalstatustyp'] = $this->modelName->getLookUpListSpecific($this->config->item('maritalstatustyp'), array('5'));
            $data['membersextype'] = $this->modelName->getLookUpList($this->config->item('membersextype'));
            $data['relationhhh'] = $this->modelName->getLookUpListNotSpecific($this->config->item('relationhhh'), array('01','02','09'));
            $data['religion'] = $this->modelName->getLookUpList($this->config->item('religion'));
            
            $data['birth_weight_size'] = $this->modelName->getLookUpList($this->config->item('birth_weight_size'));
            $data['mother_live_birth_order'] = $this->modelName->getLookUpList($this->config->item('mother_live_birth_order'));
            
            $data['educationtyp'] = $this->modelName->getLookUpList($this->config->item('educationtyp'));
            $data['secularedutyp'] = $this->modelName->getLookUpList($this->config->item('secularedutyp'));
            $data['religiousedutype'] = $this->modelName->getLookUpList($this->config->item('religiousedutype'));
            $data['occupationtyp'] = $this->modelName->getLookUpList($this->config->item('occupationtyp'));
            $data['birthregistration'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
            $data['additionChild'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
            $data['whynotbirthreg'] = $this->modelName->getLookUpList($this->config->item('whynotbirthreg'));

            $data['onlyYesNo'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
            $data['ancPncVisit'] = $this->modelName->getLookUpList($this->config->item('ancPncVisit'));
            $data['pncassisttyp'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));
            $data['pncassisttyp1'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/birth_edit_details', $data);
            $this->load->view('includes/footer');
        
    }

    function editBirthDetails()
    {
          
          //  print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $member_master_id = $this->input->post('member_master_id',true);
            $member_household_id_last = $this->input->post('member_household_id_last',true);
            $fk_education_id_last = $this->input->post('fk_education_id_last',true);
            $fk_occupation_id_last = $this->input->post('fk_occupation_id_last',true);
            $fk_member_relation_id_last = $this->input->post('fk_member_relation_id_last',true);

            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('memberName','Child Name','trim|required');
            $this->form_validation->set_rules('sexType','Sex','trim|required|numeric');
            $this->form_validation->set_rules('birth_time','Birth Time','trim|required');
            $this->form_validation->set_rules('birth_weight','Birth weight','trim|required');
            
            $this->form_validation->set_rules('fk_birth_weight_size','Birth weight size','trim|required|numeric');
            $this->form_validation->set_rules('fatherCode','Father','trim|required|numeric');
            $this->form_validation->set_rules('motherCode','Mother','trim|required|numeric');
            $this->form_validation->set_rules('pregnancy_outcome_id','Pregnancy Outcome','trim|required|numeric');
            
            $this->form_validation->set_rules('relationheadID','Relation with head','trim|required|numeric');
            $this->form_validation->set_rules('entryType','entry type','trim');
            $this->form_validation->set_rules('entryDate','entry date','trim|required');
            $this->form_validation->set_rules('maritalStatusType','marital status','trim|required|numeric');
            $this->form_validation->set_rules('religionType','Religion','trim|required|numeric');
            $this->form_validation->set_rules('educationType','Edication Type','trim|required|numeric');
            //$this->form_validation->set_rules('secularEduType','Secular Education','trim|required|numeric');
           // $this->form_validation->set_rules('religiousEduType','Religious Education','trim|required|numeric');
            $this->form_validation->set_rules('occupationType','Occupation Type','trim|required|numeric');
            $this->form_validation->set_rules('fk_mother_live_birth_order','Live birth order','trim|required|numeric');
            $this->form_validation->set_rules('keep_follow_up','Follow up','trim|required|numeric');
            $this->form_validation->set_rules('checkupTypeChild','Birth of the child is made to check-up within 42 days','trim|required|numeric');

              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberBirth/addEditBirth/'. $member_master_id.'?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#birth');
            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                
            	$memberName = $this->input->post('memberName',true);
                $sexType = $this->input->post('sexType',true);
                $birth_time = $this->input->post('birth_time',true);
                $birth_weight = $this->input->post('birth_weight',true);
                $fk_birth_weight_size = $this->input->post('fk_birth_weight_size',true);
                $relationheadID = $this->input->post('relationheadID',true);
                $fatherCode = $this->input->post('fatherCode',true);
                $motherCode = $this->input->post('motherCode',true);
                $maritalStatusType = $this->input->post('maritalStatusType',true);
                $religionType = $this->input->post('religionType',true);
                $fk_mother_live_birth_order = $this->input->post('fk_mother_live_birth_order',true);
                $keep_follow_up = $this->input->post('keep_follow_up',true);

                $birstRegiType = $this->input->post('birstRegiType',true);
                $birthRegidate = $this->input->post('birthRegidate',true);
                $whyNotRegi = $this->input->post('whyNotRegi',true);

                $pregnancy_outcome_id = $this->input->post('pregnancy_outcome_id',true);

                $entryType = $this->input->post('entryType',true);
                $entryDate = $this->input->post('entryDate',true);

                $educationType = $this->input->post('educationType',true);
                //$religiousEduType = $this->input->post('religiousEduType',true);
               // $secularEduType = $this->input->post('secularEduType',true);

                $occupationType = $this->input->post('occupationType',true);


                $new_birthRegidate = null;

                if (!empty($birthRegidate)) {
                    $parts5 = explode('/', $birthRegidate);
                    $new_birthRegidate = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }



                // father code 

                $whereFather = array('id' =>$fatherCode);
                $father_member_code = $this->db->select('member_code')->from($this->config->item('memberMasterTable'))->where($whereFather)->get()->row()->member_code;


                // mother code 

                $whereMother = array('id' =>$motherCode);
                $mother_member_code = $this->db->select('member_code')->from($this->config->item('memberMasterTable'))->where($whereMother)->get()->row()->member_code;

                // get birth date as pregnancy outcome date is equal to birth date

                $wherePregnancyDate = array('id' =>$pregnancy_outcome_id);
                $pregnancy_outcome_date = $this->db->select('pregnancy_outcome_date')->from($this->config->item('pregnancyTable'))->where($wherePregnancyDate)->get()->row()->pregnancy_outcome_date;

              
              
                $new_entryDate = null;

                if (!empty($entryDate)) {
                    $parts3 = explode('/', $entryDate);
                    $new_entryDate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }


                // pnc
                $checkupTypeChild = $this->input->post('checkupTypeChild',true);


                if ($checkupTypeChild == 1)
                {

                    $fk_post_natal_visit = $this->input->post('fk_post_natal_visit',true) ?  $this->input->post('fk_post_natal_visit',true) : 0;
                    $afterTotalTimesChild = $this->input->post('afterTotalTimesChild',true) ?  $this->input->post('afterTotalTimesChild',true) : 0;

                    $childSecondVisitAsist = $this->input->post('childSecondVisitAsist',true);
                    $childFirstVisit = $this->input->post('childFirstVisit',true);
                    $childFirstVisitDays = $this->input->post('childFirstVisitDays',true) ?  $this->input->post('childFirstVisitDays',true) : 0;

                    $childFirstVisitAsist = $this->input->post('childFirstVisitAsist',true);
                    $childSecondVisit = $this->input->post('childSecondVisit',true);
                    $childSecondVisitDays = $this->input->post('childSecondVisitDays',true) ?  $this->input->post('childSecondVisitDays',true) : 0;
                   
                }

                else
                {
                    $childSecondVisitAsist = 0;
                    $childFirstVisitAsist = 0;
                    $fk_post_natal_visit = 0;
                    $afterTotalTimesChild = 0;
                    $childFirstVisit = 0;
                    $childFirstVisitDays = 0;
                    $childSecondVisit = 0;
                    $childSecondVisitDays = 0;
                   
                }

				

                $this->db->trans_start();

                try
                { 
				
				    $memberMaster = array(
                        'birth_date'=>$pregnancy_outcome_date, 
                        'member_name'=>$memberName, 
                        'fk_marital_status'=>$maritalStatusType, 
                        'fk_sex'=>$sexType, 
                        'fk_religion'=>$religionType, 
                        'fk_relation_with_hhh'=>$relationheadID, 
                        'father_code'=>$father_member_code, 
                        'fk_father_id'=>$fatherCode, 
                        'mother_code'=>$mother_member_code, 
                        'fk_mother_id'=>$motherCode, 
                        'fk_mother_live_birth_order'=>$fk_mother_live_birth_order,  
                        'birth_time'=>$birth_time,  
                        'birth_weight'=>$birth_weight,  
                        'fk_birth_weight_size'=>$fk_birth_weight_size,  
                        'pregnancy_outcome_id'=>$pregnancy_outcome_id,  
                        'fk_birth_registration'=>$birstRegiType, 
                        'birth_registration_date'=>$new_birthRegidate, 
                        'fk_why_not_birth_registration'=>$whyNotRegi, 
                        'keep_follow_up'=>$keep_follow_up,  
                        'fk_pnc_chkup_child_id'=>$checkupTypeChild, 
                        'pnc_chkup_child_times'=>$afterTotalTimesChild, 
                        'fk_pnc_first_visit_id'=>$childFirstVisit, 
                        'pnc_first_visit_days'=>$childFirstVisitDays, 
                        'fk_pnc_second_visit_id'=>$childSecondVisit, 
                        'pnc_second_visit_days'=>$childSecondVisitDays,
                        'fk_child_first_visit_assist'=>$childFirstVisitAsist,
                        'fk_child_second_visit_assist'=>$childSecondVisitAsist,
                        'fk_post_natal_child_visit'=>$fk_post_natal_visit,
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );

                    // member master
                        
                    $this->modelName->editList($memberMaster,$member_master_id,$this->config->item('memberMasterTable'));


                     // member household

                    $memberHousehold = array(
                        'entry_date'=>$new_entryDate,  
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );

                     $this->modelName->editList($memberHousehold,$member_household_id_last,$this->config->item('memberHouseholdTable'));

                     // occupation
                    $occupation= array(
                        'fk_main_occupation'=>$occupationType, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );

                   $this->modelName->editList($occupation,$fk_occupation_id_last,$this->config->item('memberOccupationTable'));

                     // Education

                    $education= array(
                        //'fk_religious_edu'=>$religiousEduType, 
                        //'fk_secular_edu'=>$secularEduType, 
                        'fk_education_type'=>$educationType, 
                        'year_of_education'=>0, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );

                    $this->modelName->editList($education,$fk_education_id_last,$this->config->item('memberEducationTable'));


                    // Relation

                    $relation= array(
                        'fk_relation'=>$relationheadID, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );

                    $this->modelName->editList($relation,$fk_member_relation_id_last,$this->config->item('memberRelationTable'));
				

                     $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_birth'=>1, 
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
                    $this->session->set_flashdata('error', 'Error occurred while updating birth.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Member Birth updated successfully.');
                
                redirect('householdvisit/birth?baseID='.$baseID.'#birth');
            }
        
    }


    public function addBirth()
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Birth' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';


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

           
            $data['femaleList'] = $this->memberModel->getMemberMasterFemalePresentListByHouseholdIds($data['household_master_id_sub'],$this->config->item('femaleSexCode'));
            $data['maleList'] = $this->memberModel->getMemberMasterFemalePresentListByHouseholdIds($data['household_master_id_sub'],$this->config->item('femaleSexCodeMale'));
			

           
            $data['entryType'] = $this->modelName->getLookUpListSpecific($this->config->item('mementrytyp'), array('bir'));
            $data['maritalstatustyp'] = $this->modelName->getLookUpListSpecific($this->config->item('maritalstatustyp'), array('5'));
            $data['membersextype'] = $this->modelName->getLookUpList($this->config->item('membersextype'));
            $data['relationhhh'] = $this->modelName->getLookUpListNotSpecific($this->config->item('relationhhh'), array('01','02','09'));
            $data['religion'] = $this->modelName->getLookUpList($this->config->item('religion'));
			
            $data['birth_weight_size'] = $this->modelName->getLookUpList($this->config->item('birth_weight_size'));
            $data['mother_live_birth_order'] = $this->modelName->getLookUpList($this->config->item('mother_live_birth_order'));
			
            $data['educationtyp'] = $this->modelName->getLookUpList($this->config->item('educationtyp'));
            $data['secularedutyp'] = $this->modelName->getLookUpList($this->config->item('secularedutyp'));
            $data['religiousedutype'] = $this->modelName->getLookUpList($this->config->item('religiousedutype'));
            $data['occupationtyp'] = $this->modelName->getLookUpList($this->config->item('occupationtyp'));
            $data['birthregistration'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
            $data['additionChild'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
            $data['whynotbirthreg'] = $this->modelName->getLookUpList($this->config->item('whynotbirthreg'));

            $data['onlyYesNo'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
            $data['ancPncVisit'] = $this->modelName->getLookUpList($this->config->item('ancPncVisit'));
            $data['pncassisttyp'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));
            $data['pncassisttyp1'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));
            
			
		
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/birth_add_details', $data);
            $this->load->view('includes/footer');
        
    }  

    function addBirthDetails()
    {
          
          
			//print_r($this->input->post()); die();	


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('memberName','Child Name','trim|required');
            $this->form_validation->set_rules('sexType','Sex','trim|required|numeric');
            $this->form_validation->set_rules('birth_time','Birth Time','trim|required');
            $this->form_validation->set_rules('birth_weight','Birth weight','trim|required');
			
            $this->form_validation->set_rules('fk_birth_weight_size','Birth weight size','trim|required|numeric');
            $this->form_validation->set_rules('fatherCode','Father','trim|required|numeric');
            $this->form_validation->set_rules('motherCode','Mother','trim|required|numeric');
            $this->form_validation->set_rules('pregnancy_outcome_id','Pregnancy Outcome','trim|required|numeric');
			
            $this->form_validation->set_rules('relationheadID','Relation with head','trim|required|numeric');
            $this->form_validation->set_rules('entryType','entry type','trim');
            $this->form_validation->set_rules('entryDate','entry date','trim|required');
            $this->form_validation->set_rules('maritalStatusType','marital status','trim|required|numeric');
            $this->form_validation->set_rules('religionType','Religion','trim|required|numeric');
            $this->form_validation->set_rules('educationType','Edication Type','trim|required|numeric');
           // $this->form_validation->set_rules('secularEduType','Secular Education','trim|required|numeric');
           //$this->form_validation->set_rules('religiousEduType','Religious Education','trim|required|numeric');
            $this->form_validation->set_rules('occupationType','Occupation Type','trim|required|numeric');
            $this->form_validation->set_rules('fk_mother_live_birth_order','Live birth order','trim|required|numeric');
            $this->form_validation->set_rules('keep_follow_up','Follow up','trim|required|numeric');

            $this->form_validation->set_rules('checkupTypeChild','Birth of the child is made to check-up within 42 days','trim|required|numeric');

           
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberBirth/addBirth?household_master_id='.$household_master_id.'&&baseID='.$baseID.'#birth');
            }
            else
            {
               if ($this->getCurrentRound()[0]->active == 0)
               {
                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }
			   
			    $memberName = $this->input->post('memberName',true);
                $sexType = $this->input->post('sexType',true);
                $birth_time = $this->input->post('birth_time',true);
                $birth_weight = $this->input->post('birth_weight',true);
                $fk_birth_weight_size = $this->input->post('fk_birth_weight_size',true);
                $relationheadID = $this->input->post('relationheadID',true);
                $fatherCode = $this->input->post('fatherCode',true);
                $motherCode = $this->input->post('motherCode',true);
                $maritalStatusType = $this->input->post('maritalStatusType',true);
                $religionType = $this->input->post('religionType',true);
                $fk_mother_live_birth_order = $this->input->post('fk_mother_live_birth_order',true);
                $keep_follow_up = $this->input->post('keep_follow_up',true);

                $birstRegiType = $this->input->post('birstRegiType',true);
                $birthRegidate = $this->input->post('birthRegidate',true);
                $whyNotRegi = $this->input->post('whyNotRegi',true);

                $pregnancy_outcome_id = $this->input->post('pregnancy_outcome_id',true);

                $entryType = $this->input->post('entryType',true);
                $entryDate = $this->input->post('entryDate',true);

                $educationType = $this->input->post('educationType',true);
               // $religiousEduType = $this->input->post('religiousEduType',true);
              //  $secularEduType = $this->input->post('secularEduType',true);

                $occupationType = $this->input->post('occupationType',true);
               


                $new_birthRegidate = null;

                if (!empty($birthRegidate)) {
                    $parts5 = explode('/', $birthRegidate);
                    $new_birthRegidate = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }



                // father code 

                $whereFather = array('id' =>$fatherCode);
                $father_member_code = $this->db->select('member_code')->from($this->config->item('memberMasterTable'))->where($whereFather)->get()->row()->member_code;


                // mother code 

                $whereMother = array('id' =>$motherCode);
                $mother_member_code = $this->db->select('member_code')->from($this->config->item('memberMasterTable'))->where($whereMother)->get()->row()->member_code;

                // get birth date as pregnancy outcome date is equal to birth date

                $wherePregnancyDate = array('id' =>$pregnancy_outcome_id);
                $pregnancy_outcome_date = $this->db->select('pregnancy_outcome_date')->from($this->config->item('pregnancyTable'))->where($wherePregnancyDate)->get()->row()->pregnancy_outcome_date;

              
			  
                $new_entryDate = null;

                if (!empty($entryDate)) {
                    $parts3 = explode('/', $entryDate);
                    $new_entryDate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }



                // pnc
                $checkupTypeChild = $this->input->post('checkupTypeChild',true);


                if ($checkupTypeChild == 1)
                {
                    $fk_post_natal_visit = $this->input->post('fk_post_natal_visit',true);
                    $afterTotalTimesChild = $this->input->post('afterTotalTimesChild',true) ?  $this->input->post('afterTotalTimesChild',true) : 0;

                    $childFirstVisitAsist = $this->input->post('childFirstVisitAsist',true);
                    $childFirstVisit = $this->input->post('childFirstVisit',true);
                    $childFirstVisitDays = $this->input->post('childFirstVisitDays',true) ?  $this->input->post('childFirstVisitDays',true) : 0;

                    $childSecondVisitAsist = $this->input->post('childSecondVisitAsist',true);
                    $childSecondVisit = $this->input->post('childSecondVisit',true);
                    $childSecondVisitDays = $this->input->post('childSecondVisitDays',true) ?  $this->input->post('childSecondVisitDays',true) : 0;
                   
                }

                else
                {
                    $childSecondVisitAsist = 0;
                    $childFirstVisitAsist = 0;
                    $fk_post_natal_visit = 0;
                    $afterTotalTimesChild = 0;
                    $childFirstVisit = 0;
                    $childFirstVisitDays = 0;
                    $childSecondVisit = 0;
                    $childSecondVisitDays = 0;
                   
                }


				


                 //$membercode = $this->getMemberCode($household_master_id);
                 $membercode = $this->getMemberCodebyCID($household_master_id);
                 $round_master_id =  $this->getCurrentRound()[0]->id;

                $this->db->trans_start();

                try
                { 
				

                    $memberMaster = array(
                        'birth_date'=>$pregnancy_outcome_date, 
                        'member_name'=>$memberName, 
                        'member_code'=>$membercode, 
                        'fk_marital_status'=>$maritalStatusType, 
                        'fk_sex'=>$sexType, 
                        'fk_religion'=>$religionType, 
                        'fk_relation_with_hhh'=>$relationheadID, 
                        'father_code'=>$father_member_code, 
                        'fk_father_id'=>$fatherCode, 
                        'mother_code'=>$mother_member_code, 
                        'fk_mother_id'=>$motherCode, 
                        'household_master_id_hh'=>$household_master_id,  
                        'fk_mother_live_birth_order'=>$fk_mother_live_birth_order,  
                        'birth_time'=>$birth_time,  
                        'birth_weight'=>$birth_weight,  
                        'fk_birth_weight_size'=>$fk_birth_weight_size,  
                        'pregnancy_outcome_id'=>$pregnancy_outcome_id,  
                        'fk_birth_registration'=>$birstRegiType, 
                        'birth_registration_date'=>$new_birthRegidate, 
                        'fk_why_not_birth_registration'=>$whyNotRegi, 
                        'fk_pnc_chkup_child_id'=>$checkupTypeChild, 
                        'pnc_chkup_child_times'=>$afterTotalTimesChild, 
                        'fk_pnc_first_visit_id'=>$childFirstVisit, 
                        'pnc_first_visit_days'=>$childFirstVisitDays, 
                        'fk_pnc_second_visit_id'=>$childSecondVisit, 
                        'pnc_second_visit_days'=>$childSecondVisitDays,
                        'fk_child_first_visit_assist'=>$childFirstVisitAsist,
                        'fk_child_second_visit_assist'=>$childSecondVisitAsist,
                        'fk_post_natal_child_visit'=>$fk_post_natal_visit,
                        'keep_follow_up'=>$keep_follow_up,  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    // member master
                        
                    $member_master_id = $this->modelName->addNewList($memberMaster,$this->config->item('memberMasterTable'));
					
					
					  // member household

                    $memberHousehold = array(
                        'household_master_id'=>$household_master_id, 
                        'is_last_household'=>'Yes', 
                        'member_master_id'=>$member_master_id, 
                        'fk_entry_type'=>$entryType, 
                        'entry_date'=>$new_entryDate, 
                        'round_master_id_entry_round'=>$round_master_id, 
                        'current_indenttification_id'=>$membercode, 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    $member_household_id = $this->modelName->addNewList($memberHousehold,$this->config->item('memberHouseholdTable'));


                     // occupation
                    $occupation= array(
                        'member_master_id'=>$member_master_id, 
                        'household_master_id'=>$household_master_id, 
                        'round_master_id'=>$round_master_id, 
                        'fk_main_occupation'=>$occupationType, 
                        'is_last_occupation'=>'Yes', 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    $member_occupation_id = $this->modelName->addNewList($occupation,$this->config->item('memberOccupationTable'));

                     // Education

                    $education= array(
                        'member_master_id'=>$member_master_id, 
                        'household_master_id'=>$household_master_id, 
                        'round_master_id'=>$round_master_id, 
                       // 'fk_religious_edu'=>$religiousEduType, 
                       // 'fk_secular_edu'=>$secularEduType, 
                        'fk_education_type'=>$educationType, 
                        'year_of_education'=>0, 
                        'is_last_education'=>'Yes', 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    $member_education_id = $this->modelName->addNewList($education,$this->config->item('memberEducationTable'));


                    // Relation

                    $relation= array(
                        'member_master_id'=>$member_master_id, 
                        'household_master_id'=>$household_master_id, 
                        'round_master_id'=>$round_master_id, 
                        'fk_relation'=>$relationheadID, 
                        'is_last_relation'=>'Yes', 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    $member_relation_id = $this->modelName->addNewList($relation,$this->config->item('memberRelationTable'));

                    // update member master

                    $memberUpdate = array(
                                'member_household_id_last'=>$member_household_id, 
                                'fk_education_id_last'=>$member_education_id, 
                                'fk_occupation_id_last'=>$member_occupation_id,
                                'fk_member_relation_id_last'=>$member_relation_id
                    );

                    $this->modelName->editList($memberUpdate,$member_master_id,$this->config->item('memberMasterTable'));


                    // update household visit

                     $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_birth'=>1, 
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
                    $this->session->set_flashdata('error', 'Error occurred while creating birth.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','birth created successfully.');
                
                redirect('householdvisit/birth?baseID='.$baseID.'#birth');
            }
        
    }


   
  
    
    
}

?>