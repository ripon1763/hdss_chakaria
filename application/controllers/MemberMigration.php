<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberMigration extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
		$this->load->library('pagination');
		$this->load->model('master_model');
		$this->load->model('member_model');
        $this->isLoggedIn();
    }

	function get_autocomplete_member(){
        if (isset($_GET['term'])) {
            $result = $this->member_model->getAutocompleteMember($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->member_code.' - '. $row->member_name.' - '. $row->household_code,
                    'house' => $row->member_code,
                    'member' => $row->member_name,
                    'value' => $row->id,
                );
                echo json_encode($arr_result);
            }
        }
    }
	
	function addNew()
    {

        $data['pageTitle'] = 'Add new member';
        $data['controller'] = 'memberMigrationIn';
        $data['actionMethod'] = 'addNewMemberSubmit';
        $data['shortName'] = 'Add member';
        $data['boxTitle'] = 'Add';
        $data['roundStstus'] = $this->getCurrentRound()[0]->active;
        $data['roundid'] = $this->getCurrentRound()[0]->id;
        $data['household_master_id'] = $this->input->post('id', TRUE);
        
        $data['entryType'] = $this->master_model->getLookUpListSpecific($this->config->item('mementrytyp'), array('bls'));
        
        $data['membersextype'] = $this->master_model->getLookUpList($this->config->item('membersextype'));
        //$data['relationhhh'] = $this->master_model->getLookUpList($this->config->item('relationhhh'));
        $data['relationhhh'] = $this->master_model->getLookUpListNotSpecific($this->config->item('relationhhh'), array('hhh'));
        $data['religion'] = $this->master_model->getLookUpList($this->config->item('religion'));
        $data['maritalstatustyp'] = $this->master_model->getLookUpList($this->config->item('maritalstatustyp'));
        $data['educationtyp'] = $this->master_model->getLookUpList($this->config->item('educationtyp'));
        $data['secularedutyp'] = $this->master_model->getLookUpList($this->config->item('secularedutyp'));
        $data['religiousedutype'] = $this->master_model->getLookUpList($this->config->item('religiousedutype'));
        $data['occupationtyp'] = $this->master_model->getLookUpList($this->config->item('occupationtyp'));
        $data['birthregistration'] = $this->master_model->getLookUpList($this->config->item('yes_no'));
        $data['additionChild'] = $this->master_model->getLookUpList($this->config->item('yes_no'));
        $data['whynotbirthreg'] = $this->master_model->getLookUpList($this->config->item('whynotbirthreg'));
        
        $data['education_year'] = $this->master_model->getLookUpList($this->config->item('education_year'));

        $data['child_after_year'] = $this->master_model->getLookUpList($this->config->item('child_after_year'));
        
        $data['fatherList'] = '';
        $data['motherList'] = '';
        $data['spouseList'] = '';

        if ($data['household_master_id'] > 0)
        {
            $data['fatherList'] = $this->member_model->getMemberMasterPresentListByHouseholdIdnSex($data['household_master_id'],25);
            $data['motherList'] = $this->member_model->getMemberMasterPresentListByHouseholdIdnSex($data['household_master_id'],26);
            $data['spouseList'] = $this->member_model->getMemberMasterPresentListByHouseholdIdnAll($data['household_master_id']);
        }
        
        $this->load->view('memberMigrationIn/addNew',$data);
        
        
    }
	

	function addNewMemberSubmit()
    {
        $this->load->library('form_validation');
		
		$this->form_validation->set_rules('sexType','Sex Type','trim|required|numeric');
		$this->form_validation->set_rules('relationheadID','Relation with Head','trim|required|numeric');
		$this->form_validation->set_rules('maritalStatusType','Marital Status','trim|required|numeric');

		$this->form_validation->set_rules('memberName','Member Name','trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('nationalID','National ID','trim|max_length[50]|xss_clean');
		$this->form_validation->set_rules('entryDate','Entry Date','trim|required');
		//$this->form_validation->set_rules('birthdate','Birth Date','trim|required');
		$this->form_validation->set_rules('religionType','Religion','trim|required|numeric');
		$this->form_validation->set_rules('educationType','Education Type','trim|required|numeric');
		//$this->form_validation->set_rules('secularEduType','Secular Education','trim|required|numeric');
		//$this->form_validation->set_rules('religiousEduType','Religious Education','trim|required|numeric');
		$this->form_validation->set_rules('occupationType','Occupation','trim|required|numeric');
		$this->form_validation->set_rules('birstRegiType','Birth Registration','trim|required|numeric');
		//$this->form_validation->set_rules('additionalChild','additional Child','trim|required|numeric');
		
		if($this->form_validation->run() == FALSE)
		{
			    $data = array('success1'=>'0');
		}
		else
		{
				$household_master_id = $this->input->post('household_master_id',true);
				$baseID = $this->input->post('baseID',true);
				
				
				$memberName = $this->input->post('memberName',true);
                $entryType = $this->config->item('migrationInMovement');
                $entryDate = $this->input->post('entryDate',true);
                $sexType = $this->input->post('sexType',true);
                $birthdate = $this->input->post('birthdate',true);

                $fatherCode = $this->input->post('fatherCode',true);
                $motherCode = $this->input->post('motherCode',true);
                $spouseCode = $this->input->post('spouseCode',true);
                $nationalID = $this->input->post('nationalID',true);
                $relationheadID = $this->input->post('relationheadID',true);
   
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
                $additionalChild = $this->input->post('additionalChild',true);
                $afterManyYear = $this->input->post('afterManyYear',true);

                $contactNoOne = $this->input->post('contactNoOne',true);
                $contactNoTwo = $this->input->post('contactNoTwo',true);

                $age = $this->input->post('age',true) ? $this->input->post('age',true) : 0;

               // $this->session->userdata('day') ?  $this->session->userdata('day') : 0;
                if ($maritalStatusType == 41)
                {
                    $additionalChild = $this->input->post('additionalChild',true);
                    $afterManyYear = $this->input->post('afterManyYear',true);
                }
                else{
                    $additionalChild = 0;
                    $afterManyYear = 0;
                }
				
				
				$membercode = $this->getMemberCodebyCID($household_master_id);
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
				
				$uniquerNumber = date("ymdis");
				$this->db->trans_begin();

                try
                { 

    				$memberMaster = array(
                        'birth_date'=>$new_birthdate, 
                        'member_name'=>$memberName, 
                        'member_code'=>$uniquerNumber, 
                        'fk_marital_status'=>$maritalStatusType, 
                        'fk_sex'=>$sexType, 
                        'fk_religion'=>$religionType, 
                        'fk_relation_with_hhh'=>$relationheadID, 
                        'fk_father_id'=>$fatherCode, 
                        'fk_mother_id'=>$motherCode, 
                        'fk_spouse_id'=>$spouseCode, 
                        'household_master_id_hh'=>$household_master_id, 
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
    					
    				$member_master_id = $this->master_model->addNewList($memberMaster,$this->config->item('memberMasterTable'));

                     // member household

                    $memberHousehold = array(
                        //'household_master_id'=>$househodID, 
                        'is_last_household'=>'Yes', 
                        'member_master_id'=>$member_master_id, 
                        'fk_entry_type'=>$entryType, 
                        'entry_date'=>$new_entryDate, 
                        'round_master_id_entry_round'=>$round_master_id, 
                       //'current_indenttification_id'=>$membercode, 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    $member_household_id = $this->master_model->addNewList($memberHousehold,$this->config->item('memberHouseholdTable'));

                    // occupation
                    $occupation= array(
                        'member_master_id'=>$member_master_id, 
                        //'household_master_id'=>$househodID, 
                        'round_master_id'=>$round_master_id, 
                        'fk_main_occupation'=>$occupationType, 
                        'is_last_occupation'=>'Yes', 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    $member_occupation_id = $this->master_model->addNewList($occupation,$this->config->item('memberOccupationTable'));

                     // Education

                    $education= array(
                        'member_master_id'=>$member_master_id, 
                        //'household_master_id'=>$househodID, 
                        'round_master_id'=>$round_master_id, 
                        //'fk_religious_edu'=>$religiousEduType, 
                       // 'fk_secular_edu'=>$secularEduType, 
                        'fk_education_type'=>$educationType, 
                        'year_of_education'=>$yearOfEdu, 
                        'is_last_education'=>'Yes', 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    $member_education_id = $this->master_model->addNewList($education,$this->config->item('memberEducationTable'));


                    // Relation

                    $relation= array(
                        'member_master_id'=>$member_master_id, 
                       // 'household_master_id'=>$househodID, 
                        'round_master_id'=>$round_master_id, 
                        'fk_relation'=>$relationheadID, 
                        'is_last_relation'=>'Yes', 
                        'transfer_complete'=>'No',  
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );

                    $member_relation_id = $this->master_model->addNewList($relation,$this->config->item('memberRelationTable'));

                    // member master

                    $memberUpdate = array(
                                'member_household_id_last'=>$member_household_id, 
                                'fk_education_id_last'=>$member_education_id, 
                                'fk_occupation_id_last'=>$member_occupation_id,
                                'fk_member_relation_id_last'=>$member_relation_id
                    );

                    $this->master_model->editList($memberUpdate,$member_master_id,$this->config->item('memberMasterTable'));

    				
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $data = array('success1'=>'2');
                }
				
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					$data = array('success1'=>'3');
				}
				else
				{
					$this->db->trans_commit();
                    $data = array('success1'=>'1');
                    $this->session->set_userdata('success',1);
                    
				}

 
				// success
				
			    
		}
		
		echo  json_encode($data);
		
      // exit;
    }
	 

	 
		
	
	

}