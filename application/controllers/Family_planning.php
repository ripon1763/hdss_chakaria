<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Family_planning extends BaseController {

    /**
     * This is default constructor of the class
     */
    public $controller = "Family_planning";
    public $pageTitle = 'Family planning';
    public $pageShortName = 'Family planning';

    public function __construct() {
        parent::__construct();
        $this->load->model('member_model', 'memberModel');
        $this->load->model('master_model', 'modelName');
        $this->load->model('householdVisit_model', 'visitModel');
        $this->load->model('Householdasset_model', 'assetModel');
        $this->load->model('FamilyPlanning_model', 'FamilyPlanningModel');
        $this->load->model('menu_model', 'menuModel');
        $this->load->library('pagination');
        $this->isLoggedIn();
        $menu_key = 'family-planning';
        $baseID = $this->input->get('baseID', TRUE);
        $result = $this->loadThisForAccess($this->role, $baseID, $menu_key);
        if ($result != true) {
            redirect('access');
        }
    }

    public function index() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['addMethod'] = 'addNew';
        $data['editMethod'] = 'editOld';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        if ($this->getCurrentRound()[0]->active == 0) {

            $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
            redirect($this->controller . '?baseID=' . $baseID);
        }

        if ($this->input->post('Clear')) {
            $this->session->unset_userdata('household_code');
            $this->session->unset_userdata('slumid_visit');
            $this->session->unset_userdata('slumareaid_visit');
            $this->session->unset_userdata('barinumber_visit');
            $this->session->unset_userdata('household_master_id_sub');
            $data['household_master_id_sub'] = '';
        }


        if ($this->input->post('search')) {

            $household_id = $this->input->post('household_id', true);


            $slumid_visit = $this->input->post('slum_id', true);
            $slumareaid_visit = $this->input->post('slumarea_id', true);
            $barinumber_visit = $this->input->post('barinumber', true);


            if ($household_id == 0) {
                redirect('Family_planning/visit?baseID=' . $baseID);
            }

            $whereHousehold = array('id' => $household_id);
            $household_code = $this->db->select('household_code')->from($this->config->item('householdMasterTable'))->where($whereHousehold)->get()->row()->household_code;

            $household_master_id_sub = 0;
            $data['household_master_id_sub'] = 0;


            $this->session->set_userdata('householdcode', $household_code);

            $this->session->set_userdata('slumid_visit', $slumid_visit);
            $this->session->set_userdata('slumareaid_visit', $slumareaid_visit);
            $this->session->set_userdata('barinumber_visit', $barinumber_visit);

            $household_master_id_sub = $this->input->post('household_id', true);
            $this->session->set_userdata('household_master_id_sub', $household_master_id_sub);

            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] > 0) {
                redirect('Family_planning/family_planning_info?baseID=' . $baseID . '#family_planning_info');
            }
        } else {
            redirect('Family_planning/visit?baseID=' . $baseID);
        }


        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard_family_planning');
        $this->load->view($this->controller . '/family_planning', $data);
        $this->load->view('includes/footer');
    }

    /**
     * This function used to load the first screen of the user
     */
    public function visit() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['addMethod'] = 'addNew';
        $data['editMethod'] = 'editOld';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        $data['Slum'] = $this->modelName->getSlumListNew();

        $data['household_master_id_visit'] = $this->session->userdata('household_master_id_sub');
        $data['slumid_visit'] = $this->session->userdata('slumid_visit');
        $data['slumareaid_visit'] = $this->session->userdata('slumareaid_visit');
        $data['barinumber_visit'] = $this->session->userdata('barinumber_visit');


        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view($this->controller . '/index', $data);
        $this->load->view('includes/footer');
    }

    public function family_planning_info() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : Household Baseline Census';
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['addMethod'] = 'addNew';
        $data['editMethod'] = 'editOld';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        if ($this->getCurrentRound()[0]->active == 0) {

            $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
            redirect($this->controller . '?baseID=' . $baseID);
        }

        $data['roundNo'] = $this->getCurrentRound()[0]->roundNo;
        $data['round_master_id'] = $this->getCurrentRound()[0]->id;
        $data['householdcode'] = $this->session->userdata('householdcode');

        $data['household_master_id_sub'] = 0;
        $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');


        if ($data['household_master_id_sub'] == 0) {
            redirect('Family_planning/visit?baseID=' . $baseID);
        }

        if ($this->input->post('submit')) {
            $this->session->unset_userdata('household_master_id_sub');
            redirect('Family_planning/visit?baseID=' . $baseID);
        }

        $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'), $data['household_master_id_sub'], $data['round_master_id']);
        $data['familyPlanningRecords'] = $this->FamilyPlanningModel->getFamilyPlanningHistory($data['household_master_id_sub'], $data['round_master_id']);
        $data['presentMemberList'] = $this->memberModel->getMemberMasterPresentListByHouseholdIdsandMaritalStatusmarsep($data['household_master_id_sub']);
