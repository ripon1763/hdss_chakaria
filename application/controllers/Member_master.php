<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Member_master extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "member_master";
	public $pageTitle = 'Member Management';
	public $pageShortName = 'Member Master';
	
	 
    public function __construct()
    {
        parent::__construct();
		$this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
		$this->load->model('menu_model','menuModel');
		$this->load->library('pagination');
        $this->isLoggedIn(); 
		 $menu_key = 'member';
         $baseID = $this->input->get('baseID',TRUE);
		 $result = $this->loadThisForAccess($this->role,$baseID,$menu_key);
		 if ($result != true) 
		 {
			 redirect('access');
		 }

      
			
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
            $baseID = $this->input->get('baseID', TRUE);
		    $this->global['menu'] =  $this->menuModel->getMenu($this->role);
	        
			$this->global['pageTitle'] = $this->config->item('prefix'). ' : ' .$this->pageTitle;
	        $data['pageTitle'] = $this->pageTitle;
			$data['controller'] = $this->controller;
			$data['addMethod'] = 'addNew';
			$data['editMethod'] = 'editOld';
			$data['shortName'] = $this->pageShortName;
			$data['boxTitle'] = 'List';

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            // $this->$roundID =  $this->getCurrentRound()[0]->id;


            $data['district_id'] = '';
            $data['thana_id'] = '';
            $data['slum_id'] = '';
            $data['slumarea_id'] = '';
            $data['household_id'] = '';
            $district_id = '';
            $thana_id = '';
            $slum_id = '';
            $slumarea_id = '';
            $household_id = '';
                
            if($this->input->post('Clear'))
            {
                $this->session->unset_userdata('district_id'); 
                $data['district_id'] = '';
                $this->session->unset_userdata('thana_id'); 
                $data['thana_id'] = '';
                $this->session->unset_userdata('slum_id'); 
                $data['slum_id'] = '';
                $this->session->unset_userdata('slumarea_id'); 
                $data['slumarea_id'] = '';
                $this->session->unset_userdata('household_id'); 
                $data['household_id'] = '';
            }
            
          
            
            $district_id = $this->input->post('district_id');
            $thana_id = $this->input->post('thana_id');
            $slum_id = $this->input->post('slum_id');
            $slumarea_id = $this->input->post('slumarea_id');
            $household_id = $this->input->post('household_id');

            $data['district_id'] = $this->session->userdata('district_id');
            $data['thana_id'] = $this->session->userdata('thana_id');
            $data['slum_id'] = $this->session->userdata('slum_id');
            $data['slumarea_id'] = $this->session->userdata('slumarea_id');
            $data['household_id'] = $this->session->userdata('household_id');
            
            if($this->input->post('search'))
            {
            
             $this->session->set_userdata('district_id', $district_id);
             $data['district_id'] = $this->session->userdata('district_id');

             $this->session->set_userdata('thana_id', $thana_id);
             $data['thana_id'] = $this->session->userdata('thana_id');

             $this->session->set_userdata('slum_id', $slum_id);
             $data['slum_id'] = $this->session->userdata('slum_id');

             $this->session->set_userdata('slumarea_id', $slumarea_id);
             $data['slumarea_id'] = $this->session->userdata('slumarea_id');
			 
             $this->session->set_userdata('household_id', $household_id);
             $data['household_id'] = $this->session->userdata('household_id');

            }

           
        


            $data['district'] = $this->modelName->getListType($this->config->item('districtTable'));

            if ( ($data['district_id'] > 0) &&  ($data['thana_id'] > 0) && ($data['slum_id'] > 0))
            {

                 $data['userRecords'] = $this->memberModel->listingMember($this->config->item('memberMasterTable'), $data['district_id'],$data['thana_id'], $data['slum_id'],$data['slumarea_id'], $data['household_id']);
            }

           
            
			$data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
			$data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
	
		    $this->load->view('includes/header', $this->global);
			$this->load->view('includes/script');
			$this->load->view($this->controller.'/index', $data);
			$this->load->view('includes/footer');
		
    }
    

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
      
            $baseID = $this->input->get('baseID', TRUE);
			
			$addPerm  =  $this->getPermission($baseID, $this->role, 'add');
			
			if($addPerm == 0)
            {
                $this->session->set_flashdata('error', "Unauthorized Access");
				redirect($this->controller.'?baseID='.$baseID);
            }
			
		    $this->global['menu'] =  $this->menuModel->getMenu($this->role);
			
			$this->global['pageTitle'] = $this->config->item('prefix'). ' : ' .$this->pageTitle;
	        $data['pageTitle'] = $this->pageTitle;
			$data['controller'] = $this->controller;
			$data['actionMethod'] = 'addNewMember';
			$data['shortName'] = $this->pageShortName;
			$data['boxTitle'] = 'Add';
            $data['roundStstus'] = $this->getCurrentRound()[0]->active;
            $data['roundid'] = $this->getCurrentRound()[0]->id;




            //$data['division'] = $this->modelName->getListType($this->config->item('divTable'));
            $data['district'] = $this->modelName->getListType($this->config->item('districtTable'));
            $data['district2'] = $this->modelName->getListType($this->config->item('districtTable'));
            $data['country'] = $this->modelName->getListType($this->config->item('countryTable'));
           // $data['thana']    = $this->modelName->getListType($this->config->item('upazilaTable'));
            //$data['slum']     = $this->modelName->getListType($this->config->item('slumTable'));
           // $data['slumarea'] = $this->modelName->getListType($this->config->item('slumAreaTable'));

            $data['entryType'] = $this->modelName->getLookUpListSpecific($this->config->item('mementrytyp'), array('bls'));
            $data['membersextype'] = $this->modelName->getLookUpList($this->config->item('membersextype'));
            $data['relationhhh'] = $this->modelName->getLookUpList($this->config->item('relationhhh'));
            $data['religion'] = $this->modelName->getLookUpList($this->config->item('religion'));
            $data['maritalstatustyp'] = $this->modelName->getLookUpList($this->config->item('maritalstatustyp'));
            $data['educationtyp'] = $this->modelName->getLookUpList($this->config->item('educationtyp'));
            $data['secularedutyp'] = $this->modelName->getLookUpList($this->config->item('secularedutyp'));
            $data['religiousedutype'] = $this->modelName->getLookUpList($this->config->item('religiousedutype'));
            $data['occupationtyp'] = $this->modelName->getLookUpList($this->config->item('occupationtyp'));
            $data['birthregistration'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
            $data['additionChild'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
            $data['whynotbirthreg'] = $this->modelName->getLookUpList($this->config->item('whynotbirthreg'));
            $data['education_year'] = $this->modelName->getLookUpList($this->config->item('education_year'));
            $data['child_after_year'] = $this->modelName->getLookUpList($this->config->item('child_after_year'));
           
			
            $data['district_id'] = $this->session->userdata('district_id');
            $data['thana_id'] = $this->session->userdata('thana_id');
            $data['slum_id'] = $this->session->userdata('slum_id');
            $data['slumarea_id'] = $this->session->userdata('slumarea_id');
            $data['household_id'] = $this->session->userdata('household_id');

            $data['fatherList'] = array();
            $data['motherList'] = array();
            $data['spouseList'] = array();

            if ($data['household_id'] > 0)
            {
                 
                $data['fatherList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIdnSex($data['household_id'],25);
                $data['motherList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIdnSex($data['household_id'],26);
                $data['spouseList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIdnAll($data['household_id']);
            }
           

            $this->load->view('includes/header', $this->global);
            $this->load->view($this->controller.'/addNew',$data);
            $this->load->view('includes/footer');
        
    }
    
    /**
     * This function is used to add new
     */
    function addNewMember()
    {
          
			//print_r($this->input->post()); die();

          // echo   $membercode = $this->getMemberCode(2); die();

            $this->load->library('form_validation');
           
            $this->form_validation->set_rules('househodID','Household Name','trim|required|numeric');
            $this->form_validation->set_rules('sexType','Sex Type','trim|required|numeric');
            $this->form_validation->set_rules('relationheadID','Relation with Head','trim|required|numeric');
            $this->form_validation->set_rules('maritalStatusType','Marital Status','trim|required|numeric');

            $this->form_validation->set_rules('memberName','Member Name','trim|required|max_length[255]|xss_clean');
           // $this->form_validation->set_rules('fatherCode','Father Code','trim|required|max_length[11]|xss_clean');
           // $this->form_validation->set_rules('motherCode','Mother Code','trim|required|max_length[11]|xss_clean');
          //  $this->form_validation->set_rules('spouseCode','Spouse Code','trim|required|max_length[11]|xss_clean');
            $this->form_validation->set_rules('nationalID','National ID','trim|max_length[17]|xss_clean');

            $this->form_validation->set_rules('entryType','Entry Type','trim|required|numeric');
            $this->form_validation->set_rules('entryDate','Entry Date','trim|required');
           // $this->form_validation->set_rules('birthdate','Birth Date','trim|required');

           // $this->form_validation->set_rules('contactNumber','Contact Number','trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('religionType','Religion','trim|required|numeric');
            $this->form_validation->set_rules('educationType','Education Type','trim|required|numeric');
            //$this->form_validation->set_rules('secularEduType','Secular Education','trim|required|numeric');
            //$this->form_validation->set_rules('religiousEduType','Religious Education','trim|required|numeric');
            $this->form_validation->set_rules('occupationType','Occupation','trim|required|numeric');
            $this->form_validation->set_rules('birstRegiType','Birth Registration','trim|required|numeric');
            $this->form_validation->set_rules('additionalChild','additional Child','trim|required|numeric');
			
			$this->form_validation->set_rules('contactNoOne','Contact Number One','trim|max_length[11]|xss_clean');
			$this->form_validation->set_rules('contactNoTwo','Contact Number Two','trim|max_length[11]|xss_clean');
           
              
            $baseID = $this->input->get('baseID', TRUE);
           
		   if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect($this->controller.'?baseID='.$baseID);
               }

				
                $househodID = $this->input->post('househodID',true);
                $memberName = $this->input->post('memberName',true);
                $entryType = $this->input->post('entryType',true);
                $entryDate = $this->input->post('entryDate',true);
                $sexType = $this->input->post('sexType',true);
                $birthdate = $this->input->post('birthdate',true);

                $fatherCode = $this->input->post('fatherCode',true);
                $motherCode = $this->input->post('motherCode',true);
                $spouseCode = $this->input->post('spouseCode',true);
                $nationalID = $this->input->post('nationalID',true);
                $relationheadID = $this->input->post('relationheadID',true);
                $hhdate = $this->input->post('hhdate',true);
               
                $maritalStatusType = $this->input->post('maritalStatusType',true);
                $religionType = $this->input->post('religionType',true);
                $educationType = $this->input->post('educationType',true);
                $yearOfEdu = $this->input->post('yearOfEdu',true);
               // $secularEduType = $this->input->post('secularEduType',true);
               // $religiousEduType = $this->input->post('religiousEduType',true);
                $occupationType = $this->input->post('occupationType',true);
                $birstRegiType = $this->input->post('birstRegiType',true);
                $birthRegidate = $this->input->post('birthRegidate',true);
                $whyNotRegi = $this->input->post('whyNotRegi',true);
               
				
                $main_occupation_oth = $this->input->post('main_occupation_oth',true);
                $contactNoOne = $this->input->post('contactNoOne',true);
                $contactNoTwo = $this->input->post('contactNoTwo',true);
                $age = $this->input->post('age',true);

                if ($maritalStatusType == 41)
                {
                    $additionalChild = $this->input->post('additionalChild',true);
                    $afterManyYear = $this->input->post('afterManyYear',true);
                }
                else{
                    $additionalChild = 0;
                    $afterManyYear = 0;
                }



                 $hhcode = $this->getLookUpDetailCode($relationheadID)[0]->internal_code;

                 if ($hhcode == $this->config->item('household_head_code'))
                 {
                       $head = $this->getActiveHeadDetails($househodID, $relationheadID);

                       if (!empty($head))
                       {
                          $this->session->set_flashdata('error', 'An active head of this household already exist. Plz select something different as relation to head.');
                          redirect($this->controller.'?baseID='.$baseID);
                       }
                 }

                 $membercode = $this->getMemberCodebyCID($househodID);
                 $round_master_id =  $this->getCurrentRound()[0]->id;

                 $new_birthdate = null;

                if ($age > 0)
                {
                     $day = date("d");
                     $month = date("m");
                     $year = date("Y");
                     $new_year = $year - $age;
                     $new_birthdate = $new_year . '-' . $month . '-' . $day;

                }
                else{

                    if (!empty($birthdate)) {
                        $parts2 = explode('/', $birthdate);
                        $new_birthdate = $parts2[2] . '-' . $parts2[1] . '-' . $parts2[0];
                    }

                }


                if (!empty($entryDate)) {
                    $parts1 = explode('/', $entryDate);
                    $new_entryDate = $parts1[2] . '-' . $parts1[1] . '-' . $parts1[0];
                }

                $new_hhdate = null;

                if (!empty($hhdate)) {
                    $parts3 = explode('/', $hhdate);
                    $new_hhdate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }

                $new_birthRegidate = null;

                if (!empty($birthRegidate)) {
                    $parts5 = explode('/', $birthRegidate);
                    $new_birthRegidate = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }

                if ($educationType == 45)
                {
                    $yearOfEdu = 0;
                }

                if ($educationType == 120)
                {
                    $yearOfEdu = 0;
                }

                if ($birstRegiType == 2)
                {
                    $whyNotRegi = 0;
                }

                if ($additionalChild == 2)
                {
                    $afterManyYear = 0;
                }
                
            

                $this->db->trans_start();

                try
                { 

    				$memberMaster = array(
                        'birth_date'=>$new_birthdate, 
                        'member_name'=>$memberName, 
                        'member_code'=>$membercode, 
                        'fk_marital_status'=>$maritalStatusType, 
                        'fk_sex'=>$sexType, 
                        'fk_religion'=>$religionType, 
                        'fk_relation_with_hhh'=>$relationheadID, 
                        'fk_father_id'=>$fatherCode, 
                        'fk_mother_id'=>$motherCode, 
                        'fk_spouse_id'=>$spouseCode, 
                        'household_master_id_hh'=>$househodID, 
                        'national_id'=>$nationalID, 
                        'fk_birth_registration'=>$birstRegiType, 
                        'birth_registration_date'=>$new_birthRegidate, 
                        'fk_why_not_birth_registration'=>$whyNotRegi, 
                        'fk_additionalChild'=>$additionalChild, 
                        'contactNoOne'=>$contactNoOne, 
                        'contactNoTwo'=>$contactNoTwo, 
                        'afterYear'=>$afterManyYear, 
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    // member master
    					
    				$member_master_id = $this->modelName->addNewList($memberMaster,$this->config->item('memberMasterTable'));

                     // member household

                    $memberHousehold = array(
                        'household_master_id'=>$househodID, 
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

                    // household head

                   if ($hhcode == $this->config->item('household_head_code'))
                     {
                           
                       
                        // update household master

                        $householdMaster = array(
                            'member_master_id_last_head'=>$member_master_id, 
                            'transfer_complete'=>'No',  
                            'updateBy'=>$this->vendorId, 
                            'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->modelName->editList($householdMaster,$househodID,$this->config->item('householdMasterTable'));

                        $householdHeadUpdate = array(
                            'is_last_head'=>'No', 
                            'transfer_complete'=>'No',  
                            'updateBy'=>$this->vendorId, 
                            'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->db->where('household_master_id', $househodID);
                        $this->db->where('is_last_head', 'Yes');
                        $this->db->update($this->config->item('memberHeadTable'), $householdHeadUpdate);

                         $whereHouseholdhead = array('household_master_id' =>$househodID,'round_master_id'=>$round_master_id);

                         $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberHeadTable'))->where($whereHouseholdhead)->get()->row()->countRow;

                         if ($countRow > 0)
                         {

                            $headID = $this->db->select('id')->from($this->config->item('memberHeadTable'))->where($whereHouseholdhead)->get()->row()->id;

                            $householdHeadup = array(
                                'member_master_id'=>$member_master_id, 
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
                                'household_master_id'=>$househodID, 
                                'round_master_id'=>$round_master_id, 
                                'change_date'=>$new_hhdate, 
                                'is_last_head'=>'Yes', 
                                'transfer_complete'=>'No',  
                                'insertedBy'=>$this->vendorId, 
                                'insertedOn'=>date('Y-m-d H:i:s')
                            );

                            $member_household_head_id = $this->modelName->addNewList($householdHeadNew,$this->config->item('memberHeadTable'));


                         }

                     }

                    // occupation
                    $occupation= array(
                        'member_master_id'=>$member_master_id, 
                        'household_master_id'=>$househodID, 
                        'round_master_id'=>$round_master_id, 
                        'fk_main_occupation'=>$occupationType, 
                        'main_occupation_oth'=>$main_occupation_oth, 
                        'is_last_occupation'=>'Yes', 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    $member_occupation_id = $this->modelName->addNewList($occupation,$this->config->item('memberOccupationTable'));

                     // Education

                    $education= array(
                        'member_master_id'=>$member_master_id, 
                        'household_master_id'=>$househodID, 
                        'round_master_id'=>$round_master_id, 
                       // 'fk_religious_edu'=>$religiousEduType, 
                       // 'fk_secular_edu'=>$secularEduType, 
                        'fk_education_type'=>$educationType, 
                        'year_of_education'=>$yearOfEdu, 
                        'is_last_education'=>'Yes', 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    $member_education_id = $this->modelName->addNewList($education,$this->config->item('memberEducationTable'));


                    // Relation

                    $relation= array(
                        'member_master_id'=>$member_master_id, 
                        'household_master_id'=>$househodID, 
                        'round_master_id'=>$round_master_id, 
                        'fk_relation'=>$relationheadID, 
                        'is_last_relation'=>'Yes', 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    $member_relation_id = $this->modelName->addNewList($relation,$this->config->item('memberRelationTable'));

                    // member master

                    $memberUpdate = array(
                                'member_household_id_last'=>$member_household_id, 
                                'fk_education_id_last'=>$member_education_id, 
                                'fk_occupation_id_last'=>$member_occupation_id,
                                'fk_member_relation_id_last'=>$member_relation_id
                    );

                    $this->modelName->editList($memberUpdate,$member_master_id,$this->config->item('memberMasterTable'));


                     $whereHouseholdVisit = array('household_master_id' =>$househodID,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_education'=>1, 
                        'any_occupation'=>1, 
                        'any_relation'=>1, 
                        'transfer_complete'=>'No',  
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->modelName->editList($householdVisit,$visitID,$this->config->item('householdVisitTable'));

                     }
                     else
                     {
                         $visitHousehold= array(
                        'household_master_id'=>$househodID, 
                        'round_master_id'=>$round_master_id, 
                        'any_education'=>1, 
                        'any_occupation'=>1, 
                        'any_relation'=>1, 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                        );

                         $this->modelName->addNewList($visitHousehold,$this->config->item('householdVisitTable'));
                     }




 
    				
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while creating household.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Member Code '. $membercode .' created successfully');
				
                redirect($this->controller.'?baseID='.$baseID);
            }
        
    }

    function editOld($id = NULL)
    {
			$baseID = $this->input->get('baseID', TRUE);
			$household_master_id = $this->input->get('household_master_id', TRUE);
			
            if($id == null)
            {
                $this->session->set_flashdata('error', "Someting went wrong!! Please try Again");
				redirect($this->controller.'?baseID='.$baseID);
            }
			
			$editPerm =  $this->getPermission($baseID, $this->role, 'edit');
			if($editPerm == 0)
            {
                $this->session->set_flashdata('error', "Unauthorized Access");
				redirect($this->controller.'?baseID='.$baseID);
            }
			
            
		    $this->global['menu'] =  $this->menuModel->getMenu($this->role);
           

			
			$this->global['pageTitle'] = $this->config->item('prefix'). ' : ' .$this->pageTitle;
	        $data['pageTitle'] = $this->pageTitle;
			$data['controller'] = $this->controller;
			$data['actionMethod'] = 'editList';
			$data['shortName'] = $this->pageShortName;
			$data['boxTitle'] = 'Edit';


             $data['userInfo'] = $this->memberModel->getListInfo($id,$this->config->item('memberMasterTable'));


            $data['roundStstus'] = $this->getCurrentRound()[0]->active;
            $data['roundid'] = $this->getCurrentRound()[0]->id;




            $data['district'] = $this->modelName->getListType($this->config->item('districtTable'));
            $data['district2'] = $this->modelName->getListType($this->config->item('districtTable'));
            $data['country'] = $this->modelName->getListType($this->config->item('countryTable'));

            $data['entryType'] = $this->modelName->getLookUpListSpecific($this->config->item('mementrytyp'), array('bls'));
            $data['membersextype'] = $this->modelName->getLookUpList($this->config->item('membersextype'));
            $data['relationhhh'] = $this->modelName->getLookUpList($this->config->item('relationhhh'));
            $data['religion'] = $this->modelName->getLookUpList($this->config->item('religion'));
            $data['maritalstatustyp'] = $this->modelName->getLookUpList($this->config->item('maritalstatustyp'));
            $data['educationtyp'] = $this->modelName->getLookUpList($this->config->item('educationtyp'));
            $data['secularedutyp'] = $this->modelName->getLookUpList($this->config->item('secularedutyp'));
            $data['religiousedutype'] = $this->modelName->getLookUpList($this->config->item('religiousedutype'));
            $data['occupationtyp'] = $this->modelName->getLookUpList($this->config->item('occupationtyp'));
            $data['birthregistration'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
            $data['additionChild'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
            $data['whynotbirthreg'] = $this->modelName->getLookUpList($this->config->item('whynotbirthreg'));
            $data['education_year'] = $this->modelName->getLookUpList($this->config->item('education_year'));
            $data['child_after_year'] = $this->modelName->getLookUpList($this->config->item('child_after_year'));

            $data['fatherList'] = array();
            $data['motherList'] = array();
            $data['spouseList'] = array();

            if ($household_master_id > 0)
            {
                 
                $data['fatherList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIdnSex($household_master_id,25);
                $data['motherList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIdnSex($household_master_id,26);
                $data['spouseList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIdnAll($household_master_id);
            }
			
			
            $this->load->view('includes/header', $this->global);
            $this->load->view($this->controller.'/editOld', $data);
            $this->load->view('includes/footer');
    }
    
    
    /**
     * This function is used to edit information
     */
    function editList()
    {
            $this->load->library('form_validation');
            
            $member_master_id = $this->input->post('id',true);

            $household_master_id = $this->input->post('household_master_id',true);
            $fk_member_relation_id_last = $this->input->post('fk_member_relation_id_last',true);
            $fk_education_id_last = $this->input->post('fk_education_id_last',true);
            $fk_occupation_id_last = $this->input->post('fk_occupation_id_last',true);
            $member_household_id_last = $this->input->post('member_household_id_last',true);


			$baseID = $this->input->get('baseID', TRUE);
	
            $this->form_validation->set_rules('sexType','Sex Type','trim|required|numeric');
            $this->form_validation->set_rules('relationheadID','Relation with Head','trim|required|numeric');
            $this->form_validation->set_rules('maritalStatusType','Marital Status','trim|required|numeric');

            $this->form_validation->set_rules('memberName','Member Name','trim|required|max_length[255]|xss_clean');
           // $this->form_validation->set_rules('fatherCode','Father Code','trim|required|max_length[11]|xss_clean');
           // $this->form_validation->set_rules('motherCode','Mother Code','trim|required|max_length[11]|xss_clean');
          //  $this->form_validation->set_rules('spouseCode','Spouse Code','trim|required|max_length[11]|xss_clean');
            $this->form_validation->set_rules('nationalID','National ID','trim|max_length[50]|xss_clean');

            //$this->form_validation->set_rules('entryType','Entry Type','trim|required|numeric');
            $this->form_validation->set_rules('entryDate','Entry Date','trim|required');
            $this->form_validation->set_rules('birthdate','Birth Date','trim|required');

           // $this->form_validation->set_rules('contactNumber','Contact Number','trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('religionType','Religion','trim|required|numeric');
            $this->form_validation->set_rules('educationType','Education Type','trim|required|numeric');
           // $this->form_validation->set_rules('secularEduType','Secular Education','trim|required|numeric');
           // $this->form_validation->set_rules('religiousEduType','Religious Education','trim|required|numeric');
            $this->form_validation->set_rules('occupationType','Occupation','trim|required|numeric');
            $this->form_validation->set_rules('birstRegiType','Birth Registration','trim|required|numeric');
            $this->form_validation->set_rules('additionalChild','additional Child','trim|required|numeric');
			
			$this->form_validation->set_rules('contactNoOne','Contact Number One','trim|max_length[11]|xss_clean');
			$this->form_validation->set_rules('contactNoTwo','Contact Number Two','trim|max_length[11]|xss_clean');

            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($id);
            }
            else
            {
                
                $memberName = $this->input->post('memberName',true);
               // $entryType = $this->input->post('entryType',true);
                $entryDate = $this->input->post('entryDate',true);
                $sexType = $this->input->post('sexType',true);
                $birthdate = $this->input->post('birthdate',true);
				
                $contactNoOne = $this->input->post('contactNoOne',true);
                $contactNoTwo = $this->input->post('contactNoTwo',true);

                $fatherCode = $this->input->post('fatherCode',true);
                $motherCode = $this->input->post('motherCode',true);
                $spouseCode = $this->input->post('spouseCode',true);
                $nationalID = $this->input->post('nationalID',true);
                $relationheadID = $this->input->post('relationheadID',true);
                $hhdate = $this->input->post('hhdate',true);
               
                $maritalStatusType = $this->input->post('maritalStatusType',true);
                $religionType = $this->input->post('religionType',true);
                $educationType = $this->input->post('educationType',true);
                $yearOfEdu = $this->input->post('yearOfEdu',true);
              //  $secularEduType = $this->input->post('secularEduType',true);
               // $religiousEduType = $this->input->post('religiousEduType',true);
                $occupationType = $this->input->post('occupationType',true);
                $birstRegiType = $this->input->post('birstRegiType',true);
                $birthRegidate = $this->input->post('birthRegidate',true);
                $whyNotRegi = $this->input->post('whyNotRegi',true);
                $additionalChild = $this->input->post('additionalChild',true);
                $afterManyYear = $this->input->post('afterManyYear',true);
                $main_occupation_oth = $this->input->post('main_occupation_oth',true);

                 // print_r($memberMaster); die();

                if ($maritalStatusType == 41)
                {
                    $additionalChild = $this->input->post('additionalChild',true);
                    $afterManyYear = $this->input->post('afterManyYear',true);
                }
                else{
                    $additionalChild = 0;
                    $afterManyYear = 0;
                }




                 $hhcode = $this->getLookUpDetailCode($relationheadID)[0]->internal_code;

                 if ($hhcode == $this->config->item('household_head_code'))
                 {
                       $head = $this->getActiveHeadDetails($household_master_id, $relationheadID);

                       if (!empty($head))
                       {

                          if ($head[0]->member_master_id != $member_master_id)
                          {

                            $this->session->set_flashdata('error', 'An active head of this household already exist. Plz select something different as relation to head.');
                          redirect($this->controller.'?baseID='.$baseID);
                          }

 
                       }
                 }

                
                 $round_master_id =  $this->getCurrentRound()[0]->id;


                if (!empty($birthdate)) {
                    $parts2 = explode('/', $birthdate);
                    $new_birthdate = $parts2[2] . '-' . $parts2[1] . '-' . $parts2[0];
                }


                if (!empty($entryDate)) {
                    $parts1 = explode('/', $entryDate);
                    $new_entryDate = $parts1[2] . '-' . $parts1[1] . '-' . $parts1[0];
                }

                $new_hhdate = null;

                if (!empty($hhdate)) {
                    $parts3 = explode('/', $hhdate);
                    $new_hhdate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }

                $new_birthRegidate = null;

                if (!empty($birthRegidate)) {
                    $parts5 = explode('/', $birthRegidate);
                    $new_birthRegidate = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
                }

                if ($educationType == 45)
                {
                    $yearOfEdu = 0;
                }

                if ($educationType == 120)
                {
                    $yearOfEdu = 0;
                }

                if ($birstRegiType == 2)
                {
                    $whyNotRegi = 0;
                }

                if ($additionalChild == 2)
                {
                    $afterManyYear = 0;
                }


                $this->db->trans_start();

                try
                { 

                   

                    $memberMaster = array(
                        'birth_date'=>$new_birthdate, 
                        'member_name'=>$memberName, 
                        'fk_marital_status'=>$maritalStatusType, 
                        'fk_sex'=>$sexType, 
                        'fk_religion'=>$religionType, 
                        'fk_relation_with_hhh'=>$relationheadID, 
                        'father_code'=>$fatherCode, 
                        'fk_mother_id'=>$motherCode, 
                        'fk_spouse_id'=>$spouseCode, 
                        'national_id'=>$nationalID, 
                        'fk_birth_registration'=>$birstRegiType, 
                        'birth_registration_date'=>$new_birthRegidate, 
                        'fk_why_not_birth_registration'=>$whyNotRegi, 
                        'fk_additionalChild'=>$additionalChild, 
                        'contactNoTwo'=>$contactNoTwo, 
                        'contactNoOne'=>$contactNoOne, 
                        'afterYear'=>$afterManyYear, 
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

                    // occupation
                    $occupation= array(
                        'fk_main_occupation'=>$occupationType, 
                        'main_occupation_oth'=>$main_occupation_oth, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );

                   $this->modelName->editList($occupation,$fk_occupation_id_last,$this->config->item('memberOccupationTable'));

                     // Education

                    $education= array(
                       // 'fk_religious_edu'=>$religiousEduType, 
                      //  'fk_secular_edu'=>$secularEduType, 
                        'fk_education_type'=>$educationType, 
                        'year_of_education'=>$yearOfEdu, 
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


                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating member.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success', 'Memebr information updated successfully');
                
                redirect($this->controller.'?baseID='.$baseID);


            }
        
    }
	
	

    
}

?>