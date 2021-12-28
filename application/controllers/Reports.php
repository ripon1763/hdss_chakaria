<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Reports extends BaseController {

    /**
     * This is default constructor of the class
     */
    public $controller = "reports";
    public $pageTitle = 'Data Management';
    public $pageShortName = 'Data';

    public function __construct() {
        parent::__construct();
		
		ini_set('max_execution_time', 0);
		ini_set('memory_limit','256M');
		ini_set('sqlsrv.ClientBufferMaxKBSize','1048576'); // Setting to 512M
		ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1048576'); // Setting to 512M - for pdo_sqlsrv
        $this->load->model('Reports_model', 'modelName');
        $this->load->model('menu_model', 'menuModel');
        $this->load->library('pagination');
        $this->isLoggedIn();
        $menu_key = 'report';
        $baseID = $this->input->get('baseID', TRUE);
        $result = $this->loadThisForAccess($this->role, $baseID, $menu_key);
        if ($result != true) {
            redirect('access');
        }
    }

    /**
     * This function used to load the first screen of the user
     */
    public function conception() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = 'Conception';
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'conception';
        $data['editMethod'] = 'edit_conception';
        $data['shortName'] = 'Conception';
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0; 

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['conception_info'] = $this->modelName->all_conception_info($data['round_no'], $this->config->item('conceptionTable'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/conception', $data);
        $this->load->view('includes/footer');
    }

    public function edit_conception($id) {
//        echo $id; exit();
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Conception";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_conception';
        $data['shortName'] = "Conception";
        $data['boxTitle'] = 'List';

        $data['conception_info'] = $this->modelName->conception_info($id, $this->config->item('conceptionTable'));


        $data['conception_plan'] = $this->modelName->getLookUpList($this->config->item('conception_plan'));
        $data['conception_order'] = $this->modelName->getLookUpList($this->config->item('conception_order'));
        $data['consp_follow_up_status'] = $this->modelName->getLookUpList($this->config->item('consp_follow_up_status'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_conception', $data);
        $this->load->view('includes/footer');
    }

    public function edit_internal_in($id) {
//        echo $id; exit();
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Internal in";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_internal_in';
        $data['shortName'] = "Internal in";
        $data['boxTitle'] = 'List';

        $data['internal_in_info'] = $this->modelName->internal_in_info($id, $this->config->item('migrationInTable'));

        $data['memberexittyp'] = $this->modelName->getLookUpListSpecific($this->config->item('mementrytyp'), array('intin'));
        $data['internal_movement_cause'] = $this->modelName->getLookUpList($this->config->item('internal_movement_cause'));
        $data['slumlist'] = $this->modelName->getListType($this->config->item('slumTable'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_internal_in', $data);
        $this->load->view('includes/footer');
    }

    function update_internal_in() {

        $migrationID = $this->input->post('migrationID', true);
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('movement_date', 'Movement/migration Date', 'trim|required');

        $getCurrentRound = $this->modelName->getCurrentRound();
        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_internal_in/' . $migrationID . '?baseID=' . $baseID);
        } else {

            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_internal_in/' . $migrationID . '?baseID=' . $baseID);
            }

            $movement_date = $this->input->post('movement_date', true);
            $remarks = $this->input->post('remarks', true);


            $fk_internal_cause = 0;
            $slumID = 0;
            $slumAreaID = 0;
            $househodID = 0;


            $fk_internal_cause = $this->input->post('fk_internal_cause', true);
            $slumID = $this->input->post('slumID', true);
            $slumAreaID = $this->input->post('slumAreaID', true);
            $househodID = $this->input->post('househodID', true);


            $new_movement_date = NULL;

            if (!empty($movement_date)) {
                $parts5 = explode('/', $movement_date);
                $new_movement_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
            }



            $this->db->trans_start();

            try {

                $IdInfo = array(
                    'movement_date' => $new_movement_date,
                    'fk_internal_cause' => $fk_internal_cause,
                    'slumIDFrom' => $slumID,
                    'slumAreaIDFrom' => $slumAreaID,
                    'household_master_id_move_from' => $househodID,
                    'remarks' => $remarks,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($IdInfo, $migrationID, $this->config->item('migrationInTable'));

                // member household

                $whereMigout = array('id' => $member_master_id);
                $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereMigout)->get()->row()->member_household_id_last;


                $memberHouseholdUpdate = array(
                    'entry_date' => $new_movement_date,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($memberHouseholdUpdate, $member_household_id_last, $this->config->item('memberHouseholdTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating movement/Internal in.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Movement/Internal in updated successfully.');

            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/internal_in' . '?baseID=' . $baseID);
            }

            redirect($this->controller . '/edit_internal_in/' . $migrationID . '?baseID=' . $baseID);
        }
    }

    public function edit_migration_in($id) {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Migration in";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_migration_in';
        $data['shortName'] = "Migration in";
        $data['boxTitle'] = 'List';

        $data['migration_in_info'] = $this->modelName->migration_in_info($id, $this->config->item('migrationInTable'));


        $data['memberexittyp'] = $this->modelName->getLookUpListSpecific($this->config->item('mementrytyp'), array('min'));
        $data['outside_cause'] = $this->modelName->getLookUpList($this->config->item('migReason'));
        $data['countrylist'] = $this->modelName->getListType($this->config->item('countryTable'));
        $data['divisionlist'] = $this->modelName->getListType($this->config->item('divTable'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_migration_in', $data);
        $this->load->view('includes/footer');
    }

    function update_migration_in() {

        $migrationID = $this->input->post('migrationID', true);
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('movement_date', 'Movement/migration Date', 'trim|required');

        $getCurrentRound = $this->modelName->getCurrentRound();

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_migration_in/' . $migrationID . '?baseID=' . $baseID);
        } else {

            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_migration_in/' . $migrationID . '?baseID=' . $baseID);
            }


            $movement_date = $this->input->post('movement_date', true);
            $remarks = $this->input->post('remarks', true);

            $fk_migration_cause = 0;
            $countryID = 0;
            $divisionID = 0;
            $districtID = 0;
            $thanaID = 0;

            $fk_migration_cause = $this->input->post('fk_migration_cause', true);
            $countryID = $this->input->post('countryID', true);

            if ($this->config->item('bangladesh') == $countryID) { // bangldesh 
                $divisionID = ($this->input->post('divisionID', true)) ? $this->input->post('divisionID', true) : 0;
                $districtID = ($this->input->post('districtID', true)) ? $this->input->post('districtID', true) : 0;
                $thanaID = ($this->input->post('thanaID', true)) ? $this->input->post('thanaID', true) : 0;
            }



            if (!empty($movement_date)) {
                $parts5 = explode('/', $movement_date);
                $new_movement_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
            }



            $this->db->trans_start();

            try {
                $IdInfo = array(
                    'movement_date' => $new_movement_date,
                    'fk_migration_cause' => $fk_migration_cause,
                    'countryIDMoveFrom' => $countryID,
                    'divisionIDMoveFrom' => $divisionID,
                    'districtIDMoveFrom' => $districtID,
                    'thanaIDMoveFrom' => $thanaID,
                    'remarks' => $remarks,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($IdInfo, $migrationID, $this->config->item('migrationInTable'));


                $whereMigout = array('id' => $member_master_id);
                $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereMigout)->get()->row()->member_household_id_last;


                $memberHouseholdUpdate = array(
                    'entry_date' => $new_movement_date,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($memberHouseholdUpdate, $member_household_id_last, $this->config->item('memberHouseholdTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating movement/migration in.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Movement/Migration in updated successfully.');

            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/migration_in' . '?baseID=' . $baseID);
            }

            redirect($this->controller . '/edit_migration_in/' . $migrationID . '?baseID=' . $baseID);
        }
    }

    public function member_master() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'member_master';
        $data['editMethod'] = 'edit_member_master';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['district_id'] = '';
        $data['thana_id'] = '';
        $data['slum_id'] = '';
        $data['slumarea_id'] = '';
        $data['round_no'] = '';

        $data['district_id'] = $this->input->get('district_id');
        $data['thana_id'] = $this->input->get('thana_id');
        $data['slum_id'] = $this->input->get('slum_id');
        $data['slumarea_id'] = $this->input->get('slumarea_id');
        $data['round_no'] = $this->input->get('round_no');


        $data['district'] = $this->modelName->getListType($this->config->item('districtTable'));
        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));


        if ($this->input->get('Clear') == 'Clear') {
            redirect($this->controller . '/member_master?baseID=' . $baseID);
        }

        $data['member_info'] = $this->modelName->all_member_info($data['district_id'], $data['thana_id'], $data['slum_id'], $data['slumarea_id'], $data['round_no'], $this->config->item('memberMasterTable'));


        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/member', $data);
        $this->load->view('includes/footer');
    }

    public function edit_member_master($id) {

        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id = $this->input->get('household_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Member master";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_member_master';
        $data['shortName'] = "Member master";
        $data['boxTitle'] = 'List';

        $data['member_master_info'] = $this->modelName->member_master_info($id, $this->config->item('memberMasterTable'));


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

        $data['motherList'] = $this->modelName->getMemberMasterPresentListByHouseholdIds($household_master_id, $this->config->item('femaleSexCode'));
        $data['fatherList'] = $this->modelName->getMemberMasterPresentListByHouseholdIds($household_master_id, $this->config->item('femaleSexCodeMale'));
        $data['spouseList'] = $this->modelName->getMemberMasterPresentList($household_master_id);

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_member_master', $data);
        $this->load->view('includes/footer');
    }

    function update_member_master() {

        $this->load->library('form_validation');

        $member_master_id = $this->input->post('id', true);

        $household_master_id = $this->input->post('household_master_id', true);
        $fk_member_relation_id_last = $this->input->post('fk_member_relation_id_last', true);
        $fk_education_id_last = $this->input->post('fk_education_id_last', true);
        $fk_occupation_id_last = $this->input->post('fk_occupation_id_last', true);
        $member_household_id_last = $this->input->post('member_household_id_last', true);


        $baseID = $this->input->get('baseID', TRUE);

        $this->form_validation->set_rules('sexType', 'Sex Type', 'trim|required|numeric');
        $this->form_validation->set_rules('relationheadID', 'Relation with Head', 'trim|required|numeric');
        $this->form_validation->set_rules('maritalStatusType', 'Marital Status', 'trim|required|numeric');

        $this->form_validation->set_rules('memberName', 'Member Name', 'trim|required|max_length[255]|xss_clean');
        // $this->form_validation->set_rules('fatherCode','Father Code','trim|required|max_length[11]|xss_clean');
        // $this->form_validation->set_rules('motherCode','Mother Code','trim|required|max_length[11]|xss_clean');
        //  $this->form_validation->set_rules('spouseCode','Spouse Code','trim|required|max_length[11]|xss_clean');
        $this->form_validation->set_rules('nationalID', 'National ID', 'trim|max_length[50]|xss_clean');

        //$this->form_validation->set_rules('entryType','Entry Type','trim|required|numeric');
        $this->form_validation->set_rules('entryDate', 'Entry Date', 'trim|required');
        $this->form_validation->set_rules('birthdate', 'Birth Date', 'trim|required');

        // $this->form_validation->set_rules('contactNumber','Contact Number','trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('religionType', 'Religion', 'trim|required|numeric');
        $this->form_validation->set_rules('educationType', 'Education Type', 'trim|required|numeric');
        // $this->form_validation->set_rules('secularEduType','Secular Education','trim|required|numeric');
        // $this->form_validation->set_rules('religiousEduType','Religious Education','trim|required|numeric');
        $this->form_validation->set_rules('occupationType', 'Occupation', 'trim|required|numeric');
        $this->form_validation->set_rules('birstRegiType', 'Birth Registration', 'trim|required|numeric');
        $this->form_validation->set_rules('additionalChild', 'additional Child', 'trim|required|numeric');

        $this->form_validation->set_rules('contactNoOne', 'Contact Number One', 'trim|max_length[11]|xss_clean');
        $this->form_validation->set_rules('contactNoTwo', 'Contact Number Two', 'trim|max_length[11]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_member_master/' . $member_master_id . '?baseID=' . $baseID . '&household_master_id=' . $household_master_id);
        } else {
            $memberName = $this->input->post('memberName', true);
            // $entryType = $this->input->post('entryType',true);
            $entryDate = $this->input->post('entryDate', true);
            $sexType = $this->input->post('sexType', true);
            $birthdate = $this->input->post('birthdate', true);

            $contactNoOne = $this->input->post('contactNoOne', true);
            $contactNoTwo = $this->input->post('contactNoTwo', true);

            $fatherCode = $this->input->post('fatherCode', true);
            $motherCode = $this->input->post('motherCode', true);
            $spouseCode = $this->input->post('spouseCode', true);
            $nationalID = $this->input->post('nationalID', true);
            $relationheadID = $this->input->post('relationheadID', true);
            $hhdate = $this->input->post('hhdate', true);

            $maritalStatusType = $this->input->post('maritalStatusType', true);
            $religionType = $this->input->post('religionType', true);
            $educationType = $this->input->post('educationType', true);
            $yearOfEdu = $this->input->post('yearOfEdu', true);
            //  $secularEduType = $this->input->post('secularEduType',true);
            // $religiousEduType = $this->input->post('religiousEduType',true);
            $occupationType = $this->input->post('occupationType', true);
            $birstRegiType = $this->input->post('birstRegiType', true);
            $birthRegidate = $this->input->post('birthRegidate', true);
            $whyNotRegi = $this->input->post('whyNotRegi', true);
            $additionalChild = $this->input->post('additionalChild', true);
            $afterManyYear = $this->input->post('afterManyYear', true);
            $main_occupation_oth = $this->input->post('main_occupation_oth', true);

            // print_r($memberMaster); die();

            if ($maritalStatusType == 41) {
                $additionalChild = $this->input->post('additionalChild', true);
            } else {
                $additionalChild = 0;
            }
            if ($additionalChild == 1) {
                $afterManyYear = $this->input->post('afterManyYear', true);
            } else {
                $afterManyYear = 0;
            }




            $hhcode = $this->getLookUpDetailCode($relationheadID)[0]->internal_code;

            if ($hhcode == $this->config->item('household_head_code')) {
                $head = $this->getActiveHeadDetails($household_master_id, $relationheadID);

                if (!empty($head)) {

                    if ($head[0]->member_master_id != $member_master_id) {

                        $this->session->set_flashdata('error', 'An active head of this household already exist. Plz select something different as relation to head.');
                        redirect($this->controller . '/edit_member_master/' . $member_master_id . '?baseID=' . $baseID . '&household_master_id=' . $household_master_id);
                    }
                }
            }


            $round_master_id = $this->getCurrentRound()[0]->id;


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

            if ($educationType == 45) {
                $yearOfEdu = 0;
            }

            if ($educationType == 120) {
                $yearOfEdu = 0;
            }

            if ($birstRegiType == 2) {
                $whyNotRegi = 0;
            }

            if ($additionalChild == 2) {
                $afterManyYear = 0;
            }


            $this->db->trans_start();

            try {



                $memberMaster = array(
                    'birth_date' => $new_birthdate,
                    'member_name' => $memberName,
                    'fk_marital_status' => $maritalStatusType,
                    'fk_sex' => $sexType,
                    'fk_religion' => $religionType,
                    'fk_relation_with_hhh' => $relationheadID,
                    'father_code' => $fatherCode,
                    'fk_mother_id' => $motherCode,
                    'fk_spouse_id' => $spouseCode,
                    'national_id' => $nationalID,
                    'fk_birth_registration' => $birstRegiType,
                    'birth_registration_date' => $new_birthRegidate,
                    'fk_why_not_birth_registration' => $whyNotRegi,
                    'fk_additionalChild' => $additionalChild,
                    'contactNoTwo' => $contactNoTwo,
                    'contactNoOne' => $contactNoOne,
                    'afterYear' => $afterManyYear,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                // member master

                $this->modelName->UpdateInfo($memberMaster, $member_master_id, $this->config->item('memberMasterTable'));


                // member household

                $memberHousehold = array(
                    'entry_date' => $new_entryDate,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($memberHousehold, $member_household_id_last, $this->config->item('memberHouseholdTable'));


                $whereHouseholdMaster = array('id' => $household_master_id);
                $member_master_id_last_head = $this->db->select('member_master_id_last_head')->from($this->config->item('householdMasterTable'))->where($whereHouseholdMaster)->get()->row()->member_master_id_last_head;


                // household head

                if ($hhcode == $this->config->item('household_head_code')) {


                    if ($member_master_id_last_head != $member_master_id) {

                        $householdMasterNew = array(
                            'member_master_id_last_head' => $member_master_id,
                            'transfer_complete' => 'No',
                            'updateBy' => $this->vendorId,
                            'updatedOn' => date('Y-m-d H:i:s')
                        );

                        $this->modelName->UpdateInfo($householdMasterNew, $household_master_id, $this->config->item('householdMasterTable'));

                        $householdHeadUpdate = array(
                            'is_last_head' => 'No',
                            'transfer_complete' => 'No',
                            'updateBy' => $this->vendorId,
                            'updatedOn' => date('Y-m-d H:i:s')
                        );

                        $this->db->where('household_master_id', $household_master_id);
                        $this->db->where('is_last_head', 'Yes');
                        $this->db->update($this->config->item('memberHeadTable'), $householdHeadUpdate);


                        $whereHouseholdhead = array('household_master_id' => $household_master_id, 'round_master_id' => $round_master_id);

                        $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberHeadTable'))->where($whereHouseholdhead)->get()->row()->countRow;

                        if ($countRow > 0) {

                            $headID = $this->db->select('id')->from($this->config->item('memberHeadTable'))->where($whereHouseholdhead)->get()->row()->id;

                            $householdHeadup = array(
                                'member_master_id' => $member_master_id,
                                'change_date' => $new_hhdate,
                                'is_last_head' => 'Yes',
                                'transfer_complete' => 'No',
                                'updateBy' => $this->vendorId,
                                'updatedOn' => date('Y-m-d H:i:s')
                            );

                            $this->modelName->UpdateInfo($householdHeadup, $headID, $this->config->item('memberHeadTable'));
                        } else {

                            $householdHeadNew = array(
                                'member_master_id' => $member_master_id,
                                'household_master_id' => $household_master_id,
                                'round_master_id' => $round_master_id,
                                'change_date' => $new_hhdate,
                                'is_last_head' => 'Yes',
                                'transfer_complete' => 'No',
                                'insertedBy' => $this->vendorId,
                                'insertedOn' => date('Y-m-d H:i:s')
                            );

                            $this->modelName->addNewList($householdHeadNew, $this->config->item('memberHeadTable'));
                        }
                    }
                } else if ($member_master_id_last_head == $member_master_id) {

                    //update household_head

                    $householdHeadUpdate = array(
                        'is_last_head' => 'No',
                        'transfer_complete' => 'No',
                        'updateBy' => $this->vendorId,
                        'updatedOn' => date('Y-m-d H:i:s')
                    );

                    $this->db->where('household_master_id', $household_master_id);
                    $this->db->where('is_last_head', 'Yes');
                    $this->db->update($this->config->item('memberHeadTable'), $householdHeadUpdate);


                    // delete household head
                    $this->db->where('household_master_id', $member_master_id_last_head);
                    $this->db->where('round_master_id', $round_master_id);
                    $this->db->delete($this->config->item('memberHeadTable'));


                    $householdMaster = array(
                        'member_master_id_last_head' => 0,
                        'transfer_complete' => 'No',
                        'updateBy' => $this->vendorId,
                        'updatedOn' => date('Y-m-d H:i:s')
                    );

                    $this->modelName->UpdateInfo($householdMaster, $household_master_id, $this->config->item('householdMasterTable'));
                }

                // occupation
                $occupation = array(
                    'fk_main_occupation' => $occupationType,
                    'main_occupation_oth' => $main_occupation_oth,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($occupation, $fk_occupation_id_last, $this->config->item('memberOccupationTable'));

                // Education

                $education = array(
                    // 'fk_religious_edu'=>$religiousEduType, 
                    //  'fk_secular_edu'=>$secularEduType, 
                    'fk_education_type' => $educationType,
                    'year_of_education' => $yearOfEdu,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($education, $fk_education_id_last, $this->config->item('memberEducationTable'));


                // Relation

                $relation = array(
                    'fk_relation' => $relationheadID,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($relation, $fk_member_relation_id_last, $this->config->item('memberRelationTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating member.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Member info updated successfully');

            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/member_master' . '?baseID=' . $baseID);
            }

            redirect($this->controller . '/edit_member_master/' . $member_master_id . '?baseID=' . $baseID . '&household_master_id=' . $household_master_id);
        }
    }

    public function pregnancy() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Pregnancy";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'pregnancy';
        $data['editMethod'] = 'edit_pregnancy';
        $data['shortName'] = 'Pregnancy';
        $data['boxTitle'] = 'List';
        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['pregnancy_info'] = $this->modelName->all_pregnancy_info($data['round_no'], $this->config->item('pregnancyTable'));


        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/pregnancy', $data);
        $this->load->view('includes/footer');
    }

    public function edit_pregnancy($id) {
//        echo $id; exit();
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Pregnancy";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_pregnancy';
        $data['shortName'] = "Pregnancy";
        $data['boxTitle'] = 'List';

        $data['pregnancy_info'] = $this->modelName->pregnancy_info($id, $this->config->item('pregnancyTable'));

        $data['pregnancy_result'] = $this->modelName->getLookUpList($this->config->item('pregnancy_result'));
        $data['delivery_methodology'] = $this->modelName->getLookUpList($this->config->item('delivery_methodology'));
        $data['preg_term_assist'] = $this->modelName->getLookUpList($this->config->item('preg_term_assist'));
        $data['preg_term_place'] = $this->modelName->getLookUpList($this->config->item('preg_term_place'));
        $data['yes_no_miss_not_app'] = $this->modelName->getLookUpList($this->config->item('yes_no_miss_not_app'));


        $data['onlyYesNo'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
        $data['ancPncVisit'] = $this->modelName->getLookUpList($this->config->item('ancPncVisit'));
        $data['litter_size'] = $this->modelName->getLookUpList($this->config->item('litter_size'));

        $data['yes_no'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
        $data['yes_no_com'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
        $data['facility_delivery'] = $this->modelName->getLookUpList($this->config->item('facility_delivery'));
        $data['fast_milk_birth'] = $this->modelName->getLookUpList($this->config->item('fast_milk_birth'));
        $data['anc_assist_typ'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));
        $data['anc_assist_typ1'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));
        $data['anc_assist_typ2'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));
        $data['anc_assist_typ3'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));
        $data['anc_assist_typ4'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));
        $data['pnc_assist_typ'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));
        $data['pnc_assist_typ1'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));

        $data['prescribe_antibiotics'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));

        $data['go_for_treatment'] = $this->modelName->getLookUpList($this->config->item('ancPncVisit'));

        $data['ifa_supliment_source'] = $this->modelName->getLookUpList($this->config->item('ifa_supliment_source'));
        $data['how_many_tablet'] = $this->modelName->getLookUpList($this->config->item('how_many_tablet'));
        $data['yes_no_not_applicable'] = $this->modelName->getLookUpList($this->config->item('yes_no_not_applicable'));
        $data['knowledgebehavior'] = $this->modelName->getLookUpList($this->config->item('knowledge_behavior'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_pregnancy', $data);
        $this->load->view('includes/footer');
    }

    function update_pregnancy() {

        $member_master_id = $this->input->post('member_master_id', true);
        $conceptionID = $this->input->post('conceptionID', true);
        $pregnancyID = $this->input->post('pregnancyID', true);

        $this->load->library('form_validation');



        $this->form_validation->set_rules('pregnancy_outcome_date', 'pregnancy outcome Date', 'trim|required');
        $this->form_validation->set_rules('spontaneous_abortion', 'spontaneous abortion', 'trim|required|numeric');
        $this->form_validation->set_rules('induced_abortion', 'induced abortion', 'trim|required|numeric');
        $this->form_validation->set_rules('still_birth', 'still birth', 'trim|required|numeric');

        $this->form_validation->set_rules('live_birth', 'live birth', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_conception_result', 'conception result', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_delivery_methodology', 'Delivery methodology', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_delivery_assist_type', 'Delivery assist type', 'trim|required|numeric');

        $this->form_validation->set_rules('fk_delivery_term_place', 'Delivery Termination Place', 'trim|required|numeric');
        // $this->form_validation->set_rules('given_six_hour_birth','given_six_hour_birth','trim');
        // $this->form_validation->set_rules('breast_milk_day','breast milk day','trim|required|numeric');
        // $this->form_validation->set_rules('breast_milk_hour','breast milk hour','trim|required|numeric');
        // $this->form_validation->set_rules('fk_health_problem_id','Health Problem','trim|required|numeric');
        // $this->form_validation->set_rules('fk_high_pressure_id','High Pressure','trim|required|numeric');
        // $this->form_validation->set_rules('fk_diabetis_id','Diabetis','trim|required|numeric');
        // $this->form_validation->set_rules('fk_preaklampshia_id','Pre aklampshia','trim|required|numeric');
        // $this->form_validation->set_rules('fk_lebar_birth_id','Pre term Laber','trim|required|numeric');
        // $this->form_validation->set_rules('fk_vomiting_id','Vomiting','trim|required|numeric');
        // $this->form_validation->set_rules('fk_amliotic_id','Amliotic','trim|required|numeric');
        // $this->form_validation->set_rules('fk_membrane_id','Membrane','trim|required|numeric');
        // $this->form_validation->set_rules('fk_malposition_id','Malposition','trim|required|numeric');
        // $this->form_validation->set_rules('fk_headache_id','Headache','trim|required|numeric');
        // $this->form_validation->set_rules('keep_follow_up','Follow up','trim|required|numeric');
        $this->form_validation->set_rules('conceptionID', 'Conception ID', 'trim|required|numeric');
        $this->form_validation->set_rules('checkupTypeRoutine', 'Routine check-up in pregnancy  for mother', 'trim|required|numeric');
        $this->form_validation->set_rules('checkupType', 'Within 42 days of the birth of the baby you ever had a check-up', 'trim|required|numeric');

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_pregnancy/' . $pregnancyID . '?baseID=' . $baseID);
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_pregnancy/' . $pregnancyID . '?baseID=' . $baseID);
            }


            $spontaneous_abortion = $this->input->post('spontaneous_abortion', true);
            $induced_abortion = $this->input->post('induced_abortion', true);
            $still_birth = $this->input->post('still_birth', true);
            $live_birth = $this->input->post('live_birth', true);
            $fk_conception_result = $this->input->post('fk_conception_result', true);
            $fk_delivery_methodology = $this->input->post('fk_delivery_methodology', true);
            $fk_delivery_assist_type = $this->input->post('fk_delivery_assist_type', true);
            $fk_delivery_term_place = $this->input->post('fk_delivery_term_place', true);
            // $given_six_hour_birth = $this->input->post('given_six_hour_birth',true);
            // $breast_milk_day = $this->input->post('breast_milk_day',true);
            // $breast_milk_hour = $this->input->post('breast_milk_hour',true);
            // $fk_health_problem_id = $this->input->post('fk_health_problem_id',true);
            // $fk_high_pressure_id = $this->input->post('fk_high_pressure_id',true);
            // $fk_diabetis_id = $this->input->post('fk_diabetis_id',true);
            // $fk_preaklampshia_id = $this->input->post('fk_preaklampshia_id',true);
            // $fk_lebar_birth_id = $this->input->post('fk_lebar_birth_id',true);
            // $fk_vomiting_id = $this->input->post('fk_vomiting_id',true);
            // $fk_amliotic_id = $this->input->post('fk_amliotic_id',true);
            // $fk_membrane_id = $this->input->post('fk_membrane_id',true);
            // $fk_malposition_id = $this->input->post('fk_malposition_id',true);
            // $fk_headache_id = $this->input->post('fk_headache_id',true);
            // $keep_follow_up = $this->input->post('keep_follow_up',true);
            $conceptionDate = $this->input->post('conceptionDate', true);

            $fk_facility_delivery = $this->input->post('fk_facility_delivery', true);

            if (($fk_conception_result == 95) || ($fk_conception_result == 199)) {
                $fk_colostrum = 0;
                $fk_first_milk = 0;
                $milk_day = 0;
            } else {

                $fk_colostrum = $this->input->post('fk_colostrum', true);
                $fk_first_milk = $this->input->post('fk_first_milk', true);
                $milk_hours = $this->input->post('milk_hours', true);
                $milk_day = $this->input->post('milk_day', true);
            }

            if (($fk_delivery_term_place == 103) || ($fk_delivery_term_place == 104) || ($fk_delivery_term_place == 205)) {
                $fk_facility_delivery = 0;
            } else {
                $fk_facility_delivery = $this->input->post('fk_facility_delivery', true) ? $this->input->post('fk_facility_delivery', true) : 0;
            }


            $fk_preg_complication = $this->input->post('fk_preg_complication', true) ? $this->input->post('fk_preg_complication', true) : 0;
            $fk_delivery_complication = $this->input->post('fk_delivery_complication', true) ? $this->input->post('fk_delivery_complication', true) : 0;
            $fk_preg_violence = $this->input->post('fk_preg_violence', true) ? $this->input->post('fk_preg_violence', true) : 0;
            $fk_litter_size = $this->input->post('fk_litter_size', true) ? $this->input->post('fk_litter_size', true) : 0;




            $pregnancy_outcome_date = $this->input->post('pregnancy_outcome_date', true);

            $new_pregnancy_outcome_date = null;

            if (!empty($pregnancy_outcome_date)) {
                $parts3 = explode('/', $pregnancy_outcome_date);
                $new_pregnancy_outcome_date = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            // anc
            $checkupTypeRoutine = $this->input->post('checkupTypeRoutine', true);

            if ($checkupTypeRoutine == 1) {

                $afterTotalTimesRoutine = $this->input->post('afterTotalTimesRoutine', true) ? $this->input->post('afterTotalTimesRoutine', true) : 0;

                $routineFirstVisitAsist = $this->input->post('routineFirstVisitAsist', true);
                $routineFirstVisit = $this->input->post('routineFirstVisit', true);
                $routineFirstVisitMonthss = $this->input->post('routineFirstVisitMonthss', true) ? $this->input->post('routineFirstVisitMonthss', true) : 0;

                $routineSecondVisitAsist = $this->input->post('routineSecondVisitAsist', true);
                $routineSecondVisit = $this->input->post('routineSecondVisit', true);
                $routineSecondVisitMonths = $this->input->post('routineSecondVisitMonths', true) ? $this->input->post('routineSecondVisitMonths', true) : 0;

                $routineThirdVisitAsist = $this->input->post('routineThirdVisitAsist', true);
                $routineThirdVisit = $this->input->post('routineThirdVisit', true);
                $routineThirdVisitMonths = $this->input->post('routineThirdVisitMonths', true) ? $this->input->post('routineThirdVisitMonths', true) : 0;

                $routineFourthVisitAsist = $this->input->post('routineFourthVisitAsist', true);
                $routineFourthVisit = $this->input->post('routineFourthVisit', true);
                $routineFourthVisitMonths = $this->input->post('routineFourthVisitMonths', true) ? $this->input->post('routineFourthVisitMonths', true) : 0;

                $routineFifthVisitAsist = $this->input->post('routineFifthVisitAsist', true);
                $routineFifthVisit = $this->input->post('routineFifthVisit', true);
                $routineFifthVisitMonths = $this->input->post('routineFifthVisitMonths', true) ? $this->input->post('routineFifthVisitMonths', true) : 0;
            } else {
                $routineFirstVisitAsist = 0;
                $routineSecondVisitAsist = 0;
                $routineThirdVisitAsist = 0;
                $routineFourthVisitAsist = 0;
                $routineFifthVisitAsist = 0;

                $afterTotalTimesRoutine = 0;
                $routineFirstVisit = 0;
                $routineFirstVisitMonthss = 0;
                $routineSecondVisit = 0;
                $routineSecondVisitMonths = 0;
                $routineThirdVisit = 0;
                $routineThirdVisitMonths = 0;
                $routineFourthVisit = 0;
                $routineFourthVisitMonths = 0;
                $routineFifthVisit = 0;
                $routineFifthVisitMonths = 0;
            }

            $fk_supliment = $this->input->post('fk_supliment', true);
            if ($fk_supliment == 1) {
                $fk_supliment_received_way = $this->input->post('fk_supliment_received_way', true) ? $this->input->post('fk_supliment_received_way', true) : 0;
                $fk_how_many_tab = $this->input->post('fk_how_many_tab', true) ? $this->input->post('fk_how_many_tab', true) : 0;

                if ($fk_how_many_tab == 226) {
                    $totalNumberTablet = $this->input->post('totalNumberTablet', true) ? $this->input->post('totalNumberTablet', true) : 0;
                } else {
                    $totalNumberTablet = 0;
                }
            } else {
                $fk_supliment_received_way = 0;
                $fk_how_many_tab = 0;
                $totalNumberTablet = 0;
            }



            // Basic components of ANC
            $fk_anc_weight_taken = $this->input->post('fk_anc_weight_taken', true);
            $fk_anc_blood_pressure = $this->input->post('fk_anc_blood_pressure', true);
            $fk_anc_urine = $this->input->post('fk_anc_urine', true);
            $fk_anc_blood = $this->input->post('fk_anc_blood', true);
            $fk_anc_denger_sign = $this->input->post('fk_anc_denger_sign', true);
            $fk_anc_nutrition = $this->input->post('fk_anc_nutrition', true);
            $fk_anc_birth_prepare = $this->input->post('fk_anc_birth_prepare', true);

            // Newborn care practices

            $fk_anc_delivery_kit = $this->input->post('fk_anc_delivery_kit', true);
            $fk_anc_soap = $this->input->post('fk_anc_soap', true);
            $fk_anc_care_chix = $this->input->post('fk_anc_care_chix', true);

            $fk_anc_dried = $this->input->post('fk_anc_dried', true);
            $fk_anc_bathing = $this->input->post('fk_anc_bathing', true);
            $fk_anc_breast_feed = $this->input->post('fk_anc_breast_feed', true);
            $fk_anc_skin_contact = $this->input->post('fk_anc_skin_contact', true);
            $fk_anc_enc = $this->input->post('fk_anc_enc', true);


            //  sepsis

            $fk_suspecred_infection = $this->input->post('fk_suspecred_infection', true);

            if ($fk_suspecred_infection == 228) {

                $fk_baby_antibiotics = $this->input->post('fk_baby_antibiotics', true) ? $this->input->post('fk_baby_antibiotics', true) : 0;
                if ($fk_baby_antibiotics == 1) {
                    $fk_prescribe_antibiotics = $this->input->post('fk_prescribe_antibiotics', true) ? $this->input->post('fk_prescribe_antibiotics', true) : 0;
                    $fk_seek_treatment = $this->input->post('fk_seek_treatment', true) ? $this->input->post('fk_seek_treatment', true) : 0;
                } else {
                    $fk_prescribe_antibiotics = 0;
                    $fk_seek_treatment = 0;
                }
            } else {
                $fk_baby_antibiotics = 0;
                $fk_prescribe_antibiotics = 0;
                $fk_seek_treatment = 0;
            }



            //  Knowledge and Behavior 

            $fk_anc_vaginal_bleeding = $this->input->post('fk_anc_vaginal_bleeding', true);
            $fk_anc_convulsions = $this->input->post('fk_anc_convulsions', true);
            $fk_anc_severe_headache = $this->input->post('fk_anc_severe_headache', true);
            $fk_anc_fever = $this->input->post('fk_anc_fever', true);
            $fk_anc_abdominal_pain = $this->input->post('fk_anc_abdominal_pain', true);
            $fk_anc_diff_breath = $this->input->post('fk_anc_diff_breath', true);

            // danger signs of delivery
            $fk_anc_water_break = $this->input->post('fk_anc_water_break', true);
            $fk_anc_vaginal_bleed_aph = $this->input->post('fk_anc_vaginal_bleed_aph', true);
            $fk_anc_obstructed_labour = $this->input->post('fk_anc_obstructed_labour', true);
            $fk_anc_convulsion = $this->input->post('fk_anc_convulsion', true);
            $fk_anc_sepsis = $this->input->post('fk_anc_sepsis', true);
            $fk_anc_severe_headache_delivery = $this->input->post('fk_anc_severe_headache_delivery', true);
            $fk_anc_consciousness = $this->input->post('fk_anc_consciousness', true);

            // signs of postnatal period

            $fk_anc_vaginal_bleeding_post = $this->input->post('fk_anc_vaginal_bleeding_post', true);
            $fk_anc_convulsion_eclampsia_post = $this->input->post('fk_anc_convulsion_eclampsia_post', true);
            $fk_anc_high_feaver_post = $this->input->post('fk_anc_high_feaver_post', true);
            $fk_anc_smelling_discharge_post = $this->input->post('fk_anc_smelling_discharge_post', true);
            $fk_anc_severe_headache_post = $this->input->post('fk_anc_severe_headache_post', true);
            $fk_anc_consciousness_post = $this->input->post('fk_anc_consciousness_post', true);

            // signs of newborn baby
            $fk_anc_inability_baby = $this->input->post('fk_anc_inability_baby', true);
            $fk_anc_baby_small_baby = $this->input->post('fk_anc_baby_small_baby', true);
            $fk_anc_fast_breathing_baby = $this->input->post('fk_anc_fast_breathing_baby', true);
            $fk_anc_convulsions_baby = $this->input->post('fk_anc_convulsions_baby', true);
            $fk_anc_drowsy_baby = $this->input->post('fk_anc_drowsy_baby', true);
            $fk_anc_movement_baby = $this->input->post('fk_anc_movement_baby', true);
            $fk_anc_grunting_baby = $this->input->post('fk_anc_grunting_baby', true);
            $fk_anc_indrawing_baby = $this->input->post('fk_anc_indrawing_baby', true);
            $fk_anc_temperature_baby = $this->input->post('fk_anc_temperature_baby', true);
            $fk_anc_hypothermia_baby = $this->input->post('fk_anc_hypothermia_baby', true);
            $fk_anc_central_cyanosis_baby = $this->input->post('fk_anc_central_cyanosis_baby', true);
            $fk_anc_umbilicus_baby = $this->input->post('fk_anc_umbilicus_baby', true);

            //complicated pregnancy

            $fk_anc_labour_preg = $this->input->post('fk_anc_labour_preg', true);
            $fk_anc_excessive_bld_pre = $this->input->post('fk_anc_excessive_bld_pre', true);
            $fk_anc_severe_headache_preg = $this->input->post('fk_anc_severe_headache_preg', true);
            $fk_anc_obstructed_preg = $this->input->post('fk_anc_obstructed_preg', true);
            $fk_anc_convulsion_preg = $this->input->post('fk_anc_convulsion_preg', true);
            $fk_anc_placenta_preg = $this->input->post('fk_anc_placenta_preg', true);


            //newborn and child
            $fk_anc_breath_child = $this->input->post('fk_anc_breath_child', true);
            $fk_anc_suck_baby = $this->input->post('fk_anc_suck_baby', true);
            $fk_anc_hot_cold_child = $this->input->post('fk_anc_hot_cold_child', true);
            $fk_anc_blue_child = $this->input->post('fk_anc_blue_child', true);
            $fk_anc_convulsion_child = $this->input->post('fk_anc_convulsion_child', true);
            $fk_anc_indrawing_child = $this->input->post('fk_anc_indrawing_child', true);


            $remarks = $this->input->post('remarks', true);

            // pnc
            $fk_supliment_post = $this->input->post('fk_supliment_post', true);


            // pnc
            $checkupType = $this->input->post('checkupType', true);


            if ($checkupType == 1) {

                $fk_post_natal_visit = $this->input->post('fk_post_natal_visit', true) ? $this->input->post('fk_post_natal_visit', true) : 0;
                $afterTotalTimes = $this->input->post('afterTotalTimes', true) ? $this->input->post('afterTotalTimes', true) : 0;

                $pncFirstVisitAsist = $this->input->post('pncFirstVisitAsist', true);
                $firstVisit = $this->input->post('firstVisit', true);
                $firstVisitDays = $this->input->post('firstVisitDays', true) ? $this->input->post('firstVisitDays', true) : 0;

                $pncSecondVisitAsist = $this->input->post('pncSecondVisitAsist', true);
                $secondVisit = $this->input->post('secondVisit', true);
                $secondVisitDays = $this->input->post('secondVisitDays', true) ? $this->input->post('secondVisitDays', true) : 0;
            } else {
                $afterTotalTimes = 0;
                $fk_post_natal_visit = 0;
                $pncFirstVisitAsist = 0;
                $pncSecondVisitAsist = 0;
                $firstVisit = 0;
                $firstVisitDays = 0;
                $secondVisit = 0;
                $secondVisitDays = 0;
            }

            //live_birth

            if ($live_birth > 0) {
                if (!empty($conceptionDate)) {
                    $concept = date_create($conceptionDate);
                    $preg = date_create($new_pregnancy_outcome_date);
                    $diff = date_diff($concept, $preg);
                    $days = $diff->format("%a");


                    if ($days <= 160) {
                        $this->session->set_flashdata('error', 'Pregnancy out come date is less than 160 days.');
                        //redirect('memberPregnancy/addEditPregnancy/'. $pregnancyID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#pregnancy');
                    }

                    if ($days >= 320) {
                        $this->session->set_flashdata('error', 'Pregnancy out come date is greater than 320 days.');
                        //redirect('memberPregnancy/addEditPregnancy/'. $pregnancyID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#pregnancy');
                    }
                }
            }


            $this->db->trans_start();

            try {


                // check same pregnancy date
                $whereHouseholdPregDate = array('pregnancy_outcome_date' => $new_pregnancy_outcome_date, 'member_master_id' => $member_master_id);

                $countRowDate = $this->db->select('count(id) as countRowDate')->from($this->config->item('pregnancyTable'))->where($whereHouseholdPregDate)->get()->row()->countRowDate;

                if ($countRowDate > 1) {
                    $this->session->set_flashdata('error', 'Same pregnancy outcome date already exists. Please select another date.');
                    redirect($this->controller . '/edit_pregnancy/' . $pregnancyID . '?baseID=' . $baseID);
                }


                $IdInfo = array(
                    'pregnancy_outcome_date' => $new_pregnancy_outcome_date,
                    //'breast_milk_day'=>$breast_milk_day, 
                    //'breast_milk_hour'=>$breast_milk_hour,
                    'induced_abortion' => $induced_abortion,
                    'spontaneous_abortion' => $spontaneous_abortion,
                    'live_birth' => $live_birth,
                    'still_birth' => $still_birth,
                    'fk_delivery_methodology' => $fk_delivery_methodology,
                    'fk_delivery_assist_type' => $fk_delivery_assist_type,
                    'fk_delivery_term_place' => $fk_delivery_term_place,
                    'fk_litter_size' => $fk_litter_size,
                    'fk_colostrum' => $fk_colostrum,
                    'fk_first_milk' => $fk_first_milk,
                    'milk_hours' => $milk_hours,
                    'milk_day' => $milk_day,
                    'fk_facility_delivery' => $fk_facility_delivery,
                    'fk_preg_complication' => $fk_preg_complication,
                    'fk_delivery_complication' => $fk_delivery_complication,
                    'fk_preg_violence' => $fk_preg_violence,
                    'fk_anc_first_assist_id' => $routineFirstVisitAsist,
                    'fk_anc_second_assist_id' => $routineSecondVisitAsist,
                    'fk_anc_third_assist_id' => $routineThirdVisitAsist,
                    'fk_anc_fourth_assist_id' => $routineFourthVisitAsist,
                    'fk_anc_fifth_assist_id' => $routineFifthVisitAsist,
                    'fk_anc_supliment' => $fk_supliment,
                    'fk_supliment_received_way' => $fk_supliment_received_way,
                    'fk_how_many_tab' => $fk_how_many_tab,
                    'totalnumbertab' => $totalNumberTablet,
                    'fk_anc_weight_taken' => $fk_anc_weight_taken,
                    'fk_anc_blood_pressure' => $fk_anc_blood_pressure,
                    'fk_anc_urine' => $fk_anc_urine,
                    'fk_anc_blood' => $fk_anc_blood,
                    'fk_anc_denger_sign' => $fk_anc_denger_sign,
                    'fk_anc_nutrition' => $fk_anc_nutrition,
                    'fk_anc_birth_prepare' => $fk_anc_birth_prepare,
                    'fk_anc_delivery_kit' => $fk_anc_delivery_kit,
                    'fk_anc_soap' => $fk_anc_soap,
                    'fk_anc_care_chix' => $fk_anc_care_chix,
                    'fk_anc_dried' => $fk_anc_dried,
                    'fk_anc_bathing' => $fk_anc_bathing,
                    'fk_anc_breast_feed' => $fk_anc_breast_feed,
                    'fk_anc_skin_contact' => $fk_anc_skin_contact,
                    'fk_anc_enc' => $fk_anc_enc,
                    'fk_suspecred_infection' => $fk_suspecred_infection,
                    'fk_baby_antibiotics' => $fk_baby_antibiotics,
                    'fk_prescribe_antibiotics' => $fk_prescribe_antibiotics,
                    'fk_seek_treatment' => $fk_seek_treatment,
                    'fk_anc_vaginal_bleeding' => $fk_anc_vaginal_bleeding,
                    'fk_anc_convulsions' => $fk_anc_convulsions,
                    'fk_anc_severe_headache' => $fk_anc_severe_headache,
                    'fk_anc_fever' => $fk_anc_fever,
                    'fk_anc_abdominal_pain' => $fk_anc_abdominal_pain,
                    'fk_anc_diff_breath' => $fk_anc_diff_breath,
                    'fk_anc_water_break' => $fk_anc_water_break,
                    'fk_anc_vaginal_bleed_aph' => $fk_anc_vaginal_bleed_aph,
                    'fk_anc_obstructed_labour' => $fk_anc_obstructed_labour,
                    'fk_anc_convulsion' => $fk_anc_convulsion,
                    'fk_anc_sepsis' => $fk_anc_sepsis,
                    'fk_anc_severe_headache_delivery' => $fk_anc_severe_headache_delivery,
                    'fk_anc_consciousness' => $fk_anc_consciousness,
                    'fk_anc_vaginal_bleeding_post' => $fk_anc_vaginal_bleeding_post,
                    'fk_anc_convulsion_eclampsia_post' => $fk_anc_convulsion_eclampsia_post,
                    'fk_anc_high_feaver_post' => $fk_anc_high_feaver_post,
                    'fk_anc_smelling_discharge_post' => $fk_anc_smelling_discharge_post,
                    'fk_anc_severe_headache_post' => $fk_anc_severe_headache_post,
                    'fk_anc_consciousness_post' => $fk_anc_consciousness_post,
                    'fk_anc_inability_baby' => $fk_anc_inability_baby,
                    'fk_anc_baby_small_baby' => $fk_anc_baby_small_baby,
                    'fk_anc_fast_breathing_baby' => $fk_anc_fast_breathing_baby,
                    'fk_anc_convulsions_baby' => $fk_anc_convulsions_baby,
                    'fk_anc_drowsy_baby' => $fk_anc_drowsy_baby,
                    'fk_anc_movement_baby' => $fk_anc_movement_baby,
                    'fk_anc_grunting_baby' => $fk_anc_grunting_baby,
                    'fk_anc_indrawing_baby' => $fk_anc_indrawing_baby,
                    'fk_anc_temperature_baby' => $fk_anc_temperature_baby,
                    'fk_anc_hypothermia_baby' => $fk_anc_hypothermia_baby,
                    'fk_anc_central_cyanosis_baby' => $fk_anc_central_cyanosis_baby,
                    'fk_anc_umbilicus_baby' => $fk_anc_umbilicus_baby,
                    'fk_anc_labour_preg' => $fk_anc_labour_preg,
                    'fk_anc_severe_headache_preg' => $fk_anc_severe_headache_preg,
                    'fk_anc_excessive_bld_pre' => $fk_anc_excessive_bld_pre,
                    'fk_anc_convulsion_preg' => $fk_anc_convulsion_preg,
                    'fk_anc_obstructed_preg' => $fk_anc_obstructed_preg,
                    'fk_anc_placenta_preg' => $fk_anc_placenta_preg,
                    'fk_anc_breath_child' => $fk_anc_breath_child,
                    'fk_anc_suck_baby' => $fk_anc_suck_baby,
                    'fk_anc_hot_cold_child' => $fk_anc_hot_cold_child,
                    'fk_anc_blue_child' => $fk_anc_blue_child,
                    'fk_anc_convulsion_child' => $fk_anc_convulsion_child,
                    'fk_anc_indrawing_child' => $fk_anc_indrawing_child,
                    'fk_supliment_post' => $fk_supliment_post,
                    'fk_post_natal_visit' => $fk_post_natal_visit,
                    'fk_pnc_first_visit_assist' => $pncFirstVisitAsist,
                    'fk_pnc_second_visit_assist' => $pncSecondVisitAsist,
                    'remarks' => $remarks,
                    // 'given_six_hour_birth'=>$given_six_hour_birth,
                    // 'fk_health_problem_id'=>$fk_health_problem_id,
                    // 'fk_high_pressure_id'=>$fk_high_pressure_id,
                    // 'fk_diabetis_id'=>$fk_diabetis_id,
                    // 'fk_preaklampshia_id'=>$fk_preaklampshia_id,
                    // 'fk_lebar_birth_id'=>$fk_lebar_birth_id,
                    // 'fk_vomiting_id'=>$fk_vomiting_id,
                    // 'fk_amliotic_id'=>$fk_amliotic_id,
                    // 'fk_membrane_id'=>$fk_membrane_id,
                    // 'fk_malposition_id'=>$fk_malposition_id,
                    // 'fk_headache_id'=>$fk_headache_id,
                    'fk_routine_anc_chkup_mother_id' => $checkupTypeRoutine,
                    'routine_anc_chkup_mother_times' => $afterTotalTimesRoutine,
                    'fk_anc_first_visit_id' => $routineFirstVisit,
                    'anc_first_visit_months' => $routineFirstVisitMonthss,
                    'fk_anc_second_visit_id' => $routineSecondVisit,
                    'anc_second_visit_months' => $routineSecondVisitMonths,
                    'fk_anc_third_visit_id' => $routineThirdVisit,
                    'anc_third_visit_months' => $routineThirdVisitMonths,
                    'fk_anc_fourth_visit_id' => $routineFourthVisit,
                    'anc_fourth_visit_months' => $routineFourthVisitMonths,
                    'fk_anc_fifth_visit_id' => $routineFifthVisit,
                    'anc_fifth_visit_months' => $routineFifthVisitMonths,
                    'fk_pnc_chkup_mother_id' => $checkupType,
                    'pnc_chkup_mother_times' => $afterTotalTimes,
                    'fk_pnc_first_visit_id' => $firstVisit,
                    'pnc_first_visit_days' => $firstVisitDays,
                    'fk_pnc_second_visit_id' => $secondVisit,
                    'pnc_second_visit_days' => $secondVisitDays,
                    //'keep_follow_up'=>$keep_follow_up,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($IdInfo, $pregnancyID, $this->config->item('pregnancyTable'));


                $conceptfo = array(
                    'fk_conception_result' => $fk_conception_result,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );


                $this->modelName->UpdateInfo($conceptfo, $conceptionID, $this->config->item('conceptionTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating pregnancy.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Member pregnancy info updated successfully.');

            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/pregnancy' . '?baseID=' . $baseID);
            }

            redirect($this->controller . '/edit_pregnancy/' . $pregnancyID . '?baseID=' . $baseID);
        }
    }

    public function birth() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'birth';
        $data['editMethod'] = 'edit_birth';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';
        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['birth_info'] = $this->modelName->all_birth_info($data['round_no'], $this->config->item('memberMasterTable'));


        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/birth', $data);
        $this->load->view('includes/footer');
    }

    public function edit_birth($id) {
        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id = $this->input->get('household_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Birth";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_birth';
        $data['shortName'] = "Birth";
        $data['boxTitle'] = 'List';

        $data['birth_info'] = $this->modelName->birth_info($id, $this->config->item('memberMasterTable'));


        $data['femaleList'] = $this->modelName->getMemberMasterPresentListByHouseholdIds($household_master_id, $this->config->item('femaleSexCode'));
        $data['maleList'] = $this->modelName->getMemberMasterPresentListByHouseholdIds($household_master_id, $this->config->item('femaleSexCodeMale'));


        $data['entryType'] = $this->modelName->getLookUpListSpecific($this->config->item('mementrytyp'), array('bir'));
        $data['maritalstatustyp'] = $this->modelName->getLookUpListSpecific($this->config->item('maritalstatustyp'), array('5'));
        $data['membersextype'] = $this->modelName->getLookUpList($this->config->item('membersextype'));
        $data['relationhhh'] = $this->modelName->getLookUpListNotSpecific($this->config->item('relationhhh'), array('01', '02', '09'));



        $data['religion'] = $this->modelName->getLookUpList($this->config->item('religion'));

        $data['birth_weight_size'] = $this->modelName->getLookUpList($this->config->item('birth_weight_size'));
        $data['mother_live_birth_order'] = $this->modelName->getLookUpList($this->config->item('mother_live_birth_order'));

        $data['educationtyp'] = $this->modelName->getLookUpList($this->config->item('educationtyp'));
        $data['occupationtyp'] = $this->modelName->getLookUpList($this->config->item('occupationtyp'));
        $data['birthregistration'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
        $data['additionChild'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
        $data['whynotbirthreg'] = $this->modelName->getLookUpList($this->config->item('whynotbirthreg'));
        $data['pncassisttyp'] = $this->modelName->getLookUpList($this->config->item('anc_assist_typ'));

        $data['onlyYesNo'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
        $data['ancPncVisit'] = $this->modelName->getLookUpList($this->config->item('ancPncVisit'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_birth', $data);
        $this->load->view('includes/footer');
    }

    function update_birth() {
        $household_master_id = $this->input->post('household_master_id', true);
        $member_master_id = $this->input->post('member_master_id', true);
        $member_household_id_last = $this->input->post('member_household_id_last', true);
        $fk_education_id_last = $this->input->post('fk_education_id_last', true);
        $fk_occupation_id_last = $this->input->post('fk_occupation_id_last', true);
        $fk_member_relation_id_last = $this->input->post('fk_member_relation_id_last', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('memberName', 'Child Name', 'trim|required');
        $this->form_validation->set_rules('sexType', 'Sex', 'trim|required|numeric');
        $this->form_validation->set_rules('birth_time', 'Birth Time', 'trim|required');
        $this->form_validation->set_rules('birth_weight', 'Birth weight', 'trim|required');

        $this->form_validation->set_rules('fk_birth_weight_size', 'Birth weight size', 'trim|required|numeric');
//        $this->form_validation->set_rules('fatherCode', 'Father', 'trim|required|numeric');
        $this->form_validation->set_rules('motherCode', 'Mother', 'trim|required|numeric');
        $this->form_validation->set_rules('pregnancy_outcome_id', 'Pregnancy Outcome', 'trim|required|numeric');

        $this->form_validation->set_rules('relationheadID', 'Relation with head', 'trim|required|numeric');
        $this->form_validation->set_rules('entryType', 'entry type', 'trim');
        $this->form_validation->set_rules('entryDate', 'entry date', 'trim|required');
        $this->form_validation->set_rules('maritalStatusType', 'marital status', 'trim|required|numeric');
        $this->form_validation->set_rules('religionType', 'Religion', 'trim|required|numeric');
        $this->form_validation->set_rules('educationType', 'Edication Type', 'trim|required|numeric');
        //$this->form_validation->set_rules('secularEduType','Secular Education','trim|required|numeric');
        // $this->form_validation->set_rules('religiousEduType','Religious Education','trim|required|numeric');
        $this->form_validation->set_rules('occupationType', 'Occupation Type', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_mother_live_birth_order', 'Live birth order', 'trim|required|numeric');
        $this->form_validation->set_rules('keep_follow_up', 'Follow up', 'trim|required|numeric');
        $this->form_validation->set_rules('checkupTypeChild', 'Birth of the child is made to check-up within 42 days', 'trim|required|numeric');


        $getCurrentRound = $this->modelName->getCurrentRound();

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_birth/' . $member_master_id . '?baseID=' . $baseID . '&household_master_id=' . $household_master_id);
        } else {

            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_birth/' . $member_master_id . '?baseID=' . $baseID . '&household_master_id=' . $household_master_id);
            }


            $memberName = $this->input->post('memberName', true);
            $sexType = $this->input->post('sexType', true);
            $birth_time = $this->input->post('birth_time', true);
            $birth_weight = $this->input->post('birth_weight', true);
            $fk_birth_weight_size = $this->input->post('fk_birth_weight_size', true);
            $relationheadID = $this->input->post('relationheadID', true);
            $fatherCode = (!empty($this->input->post('fatherCode', true))) ? $this->input->post('fatherCode', true) : 0;
            $motherCode = $this->input->post('motherCode', true);
            $maritalStatusType = $this->input->post('maritalStatusType', true);
            $religionType = $this->input->post('religionType', true);
            $fk_mother_live_birth_order = $this->input->post('fk_mother_live_birth_order', true);
            $keep_follow_up = $this->input->post('keep_follow_up', true);

            $birstRegiType = $this->input->post('birstRegiType', true);
            $birthRegidate = $this->input->post('birthRegidate', true);
            $whyNotRegi = $this->input->post('whyNotRegi', true);

            $pregnancy_outcome_id = $this->input->post('pregnancy_outcome_id', true);

            $entryDate = $this->input->post('entryDate', true);

            $educationType = $this->input->post('educationType', true);
            //$religiousEduType = $this->input->post('religiousEduType',true);
            // $secularEduType = $this->input->post('secularEduType',true);

            $occupationType = $this->input->post('occupationType', true);


            $new_birthRegidate = null;

            if (!empty($birthRegidate)) {
                $parts5 = explode('/', $birthRegidate);
                $new_birthRegidate = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
            }



            // father code 

            $father_member_code = '';

            if ($fatherCode) {
                $whereFather = array('id' => $fatherCode);
                $father_member_code = $this->db->select('member_code')->from($this->config->item('memberMasterTable'))->where($whereFather)->get()->row()->member_code;
            }



            // mother code 

            $whereMother = array('id' => $motherCode);
            $mother_member_code = $this->db->select('member_code')->from($this->config->item('memberMasterTable'))->where($whereMother)->get()->row()->member_code;

            // get birth date as pregnancy outcome date is equal to birth date

            $wherePregnancyDate = array('id' => $pregnancy_outcome_id);
            $pregnancy_outcome_date = $this->db->select('pregnancy_outcome_date')->from($this->config->item('pregnancyTable'))->where($wherePregnancyDate)->get()->row()->pregnancy_outcome_date;



            $new_entryDate = null;

            if (!empty($entryDate)) {
                $parts3 = explode('/', $entryDate);
                $new_entryDate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }


            // pnc
            $checkupTypeChild = $this->input->post('checkupTypeChild', true);


            if ($checkupTypeChild == 1) {

                $fk_post_natal_visit = $this->input->post('fk_post_natal_visit', true) ? $this->input->post('fk_post_natal_visit', true) : 0;
                $afterTotalTimesChild = $this->input->post('afterTotalTimesChild', true) ? $this->input->post('afterTotalTimesChild', true) : 0;

                $childSecondVisitAsist = $this->input->post('childSecondVisitAsist', true);
                $childFirstVisit = $this->input->post('childFirstVisit', true);
                $childFirstVisitDays = $this->input->post('childFirstVisitDays', true) ? $this->input->post('childFirstVisitDays', true) : 0;

                $childFirstVisitAsist = $this->input->post('childFirstVisitAsist', true);
                $childSecondVisit = $this->input->post('childSecondVisit', true);
                $childSecondVisitDays = $this->input->post('childSecondVisitDays', true) ? $this->input->post('childSecondVisitDays', true) : 0;
            } else {
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

            try {

                $memberMaster = array(
                    'birth_date' => $pregnancy_outcome_date,
                    'member_name' => $memberName,
                    'fk_marital_status' => $maritalStatusType,
                    'fk_sex' => $sexType,
                    'fk_religion' => $religionType,
                    'fk_relation_with_hhh' => $relationheadID,
                    'father_code' => $father_member_code,
                    'fk_father_id' => $fatherCode,
                    'mother_code' => $mother_member_code,
                    'fk_mother_id' => $motherCode,
                    'fk_mother_live_birth_order' => $fk_mother_live_birth_order,
                    'birth_time' => $birth_time,
                    'birth_weight' => $birth_weight,
                    'fk_birth_weight_size' => $fk_birth_weight_size,
                    'pregnancy_outcome_id' => $pregnancy_outcome_id,
                    'fk_birth_registration' => $birstRegiType,
                    'birth_registration_date' => $new_birthRegidate,
                    'fk_why_not_birth_registration' => $whyNotRegi,
                    'keep_follow_up' => $keep_follow_up,
                    'fk_pnc_chkup_child_id' => $checkupTypeChild,
                    'pnc_chkup_child_times' => $afterTotalTimesChild,
                    'fk_pnc_first_visit_id' => $childFirstVisit,
                    'pnc_first_visit_days' => $childFirstVisitDays,
                    'fk_pnc_second_visit_id' => $childSecondVisit,
                    'pnc_second_visit_days' => $childSecondVisitDays,
                    'fk_child_first_visit_assist' => $childFirstVisitAsist,
                    'fk_child_second_visit_assist' => $childSecondVisitAsist,
                    'fk_post_natal_child_visit' => $fk_post_natal_visit,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                // member master

                $this->modelName->UpdateInfo($memberMaster, $member_master_id, $this->config->item('memberMasterTable'));


                // member household

                $memberHousehold = array(
                    'entry_date' => $new_entryDate,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($memberHousehold, $member_household_id_last, $this->config->item('memberHouseholdTable'));

                // occupation
                $occupation = array(
                    'fk_main_occupation' => $occupationType,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($occupation, $fk_occupation_id_last, $this->config->item('memberOccupationTable'));

                // Education

                $education = array(
                    //'fk_religious_edu'=>$religiousEduType, 
                    //'fk_secular_edu'=>$secularEduType, 
                    'fk_education_type' => $educationType,
                    'year_of_education' => 0,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($education, $fk_education_id_last, $this->config->item('memberEducationTable'));


                // Relation

                $relation = array(
                    'fk_relation' => $relationheadID,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($relation, $fk_member_relation_id_last, $this->config->item('memberRelationTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating birth.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Member Birth updated successfully.');

            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/birth' . '?baseID=' . $baseID);
            }

            redirect($this->controller . '/edit_birth/' . $member_master_id . '?baseID=' . $baseID . '&household_master_id=' . $household_master_id);
        }
    }

    public function internal_in() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = 'Internal In';
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'internal_in';
        $data['editMethod'] = 'edit_internal_in';
        $data['shortName'] = 'Internal In';
        $data['boxTitle'] = 'List';
        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }

        $data['internal_in_info'] = $this->modelName->all_internal_in_info($data['round_no'], $this->config->item('migrationInTable'));


        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/internal_in', $data);
        $this->load->view('includes/footer');
    }

    public function edit_internal_out($id) {
//        echo $id; exit();
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Internal out";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_internal_out';
        $data['shortName'] = "Internal out";
        $data['boxTitle'] = 'List';

        $data['internal_out_info'] = $this->modelName->internal_out_info($id, $this->config->item('migrationOutTable'));

        $data['memberexittyp'] = $this->modelName->getLookUpListSpecific($this->config->item('member_exit_typ'), array('intout'));
        $data['internal_movement_cause'] = $this->modelName->getLookUpList($this->config->item('internal_movement_cause'));
        $data['movement_group_typ'] = $this->modelName->getLookUpList($this->config->item('movement_group_typ'));
        $data['outside_cause'] = $this->modelName->getLookUpList($this->config->item('outside_cause'));
        $data['slumlist'] = $this->modelName->getListType($this->config->item('slumTable'));
        $data['countrylist'] = $this->modelName->getListType($this->config->item('countryTable'));
        $data['divisionlist'] = $this->modelName->getListType($this->config->item('divTable'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_internal_out', $data);
        $this->load->view('includes/footer');
    }

    function update_internal_out() {

        $migrationID = $this->input->post('migrationID', true);
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('movement_date', 'Movement/migration Date', 'trim|required');

        $getCurrentRound = $this->modelName->getCurrentRound();

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_internal_out/' . $migrationID . '?baseID=' . $baseID);
        } else {

            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_internal_out/' . $migrationID . '?baseID=' . $baseID);
            }

            $movement_date = $this->input->post('movement_date', true);

            $remarks = $this->input->post('remarks', true);


            $fk_internal_cause = 0;
            $slumID = 0;
            $slumAreaID = 0;
            $househodID = 0;

            $fk_internal_cause = $this->input->post('fk_internal_cause', true);
            $slumID = $this->input->post('slumID', true);
            $slumAreaID = $this->input->post('slumAreaID', true);
            $househodID = $this->input->post('househodID', true);



            if (!empty($movement_date)) {
                $parts5 = explode('/', $movement_date);
                $new_movement_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
            }


            $this->db->trans_start();

            try {


                $IdInfo = array(
                    'movement_date' => $new_movement_date,
                    'fk_internal_cause' => $fk_internal_cause,
                    'slumIDTo' => $slumID,
                    'slumAreaIDTo' => $slumAreaID,
                    'household_master_id_move_to' => $househodID,
                    'remarks' => $remarks,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($IdInfo, $migrationID, $this->config->item('migrationOutTable'));

                // update member household info

                $whereMigout = array('id' => $member_master_id);
                $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereMigout)->get()->row()->member_household_id_last;


                $memberHouseholdUpdate = array(
                    'exit_date' => $new_movement_date,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );
                $this->modelName->UpdateInfo($memberHouseholdUpdate, $member_household_id_last, $this->config->item('memberHouseholdTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating Movement/Internal out Info.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Movement/Internal out Info updated successfully.');

            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/internal_out' . '?baseID=' . $baseID);
            }

            redirect($this->controller . '/edit_internal_out/' . $migrationID . '?baseID=' . $baseID);
        }
    }

    public function migration_in() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Migration in";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'migration_in';
        $data['editMethod'] = 'edit_migration_in';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';
        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }

        $data['migration_in_info'] = $this->modelName->all_migration_in_info($data['round_no'], $this->config->item('migrationInTable'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/migration_in', $data);
        $this->load->view('includes/footer');
    }

    public function internal_out() {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

//        echo "<pre/>";
//        print_r($this->global['menu']); exit();

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Internal out";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'internal_out';
        $data['editMethod'] = 'edit_internal_out';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';
        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['internal_out_info'] = $this->modelName->all_internal_out_info($data['round_no'], $this->config->item('migrationOutTable'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/internal_out', $data);
        $this->load->view('includes/footer');
    }

    public function migration_out() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'migration_out';
        $data['editMethod'] = 'edit_migration_out';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';
        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['migration_out_info'] = $this->modelName->all_migration_out_info($data['round_no'], $this->config->item('migrationOutTable'));


        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/migration_out', $data);
        $this->load->view('includes/footer');
    }

    public function edit_migration_out($id) {
//        echo $id; exit();
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Migration out";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_migration_out';
        $data['shortName'] = "Migration out";
        $data['boxTitle'] = 'List';

        $data['migration_out_info'] = $this->modelName->migration_out_info($id, $this->config->item('migrationOutTable'));

        $data['memberexittyp'] = $this->modelName->getLookUpListNotSpecific($this->config->item('member_exit_typ'), array('dth', 'ext'));
        $data['internal_movement_cause'] = $this->modelName->getLookUpList($this->config->item('internal_movement_cause'));
        $data['movement_group_typ'] = $this->modelName->getLookUpList($this->config->item('movement_group_typ'));
        $data['outside_cause'] = $this->modelName->getLookUpList($this->config->item('outside_cause'));
        $data['slumlist'] = $this->modelName->getListType($this->config->item('slumTable'));
        $data['countrylist'] = $this->modelName->getListType($this->config->item('countryTable'));
        $data['divisionlist'] = $this->modelName->getListType($this->config->item('divTable'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_migration_out', $data);
        $this->load->view('includes/footer');
    }

    function update_migration_out() {

        $migrationID = $this->input->post('migrationID', true);
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('movement_date', 'Movement/migration Date', 'trim|required');


        $getCurrentRound = $this->modelName->getCurrentRound();

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_migration_out/' . $migrationID . '?baseID=' . $baseID);
        } else {

            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_migration_out/' . $migrationID . '?baseID=' . $baseID);
            }

            $movement_date = $this->input->post('movement_date', true);
            $remarks = $this->input->post('remarks', true);

            $fk_type_of_group = 0;
            $fk_outside_cause_individual = 0;
            $fk_outside_cause_group = 0;
            $countryID = 0;
            $divisionID = 0;
            $districtID = 0;
            $thanaID = 0;

            $fk_type_of_group = $this->input->post('fk_type_of_group', true);
            $fk_outside_cause_individual = ($this->input->post('fk_outside_cause_individual', true)) ? $this->input->post('fk_outside_cause_individual', true) : 0;
            $fk_outside_cause_group = ($this->input->post('fk_outside_cause_group', true)) ? $this->input->post('fk_outside_cause_group', true) : 0;
            $countryID = $this->input->post('countryID', true);

            if ($this->config->item('bangladesh') == $countryID) { // bangldesh 
                $divisionID = ($this->input->post('divisionID', true)) ? $this->input->post('divisionID', true) : 0;
                $districtID = ($this->input->post('districtID', true)) ? $this->input->post('districtID', true) : 0;
                $thanaID = ($this->input->post('thanaID', true)) ? $this->input->post('thanaID', true) : 0;
            }



            if (!empty($movement_date)) {
                $parts5 = explode('/', $movement_date);
                $new_movement_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
            }


            $this->db->trans_start();

            try {
                $IdInfo = array(
                    'movement_date' => $new_movement_date,
                    'fk_type_of_group' => $fk_type_of_group,
                    'fk_outside_cause_individual' => $fk_outside_cause_individual,
                    'fk_outside_cause_group' => $fk_outside_cause_group,
                    'countryIDMoveTo' => $countryID,
                    'divisionIDMoveTo' => $divisionID,
                    'districtIDMoveTo' => $districtID,
                    'thanaIDMoveTo' => $thanaID,
                    'remarks' => $remarks,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($IdInfo, $migrationID, $this->config->item('migrationOutTable'));


                // update member household info

                $whereMigout = array('id' => $member_master_id);
                $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereMigout)->get()->row()->member_household_id_last;


                $memberHouseholdUpdate = array(
                    'exit_date' => $new_movement_date,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($memberHouseholdUpdate, $member_household_id_last, $this->config->item('memberHouseholdTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating movement/migration out.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Movement/Migration out updated successfully.');

            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/migration_out' . '?baseID=' . $baseID);
            }

            redirect($this->controller . '/edit_migration_out/' . $migrationID . '?baseID=' . $baseID);
        }
    }

    public function education() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Education";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'education';
        $data['editMethod'] = 'edit_education';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['education_info'] = $this->modelName->all_education_info($data['round_no'], $this->config->item('memberEducationTable'));


//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/education', $data);
        $this->load->view('includes/footer');
    }

    public function edit_education($id) {
//        echo $id; exit();
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Education";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_education';
        $data['shortName'] = "Education";
        $data['boxTitle'] = 'List';

        $data['education_info'] = $this->modelName->education_info($id, $this->config->item('memberEducationTable'));

//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['educationtyp'] = $this->modelName->getLookUpList($this->config->item('educationtyp'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_education', $data);
        $this->load->view('includes/footer');
    }

    public function occupation() {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Occupation";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'occupation';
        $data['editMethod'] = 'edit_occupation';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }

        $data['occupation_info'] = $this->modelName->all_occupation_info($data['round_no'], $this->config->item('memberOccupationTable'));

//        echo "<pre/>";
//        print_r($data['occupation_info']); exit();

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/occupation', $data);
        $this->load->view('includes/footer');
    }

    public function edit_occupation($id) {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Occupation";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_occupation';
        $data['shortName'] = "Occupation";
        $data['boxTitle'] = 'List';

        $data['occupation_info'] = $this->modelName->occupation_info($id, $this->config->item('memberOccupationTable'));
        $data['occupationtyp'] = $this->modelName->getLookUpList($this->config->item('occupationtyp'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_occupation', $data);
        $this->load->view('includes/footer');
    }

    function update_occupation() {
        $occupationID = $this->input->post('occupationID', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('occupationType', 'Main Occupation', 'trim|required|numeric');


        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_occupation/' . $occupationID . '?baseID=' . $baseID);
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_occupation/' . $occupationID . '?baseID=' . $baseID);
            }


            $occupationType = $this->input->post('occupationType', true);
            $main_occupation_oth = '';
            if ($occupationType == 166) {
                $main_occupation_oth = $this->input->post('main_occupation_oth', true);
            }


            $this->db->trans_start();

            try {

                $IdInfo = array(
                    'fk_main_occupation' => $occupationType,
                    'main_occupation_oth' => $main_occupation_oth,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );


                $this->modelName->UpdateInfo($IdInfo, $occupationID, $this->config->item('memberOccupationTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating occupation.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Member occupation updated successfully.');
            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/occupation' . '?baseID=' . $baseID);
            }
            redirect($this->controller . '/edit_occupation/' . $occupationID . '?baseID=' . $baseID);
        }
    }

    public function relation() {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Relation";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'relation';
        $data['editMethod'] = 'edit_relation';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['relation_info'] = $this->modelName->all_relation_info($data['round_no'], $this->config->item('memberRelationTable'));


//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/relation', $data);
        $this->load->view('includes/footer');
    }

    public function edit_relation($id) {

        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id_current = $this->input->get('household_master_id', TRUE);
        $member_master_id_current = $this->input->get('member_master_id', TRUE);
        $round_master_id_current = $this->input->get('round_master_id', TRUE);
        $fk_relation_current = $this->input->get('fk_relation', TRUE);

//        echo $round_master_id_current;
//        exit();
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Relation";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_relation';
        $data['shortName'] = "Relation";
        $data['boxTitle'] = 'List';


        $data['relation_info'] = $this->modelName->relation_info($id, $household_master_id_current, $member_master_id_current, $round_master_id_current, $fk_relation_current, $this->config->item('memberRelationTable'));

//        echo "<pre/>";
//        print_r($data['relation_info']);
//        exit();
        //while Cause of head change,Effective date (If HHH) are empty instead of fk_relation==27
        if ($data['relation_info'] == false) {
            $data['relation_info'] = $this->modelName->relation_info($id, $household_master_id_current, $member_master_id_current, $round_master_id_current, 0, $this->config->item('memberRelationTable'));
        }

        if ($fk_relation_current != 27) {
            $data['relationhhh'] = $this->modelName->getLookUpListNotSpecific($this->config->item('relationhhh'), array('01'));
        }
//        echo "<pre/>";
//        print_r($data['relation_info']);
//        exit();


        $data['hh_change_reason'] = $this->modelName->getLookUpList($this->config->item('hh_change_reason'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_relation', $data);
        $this->load->view('includes/footer');
    }

    public function asset() {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Asset";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'asset';
        $data['editMethod'] = 'edit_asset';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['asset_info'] = $this->modelName->all_asset_info($data['round_no'], $this->config->item('householdAssetTable'));


//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/asset', $data);
        $this->load->view('includes/footer');
    }

    public function edit_asset($id) {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Asset";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_asset';
        $data['shortName'] = "Asset";
        $data['boxTitle'] = 'List';

        $data['asset_info'] = $this->modelName->asset_info($id, $this->config->item('householdAssetTable'));

        $data['assetYesNo'] = $this->modelName->getLookUpList($this->config->item('asset_yes_no'));
        $data['land_owner'] = $this->modelName->getLookUpList($this->config->item('land_owner'));
        $data['house_owner'] = $this->modelName->getLookUpList($this->config->item('house_owner'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_asset', $data);
        $this->load->view('includes/footer');
    }

    function update_asset() {

        $assetID = $this->input->post('assetID', true);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('fk_owner_land', 'Land Owner', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_owner_house', 'House Owner', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_chair', 'Chair', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_dining_table', 'Dining Table', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_khat', 'Khat', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_chowki', 'Chowki', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_almirah', 'Almirah', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_sofa', 'Sofa', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_radio', 'Radio', 'trim|required|numeric');

        $this->form_validation->set_rules('fk_tv', 'TV', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_freeze', 'Fridge', 'trim|required|numeric');

        $this->form_validation->set_rules('fk_mobile', 'Entry Date', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_electric_fan', 'Electric_Fan', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_hand_watch', 'Hand Watch', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_rickshow', 'Rikshaw', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_computer', 'Computer', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_sewing_machine', 'Sewing machine', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_cycle', 'By Cycle', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_motor_cycle', 'Motor Cycle', 'trim|required|numeric');


        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_asset/' . $assetID . '?baseID=' . $baseID);
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_asset/' . $assetID . '?baseID=' . $baseID);
            }


            $fk_owner_land = $this->input->post('fk_owner_land', true);
            $fk_owner_house = $this->input->post('fk_owner_house', true);
            $fk_chair = $this->input->post('fk_chair', true);
            $fk_dining_table = $this->input->post('fk_dining_table', true);
            $fk_khat = $this->input->post('fk_khat', true);
            $fk_chowki = $this->input->post('fk_chowki', true);
            $fk_almirah = $this->input->post('fk_almirah', true);
            $fk_sofa = $this->input->post('fk_sofa', true);
            $fk_radio = $this->input->post('fk_radio', true);
            $fk_tv = $this->input->post('fk_tv', true);
            $fk_freeze = $this->input->post('fk_freeze', true);
            $fk_mobile = $this->input->post('fk_mobile', true);
            $fk_electric_fan = $this->input->post('fk_electric_fan', true);
            $fk_hand_watch = $this->input->post('fk_hand_watch', true);
            $fk_rickshow = $this->input->post('fk_rickshow', true);
            $fk_computer = $this->input->post('fk_computer', true);
            $fk_sewing_machine = $this->input->post('fk_sewing_machine', true);
            $fk_cycle = $this->input->post('fk_cycle', true);
            $fk_motor_cycle = $this->input->post('fk_motor_cycle', true);

            $this->db->trans_start();

            try {

                $IdInfo = array(
                    'fk_owner_land' => $fk_owner_land,
                    'fk_owner_house' => $fk_owner_house,
                    'fk_chair' => $fk_chair,
                    'fk_dining_table' => $fk_dining_table,
                    'fk_khat' => $fk_khat,
                    'fk_chowki' => $fk_chowki,
                    'fk_almirah' => $fk_almirah,
                    'fk_radio' => $fk_radio,
                    'fk_sofa' => $fk_sofa,
                    'fk_tv' => $fk_tv,
                    'fk_freeze' => $fk_freeze,
                    'fk_mobile' => $fk_mobile,
                    'fk_electric_fan' => $fk_electric_fan,
                    'fk_hand_watch' => $fk_hand_watch,
                    'fk_rickshow' => $fk_rickshow,
                    'fk_computer' => $fk_computer,
                    'fk_sewing_machine' => $fk_sewing_machine,
                    'fk_cycle' => $fk_cycle,
                    'fk_motor_cycle' => $fk_motor_cycle,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($IdInfo, $assetID, $this->config->item('householdAssetTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating household Asset.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Household Asset updated successfully.');
            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/asset' . '?baseID=' . $baseID);
            }
            redirect($this->controller . '/edit_asset/' . $assetID . '?baseID=' . $baseID);
        }
    }

    public function marriage_start() {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Marriage start";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'marriage_start';
        $data['editMethod'] = 'edit_marriage_start';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['marriage_start_info'] = $this->modelName->all_marriage_start_info($data['round_no'], $this->config->item('marriageStartTable'));


//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/marriage_start', $data);
        $this->load->view('includes/footer');
    }

    public function edit_marriage_start($id) {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Marriage start";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_marriage_start';
        $data['shortName'] = "Marriage start";
        $data['boxTitle'] = 'List';

        $data['marriage_start_info'] = $this->modelName->marriage_start_info($id, $this->config->item('marriageStartTable'));

//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['maritalstatustyp'] = $this->modelName->getLookUpList($this->config->item('maritalstatustyp'));
        $data['marriage_order'] = $this->modelName->getLookUpList($this->config->item('marriage_order'));
        $data['marriage_registration'] = $this->modelName->getLookUpList($this->config->item('marriage_registration'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_marriage_start', $data);
        $this->load->view('includes/footer');
    }

    function update_marriage_start() {

        $marriageID = $this->input->post('marriageID', true);
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');


        $this->form_validation->set_rules('fk_member_premarital_status', 'Member previous marital status', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_member_marital_order', 'Member marital order', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_bri_gem_premarital_status', 'Bride/Groom previous marital status', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_bri_gem_marital_order', 'Bride/Groom marital order', 'trim|required|numeric');
        $this->form_validation->set_rules('marriage_date', 'Marriage Date', 'trim|required');
        $this->form_validation->set_rules('fk_kazi_registered', 'Kazi registered', 'trim|required|numeric');


        $getCurrentRound = $this->modelName->getCurrentRound();

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_marriage_start/' . $marriageID . '?baseID=' . $baseID);
        } else {

            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_marriage_start/' . $marriageID . '?baseID=' . $baseID);
            }


            $fk_member_premarital_status = $this->input->post('fk_member_premarital_status', true);
            $fk_member_marital_order = $this->input->post('fk_member_marital_order', true);
            $fk_bri_gem_premarital_status = $this->input->post('fk_bri_gem_premarital_status', true);
            $fk_bri_gem_marital_order = $this->input->post('fk_bri_gem_marital_order', true);
            $marriage_date = $this->input->post('marriage_date', true);
            $fk_kazi_registered = $this->input->post('fk_kazi_registered', true);
            $remarks = $this->input->post('remarks', true);

            $prev_spause_id = $this->input->post('prev_spause_id', true);


            if (!empty($marriage_date)) {
                $parts5 = explode('/', $marriage_date);
                $new_marriage_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
            }

            $member_id = $this->input->post('member_id', true);

            $member_code = '';
            $member_code_spause = '';
            $bride_groom_id = 0;

            $member_master_id_bride_groom = $this->input->post('member_master_id_bride_groom', true);
            $full_code = $this->input->post('full_code', true);

            if (!empty($full_code)) {
                $member_code = $this->input->post('member_code', true);
                $bride_groom_id = $this->input->post('member_id', true);

                $wherememberCode = array('id' => $member_master_id);
                $member_code_spause = $this->db->select('member_code')->from($this->config->item('memberMasterTable'))->where($wherememberCode)->get()->row()->member_code;
            }

            $this->db->trans_start();

            try {

                $IdInfo = array(
                    'fk_member_premarital_status' => $fk_member_premarital_status,
                    'fk_member_marital_order' => $fk_member_marital_order,
                    'fk_bri_gem_premarital_status' => $fk_bri_gem_premarital_status,
                    'fk_bri_gem_marital_order' => $fk_bri_gem_marital_order,
                    'marriage_date' => $new_marriage_date,
                    'fk_kazi_registered' => $fk_kazi_registered,
                    'member_master_id_bride_groom' => $bride_groom_id,
                    'remarks' => $remarks,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($IdInfo, $marriageID, $this->config->item('marriageStartTable'));


                // update member info

                $memberUpdate = array(
                    'spouse_code' => $member_code,
                    'fk_spouse_id' => $bride_groom_id,
                    'fk_marital_status' => $this->config->item('maritalStatusMarried'),
                    'last_marriage_date' => $new_marriage_date,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($memberUpdate, $member_master_id, $this->config->item('memberMasterTable'));


                // update previous spause info

                if ($prev_spause_id > 0) {
                    $memberUpdateBrideGroomPrev = array(
                        'spouse_code' => '',
                        'fk_spouse_id' => 0,
                        'fk_marital_status' => $this->config->item('maritalStatusUnMarried'),
                        'last_marriage_date' => null,
                        'updateBy' => $this->vendorId,
                        'updatedOn' => date('Y-m-d H:i:s')
                    );

                    $this->modelName->UpdateInfo($memberUpdateBrideGroomPrev, $prev_spause_id, $this->config->item('memberMasterTable'));
                }

                // update spause info

                if ($bride_groom_id > 0) {
                    $memberUpdateBrideGroom = array(
                        'spouse_code' => $member_code_spause,
                        'fk_spouse_id' => $member_master_id,
                        'fk_marital_status' => $this->config->item('maritalStatusMarried'),
                        'last_marriage_date' => $new_marriage_date,
                        'updateBy' => $this->vendorId,
                        'updatedOn' => date('Y-m-d H:i:s')
                    );

                    $this->modelName->UpdateInfo($memberUpdateBrideGroom, $bride_groom_id, $this->config->item('memberMasterTable'));
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating marriage start.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Member Marriage start info updated successfully.');

            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/marriage_start' . '?baseID=' . $baseID);
            }

            redirect($this->controller . '/edit_marriage_start/' . $marriageID . '?baseID=' . $baseID);
        }
    }

    public function edit_marriage_end($id) {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Marriage end";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_marriage_end';
        $data['shortName'] = "Marriage end";
        $data['boxTitle'] = 'List';

        $data['marriage_end_info'] = $this->modelName->marriage_end_info($id, $this->config->item('marriageEndTable'));

//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['marriage_end_typ'] = $this->modelName->getLookUpListNotSpecific($this->config->item('maritalstatustyp'), array('unm', 'mar'));
        $data['marriage_end_cause'] = $this->modelName->getLookUpList($this->config->item('marriage_end_cause'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_marriage_end', $data);
        $this->load->view('includes/footer');
    }

    function update_marriage_end() {

        $marriageID = $this->input->post('marriageID', true);
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');


        $this->form_validation->set_rules('fk_marriage_end_type', 'Member marriage end type', 'trim|required|numeric');
        $this->form_validation->set_rules('marriage_end_date', 'Marriage End Date', 'trim|required');

        $getCurrentRound = $this->modelName->getCurrentRound();
        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_marriage_end/' . $marriageID . '?baseID=' . $baseID);
        } else {

            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_marriage_end/' . $marriageID . '?baseID=' . $baseID);
            }


            $fk_marriage_end_type = $this->input->post('fk_marriage_end_type', true);
            $fk_spouse_id = $this->input->post('fk_spouse_id', true);
            $fk_marriage_end_cause_one = $this->input->post('fk_marriage_end_cause_one', true);
            $fk_marriage_end_cause_two = $this->input->post('fk_marriage_end_cause_two', true);
            $fk_marriage_end_cause_three = $this->input->post('fk_marriage_end_cause_three', true);
            $marriage_end_date = $this->input->post('marriage_end_date', true);
            $remarks = $this->input->post('remarks', true);


            if (!empty($marriage_end_date)) {
                $parts5 = explode('/', $marriage_end_date);
                $new_marriage_end_date = $parts5[2] . '-' . $parts5[1] . '-' . $parts5[0];
            }


            $this->db->trans_start();

            try {

                $IdInfo = array(
                    'fk_marriage_end_type' => $fk_marriage_end_type,
                    'fk_marriage_end_cause_one' => $fk_marriage_end_cause_one,
                    'fk_marriage_end_cause_two' => $fk_marriage_end_cause_two,
                    'marriage_end_date' => $new_marriage_end_date,
                    'fk_marriage_end_cause_three' => $fk_marriage_end_cause_three,
                    'remarks' => $remarks,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($IdInfo, $marriageID, $this->config->item('marriageEndTable'));


                // update member info

                $memberUpdate = array('fk_marital_status' => $fk_marriage_end_type,
                    'last_marriage_end_date' => $new_marriage_end_date,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($memberUpdate, $member_master_id, $this->config->item('memberMasterTable'));


                // update previous spause info

                if ($fk_spouse_id > 0) {
                    $memberUpdateBrideGroomPrev = array(
                        'fk_marital_status' => $fk_marriage_end_type,
                        'last_marriage_end_date' => $new_marriage_end_date,
                        'updateBy' => $this->vendorId,
                        'updatedOn' => date('Y-m-d H:i:s')
                    );

                    $this->modelName->UpdateInfo($memberUpdateBrideGroomPrev, $fk_spouse_id, $this->config->item('memberMasterTable'));
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating marriage end.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Member Marriage end updated successfully.');

            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/marriage_end' . '?baseID=' . $baseID);
            }

            redirect($this->controller . '/edit_marriage_end/' . $marriageID . '?baseID=' . $baseID);
        }
    }

    public function marriage_end() {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Marriage end";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'marriage_end';
        $data['editMethod'] = 'edit_marriage_end';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['marriage_end_info'] = $this->modelName->all_marriage_end_info($data['round_no'], $this->config->item('marriageEndTable'));


//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/marriage_end', $data);
        $this->load->view('includes/footer');
    }

    public function interview() {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . 'Interview';
        $data['pageTitle'] = "Interview";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'interview';
        $data['editMethod'] = 'edit_interview';
        $data['shortName'] = 'Interview';
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['interview_info'] = $this->modelName->all_interview_info($data['round_no'], $this->config->item('householdVisitTable'));


//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/interview', $data);
        $this->load->view('includes/footer');
    }

    public function edit_interview($id) {
//        echo $id; exit();
        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id = $this->input->get('household_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Interview";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_interview';
        $data['shortName'] = "Interview";
        $data['boxTitle'] = 'List';

        $data['interview_info'] = $this->modelName->interview_info($id, $this->config->item('householdVisitTable'));

//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['interview_status'] = $this->modelName->getLookUpList($this->config->item('interviewstatus'));
        $data['interview_code'] = $this->modelName->getLookUpList($this->config->item('interviewercode'));
        $data['respondent_typ'] = $this->modelName->getLookUpList($this->config->item('respondent_typ'));
        $data['presentMemberList'] = $this->modelName->getMemberMasterPresentList($household_master_id);
//                echo "<pre/>";
//        print_r($data['presentMemberList']); exit();

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_interview', $data);
        $this->load->view('includes/footer');
    }

    function update_interview() {

        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id = $this->input->post('household_master_id', true);
        $householdVisitID = $this->input->post('householdVisitID', true);
        $contactNumber = $this->input->post('contactNumber', true);
        $remarks = $this->input->post('remarks', true);

        $fk_responded_type = $this->input->post('fk_responded_type', true);
        $respondent_code = $this->input->post('respondent_code', true);
        $fk_interviewer = $this->input->post('fk_interviewer', true);
        $fk_interview_status = $this->input->post('fk_interview_status', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('fk_interview_status', 'Interview status', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_interviewer', 'Interviewer Name', 'trim|required|numeric');
        $this->form_validation->set_rules('respondent_code', 'Respondent Code', 'trim|required');
        $this->form_validation->set_rules('fk_responded_type', 'Respondent Type', 'trim|required|numeric');
        $this->form_validation->set_rules('contactNumber', 'Contact Number', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $this->db->trans_start();

            try {

                $visitData = array(
                    'fk_responded_type' => $fk_responded_type,
                    'respondent_code' => $respondent_code,
                    'fk_interviewer' => $fk_interviewer,
                    'fk_interview_status' => $fk_interview_status,
                    'remarks' => $remarks,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($visitData, $householdVisitID, $this->config->item('householdVisitTable'));

                $masterData = array(
                    'contact_number' => $contactNumber,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($masterData, $household_master_id, $this->config->item('householdMasterTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while save.');
            }

            $this->db->trans_commit();

            $this->session->set_flashdata('success', 'interview Info updated successfully.');
        }

        if ($this->input->post('update_exit')) {
            redirect($this->controller . '/interview' . '?baseID=' . $baseID);
        }

        redirect($this->controller . '/edit_interview/' . $householdVisitID . '?baseID=' . $baseID . '&household_master_id=' . $household_master_id);
    }

    public function household_master() {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "household_master";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'household_master';
        $data['editMethod'] = 'edit_household_master';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['district_id'] = '';
        $data['thana_id'] = '';
        $data['slum_id'] = '';
        $data['slumarea_id'] = '';
        $data['round_no'] = '';

        $data['district_id'] = $this->input->get('district_id');
        $data['thana_id'] = $this->input->get('thana_id');
        $data['slum_id'] = $this->input->get('slum_id');
        $data['slumarea_id'] = $this->input->get('slumarea_id');
        $data['round_no'] = $this->input->get('round_no');

        $data['district'] = $this->modelName->getListType($this->config->item('districtTable'));
        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));


        if ($this->input->get('Clear') == 'Clear') {
            redirect($this->controller . '/household_master?baseID=' . $baseID);
        }
		
		$data['household_master_info'] = array();
		
		if (!empty($data['district_id']))
		{

        $data['household_master_info'] = $this->modelName->all_household_master_info($data['district_id'], $data['thana_id'], $data['slum_id'], $data['slumarea_id'], $data['round_no'], $this->config->item('householdMasterTable'));
        }

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/household_master', $data);
        $this->load->view('includes/footer');
    }

    public function edit_household_master($id) {
//        echo $id; exit();
        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id = $this->input->get('household_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Household master";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_household_master';
        $data['shortName'] = "Household master";
        $data['boxTitle'] = 'List';

        $data['household_master_info'] = $this->modelName->household_master_info($id, $this->config->item('householdMasterTable'));

        //$data['division'] = $this->modelName->getListType($this->config->item('divTable'));
        $data['district'] = $this->modelName->getListType($this->config->item('districtTable'));
        $data['district2'] = $this->modelName->getListType($this->config->item('districtTable'));
        $data['country'] = $this->modelName->getListType($this->config->item('countryTable'));
        // $data['thana']    = $this->modelName->getListType($this->config->item('upazilaTable'));
        //$data['slum']     = $this->modelName->getListType($this->config->item('slumTable'));
        // $data['slumarea'] = $this->modelName->getListType($this->config->item('slumAreaTable'));

        $data['entryType'] = $this->modelName->getLookUpListSpecific($this->config->item('hhentrytype'), array('bls', 'min', 'intin'));
        $data['migrationReason'] = $this->modelName->getLookUpList($this->config->item('migReason'));
        $data['hhcontacttyp'] = $this->modelName->getLookUpList($this->config->item('hhcontacttyp'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_household_master', $data);
        $this->load->view('includes/footer');
    }

    function update_household_master() {
        $this->load->library('form_validation');

        $id = $this->input->post('id');
        $baseID = $this->input->get('baseID', TRUE);

        //$this->form_validation->set_rules('districtID','District Name','trim|required|numeric');
        // $this->form_validation->set_rules('thanaID','Upazila Name','trim|required|numeric');
        // $this->form_validation->set_rules('slumID','Slum Name','trim|required|numeric');
        // $this->form_validation->set_rules('slumAreaID','Slum Area Name','trim|required|numeric');
        $this->form_validation->set_rules('bariwallaName', 'Bariwalla Name', 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('bariNumber', 'Bari Number', 'trim|required|max_length[10]|xss_clean');
        $this->form_validation->set_rules('headName', 'Head Name', 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('livingYear', 'Living Year', 'trim|required|max_length[2]|xss_clean');
        $this->form_validation->set_rules('livingMonth', 'Living Month', 'trim|required|max_length[2]|xss_clean');

        $this->form_validation->set_rules('leftSlum', 'Left Slum', 'trim|required|numeric');
        $this->form_validation->set_rules('entryType', 'Entry Type', 'trim|required|numeric');

        $this->form_validation->set_rules('entryDate', 'Entry Date', 'trim|required');
        $this->form_validation->set_rules('contactNumber', 'Contact Number', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('contactSource', 'Contact Source', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {

            // $districtID = $this->input->post('districtID',true);
            // $thanaID = $this->input->post('thanaID',true);
            // $slumID = $this->input->post('slumID',true);
            //$slumAreaID = $this->input->post('slumAreaID',true);
            $bariwallaName = $this->input->post('bariwallaName', true);
            $bariNumber = $this->input->post('bariNumber', true);
            $headName = $this->input->post('headName', true);
            $livingYear = $this->input->post('livingYear', true);
            $livingMonth = $this->input->post('livingMonth', true);
            $leftSlum = $this->input->post('leftSlum', true);
            $entryType = $this->input->post('entryType', true);
            $entryDate = $this->input->post('entryDate', true);
            $contactNumber = $this->input->post('contactNumber', true);
            $contactSource = $this->input->post('contactSource', true);
            $household_code = $this->input->post('household_code', true);


            if (!empty($entryDate)) {
                $parts1 = explode('/', $entryDate);
                $new_entryDate = $parts1[2] . '-' . $parts1[1] . '-' . $parts1[0];
            }


            $migrationReason = 0;
            $countryID = 0;
            $migDistrictID = 0;
            $migThanaID = 0;
            $slumIDFrom = 0;
            $slumAreaIDFrom = 0;

            $migreasonOth = '';



            if ($entryType == $this->config->item('HHEntyMigIn')) { // migration in
                $migrationReason = $this->input->post('migrationReason', true);
                $countryID = $this->input->post('countryID', true);
                $migDistrictID = $this->input->post('migDistrictID', true);
                $migThanaID = $this->input->post('migThanaID', true);

                if ($migrationReason == 12) {
                    $migreasonOth = $this->input->post('migreasonOth', true);
                }
            }


            if ($entryType == $this->config->item('HHEntyIntIn')) { // int in
                $migrationReason = $this->input->post('migrationReason', true);
                $countryID = $this->input->post('countryID', true);
                $migDistrictID = $this->input->post('migDistrictID', true);
                $migThanaID = $this->input->post('migThanaID', true);

                $slumIDFrom = $this->input->post('slumIDFrom', true);
                $slumAreaIDFrom = $this->input->post('slumAreaIDFrom', true);

                if ($migrationReason == 12) {
                    $migreasonOth = $this->input->post('migreasonOth', true);
                }
            }


            $this->db->trans_start();

            try {


                $IdInfo = array(
                    'contact_number' => $contactNumber,
                    // 'fk_district_id'=>$districtID, 
                    // 'fk_thana_id'=>$thanaID, 
                    // 'fk_slum_id'=>$slumID, 
                    // 'fk_slum_area_id'=>$slumAreaID, 
                    'barino' => $bariNumber,
                    'bariwalla_name' => $bariwallaName,
                    'household_head_name' => $headName,
                    'longlivy' => $livingYear,
                    'longlivm' => $livingMonth,
                    'leftpad' => $leftSlum,
                    'fk_entry_type' => $entryType,
                    'entry_date' => $new_entryDate,
                    'fk_migration_reason' => $migrationReason,
                    'migration_reason_oth' => $migreasonOth,
                    'fk_country_id_from' => $countryID,
                    'fk_district_id_from' => $migDistrictID,
                    'fk_thana_id_from' => $migThanaID,
                    'fk_slum_id_from' => $slumIDFrom,
                    'fk_slumArea_id_from' => $slumAreaIDFrom,
                    'fk_contract_type' => $contactSource,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $result = $this->modelName->UpdateInfo($IdInfo, $id, $this->config->item('householdMasterTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating household.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Household master info updated successfully');

            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/household_master' . '?baseID=' . $baseID);
            }

            redirect($this->controller . '/edit_household_master/' . $id . '?baseID=' . $baseID);
        }
    }

    public function household_head() {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Household head";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'household_head';
        $data['editMethod'] = 'edit_household_head';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }
        $data['household_head_info'] = $this->modelName->all_household_head_info($data['round_no'], $this->config->item('memberHeadTable'));


//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/household_head', $data);
        $this->load->view('includes/footer');
    }

    public function edit_household_head($id) {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Household head";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_household_head';
        $data['shortName'] = "Household head";
        $data['boxTitle'] = 'List';

        $data['household_head_info'] = $this->modelName->household_head_info($id, $this->config->item('memberHeadTable'));
        $data['hh_change_reason'] = $this->modelName->getLookUpList($this->config->item('hh_change_reason'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_household_head', $data);
        $this->load->view('includes/footer');
    }

    function update_household_head() {

        $household_head_id = $this->input->post('household_head_id', true);

//        $this->load->library('form_validation');

        $getCurrentRound = $this->modelName->getCurrentRound();

        if ($this->input->post('relationType', true) != NULL) {
            $relationType = $this->input->post('relationType', true);
        } else {
            $relationType = 27;
        }

        $baseID = $this->input->get('baseID', TRUE);

        if ($getCurrentRound->active == 0) {
            $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
            redirect($this->controller . '/edit_household_head/' . $household_head_id . '?baseID=' . $baseID);
        }



        $fk_hhh_cause = $this->input->post('fk_hhh_cause', true);
        $hhdate = $this->input->post('hhdate', true);

        $new_hhdate = null;

        if (!empty($hhdate)) {
            $parts3 = explode('/', $hhdate);
            $new_hhdate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
        }

        $this->db->trans_start();

        try {
            $householdHeadInfo = array(
                'change_date' => $new_hhdate,
                'fk_hhh_cause' => $fk_hhh_cause,
                'updateBy' => $this->vendorId,
                'updatedOn' => date('Y-m-d H:i:s')
            );
            $this->modelName->UpdateInfo($householdHeadInfo, $household_head_id, $this->config->item('memberHeadTable'));
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error occurred while updating Relation.');
        }

        $this->db->trans_commit();

        $this->session->set_flashdata('success', 'Household head info updated successfully.');

        if ($this->input->post('update_exit')) {
            redirect($this->controller . '/household_head' . '?baseID=' . $baseID);
        }

        redirect($this->controller . '/edit_household_head/' . $household_head_id . '?baseID=' . $baseID);
    }

    function update_conception() {
        $conceptionID = $this->input->post('conceptionID', true);
        $getCurrentRound = $this->modelName->getCurrentRound();

        $this->load->library('form_validation');

        $this->form_validation->set_rules('conception_date', 'Conception Date', 'trim|required');
        $this->form_validation->set_rules('fk_conception_plan', 'Conception plan', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_conception_order', 'Conception order', 'trim|required|numeric');

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_conception/' . $conceptionID . '?baseID=' . $baseID);
        } else {
            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_conception/' . $conceptionID . '?baseID=' . $baseID);
            }

            if (!empty($this->input->post('conception_date'))) {
                $parts3 = explode('/', $this->input->post('conception_date'));
                $data['conception_date'] = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }
            $data['fk_conception_plan'] = $this->input->post('fk_conception_plan', true);
            $data['fk_conception_order'] = $this->input->post('fk_conception_order', true);
            $data['updateBy'] = $this->vendorId;
            $data['updatedOn'] = date('Y-m-d H:i:s');


            try {

                $this->modelName->UpdateInfo($data, $conceptionID, $this->config->item('conceptionTable'));
            } catch (Exception $e) {
                $this->session->set_flashdata('error', 'Error occurred while updating Conception.');
                redirect($this->controller . '/edit_conception/' . $conceptionID . '?baseID=' . $baseID);
            }

            $this->session->set_flashdata('success', 'Member Conception Info updated successfully.');
            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/conception' . '?baseID=' . $baseID);
            }
            redirect($this->controller . '/edit_conception/' . $conceptionID . '?baseID=' . $baseID);
        }
    }

    function update_education() {

        $educationID = $this->input->post('educationID', true);

        $getCurrentRound = $this->modelName->getCurrentRound();

        $this->load->library('form_validation');

        $this->form_validation->set_rules('educationType', 'Education Type', 'trim|required|numeric');

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_education/' . $educationID . '?baseID=' . $baseID);
        } else {
            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_education/' . $educationID . '?baseID=' . $baseID);
            }

            $data['fk_education_type'] = $this->input->post('educationType', true);
            $data['year_of_education'] = ($this->input->post('yearOfEdu') == NULL) ? 0 : $this->input->post('yearOfEdu');
            $data['updateBy'] = $this->vendorId;
            $data['updatedOn'] = date('Y-m-d H:i:s');


            try {

                $this->modelName->UpdateInfo($data, $educationID, $this->config->item('memberEducationTable'));
            } catch (Exception $e) {
                $this->session->set_flashdata('error', 'Error occurred while updating Conception.');
                redirect($this->controller . '/edit_education/' . $educationID . '?baseID=' . $baseID);
            }

            $this->session->set_flashdata('success', 'Member Education Info updated successfully.');
            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/education' . '?baseID=' . $baseID);
            }
            redirect($this->controller . '/edit_education/' . $educationID . '?baseID=' . $baseID);
        }
    }

    function update_relation() {

        $household_master_id = $this->input->post('household_master_id', true);
        $round_master_id = $this->input->post('round_master_id', true);
        $relationID = $this->input->post('relationID', true);
        $member_master_id = $this->input->post('member_master_id', true);

//        $this->load->library('form_validation');

        $getCurrentRound = $this->modelName->getCurrentRound();

        if ($this->input->post('relationType', true) != NULL) {
            $relationType = $this->input->post('relationType', true);
        } else {
            $relationType = 27;
        }

        $baseID = $this->input->get('baseID', TRUE);

        if ($getCurrentRound->active == 0) {
            $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
            redirect($this->controller . '/edit_relation/' . $relationID . '?baseID=' . $baseID . '&household_master_id=' . $household_master_id . '&member_master_id=' . $member_master_id . '&round_master_id=' . $round_master_id . '&fk_relation=' . $relationType);
        }



        $fk_hhh_cause = $this->input->post('fk_hhh_cause', true);
        $hhdate = $this->input->post('hhdate', true);

        $new_hhdate = null;

        if (!empty($hhdate)) {
            $parts3 = explode('/', $hhdate);
            $new_hhdate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
        }

        $this->db->trans_start();

        try {

            if ($relationType != 27) {
                $IdInfo = array(
                    'fk_relation' => $relationType,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($IdInfo, $relationID, $this->config->item('memberRelationTable'));
            } else if ($relationType == 27) {
                $householdHeadInfo = array(
                    'change_date' => $new_hhdate,
                    'fk_hhh_cause' => $fk_hhh_cause,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo_HeadTable($householdHeadInfo, $household_master_id, $member_master_id, $round_master_id, $this->config->item('memberHeadTable'));
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error occurred while updating Relation.');
        }

        $this->db->trans_commit();

        $this->session->set_flashdata('success', 'Member Relation updated successfully.');

        if ($this->input->post('update_exit')) {
            redirect($this->controller . '/relation' . '?baseID=' . $baseID);
        }

        redirect($this->controller . '/edit_relation/' . $relationID . '?baseID=' . $baseID . '&household_master_id=' . $household_master_id . '&member_master_id=' . $member_master_id . '&round_master_id=' . $round_master_id . '&fk_relation=' . $relationType);
    }

    public function death() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'death';
        $data['editMethod'] = 'edit_death';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }

        $data['death_info'] = $this->modelName->all_death_info($data['round_no'], $this->config->item('deathTable'));

//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/death', $data);
        $this->load->view('includes/footer');
    }

    public function edit_death($id) {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Death";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_death';
        $data['shortName'] = "Death";
        $data['boxTitle'] = 'List';

        $data['death_info'] = $this->modelName->death_info($id, $this->config->item('deathTable'));

        $data['member_death_cause'] = $this->modelName->getLookUpList($this->config->item('member_death_cause'));
        $data['member_death_place'] = $this->modelName->getLookUpList($this->config->item('member_death_place'));
        $data['type_of_death'] = $this->modelName->getLookUpList($this->config->item('type_of_death'));
        $data['death_confirm_by'] = $this->modelName->getLookUpList($this->config->item('death_confirm_by'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_death', $data);
        $this->load->view('includes/footer');
    }

    function update_death() {

        $deathID = $this->input->post('deathID', true);
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('deathDate', 'Death Date', 'trim|required');
        $this->form_validation->set_rules('fk_death_place', 'Relation', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_death_cause', 'Relation', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_death_type', 'Relation', 'trim|required|numeric');
        $this->form_validation->set_rules('fk_death_confirmby', 'Relation', 'trim|required|numeric');



        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_death/' . $deathID . '?baseID=' . $baseID);
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_death/' . $deathID . '?baseID=' . $baseID);
            }


            $fk_death_place = $this->input->post('fk_death_place', true);
            $fk_death_cause = $this->input->post('fk_death_cause', true);
            $fk_death_type = $this->input->post('fk_death_type', true);
            $fk_death_confirmby = $this->input->post('fk_death_confirmby', true);
            $deathtime = $this->input->post('deathtime', true);
            $deathDate = $this->input->post('deathDate', true);

            $new_deathDate = null;

            if (!empty($deathDate)) {
                $parts3 = explode('/', $deathDate);
                $new_deathDate = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $this->db->trans_start();

            try {

                $whereMemember = array('id' => $member_master_id);
                $member_household_id_last = $this->db->select('member_household_id_last')->from($this->config->item('memberMasterTable'))->where($whereMemember)->get()->row()->member_household_id_last;

                //member household 

                $dethUpdate = array(
                    'exit_date' => $new_deathDate,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->db->where('id', $member_household_id_last);
                $this->db->where('member_master_id', $member_master_id);
                $this->db->update($this->config->item('memberHouseholdTable'), $dethUpdate);


                $IdInfo = array(
                    'death_date' => $new_deathDate,
                    'fk_death_place' => $fk_death_place,
                    'fk_death_cause' => $fk_death_cause,
                    'fk_death_type' => $fk_death_type,
                    'fk_death_confirmby' => $fk_death_confirmby,
                    'transfer_complete' => 'No',
                    'death_time' => $deathtime,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($IdInfo, $deathID, $this->config->item('deathTable'));


                $memberUpdate = array(
                    'is_died' => 1,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($memberUpdate, $member_master_id, $this->config->item('memberMasterTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating Death.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Member Death updated successfully.');
            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/death' . '?baseID=' . $baseID);
            }
            redirect($this->controller . '/edit_death/' . $deathID . '?baseID=' . $baseID);
        }
    }

    public function getUpaZila() {
        if ($this->input->post('districtID')) {
            echo $this->modelName->getUpaZila($this->input->post('districtID'));
        }
    }

    public function getSlum() {
        if ($this->input->post('thanaID')) {
            echo $this->modelName->getSlum($this->input->post('thanaID'));
        }
    }

    public function getSlumArea() {
        if ($this->input->post('slumID')) {
            echo $this->modelName->getSlumArea($this->input->post('slumID'));
        }
    }

    //.sav and .dta file exporting system

    public function sav_format_internal_in() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_internal_in_info(0, $this->config->item('migrationInTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/internal_in' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "internal_in_List_Report";
			
			
		$baseURL =  base_url().'sav_response.py';
		
		///exit();
		
        //$command = escapeshellcmd("sav.py $uniqid $file_name");
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);
		

        $file = 'internal_in_List_Report.sav';
        if (file_exists($file)) {
			
			
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_internal_in() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_internal_in_info(0, $this->config->item('migrationInTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/internal_in' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "internal_in_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'internal_in_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function test() {
        $already = array
            ('id',
            'household_code',
            'member_code',
            'member_name',
            'birth_date',
            'death_date',
            'death_time',
            'fk_death_cause_code',
            'fk_death_cause_name',
            'fk_death_place_code',
            'fk_death_place_name',
            'fk_death_type_code',
            'fk_death_type_name',
            'fk_death_confirmby_code',
            'fk_death_confirmby_name',
            'insertedBy_name',
            'insertedOn',
            'insertedOn',
            'updateBy_name',
            'updatedOn',
            'updatedOn');

        $fields = $this->db->list_fields('tbl_member_death');

        $result = array_intersect($already, $fields);
        echo "<pre/>";
        print_r($result);
    }

    public function sav_format_internal_out() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_internal_out_info(0, $this->config->item('migrationOutTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/internal_out' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "internal_out_List_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'internal_out_List_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_internal_out() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_internal_out_info(0, $this->config->item('migrationOutTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/internal_out' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "internal_out_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'internal_out_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_marriage_start() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_marriage_start_info(0, $this->config->item('marriageStartTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/marriage_start' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "marriage_start_List_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'marriage_start_List_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_marriage_start() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_marriage_start_info(0, $this->config->item('marriageStartTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/marriage_start' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "marriage_start_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'marriage_start_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_marriage_end() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_marriage_end_info(0, $this->config->item('marriageEndTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/marriage_end' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "marriage_end_List_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'marriage_end_List_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_marriage_end() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_marriage_end_info(0, $this->config->item('marriageEndTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/marriage_end' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "marriage_end_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'marriage_end_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_member() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_member_info('', '', '', '', '', $this->config->item('memberMasterTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/member' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "member_List_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'member_List_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_member() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_member_info('', '', '', '', '', $this->config->item('memberMasterTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/member' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "member_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'member_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_conception() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_conception_info(0, $this->config->item('conceptionTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/conception' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "conception_List_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'conception_List_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_conception() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_conception_info(0, $this->config->item('conceptionTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/conception' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "conception_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'conception_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_pregnancy() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_pregnancy_info(0, $this->config->item('pregnancyTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/pregnancy' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "pregnancy_List_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'pregnancy_List_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_pregnancy() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_pregnancy_info(0, $this->config->item('pregnancyTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/pregnancy' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "pregnancy_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'pregnancy_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_birth() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_birth_info(0, $this->config->item('memberMasterTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/birth' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "birth_List_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'birth_List_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_birth() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_birth_info(0, $this->config->item('memberMasterTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/birth' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "birth_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'birth_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_interview() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_interview_info(0, $this->config->item('householdVisitTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/interview' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "interview_List_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'interview_List_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_interview() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_interview_info(0, $this->config->item('householdVisitTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/interview' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "interview_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'interview_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_household() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_household_master_info('', '', '', '', '', $this->config->item('householdMasterTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/household' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "household_List_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'household_List_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_household() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_household_master_info('', '', '', '', '', $this->config->item('householdMasterTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/household' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "household_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'household_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_migration_in() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_migration_in_info(0, $this->config->item('migrationInTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/migration_in' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "migration_in_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'migration_in_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_migration_in() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_migration_in_info(0, $this->config->item('migrationInTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/migration_in' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "migration_in_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'migration_in_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_asset() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_asset_info(0, $this->config->item('householdAssetTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/asset' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "asset_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'asset_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_asset() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_asset_info(0, $this->config->item('householdAssetTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/asset' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "asset_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'asset_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_education() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_education_info(0, $this->config->item('memberEducationTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/education' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "education_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'education_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_education() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_education_info(0, $this->config->item('memberEducationTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/education' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "education_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'education_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_occupation() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_occupation_info(0, $this->config->item('memberOccupationTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/occupation' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "occupation_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'occupation_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_occupation() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_occupation_info(0, $this->config->item('memberOccupationTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/occupation' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "occupation_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'occupation_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_relation() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_relation_info(0, $this->config->item('memberRelationTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/relation' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "relation_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'relation_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_relation() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_relation_info(0, $this->config->item('memberRelationTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/relation' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "relation_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'relation_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_migration_out() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_migration_out_info(0, $this->config->item('migrationOutTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/migration_out' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "migration_out_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'migration_out_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_migration_out() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_migration_out_info(0, $this->config->item('migrationOutTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/migration_out' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "migration_out_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'migration_out_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_household_head() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_household_head_info(0, $this->config->item('memberHeadTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/household_head' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "household_head_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'household_head_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_household_head() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_household_head_info(0, $this->config->item('memberHeadTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/household_head' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "household_head_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'household_head_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function sav_format_death() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_death_info(0, $this->config->item('deathTable'));

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/death' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "death_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'death_Report.sav';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }

    public function dta_format_death() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_death_info(0, $this->config->item('deathTable'));


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/death' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "death_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'death_List_Report.dta';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            unlink($file);
        }
    }
	
	
	
	
	public function child_illness() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'child_illness';
        $data['editMethod'] = 'edit_child_illness';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = '';

        $round_no = '';

        if ($this->input->post('Clear')) {
            $this->session->unset_userdata('round_no');
            $data['round_no'] = '';
        }


        $round_no = $this->input->post('round_no');
        $data['round_no'] = $this->session->userdata('round_no');

        if ($this->input->post('search')) {

            $this->session->set_userdata('round_no', $round_no);
            $data['round_no'] = $this->session->userdata('round_no');
        }

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/child_illness', $data);
        $this->load->view('includes/footer');
    }

    public function show_child_illness() {

        $baseID = $this->input->get('baseID', TRUE);

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = $this->input->post("length");
        $order = $this->input->post("order");
        $search = $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }

        if ($dir != "asc" && $dir != "desc") {
            $dir = "desc";
        }
        $valid_columns = array(
            0 => 'id',
            1 => 'DOB',
            2 => 'HHNO',
            3 => 'member_code',
            4 => 'breastfeeding_ever_code',
            5 => 'breastfeeding_after_how_many_time_after_birth_code',
            6 => 'breastfeeding_after_how_many_hour_after_birth',
            7 => 'breastfeeding_after_how_many_day_after_birth',
            8 => 'other_drink_except_breastfeeding_code',
            9 => 'drink_anything_else_except_breastfeeding_code',
            10 => 'drink_just_water_code',
            11 => 'drink_sugar_or_glucose_water_code',
            12 => 'drink_honey_code',
            13 => 'drink_pipe_water_code',
            14 => 'drink_sugar_or_salt_mixed_water_code',
            15 => 'drink_fruit_juice_code',
            16 => 'drink_baby_food_code',
            17 => 'drink_tea_or_saline_in_vein_code',
            18 => 'drink_coffee_code',
            19 => 'drink_dont_know_code',
            20 => 'drink_other_code',
            21 => 'drink_other_value',
            22 => 'breastfeeding_still_now_code',
            23 => 'breastfeeding_how_many_month_code',
            24 => 'breastfeeding_how_many_month_value',
            25 => 'yesterday_day_night_just_water_code',
            26 => 'yesterday_day_night_juice_code',
            27 => 'yesterday_day_night_soup_fruit_juice_code',
            28 => 'yesterday_day_night_tin_milk_power_milk_cow_milk_code',
            29 => 'yesterday_day_night_baby_food_code',
            30 => 'yesterday_day_night_other_code',
            31 => 'yesterday_day_night_other_value',
            32 => 'yesterday_day_night_hard_half_hard_soft_food_code',
            33 => 'hard_half_hard_soft_food_since_how_many_month_code',
            34 => 'hard_half_hard_soft_food_since_how_many_month_value',
            35 => 'diarrhoea_happened_code',
            36 => 'diarrhoea_happened_day_number',
            37 => 'diarrhoea_type_code',
            38 => 'diarrhoea_treatment_type_code',
            39 => 'diarrhoea_treatment_from_code',
            40 => 'diarrhoea_treatment_from_other_value',
            41 => 'diarrhoea_start_date',
            42 => 'pneumonia_symptom_no_symptom_code',
            43 => 'pneumonia_symptom_fever_code',
            44 => 'pneumonia_symptom_cold_cough_code',
            45 => 'pneumonia_symptom_breath_shortness_frequent_breathing_code',
            46 => 'pneumonia_symptom_chest_going_down_code',
            47 => 'antibiotic_for_pneumonia_code',
            48 => 'pneumonia_treatment_taken_from_code',
            49 => 'pneumonia_treatment_taken_from_other_value',
            50 => 'pneumonia_start_date',
            51 => 'interview_status_code',
            52 => 'insertedDate',
            53 => 'insertedTime',
            54 => 'insertedBy_name',
            55 => 'updatedDate',
            56 => 'updatedTime',
            57 => 'updateBy_name');

        if (!isset($valid_columns[$col])) {
            $order = null;
        } else {
            $order = $valid_columns[$col];
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($search)) {
            $x = 0;
            foreach ($valid_columns as $sterm) {
                if ($x == 0) {
                    $this->db->like($sterm, $search);
                } else {
                    $this->db->or_like($sterm, $search);
                }
                $x++;
            }
        }
        $this->db->limit($length, $start);

//$this->db->limit(($length != '' && $length != '-1')? $length : 0, ($start)? $start : 0);


        $round_no = $this->session->userdata('round_no') ? $this->session->userdata('round_no') : 0;

        if ($round_no > 0) {
            $all_data_list = $this->db->get_where("child_illness_view", array('round_master_id' => $round_no));
        } else {
            $all_data_list = $this->db->get("child_illness_view");
        }

        $data = array();

        if (!empty($all_data_list)) {

            foreach ($all_data_list->result() as $rows) {
                $edit_link = "<a href='" . base_url() . "reports/edit_child_illness/" . $rows->id . "?baseID=" . $baseID . "' class='btn btn-sm btn-primary'>Edit</a>";
                $data[] = array(
                    $edit_link,
                    $rows->DOB,
                    $rows->HHNO,
                    $rows->member_code,
                    $rows->breastfeeding_ever_code,
                    $rows->breastfeeding_after_how_many_time_after_birth_code,
                    $rows->breastfeeding_after_how_many_hour_after_birth,
                    $rows->breastfeeding_after_how_many_day_after_birth,
                    $rows->other_drink_except_breastfeeding_code,
                    $rows->drink_anything_else_except_breastfeeding_code,
                    $rows->drink_just_water_code,
                    $rows->drink_sugar_or_glucose_water_code,
                    $rows->drink_honey_code,
                    $rows->drink_pipe_water_code,
                    $rows->drink_sugar_or_salt_mixed_water_code,
                    $rows->drink_fruit_juice_code,
                    $rows->drink_baby_food_code,
                    $rows->drink_tea_or_saline_in_vein_code,
                    $rows->drink_coffee_code,
                    $rows->drink_dont_know_code,
                    $rows->drink_other_code,
                    $rows->drink_other_value,
                    $rows->breastfeeding_still_now_code,
                    $rows->breastfeeding_how_many_month_code,
                    $rows->breastfeeding_how_many_month_value,
                    $rows->yesterday_day_night_just_water_code,
                    $rows->yesterday_day_night_juice_code,
                    $rows->yesterday_day_night_soup_fruit_juice_code,
                    $rows->yesterday_day_night_tin_milk_power_milk_cow_milk_code,
                    $rows->yesterday_day_night_baby_food_code,
                    $rows->yesterday_day_night_other_code,
                    $rows->yesterday_day_night_other_value,
                    $rows->yesterday_day_night_hard_half_hard_soft_food_code,
                    $rows->hard_half_hard_soft_food_since_how_many_month_code,
                    $rows->hard_half_hard_soft_food_since_how_many_month_value,
                    $rows->diarrhoea_happened_code,
                    $rows->diarrhoea_happened_day_number,
                    $rows->diarrhoea_type_code,
                    $rows->diarrhoea_treatment_type_code,
                    $rows->diarrhoea_treatment_from_code,
                    $rows->diarrhoea_treatment_from_other_value,
                    $rows->diarrhoea_start_date,
                    $rows->pneumonia_symptom_no_symptom_code,
                    $rows->pneumonia_symptom_fever_code,
                    $rows->pneumonia_symptom_cold_cough_code,
                    $rows->pneumonia_symptom_breath_shortness_frequent_breathing_code,
                    $rows->pneumonia_symptom_chest_going_down_code,
                    $rows->antibiotic_for_pneumonia_code,
                    $rows->pneumonia_treatment_taken_from_code,
                    $rows->pneumonia_treatment_taken_from_other_value,
                    $rows->pneumonia_start_date,
                    $rows->interview_status_code,
                    $rows->insertedDate,
                    $rows->insertedTime,
                    $rows->insertedBy_name,
                    $rows->updatedDate,
                    $rows->updatedTime,
                    $rows->updateBy_name
                );
            }
        }
        $total_all_data_list = $this->totalMembers_child_illness();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_all_data_list,
            "recordsFiltered" => $total_all_data_list,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function totalMembers_child_illness() {

        $round_no = $this->session->userdata('round_no') ? $this->session->userdata('round_no') : 0;

        if ($round_no > 0) {

            $query = $this->db->select("COUNT(*) as num")->get_where("child_illness_view", array('round_master_id' => $round_no));
        } else {
            $query = $this->db->select("COUNT(*) as num")->get("child_illness_view");
        }

        $result = $query->row();
        if (isset($result))
            return $result->num;
        return 0;
    }

    public function edit_child_illness($id) {
//        echo $id; exit();
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Immunization";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_child_illness';
        $data['shortName'] = "Child Illness";
        $data['boxTitle'] = 'List';

        $data['ChildIllnessRecord'] = $this->modelName->child_illness_info($id, $this->config->item('memberChildIllnessTable'));

//        echo "<pre/>";
//        print_r($data['conception_info']); exit();

        $data['instantly_hour_day'] = $this->modelName->getLookUpList($this->config->item('instantly_hour_day'));
        $data['yes_no'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
        $data['drink_type'] = $this->modelName->getLookUpList($this->config->item('drink_type'));
        $data['month_dont_know'] = $this->modelName->getLookUpList($this->config->item('month_dont_know'));
        $data['yes_no_dont_know'] = $this->modelName->getLookUpList($this->config->item('yes_no_dont_know'));
        $data['diarrhea_happened'] = $this->modelName->getLookUpList($this->config->item('diarrhea_happened'));
        $data['diarrhea_type'] = $this->modelName->getLookUpList($this->config->item('diarrhea_type'));
        $data['diarrhea_treatment_type'] = $this->modelName->getLookUpList($this->config->item('diarrhea_treatment_type'));
        $data['treatment_taken_from'] = $this->modelName->getLookUpList($this->config->item('treatment_taken_from'));
        $data['antibiotic_for_pneumonia'] = $this->modelName->getLookUpList($this->config->item('antibiotic_for_pneumonia'));
        $data['interview_status_child_illness'] = $this->modelName->getLookUpList($this->config->item('interview_status_child_illness'));


        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_child_illness', $data);
        $this->load->view('includes/footer');
    }

    function update_child_illness() {
        $child_illness_id = $this->input->post('child_illness_id', true);
        $getCurrentRound = $this->modelName->getCurrentRound();
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('breastfeeding_ever', 'breastfeeding ever', 'trim|required|numeric');
        $this->form_validation->set_rules('other_drink_except_breastfeeding', 'Other drink except breastfeeding', 'trim|required|numeric');
        $this->form_validation->set_rules('breastfeeding_still_now', 'Breastfeeding still now', 'trim|required|numeric');
        $this->form_validation->set_rules('yesterday_day_night_hard_half_hard_soft_food', 'Fed hard or half hard or soft food yesterday day night', 'trim|required|numeric');
        $this->form_validation->set_rules('diarrhoea_happened', 'diarrhoea happened', 'trim|required|numeric');
        $this->form_validation->set_rules('interview_status', 'Interview status', 'trim|required|numeric');

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_child_illness/' . $child_illness_id . '?baseID=' . $baseID);
        } else {
            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_child_illness/' . $child_illness_id . '?baseID=' . $baseID);
            }

            $breastfeeding_ever = $this->input->post('breastfeeding_ever', true);
            $breastfeeding_after_how_many_time_after_birth = 0;
            $breastfeeding_after_how_many_hour_after_birth = 0;
            $breastfeeding_after_how_many_day_after_birth = 0;

            if ($breastfeeding_ever == 1) {
                $breastfeeding_after_how_many_time_after_birth = $this->input->post('breastfeeding_after_how_many_time_after_birth', true);
                if ($breastfeeding_after_how_many_time_after_birth == 515) {
                    $breastfeeding_after_how_many_hour_after_birth = $this->input->post('breastfeeding_after_how_many_hour_after_birth', true);
                } else if ($breastfeeding_after_how_many_time_after_birth == 516) {
                    $breastfeeding_after_how_many_day_after_birth = $this->input->post('breastfeeding_after_how_many_day_after_birth', true);
                }
            }

            $other_drink_except_breastfeeding = $this->input->post('other_drink_except_breastfeeding', true);

            $drink_anything_else_except_breastfeeding = 0;
            $drink_just_water = 0;
            $drink_sugar_or_glucose_water = 0;
            $drink_honey = 0;
            $drink_pipe_water = 0;
            $drink_sugar_or_salt_mixed_water = 0;
            $drink_fruit_juice = 0;
            $drink_baby_food = 0;
            $drink_tea_or_saline_in_vein = 0;
            $drink_coffee = 0;
            $drink_dont_know = 0;
            $drink_other = 0;
            $drink_other_value = NULL;

            if ($other_drink_except_breastfeeding == 1) {
                $drink_anything_else_except_breastfeeding = $this->input->post('drink_anything_else_except_breastfeeding', true);
                $drink_just_water = $this->input->post('drink_just_water', true);
                $drink_sugar_or_glucose_water = $this->input->post('drink_sugar_or_glucose_water', true);
                $drink_honey = $this->input->post('drink_honey', true);
                $drink_pipe_water = $this->input->post('drink_pipe_water', true);
                $drink_sugar_or_salt_mixed_water = $this->input->post('drink_sugar_or_salt_mixed_water', true);
                $drink_fruit_juice = $this->input->post('drink_fruit_juice', true);
                $drink_baby_food = $this->input->post('drink_baby_food', true);
                $drink_tea_or_saline_in_vein = $this->input->post('drink_tea_or_saline_in_vein', true);
                $drink_coffee = $this->input->post('drink_coffee', true);
                $drink_dont_know = $this->input->post('drink_dont_know', true);
                $drink_other = $this->input->post('drink_other', true);
                if ($drink_other > 0) {
                    $drink_other_value = $this->input->post('drink_other_value', true);
                }
            }

            $breastfeeding_still_now = $this->input->post('breastfeeding_still_now', true);

            $breastfeeding_how_many_month = 0;
            $breastfeeding_how_many_month_value = 0;

            if ($breastfeeding_still_now == 1) {
                $breastfeeding_how_many_month = $this->input->post('breastfeeding_how_many_month', true);
                if ($breastfeeding_how_many_month == 529) {
                    $breastfeeding_how_many_month_value = $this->input->post('breastfeeding_how_many_month_value', true);
                }
            }

            $yesterday_day_night_just_water = 0;
            $yesterday_day_night_juice = 0;
            $yesterday_day_night_soup_fruit_juice = 0;
            $yesterday_day_night_tin_milk_power_milk_cow_milk = 0;
            $yesterday_day_night_baby_food = 0;
            $yesterday_day_night_other = 0;

            $yesterday_day_night_just_water = $this->input->post('yesterday_day_night_just_water', true);
            $yesterday_day_night_juice = $this->input->post('yesterday_day_night_juice', true);
            $yesterday_day_night_soup_fruit_juice = $this->input->post('yesterday_day_night_soup_fruit_juice', true);
            $yesterday_day_night_tin_milk_power_milk_cow_milk = $this->input->post('yesterday_day_night_tin_milk_power_milk_cow_milk', true);
            $yesterday_day_night_baby_food = $this->input->post('yesterday_day_night_baby_food', true);
            $yesterday_day_night_other = $this->input->post('yesterday_day_night_other', true);
            $yesterday_day_night_other_value = 0;
            if ($yesterday_day_night_other == 331) {
                $yesterday_day_night_other_value = $this->input->post('yesterday_day_night_other_value', true);
            }
            $yesterday_day_night_hard_half_hard_soft_food = $this->input->post('yesterday_day_night_hard_half_hard_soft_food', true);
            $hard_half_hard_soft_food_since_how_many_month = 0;
            $hard_half_hard_soft_food_since_how_many_month_value = NULL;
            if ($yesterday_day_night_hard_half_hard_soft_food == 1) {
                $hard_half_hard_soft_food_since_how_many_month = $this->input->post('hard_half_hard_soft_food_since_how_many_month', true);
                if ($hard_half_hard_soft_food_since_how_many_month == 529) {
                    $hard_half_hard_soft_food_since_how_many_month_value = $this->input->post('hard_half_hard_soft_food_since_how_many_month_value', true);
                }
            }


            $diarrhoea_happened = $this->input->post('diarrhoea_happened', true);
            $diarrhoea_happened_day_number = 0;
            if ($diarrhoea_happened == 532) {
                $diarrhoea_happened_day_number = $this->input->post('diarrhoea_happened_day_number', true);
            }

            $diarrhoea_type = 0;
            $diarrhoea_treatment_type = 0;
            $diarrhoea_treatment_from = 0;

            $diarrhoea_type = $this->input->post('diarrhoea_type', true);
            $diarrhoea_treatment_type = $this->input->post('diarrhoea_treatment_type', true);
            $diarrhoea_treatment_from = $this->input->post('diarrhoea_treatment_from', true);
            $diarrhoea_treatment_from_other_value = NULL;
            if ($diarrhoea_treatment_from == 549) {
                $diarrhoea_treatment_from_other_value = $this->input->post('diarrhoea_treatment_from_other_value', true);
            }
            $diarrhoea_start_date = $this->input->post('diarrhoea_start_date', true);
            $new_diarrhoea_start_date = null;
            if (!empty($diarrhoea_start_date)) {
                $parts3 = explode('/', $diarrhoea_start_date);
                $new_diarrhoea_start_date = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            if ($diarrhoea_happened == 531) {
                $diarrhoea_happened_day_number = 0;
                $diarrhoea_type = 0;
                $diarrhoea_treatment_type = 0;
                $diarrhoea_treatment_from = 0;
                $diarrhoea_treatment_from_other_value = NULL;
                $new_diarrhoea_start_date = null;
            }

            $pneumonia_symptom_no_symptom = $this->input->post('pneumonia_symptom_no_symptom', true) > 0 ? $this->input->post('pneumonia_symptom_no_symptom', true) : 0;
            $pneumonia_symptom_fever = $this->input->post('pneumonia_symptom_fever', true) > 0 ? $this->input->post('pneumonia_symptom_fever', true) : 0;
            $pneumonia_symptom_cold_cough = $this->input->post('pneumonia_symptom_cold_cough', true) > 0 ? $this->input->post('pneumonia_symptom_cold_cough', true) : 0;
            $pneumonia_symptom_breath_shortness_frequent_breathing = $this->input->post('pneumonia_symptom_breath_shortness_frequent_breathing', true) > 0 ? $this->input->post('pneumonia_symptom_breath_shortness_frequent_breathing', true) : 0;
            $pneumonia_symptom_chest_going_down = $this->input->post('pneumonia_symptom_chest_going_down', true) > 0 ? $this->input->post('pneumonia_symptom_chest_going_down', true) : 0;

            $antibiotic_for_pneumonia = $this->input->post('antibiotic_for_pneumonia', true) > 0 ? $this->input->post('antibiotic_for_pneumonia', true) : 0;
            $pneumonia_treatment_taken_from = $this->input->post('pneumonia_treatment_taken_from', true) > 0 ? $this->input->post('pneumonia_treatment_taken_from', true) : 0;
            $pneumonia_treatment_taken_from_other_value = null;
            if ($pneumonia_treatment_taken_from == 549) {
                $pneumonia_treatment_taken_from_other_value = $this->input->post('pneumonia_treatment_taken_from_other_value', true);
            }

            $pneumonia_start_date = $this->input->post('pneumonia_start_date', true);

            $new_pneumonia_start_date = null;
            if (!empty($pneumonia_start_date)) {
                $parts3 = explode('/', $pneumonia_start_date);
                $new_pneumonia_start_date = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            if ($pneumonia_symptom_no_symptom == 1) {
                $antibiotic_for_pneumonia = 0;
                $pneumonia_treatment_taken_from = 0;
                $pneumonia_treatment_taken_from_other_value = NULL;
                $pneumonia_start_date = NULL;
            }

            $interview_status = $this->input->post('interview_status', true);

            $this->db->trans_start();

            try {
                $IdInfo = array(
                    'breastfeeding_ever' => $breastfeeding_ever,
                    'breastfeeding_after_how_many_time_after_birth' => $breastfeeding_after_how_many_time_after_birth,
                    'breastfeeding_after_how_many_hour_after_birth' => $breastfeeding_after_how_many_hour_after_birth,
                    'breastfeeding_after_how_many_day_after_birth' => $breastfeeding_after_how_many_day_after_birth,
                    'other_drink_except_breastfeeding' => $other_drink_except_breastfeeding,
                    'drink_anything_else_except_breastfeeding' => $drink_anything_else_except_breastfeeding,
                    'drink_just_water' => $drink_just_water,
                    'drink_sugar_or_glucose_water' => $drink_sugar_or_glucose_water,
                    'drink_honey' => $drink_honey,
                    'drink_pipe_water' => $drink_pipe_water,
                    'drink_sugar_or_salt_mixed_water' => $drink_sugar_or_salt_mixed_water,
                    'drink_fruit_juice' => $drink_fruit_juice,
                    'drink_baby_food' => $drink_baby_food,
                    'drink_tea_or_saline_in_vein' => $drink_tea_or_saline_in_vein,
                    'drink_coffee' => $drink_coffee,
                    'drink_dont_know' => $drink_dont_know,
                    'drink_other' => $drink_other,
                    'drink_other_value' => $drink_other_value,
                    'breastfeeding_still_now' => $breastfeeding_still_now,
                    'breastfeeding_how_many_month' => $breastfeeding_how_many_month,
                    'breastfeeding_how_many_month_value' => $breastfeeding_how_many_month_value,
                    'yesterday_day_night_just_water' => $yesterday_day_night_just_water,
                    'yesterday_day_night_juice' => $yesterday_day_night_juice,
                    'yesterday_day_night_soup_fruit_juice' => $yesterday_day_night_soup_fruit_juice,
                    'yesterday_day_night_tin_milk_power_milk_cow_milk' => $yesterday_day_night_tin_milk_power_milk_cow_milk,
                    'yesterday_day_night_baby_food' => $yesterday_day_night_baby_food,
                    'yesterday_day_night_other' => $yesterday_day_night_other,
                    'yesterday_day_night_other_value' => $yesterday_day_night_other_value,
                    'yesterday_day_night_hard_half_hard_soft_food' => $yesterday_day_night_hard_half_hard_soft_food,
                    'hard_half_hard_soft_food_since_how_many_month' => $hard_half_hard_soft_food_since_how_many_month,
                    'hard_half_hard_soft_food_since_how_many_month_value' => $hard_half_hard_soft_food_since_how_many_month_value,
                    'diarrhoea_happened' => $diarrhoea_happened,
                    'diarrhoea_happened_day_number' => $diarrhoea_happened_day_number,
                    'diarrhoea_type' => $diarrhoea_type,
                    'diarrhoea_treatment_type' => $diarrhoea_treatment_type,
                    'diarrhoea_treatment_from' => $diarrhoea_treatment_from,
                    'diarrhoea_treatment_from_other_value' => $diarrhoea_treatment_from_other_value,
                    'diarrhoea_start_date' => $new_diarrhoea_start_date,
                    'pneumonia_symptom_no_symptom' => $pneumonia_symptom_no_symptom,
                    'pneumonia_symptom_fever' => $pneumonia_symptom_fever,
                    'pneumonia_symptom_cold_cough' => $pneumonia_symptom_cold_cough,
                    'pneumonia_symptom_breath_shortness_frequent_breathing' => $pneumonia_symptom_breath_shortness_frequent_breathing,
                    'pneumonia_symptom_chest_going_down' => $pneumonia_symptom_chest_going_down,
                    'antibiotic_for_pneumonia' => $antibiotic_for_pneumonia,
                    'pneumonia_treatment_taken_from' => $pneumonia_treatment_taken_from,
                    'pneumonia_treatment_taken_from_other_value' => $pneumonia_treatment_taken_from_other_value,
                    'pneumonia_start_date' => $new_pneumonia_start_date,
                    'interview_status' => $interview_status,
                    
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($IdInfo, $child_illness_id, $this->config->item('memberChildIllnessTable'));

                $fk_followup_exit_type = 0;

                if ($this->input->post('interview_status', true) == 559 || $this->input->post('interview_status', true) == 560) {
                    $fk_followup_exit_type = $this->input->post('interview_status', true);
                }

                $memberUpdate = array(
                    'fk_followup_exit_type' => $fk_followup_exit_type,
                    
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->UpdateInfo($memberUpdate, $member_master_id, $this->config->item('memberMasterTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating Immunization.');
                redirect($this->controller . '/edit_child_illness/' . $child_illness_id . '?baseID=' . $baseID);
            }

            $this->db->trans_commit();

            $this->session->set_flashdata('success', 'Member Child Illness Info updated successfully.');
            if ($this->input->post('update_exit')) {
                redirect($this->controller . '/child_illness' . '?baseID=' . $baseID);
            }
            redirect($this->controller . '/edit_child_illness/' . $child_illness_id . '?baseID=' . $baseID);
        }
    }
	
	
	

}

?>