//        echo "<pre/>";
//        print_r($data['familyPlanningRecords']);
//        exit();


        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard_family_planning', $data);
        $this->load->view($this->controller . '/family_planning_info', $data);
        $this->load->view('includes/footer');
    }

    public function add_family_planning($id) {
        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id_current = $this->input->get('household_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : Family Planning';
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['addMethod'] = 'addNew';
        $data['editMethod'] = 'editOld';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        if ($this->getCurrentRound()[0]->active == 0) {

            $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
            redirect($this->controller . '?baseID=' . $baseID);
        }

        $data['roundNo'] = $this->getCurrentRound()[0]->roundNo;
        $data['round_master_id'] = $this->getCurrentRound()[0]->id;
        $data['householdcode'] = $this->session->userdata('householdcode');

        $data['household_master_id_sub'] = 0;

        $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

        if ($data['household_master_id_sub'] == 0) {
            redirect('Family_planning/visit?baseID=' . $baseID);
        }


        $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'), $data['household_master_id_sub'], $data['round_master_id']);
        $data['memberInfo'] = $this->memberModel->getListInfo($id, $this->config->item('memberMasterTable'));


        $data['yes_no'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
        $data['marital_status_typ'] = $this->modelName->getLookUpList($this->config->item('maritalstatustyp'));
        $data['yes_no_dont_know'] = $this->modelName->getLookUpList($this->config->item('yes_no_dont_know'));
        $data['husband_staying_place'] = $this->modelName->getLookUpList($this->config->item('husband_staying_place'));
        $data['birth_control_method'] = $this->modelName->getLookUpList($this->config->item('birth_control_method'));
        $data['method_taken_from'] = $this->modelName->getLookUpList($this->config->item('method_taken_from'));
        $data['birth_control_method_taking_decision'] = $this->modelName->getLookUpList($this->config->item('birth_control_method_taking_decision'));
        $data['reason_behind_not_taking_birth_control_method'] = $this->modelName->getLookUpList($this->config->item('reason_behind_not_taking_birth_control_method'));
        $data['yes_no_pregnant_dont_know'] = $this->modelName->getLookUpList($this->config->item('yes_no_pregnant_dont_know'));
        $data['how_many_children'] = $this->modelName->getLookUpList($this->config->item('how_many_children'));
        $data['alive_children'] = $this->modelName->getLookUpList($this->config->item('alive_children'));
        $data['no_one_how_many_others'] = $this->modelName->getLookUpList($this->config->item('no_one_how_many_others'));
        $data['boy_girl_anyone'] = $this->modelName->getLookUpList($this->config->item('boy_girl_anyone'));

        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard_family_planning', $data);
        $this->load->view($this->controller . '/family_planning_details', $data);
        $this->load->view('includes/footer');
    }

    function addNewFamilyPlanning() {

        $household_master_id = $this->input->post('household_master_id_sub', true);
        $round_master_id = $this->input->post('round_master_id', true);
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('maritial_status', 'Maritial status', 'trim|required|numeric');
        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {

            redirect('Family_planning/add_family_planning/' . $member_master_id . '?household_master_id=' . $household_master_id . '&&baseID=' . $baseID . '#family_planning_info');
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect('Family_planning/visit?baseID=' . $baseID);
            }

            $whereHouseholdFamilyPlanning = array('household_master_id' => $household_master_id, 'round_master_id' => $round_master_id, 'member_master_id' => $member_master_id);

            $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('householdFamilyPlanningTable'))->where($whereHouseholdFamilyPlanning)->get()->row()->countRow;

            if ($countRow > 0) {
                $this->session->set_flashdata('error', 'Family planning already exists for this round.');
                redirect('Family_planning/family_planning_info?baseID=' . $baseID . '#family_planning_info');
            }

            $maritial_status = 0;
            $current_pregnancy_status = 0;
            $husband_living_place = 0;
            $birth_control_method_usage_status = 0;
            $birth_control_method = 0;
            $birth_control_method_other_value = 0;
            $continuously_using_how_many_month = 0;
            $continuously_using_how_many_year = 0;
            $birth_control_method_suggestion_from_where = 0;
            $birth_control_method_suggestion_from_where_other_value = NULL;
            $whose_decision = 0;
            $whose_decision_other_value = NULL;
            $reason_behind_not_using = 0;
            $reason_behind_not_using_other_value = NULL;
            $future_desire = 0;
            $reason_behind_not_having_future_desire = 0;
            $reason_behind_not_having_future_desire_other_value = NULL;
            $do_you_know_from_where = 0;
            $available_govt_hospital = 0;
            $available_central_dist_hospital = 0;
            $available_matri_sonod = 0;
            $available_ngo_facility = 0;
            $available_upazilla_sasthokendro = 0;
            $available_union_sastho_poribar_kollan_kendro = 0;
            $available_satellite_clinic = 0;
            $available_community_clinic = 0;
            $available_ngo_and_satellite_clinic = 0;
            $available_ngo_and_static_clinic = 0;
            $available_private_hospital = 0;
            $available_mbbs_doctor_chamber = 0;
            $available_doctor_without_degrees = 0;
            $available_pharmacy = 0;
            $available_other = 0;
            $available_other_value = NULL;
            $taking_desire_more_children = 0;
            $taking_desire_more_children_after_year = 0;
            $how_many_children_you_want = 0;
            $alive_children = 0;
            $alive_boy_number = 0;
            $alive_girl_number = 0;
            $alive_children_yes_availability = 0;
            $alive_children_yes_availability_other_value = NULL;
            $alive_children_yes_availability_how_many = 0;
            $alive_children_no_availability = 0;
            $alive_children_no_availability_other_value = NULL;
            $alive_children_no_availability_how_many = 0;
            $how_many_male_female_children = 0;
            $how_many_male_female_children_other_value = NULL;
            $how_many_male = 0;
            $how_many_female = 0;
            $how_many_any = 0;
            $comment = NULL;


            $maritial_status = $this->input->post('maritial_status', true);
            $current_pregnancy_status = $this->input->post('current_pregnancy_status', true);

            $husband_living_place = $this->input->post('husband_living_place', true);
            $birth_control_method_usage_status = $this->input->post('birth_control_method_usage_status', true);



            $birth_control_method = $this->input->post('birth_control_method', true);

            $birth_control_method_other_value = $this->input->post('birth_control_method_other_value', true);
            if ($birth_control_method != 455) {
                $birth_control_method_other_value = NULL;
            }
            $continuously_using_how_many_year = $this->input->post('continuously_using_how_many_year', true);
            $continuously_using_how_many_month = $this->input->post('continuously_using_how_many_month', true);
            $birth_control_method_suggestion_from_where = $this->input->post('birth_control_method_suggestion_from_where', true);

            $birth_control_method_suggestion_from_where_other_value = $this->input->post('birth_control_method_suggestion_from_where_other_value', true);

            if ($birth_control_method_suggestion_from_where != 470) {
                $birth_control_method_suggestion_from_where_other_value = NULL;
            }

            $whose_decision = $this->input->post('whose_decision', true);

            $whose_decision_other_value = $this->input->post('whose_decision_other_value', true);
            if ($whose_decision != 474) {
                $whose_decision_other_value = NULL;
            }

            $reason_behind_not_using = $this->input->post('reason_behind_not_using', true);

            $reason_behind_not_using_other_value = $this->input->post('reason_behind_not_using_other_value', true);
            if ($reason_behind_not_using != 491) {
                $reason_behind_not_using_other_value = NULL;
            }

            $future_desire = $this->input->post('future_desire', true);

            $reason_behind_not_having_future_desire = $this->input->post('reason_behind_not_having_future_desire', true);

            $reason_behind_not_having_future_desire_other_value = $this->input->post('reason_behind_not_having_future_desire_other_value', true);
            if ($reason_behind_not_having_future_desire != 491) {
                $reason_behind_not_having_future_desire_other_value = NULL;
            }

            $do_you_know_from_where = $this->input->post('do_you_know_from_where', true);
            $available_govt_hospital = $this->input->post('available_govt_hospital', true);
            $available_central_dist_hospital = $this->input->post('available_central_dist_hospital', true);
            $available_matri_sonod = $this->input->post('available_matri_sonod', true);
            $available_ngo_facility = $this->input->post('available_ngo_facility', true);
            $available_upazilla_sasthokendro = $this->input->post('available_upazilla_sasthokendro', true);
            $available_union_sastho_poribar_kollan_kendro = $this->input->post('available_union_sastho_poribar_kollan_kendro', true);
            $available_satellite_clinic = $this->input->post('available_satellite_clinic', true);
            $available_community_clinic = $this->input->post('available_community_clinic', true);
            $available_ngo_and_satellite_clinic = $this->input->post('available_ngo_and_satellite_clinic', true);
            $available_ngo_and_static_clinic = $this->input->post('available_ngo_and_static_clinic', true);
            $available_private_hospital = $this->input->post('available_private_hospital', true);
            $available_mbbs_doctor_chamber = $this->input->post('available_mbbs_doctor_chamber', true);
            $available_doctor_without_degrees = $this->input->post('available_doctor_without_degrees', true);
            $available_pharmacy = $this->input->post('available_pharmacy', true);
            $available_other = $this->input->post('available_other', true);
            $available_other_value = $this->input->post('available_other_value', true);
            if ($available_other != 15) {
                $available_other_value = NULL;
            }
            $taking_desire_more_children = $this->input->post('taking_desire_more_children', true);
            $taking_desire_more_children_after_year = 0;
            if ($taking_desire_more_children == 494||$taking_desire_more_children==495||$taking_desire_more_children==496) {
                $taking_desire_more_children_after_year = $this->input->post('taking_desire_more_children_after_year', true);
            }

            $how_many_children_you_want = $this->input->post('how_many_children_you_want', true);

            if ($current_pregnancy_status == 331) {
                $husband_living_place = 0;
                $birth_control_method_usage_status = 0;
                $birth_control_method = 0;
                $birth_control_method_other_value = NULL;
                $continuously_using_how_many_year = 0;
                $continuously_using_how_many_month = 0;
                $birth_control_method_suggestion_from_where = 0;
                $birth_control_method_suggestion_from_where_other_value = NULL;
                $whose_decision = 0;
                $whose_decision_other_value = NULL;
                $reason_behind_not_using = 0;
                $reason_behind_not_using_other_value = NULL;
            }

            if ($birth_control_method_usage_status == 4) {
                $birth_control_method = 0;
                $birth_control_method_other_value = NULL;
                $continuously_using_how_many_year = 0;
                $continuously_using_how_many_month = 0;
                $birth_control_method_suggestion_from_where = 0;
                $birth_control_method_suggestion_from_where_other_value = NULL;
                $whose_decision = 0;
                $whose_decision_other_value = NULL;
            }

            if ($whose_decision > 0) {
                $reason_behind_not_using = 0;
                $reason_behind_not_using_other_value = NULL;
                $future_desire = 0;
                $reason_behind_not_having_future_desire = 0;
                $reason_behind_not_having_future_desire_other_value = NULL;

                $do_you_know_from_where = 0;
                $available_govt_hospital = 0;
                $available_central_dist_hospital = 0;
                $available_matri_sonod = 0;
                $available_ngo_facility = 0;
                $available_upazilla_sasthokendro = 0;
                $available_union_sastho_poribar_kollan_kendro = 0;
                $available_satellite_clinic = 0;
                $available_community_clinic = 0;
                $available_ngo_and_satellite_clinic = 0;
                $available_ngo_and_static_clinic = 0;
                $available_private_hospital = 0;
                $available_mbbs_doctor_chamber = 0;
                $available_doctor_without_degrees = 0;
                $available_pharmacy = 0;
                $available_other = 0;
                $available_other_value = NULL;
            }

            if ($future_desire == 331) {
                $reason_behind_not_having_future_desire = 0;
                $reason_behind_not_having_future_desire_other_value = NULL;
            }

            if ($do_you_know_from_where == 4) {
                $available_govt_hospital = 0;
                $available_central_dist_hospital = 0;
                $available_matri_sonod = 0;
                $available_ngo_facility = 0;
                $available_upazilla_sasthokendro = 0;
                $available_union_sastho_poribar_kollan_kendro = 0;
                $available_satellite_clinic = 0;
                $available_community_clinic = 0;
                $available_ngo_and_satellite_clinic = 0;
                $available_ngo_and_static_clinic = 0;
                $available_private_hospital = 0;
                $available_mbbs_doctor_chamber = 0;
                $available_doctor_without_degrees = 0;
                $available_pharmacy = 0;
                $available_other = 0;
                $available_other_value = NULL;
            }


            $alive_children = $this->input->post('alive_children', true);
            $alive_boy_number = 0;
            if ($alive_children == 502) {
                $alive_boy_number = $this->input->post('alive_boy_number', true);
            }
            $alive_girl_number = 0;
            if ($alive_children == 503) {
                $alive_girl_number = $this->input->post('alive_girl_number', true);
            }

            if ($alive_children == 512) {
                $alive_boy_number = $this->input->post('alive_boy_number', true);
                $alive_girl_number = $this->input->post('alive_girl_number', true);
            }

            $alive_children_yes_availability = $this->input->post('alive_children_yes_availability', true);

            $alive_children_yes_availability_other_value = NULL;

            if ($alive_children_yes_availability == 507) {
                $alive_children_yes_availability_other_value = $this->input->post('alive_children_yes_availability_other_value', true);
            }

            if ($alive_children == 504) {
                $alive_children_yes_availability = 0;
                $alive_children_yes_availability_other_value = NULL;
            }
            $alive_children_yes_availability_how_many = 0;
            if ($alive_children_yes_availability == 506) {
                $alive_children_yes_availability_how_many = $this->input->post('alive_children_yes_availability_how_many', true);
            }

            $alive_children_no_availability = $this->input->post('alive_children_no_availability', true);
            $alive_children_no_availability_other_value = NULL;
            if ($alive_children_no_availability == 507) {
                $alive_children_no_availability_other_value = $this->input->post('alive_children_no_availability_other_value', true);
            }

            $alive_children_no_availability_how_many = 0;
            if ($alive_children_no_availability == 506) {
                $alive_children_no_availability_how_many = $this->input->post('alive_children_no_availability_how_many', true);
            }

            $how_many_male_female_children = $this->input->post('how_many_male_female_children', true);
            if ($how_many_male_female_children == 511) {
                $how_many_male_female_children_other_value = $this->input->post('how_many_male_female_children_other_value', true);
            }
            if ($how_many_male_female_children == 508) {
                $how_many_male = $this->input->post('how_many_male', true);
            }
            if ($how_many_male_female_children == 509) {
                $how_many_female = $this->input->post('how_many_female', true);
            }
            if ($how_many_male_female_children == 510) {
                $how_many_any = $this->input->post('how_many_any', true);
            }
            
            $comment = $this->input->post('comment', true);

            if ($alive_children_yes_availability == 505 || $alive_children_yes_availability == 507) { //end the interview
                $alive_children_no_availability = 0;
                $alive_children_no_availability_other_value = NULL;
                $alive_children_no_availability_how_many = 0;
                $how_many_male_female_children = 0;
                $how_many_male_female_children_other_value = NULL;
                $how_many_male = 0;
                $how_many_female = 0;
                $how_many_any = 0;
            }

            if ($alive_children_no_availability == 505 || $alive_children_no_availability == 507) { //end the interview
                $how_many_male_female_children = 0;
                $how_many_male_female_children_other_value = NULL;
                $how_many_male = 0;
                $how_many_female = 0;
                $how_many_any = 0;
            }

            if ($maritial_status == 44 || $maritial_status == 109 || $maritial_status == 40) {

                $current_pregnancy_status = 0;
                $husband_living_place = 0;
                $birth_control_method_usage_status = 0;
                $birth_control_method = 0;
                $birth_control_method_other_value = 0;
                $continuously_using_how_many_month = 0;
                $continuously_using_how_many_year = 0;
                $birth_control_method_suggestion_from_where = 0;
                $birth_control_method_suggestion_from_where_other_value = NULL;
                $whose_decision = 0;
                $whose_decision_other_value = NULL;
                $reason_behind_not_using = 0;
                $reason_behind_not_using_other_value = NULL;
                $future_desire = 0;
                $reason_behind_not_having_future_desire = 0;
                $reason_behind_not_having_future_desire_other_value = NULL;
                $do_you_know_from_where = 0;
                $available_govt_hospital = 0;
                $available_central_dist_hospital = 0;
                $available_matri_sonod = 0;
                $available_ngo_facility = 0;
                $available_upazilla_sasthokendro = 0;
                $available_union_sastho_poribar_kollan_kendro = 0;
                $available_satellite_clinic = 0;
                $available_community_clinic = 0;
                $available_ngo_and_satellite_clinic = 0;
                $available_ngo_and_static_clinic = 0;
                $available_private_hospital = 0;
                $available_mbbs_doctor_chamber = 0;
                $available_doctor_without_degrees = 0;
                $available_pharmacy = 0;
                $available_other = 0;
                $available_other_value = NULL;
                $taking_desire_more_children = 0;
                $taking_desire_more_children_after_year = 0;
                $how_many_children_you_want = 0;
                $alive_children = 0;
                $alive_boy_number = 0;
                $alive_girl_number = 0;
                $alive_children_yes_availability = 0;
                $alive_children_yes_availability_other_value = NULL;
                $alive_children_yes_availability_how_many = 0;
                $alive_children_no_availability = 0;
                $alive_children_no_availability_other_value = NULL;
                $alive_children_no_availability_how_many = 0;
                $how_many_male_female_children = 0;
                $how_many_male_female_children_other_value = NULL;
                $how_many_male = 0;
                $how_many_female = 0;
                $how_many_any = 0;
            }

            $round_master_id_entry_round = $this->getCurrentRound()[0]->id;

            $this->db->trans_start();

            try {
                $IdInfo = array(
                    'maritial_status' => $maritial_status,
                    'current_pregnancy_status' => $current_pregnancy_status,
                    'husband_living_place' => $husband_living_place,
                    'birth_control_method_usage_status' => $birth_control_method_usage_status,
                    'birth_control_method' => $birth_control_method,
                    'birth_control_method_other_value' => $birth_control_method_other_value,
                    'continuously_using_how_many_month' => $continuously_using_how_many_month,
                    'continuously_using_how_many_year' => $continuously_using_how_many_year,
                    'birth_control_method_suggestion_from_where' => $birth_control_method_suggestion_from_where,
                    'birth_control_method_suggestion_from_where_other_value' => $birth_control_method_suggestion_from_where_other_value,
                    'whose_decision' => $whose_decision,
                    'whose_decision_other_value' => $whose_decision_other_value,
                    'reason_behind_not_using' => $reason_behind_not_using,
                    'reason_behind_not_using_other_value' => $reason_behind_not_using_other_value,
                    'future_desire' => $future_desire,
                    'reason_behind_not_having_future_desire' => $reason_behind_not_having_future_desire,
                    'reason_behind_not_having_future_desire_other_value' => $reason_behind_not_having_future_desire_other_value,
                    'do_you_know_from_where' => $do_you_know_from_where,
                    'available_govt_hospital' => $available_govt_hospital,
                    'available_central_dist_hospital' => $available_central_dist_hospital,
                    'available_matri_sonod' => $available_matri_sonod,
                    'available_ngo_facility' => $available_ngo_facility,
                    'available_upazilla_sasthokendro' => $available_upazilla_sasthokendro,
                    'available_union_sastho_poribar_kollan_kendro' => $available_union_sastho_poribar_kollan_kendro,
                    'available_satellite_clinic' => $available_satellite_clinic,
                    'available_community_clinic' => $available_community_clinic,
                    'available_ngo_and_satellite_clinic' => $available_ngo_and_satellite_clinic,
                    'available_ngo_and_static_clinic' => $available_ngo_and_static_clinic,
                    'available_private_hospital' => $available_private_hospital,
                    'available_mbbs_doctor_chamber' => $available_mbbs_doctor_chamber,
                    'available_doctor_without_degrees' => $available_doctor_without_degrees,
                    'available_pharmacy' => $available_pharmacy,
                    'available_other' => $available_other,
                    'available_other_value' => $available_other_value,
                    'taking_desire_more_children' => $taking_desire_more_children,
                    'taking_desire_more_children_after_year' => $taking_desire_more_children_after_year,
                    'how_many_children_you_want' => $how_many_children_you_want,
                    'alive_children' => $alive_children,
                    'alive_boy_number' => $alive_boy_number,
                    'alive_girl_number' => $alive_girl_number,
                    'alive_children_yes_availability' => $alive_children_yes_availability,
                    'alive_children_yes_availability_other_value' => $alive_children_yes_availability_other_value,
                    'alive_children_yes_availability_how_many' => $alive_children_yes_availability_how_many,
                    'alive_children_no_availability' => $alive_children_no_availability,
                    'alive_children_no_availability_other_value' => $alive_children_no_availability_other_value,
                    'alive_children_no_availability_how_many' => $alive_children_no_availability_how_many,
                    'how_many_male_female_children' => $how_many_male_female_children,
                    'how_many_male_female_children_other_value' => $how_many_male_female_children_other_value,
                    'how_many_male' => $how_many_male,
                    'how_many_female' => $how_many_female,
                    'how_many_any' => $how_many_any,
                    'comment' => $comment,
                    'member_master_id' => $member_master_id,
                    'round_master_id' => $round_master_id_entry_round,
                    'household_master_id' => $household_master_id,
                    'insertedBy' => $this->vendorId,
                    'insertedOn' => date('Y-m-d H:i:s')
                );

//                echo "<pre/>";
//                print_r($IdInfo);
//                exit();

                $this->FamilyPlanningModel->addNew($IdInfo, $this->config->item('householdFamilyPlanningTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while creating family planning.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Family planning created successfully.');

            redirect('Family_planning/family_planning_info?baseID=' . $baseID . '#family_planning_info');
        }
    }

    public function addEditFP($id) {

        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id_current = $this->input->get('household_master_id', TRUE);
        $member_master_id_current = $this->input->get('member_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : Family Planning';
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';

        // $this->$rountStatus = $this->getCurrentRound()[0]->active;
        // $this->$roundID =  $this->getCurrentRound()[0]->id;


        if ($this->getCurrentRound()[0]->active == 0) {

            $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
            redirect($this->controller . '?baseID=' . $baseID);
        }

        // $this->$rountStatus = $this->getCurrentRound()[0]->active;
        $data['roundNo'] = $this->getCurrentRound()[0]->roundNo;
        $data['round_master_id'] = $this->getCurrentRound()[0]->id;
        $data['householdcode'] = $this->session->userdata('householdcode');

        $data['household_master_id_sub'] = 0;

        $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

        if ($data['household_master_id_sub'] == 0) {
            redirect('Family_planning/visit?baseID=' . $baseID);
        }

        if ($household_master_id_current != $household_master_id_current) {

            $this->session->set_flashdata('error', 'You can not change household ID. This strictly prohibited.');
            redirect('Family_planning/visit?baseID=' . $baseID);
        }


        $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'), $data['household_master_id_sub'], $data['round_master_id']);

        $data['familyPlanningRecord'] = $this->FamilyPlanningModel->getFPDetailsByIdnHousehold($id, $data['household_master_id_sub'], $data['round_master_id']);

//        echo "<pre/>";
//        print_r($data['familyPlanningRecord']); exit();

        $data['yes_no'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
        $data['marital_status_typ'] = $this->modelName->getLookUpList($this->config->item('maritalstatustyp'));
        $data['yes_no_dont_know'] = $this->modelName->getLookUpList($this->config->item('yes_no_dont_know'));
        $data['husband_staying_place'] = $this->modelName->getLookUpList($this->config->item('husband_staying_place'));
        $data['birth_control_method'] = $this->modelName->getLookUpList($this->config->item('birth_control_method'));
        $data['method_taken_from'] = $this->modelName->getLookUpList($this->config->item('method_taken_from'));
        $data['birth_control_method_taking_decision'] = $this->modelName->getLookUpList($this->config->item('birth_control_method_taking_decision'));
        $data['reason_behind_not_taking_birth_control_method'] = $this->modelName->getLookUpList($this->config->item('reason_behind_not_taking_birth_control_method'));
        $data['yes_no_pregnant_dont_know'] = $this->modelName->getLookUpList($this->config->item('yes_no_pregnant_dont_know'));
        $data['how_many_children'] = $this->modelName->getLookUpList($this->config->item('how_many_children'));
        $data['alive_children'] = $this->modelName->getLookUpList($this->config->item('alive_children'));
        $data['no_one_how_many_others'] = $this->modelName->getLookUpList($this->config->item('no_one_how_many_others'));
        $data['boy_girl_anyone'] = $this->modelName->getLookUpList($this->config->item('boy_girl_anyone'));

        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard_family_planning', $data);
        $this->load->view($this->controller . '/family_planning_edit_details', $data);
        $this->load->view('includes/footer');
    }

    function editFPDetails() {

        $household_master_id = $this->input->post('household_master_id_sub', true);
        $round_master_id = $this->input->post('round_master_id', true);
        $family_planning_id = $this->input->post('family_planning_id', true);
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('maritial_status', 'Maritial status', 'trim|required|numeric');

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            redirect('Family_planning/addEditFP/' . $family_planning_id . '?household_master_id=' . $household_master_id . '&&member_master_id=' . $member_master_id . '&&baseID=' . $baseID . '#family_planning_info');
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect('Family_planning/visit?baseID=' . $baseID);
            }

            $maritial_status = 0;
            $current_pregnancy_status = 0;
            $husband_living_place = 0;
            $birth_control_method_usage_status = 0;
            $birth_control_method = 0;
            $birth_control_method_other_value = 0;
            $continuously_using_how_many_month = 0;
            $continuously_using_how_many_year = 0;
            $birth_control_method_suggestion_from_where = 0;
            $birth_control_method_suggestion_from_where_other_value = NULL;
            $whose_decision = 0;
            $whose_decision_other_value = NULL;
            $reason_behind_not_using = 0;
            $reason_behind_not_using_other_value = NULL;
            $future_desire = 0;
            $reason_behind_not_having_future_desire = 0;
            $reason_behind_not_having_future_desire_other_value = NULL;
            $do_you_know_from_where = 0;
            $available_govt_hospital = 0;
            $available_central_dist_hospital = 0;
            $available_matri_sonod = 0;
            $available_ngo_facility = 0;
            $available_upazilla_sasthokendro = 0;
            $available_union_sastho_poribar_kollan_kendro = 0;
            $available_satellite_clinic = 0;
            $available_community_clinic = 0;
            $available_ngo_and_satellite_clinic = 0;
            $available_ngo_and_static_clinic = 0;
            $available_private_hospital = 0;
            $available_mbbs_doctor_chamber = 0;
            $available_doctor_without_degrees = 0;
            $available_pharmacy = 0;
            $available_other = 0;
            $available_other_value = NULL;
            $taking_desire_more_children = 0;
            $taking_desire_more_children_after_year = 0;
            $how_many_children_you_want = 0;
            $alive_children = 0;
            $alive_boy_number = 0;
            $alive_girl_number = 0;
            $alive_children_yes_availability = 0;
            $alive_children_yes_availability_other_value = NULL;
            $alive_children_yes_availability_how_many = 0;
            $alive_children_no_availability = 0;
            $alive_children_no_availability_other_value = NULL;
            $alive_children_no_availability_how_many = 0;
            $how_many_male_female_children = 0;
            $how_many_male_female_children_other_value = NULL;
            $how_many_male = 0;
            $how_many_female = 0;
            $how_many_any = 0;
            $comment = NULL;


            $maritial_status = $this->input->post('maritial_status', true);
            $current_pregnancy_status = $this->input->post('current_pregnancy_status', true);

            $husband_living_place = $this->input->post('husband_living_place', true);
            $birth_control_method_usage_status = $this->input->post('birth_control_method_usage_status', true);

//echo $birth_control_method_usage_status; exit();

            $birth_control_method = $this->input->post('birth_control_method', true);

            $birth_control_method_other_value = $this->input->post('birth_control_method_other_value', true);
            if ($birth_control_method != 455) {
                $birth_control_method_other_value = NULL;
            }
            $continuously_using_how_many_year = $this->input->post('continuously_using_how_many_year', true);
            $continuously_using_how_many_month = $this->input->post('continuously_using_how_many_month', true);
            $birth_control_method_suggestion_from_where = $this->input->post('birth_control_method_suggestion_from_where', true);

            $birth_control_method_suggestion_from_where_other_value = $this->input->post('birth_control_method_suggestion_from_where_other_value', true);

            if ($birth_control_method_suggestion_from_where != 470) {
                $birth_control_method_suggestion_from_where_other_value = NULL;
            }

            $whose_decision = $this->input->post('whose_decision', true);

            $whose_decision_other_value = $this->input->post('whose_decision_other_value', true);
            if ($whose_decision != 474) {
                $whose_decision_other_value = NULL;
            }

            $reason_behind_not_using = $this->input->post('reason_behind_not_using', true);

            $reason_behind_not_using_other_value = $this->input->post('reason_behind_not_using_other_value', true);
            if ($reason_behind_not_using != 491) {
                $reason_behind_not_using_other_value = NULL;
            }

            $future_desire = $this->input->post('future_desire', true);

            $reason_behind_not_having_future_desire = $this->input->post('reason_behind_not_having_future_desire', true);

            $reason_behind_not_having_future_desire_other_value = $this->input->post('reason_behind_not_having_future_desire_other_value', true);
            if ($reason_behind_not_having_future_desire != 491) {
                $reason_behind_not_having_future_desire_other_value = NULL;
            }

            $do_you_know_from_where = $this->input->post('do_you_know_from_where', true);
            $available_govt_hospital = $this->input->post('available_govt_hospital', true);
            $available_central_dist_hospital = $this->input->post('available_central_dist_hospital', true);
            $available_matri_sonod = $this->input->post('available_matri_sonod', true);
            $available_ngo_facility = $this->input->post('available_ngo_facility', true);
            $available_upazilla_sasthokendro = $this->input->post('available_upazilla_sasthokendro', true);
            $available_union_sastho_poribar_kollan_kendro = $this->input->post('available_union_sastho_poribar_kollan_kendro', true);
            $available_satellite_clinic = $this->input->post('available_satellite_clinic', true);
            $available_community_clinic = $this->input->post('available_community_clinic', true);
            $available_ngo_and_satellite_clinic = $this->input->post('available_ngo_and_satellite_clinic', true);
            $available_ngo_and_static_clinic = $this->input->post('available_ngo_and_static_clinic', true);
            $available_private_hospital = $this->input->post('available_private_hospital', true);
            $available_mbbs_doctor_chamber = $this->input->post('available_mbbs_doctor_chamber', true);
            $available_doctor_without_degrees = $this->input->post('available_doctor_without_degrees', true);
            $available_pharmacy = $this->input->post('available_pharmacy', true);
            $available_other = $this->input->post('available_other', true);
            $available_other_value = $this->input->post('available_other_value', true);
            if ($available_other != 15) {
                $available_other_value = NULL;
            }
            $taking_desire_more_children = $this->input->post('taking_desire_more_children', true);
            $taking_desire_more_children_after_year = 0;
            if ($taking_desire_more_children == 494||$taking_desire_more_children==495||$taking_desire_more_children==496) {
                $taking_desire_more_children_after_year = $this->input->post('taking_desire_more_children_after_year', true);
            }

            $how_many_children_you_want = $this->input->post('how_many_children_you_want', true);

            if ($current_pregnancy_status == 331) {
                $husband_living_place = 0;
                $birth_control_method_usage_status = 0;
                $birth_control_method = 0;
                $birth_control_method_other_value = NULL;
                $continuously_using_how_many_year = 0;
                $continuously_using_how_many_month = 0;
                $birth_control_method_suggestion_from_where = 0;
                $birth_control_method_suggestion_from_where_other_value = NULL;
                $whose_decision = 0;
                $whose_decision_other_value = NULL;
                $reason_behind_not_using = 0;
                $reason_behind_not_using_other_value = NULL;
            }

            if ($birth_control_method_usage_status == 4) {
                $birth_control_method = 0;
                $birth_control_method_other_value = NULL;
                $continuously_using_how_many_year = 0;
                $continuously_using_how_many_month = 0;
                $birth_control_method_suggestion_from_where = 0;
                $birth_control_method_suggestion_from_where_other_value = NULL;
                $whose_decision = 0;
                $whose_decision_other_value = NULL;
            }

            if ($whose_decision > 0) {
                $reason_behind_not_using = 0;
                $reason_behind_not_using_other_value = NULL;
                $future_desire = 0;
                $reason_behind_not_having_future_desire = 0;
                $reason_behind_not_having_future_desire_other_value = NULL;

                $do_you_know_from_where = 0;
                $available_govt_hospital = 0;
                $available_central_dist_hospital = 0;
                $available_matri_sonod = 0;
                $available_ngo_facility = 0;
                $available_upazilla_sasthokendro = 0;
                $available_union_sastho_poribar_kollan_kendro = 0;
                $available_satellite_clinic = 0;
                $available_community_clinic = 0;
                $available_ngo_and_satellite_clinic = 0;
                $available_ngo_and_static_clinic = 0;
                $available_private_hospital = 0;
                $available_mbbs_doctor_chamber = 0;
                $available_doctor_without_degrees = 0;
                $available_pharmacy = 0;
                $available_other = 0;
                $available_other_value = NULL;
            }

            if ($future_desire == 331) {
                $reason_behind_not_having_future_desire = 0;
                $reason_behind_not_having_future_desire_other_value = NULL;
            }

            if ($do_you_know_from_where == 4) {
                $available_govt_hospital = 0;
                $available_central_dist_hospital = 0;
                $available_matri_sonod = 0;
                $available_ngo_facility = 0;
                $available_upazilla_sasthokendro = 0;
                $available_union_sastho_poribar_kollan_kendro = 0;
                $available_satellite_clinic = 0;
                $available_community_clinic = 0;
                $available_ngo_and_satellite_clinic = 0;
                $available_ngo_and_static_clinic = 0;
                $available_private_hospital = 0;
                $available_mbbs_doctor_chamber = 0;
                $available_doctor_without_degrees = 0;
                $available_pharmacy = 0;
                $available_other = 0;
                $available_other_value = NULL;
            }


            
            $alive_children = $this->input->post('alive_children', true);
            $alive_boy_number = 0;
            if ($alive_children == 502) {
                $alive_boy_number = $this->input->post('alive_boy_number', true);
            }
            $alive_girl_number = 0;
            if ($alive_children == 503) {
                $alive_girl_number = $this->input->post('alive_girl_number', true);
            }

            if ($alive_children == 512) {
                $alive_boy_number = $this->input->post('alive_boy_number', true);
                $alive_girl_number = $this->input->post('alive_girl_number', true);
            }

            $alive_children_yes_availability = $this->input->post('alive_children_yes_availability', true);

            $alive_children_yes_availability_other_value = NULL;

            if ($alive_children_yes_availability == 507) {
                $alive_children_yes_availability_other_value = $this->input->post('alive_children_yes_availability_other_value', true);
            }

            if ($alive_children == 504) {
                $alive_children_yes_availability = 0;
                $alive_children_yes_availability_other_value = NULL;
            }
            $alive_children_yes_availability_how_many = 0;
            if ($alive_children_yes_availability == 506) {
                $alive_children_yes_availability_how_many = $this->input->post('alive_children_yes_availability_how_many', true);
            }

            $alive_children_no_availability = $this->input->post('alive_children_no_availability', true);
            $alive_children_no_availability_other_value = NULL;
            if ($alive_children_no_availability == 507) {
                $alive_children_no_availability_other_value = $this->input->post('alive_children_no_availability_other_value', true);
            }

            $alive_children_no_availability_how_many = 0;
            if ($alive_children_no_availability == 506) {
                $alive_children_no_availability_how_many = $this->input->post('alive_children_no_availability_how_many', true);
            }

            $how_many_male_female_children = $this->input->post('how_many_male_female_children', true);
            if ($how_many_male_female_children == 511) {
                $how_many_male_female_children_other_value = $this->input->post('how_many_male_female_children_other_value', true);
            }
            if ($how_many_male_female_children == 508) {
                $how_many_male = $this->input->post('how_many_male', true);
            }
            if ($how_many_male_female_children == 509) {
                $how_many_female = $this->input->post('how_many_female', true);
            }
            if ($how_many_male_female_children == 510) {
                $how_many_any = $this->input->post('how_many_any', true);
            }
            
            $comment = $this->input->post('comment', true);

            if ($alive_children_yes_availability == 505 || $alive_children_yes_availability == 507) { //end the interview
                $alive_children_no_availability = 0;
                $alive_children_no_availability_other_value = NULL;
                $alive_children_no_availability_how_many = 0;
                $how_many_male_female_children = 0;
                $how_many_male_female_children_other_value = NULL;
                $how_many_male = 0;
                $how_many_female = 0;
                $how_many_any = 0;
            }

            if ($alive_children_no_availability == 505 || $alive_children_no_availability == 507) { //end the interview
                $how_many_male_female_children = 0;
                $how_many_male_female_children_other_value = NULL;
                $how_many_male = 0;
                $how_many_female = 0;
                $how_many_any = 0;
            }

            if ($maritial_status == 44 || $maritial_status == 109 || $maritial_status == 40) {

                $current_pregnancy_status = 0;
                $husband_living_place = 0;
                $birth_control_method_usage_status = 0;
                $birth_control_method = 0;
                $birth_control_method_other_value = 0;
                $continuously_using_how_many_month = 0;
                $continuously_using_how_many_year = 0;
                $birth_control_method_suggestion_from_where = 0;
                $birth_control_method_suggestion_from_where_other_value = NULL;
                $whose_decision = 0;
                $whose_decision_other_value = NULL;
                $reason_behind_not_using = 0;
                $reason_behind_not_using_other_value = NULL;
                $future_desire = 0;
                $reason_behind_not_having_future_desire = 0;
                $reason_behind_not_having_future_desire_other_value = NULL;
                $do_you_know_from_where = 0;
                $available_govt_hospital = 0;
                $available_central_dist_hospital = 0;
                $available_matri_sonod = 0;
                $available_ngo_facility = 0;
                $available_upazilla_sasthokendro = 0;
                $available_union_sastho_poribar_kollan_kendro = 0;
                $available_satellite_clinic = 0;
                $available_community_clinic = 0;
                $available_ngo_and_satellite_clinic = 0;
                $available_ngo_and_static_clinic = 0;
                $available_private_hospital = 0;
                $available_mbbs_doctor_chamber = 0;
                $available_doctor_without_degrees = 0;
                $available_pharmacy = 0;
                $available_other = 0;
                $available_other_value = NULL;
                $taking_desire_more_children = 0;
                $taking_desire_more_children_after_year = 0;
                $how_many_children_you_want = 0;
                $alive_children = 0;
                $alive_boy_number = 0;
                $alive_girl_number = 0;
                $alive_children_yes_availability = 0;
                $alive_children_yes_availability_other_value = NULL;
                $alive_children_yes_availability_how_many = 0;
                $alive_children_no_availability = 0;
                $alive_children_no_availability_other_value = NULL;
                $alive_children_no_availability_how_many = 0;
                $how_many_male_female_children = 0;
                $how_many_male_female_children_other_value = NULL;
                $how_many_male = 0;
                $how_many_female = 0;
                $how_many_any = 0;
            }

            $round_master_id_entry_round = $this->getCurrentRound()[0]->id;

            $this->db->trans_start();

            try {
                $IdInfo = array(
                    'maritial_status' => $maritial_status,
                    'current_pregnancy_status' => $current_pregnancy_status,
                    'husband_living_place' => $husband_living_place,
                    'birth_control_method_usage_status' => $birth_control_method_usage_status,
                    'birth_control_method' => $birth_control_method,
                    'birth_control_method_other_value' => $birth_control_method_other_value,
                    'continuously_using_how_many_month' => $continuously_using_how_many_month,
                    'continuously_using_how_many_year' => $continuously_using_how_many_year,
                    'birth_control_method_suggestion_from_where' => $birth_control_method_suggestion_from_where,
                    'birth_control_method_suggestion_from_where_other_value' => $birth_control_method_suggestion_from_where_other_value,
                    'whose_decision' => $whose_decision,
                    'whose_decision_other_value' => $whose_decision_other_value,
                    'reason_behind_not_using' => $reason_behind_not_using,
                    'reason_behind_not_using_other_value' => $reason_behind_not_using_other_value,
                    'future_desire' => $future_desire,
                    'reason_behind_not_having_future_desire' => $reason_behind_not_having_future_desire,
                    'reason_behind_not_having_future_desire_other_value' => $reason_behind_not_having_future_desire_other_value,
                    'do_you_know_from_where' => $do_you_know_from_where,
                    'available_govt_hospital' => $available_govt_hospital,
                    'available_central_dist_hospital' => $available_central_dist_hospital,
                    'available_matri_sonod' => $available_matri_sonod,
                    'available_ngo_facility' => $available_ngo_facility,
                    'available_upazilla_sasthokendro' => $available_upazilla_sasthokendro,
                    'available_union_sastho_poribar_kollan_kendro' => $available_union_sastho_poribar_kollan_kendro,
                    'available_satellite_clinic' => $available_satellite_clinic,
                    'available_community_clinic' => $available_community_clinic,
                    'available_ngo_and_satellite_clinic' => $available_ngo_and_satellite_clinic,
                    'available_ngo_and_static_clinic' => $available_ngo_and_static_clinic,
                    'available_private_hospital' => $available_private_hospital,
                    'available_mbbs_doctor_chamber' => $available_mbbs_doctor_chamber,
                    'available_doctor_without_degrees' => $available_doctor_without_degrees,
                    'available_pharmacy' => $available_pharmacy,
                    'available_other' => $available_other,
                    'available_other_value' => $available_other_value,
                    'taking_desire_more_children' => $taking_desire_more_children,
                    'taking_desire_more_children_after_year' => $taking_desire_more_children_after_year,
                    'how_many_children_you_want' => $how_many_children_you_want,
                    'alive_children' => $alive_children,
                    'alive_boy_number' => $alive_boy_number,
                    'alive_girl_number' => $alive_girl_number,
                    'alive_children_yes_availability' => $alive_children_yes_availability,
                    'alive_children_yes_availability_other_value' => $alive_children_yes_availability_other_value,
                    'alive_children_yes_availability_how_many' => $alive_children_yes_availability_how_many,
                    'alive_children_no_availability' => $alive_children_no_availability,
                    'alive_children_no_availability_other_value' => $alive_children_no_availability_other_value,
                    'alive_children_no_availability_how_many' => $alive_children_no_availability_how_many,
                    'how_many_male_female_children' => $how_many_male_female_children,
                    'how_many_male_female_children_other_value' => $how_many_male_female_children_other_value,
                    'how_many_male' => $how_many_male,
                    'how_many_female' => $how_many_female,
                    'how_many_any' => $how_many_any,
                    'comment' => $comment,
                    'member_master_id' => $member_master_id,
                    'round_master_id' => $round_master_id_entry_round,
                    'household_master_id' => $household_master_id,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

//                echo "<pre/>";
//                print_r($IdInfo); exit();

                $this->FamilyPlanningModel->edit($IdInfo, $family_planning_id, $this->config->item('householdFamilyPlanningTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating Family Planning.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Member Family planning updated successfully.');

            redirect('Family_planning/family_planning_info?baseID=' . $baseID . '#family_planning_info');
        }
    }

    function mapp() {

        $this->db->select('*');
        $this->db->from('mig_birth_first'); //change table name
        $query = $this->db->get();
        $result = $query->result();
//            echo "<pre/>";
//            print_r($result);
        foreach ($result as $data) {
            $this->db->select('*');
            $this->db->from('tbl_slum_area');
            $this->db->where('slumID', $data->slum_id); //change $data->slum_id
            $this->db->where('name', $data->slum_area); //change $data->slum_area
            $query = $this->db->get();

            $main_info = $query->row();

            $IdInfo = array();

            if ($main_info) {
                $IdInfo = array(
                    'slum_area_id' => $main_info->id //change 'slum_area_id'
                );

                $this->db->where('id', $data->id);
                $this->db->update('mig_birth_first', $IdInfo); //change table name

                echo "done!!!!!!!!!!" . '<pre/>';
            }
        }
    }

}

?>