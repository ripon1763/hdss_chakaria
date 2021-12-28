<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Family_planning_report extends BaseController {

    /**
     * This is default constructor of the class
     */
    public $controller = "Family_planning_report";
    public $pageTitle = 'Family planning report management';
    public $pageShortName = 'Data';

    public function __construct() {
        parent::__construct();
        $this->load->model('FamilyPlanning_model', 'modelName');
        $this->load->model('menu_model', 'menuModel');
        $this->load->model('master_model', 'masterName');
        $this->load->library('pagination');
        $this->isLoggedIn();
        $menu_key = 'family_planning_report';
        $baseID = $this->input->get('baseID', TRUE);
        $result = $this->loadThisForAccess($this->role, $baseID, $menu_key);
        if ($result != true) {
            redirect('access');
        }
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index() {
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = 'Family Planning Report';
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'Family_planning_report';
        $data['editMethod'] = 'edit_family_planning';
        $data['shortName'] = 'Family planning';
        $data['boxTitle'] = 'List';


//        $data['all_family_planning_info'] = $this->modelName->all_family_planning_info(0, $this->config->item('householdFamilyPlanningTable'), 1);
//
//        foreach ($data['all_family_planning_info'] as $list_field) {
//            if ($list_field != 'id')
//                echo '<th>' . $list_field . '</th>';
//        }
//        exit();
//
//        echo "<pre/>";
//        print_r($data['all_family_planning_info']);
//        exit();

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
        $this->load->view($this->controller . '/index', $data);
        $this->load->view('includes/footer');
    }

    public function show_family_planning_view() {

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
            2 => 'DOBN',
            3 => 'household_code',
            4 => 'member_code',
            5 => 'maritial_status_code',
            6 => 'current_pregnancy_status_code',
            7 => 'husband_living_place_code',
            8 => 'birth_control_method_usage_status_code',
            9 => 'birth_control_method_code',
            10 => 'birth_control_method_other_value',
            11 => 'continuously_using_how_many_month',
            12 => 'continuously_using_how_many_year',
            13 => 'birth_control_method_suggestion_from_where_status_code',
            14 => 'birth_control_method_suggestion_from_where_other_value',
            15 => 'whose_decision_code',
            16 => 'whose_decision_other_value',
            17 => 'reason_behind_not_using_code',
            18 => 'reason_behind_not_using_other_value',
            19 => 'future_desire_code',
            20 => 'reason_behind_not_having_future_desire_code',
            21 => 'reason_behind_not_having_future_desire_other_value',
            22 => 'do_you_know_from_where_code',
            23 => 'available_govt_hospital',
            24 => 'available_central_dist_hospital',
            25 => 'available_matri_sonod',
            26 => 'available_ngo_facility',
            27 => 'available_upazilla_sasthokendro',
            28 => 'available_union_sastho_poribar_kollan_kendro',
            29 => 'available_satellite_clinic',
            30 => 'available_community_clinic',
            31 => 'available_ngo_and_satellite_clinic',
            32 => 'available_ngo_and_static_clinic',
            33 => 'available_private_hospital',
            34 => 'available_mbbs_doctor_chamber',
            35 => 'available_doctor_without_degrees',
            36 => 'available_pharmacy',
            37 => 'available_other',
            38 => 'available_other_value',
            39 => 'taking_desire_more_children_code',
            40 => 'taking_desire_more_children_after_year',
            41 => 'how_many_children_you_want_code',
            42 => 'alive_children_code',
            43 => 'alive_boy_number',
            44 => 'alive_girl_number',
            45 => 'alive_children_yes_availability_code',
            46 => 'alive_children_yes_availability_other_value',
            47 => 'alive_children_yes_availability_how_many',
            48 => 'alive_children_no_availability_code',
            49 => 'alive_children_no_availability_other_value',
            50 => 'alive_children_no_availability_how_many',
            51 => 'how_many_male_female_children_code',
            52 => 'how_many_male_female_children_other_value',
            53 => 'how_many_male',
            54 => 'how_many_female',
            55 => 'how_many_any',
            56 => 'comment',
            57 => 'insertedDate',
            58 => 'insertedTime',
            59 => 'insertedBy_name',
            60 => 'updatedDate',
            61 => 'updatedTime',
            62 => 'updateBy_name'
        );

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
            $all_data_list = $this->db->get_where("family_planning_view", array('round_master_id' => $round_no));
        } else {
            $all_data_list = $this->db->get("family_planning_view");
        }

        $data = array();

        if (!empty($all_data_list)) {

            foreach ($all_data_list->result() as $rows) {
                $edit_link = "<a href='" . base_url() . "Family_planning_report/edit_family_planning/" . $rows->id . "?baseID=" . $baseID . "' class='btn btn-sm btn-primary'>Edit</a>";
                $data[] = array(
                    $edit_link,
                    $rows->DOB,
                    $rows->DOBN,
                    $rows->household_code,
                    $rows->member_code,
                    $rows->maritial_status_code,
                    $rows->current_pregnancy_status_code,
                    $rows->husband_living_place_code,
                    $rows->birth_control_method_usage_status_code,
                    $rows->birth_control_method_code,
                    $rows->birth_control_method_other_value,
                    $rows->continuously_using_how_many_month,
                    $rows->continuously_using_how_many_year,
                    $rows->birth_control_method_suggestion_from_where_status_code,
                    $rows->birth_control_method_suggestion_from_where_other_value,
                    $rows->whose_decision_code,
                    $rows->whose_decision_other_value,
                    $rows->reason_behind_not_using_code,
                    $rows->reason_behind_not_using_other_value,
                    $rows->future_desire_code,
                    $rows->reason_behind_not_having_future_desire_code,
                    $rows->reason_behind_not_having_future_desire_other_value,
                    $rows->do_you_know_from_where_code,
                    $rows->available_govt_hospital,
                    $rows->available_central_dist_hospital,
                    $rows->available_matri_sonod,
                    $rows->available_ngo_facility,
                    $rows->available_upazilla_sasthokendro,
                    $rows->available_union_sastho_poribar_kollan_kendro,
                    $rows->available_satellite_clinic,
                    $rows->available_community_clinic,
                    $rows->available_ngo_and_satellite_clinic,
                    $rows->available_ngo_and_static_clinic,
                    $rows->available_private_hospital,
                    $rows->available_mbbs_doctor_chamber,
                    $rows->available_doctor_without_degrees,
                    $rows->available_pharmacy,
                    $rows->available_other,
                    $rows->available_other_value,
                    $rows->taking_desire_more_children_code,
                    $rows->taking_desire_more_children_after_year,
                    $rows->how_many_children_you_want_code,
                    $rows->alive_children_code,
                    $rows->alive_boy_number,
                    $rows->alive_girl_number,
                    $rows->alive_children_yes_availability_code,
                    $rows->alive_children_yes_availability_other_value,
                    $rows->alive_children_yes_availability_how_many,
                    $rows->alive_children_no_availability_code,
                    $rows->alive_children_no_availability_other_value,
                    $rows->alive_children_no_availability_how_many,
                    $rows->how_many_male_female_children_code,
                    $rows->how_many_male_female_children_other_value,
                    $rows->how_many_male,
                    $rows->how_many_female,
                    $rows->how_many_any,
                    $rows->comment,
                    $rows->insertedDate,
                    $rows->insertedTime,
                    $rows->insertedBy_name,
                    $rows->updatedDate,
                    $rows->updatedTime,
                    $rows->updateBy_name
                );
            }
        }
        $total_all_data_list = $this->totalMembers_family_planning();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_all_data_list,
            "recordsFiltered" => $total_all_data_list,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function totalMembers_family_planning() {

        $round_no = $this->session->userdata('round_no') ? $this->session->userdata('round_no') : 0;

        if ($round_no > 0) {

            $query = $this->db->select("COUNT(*) as num")->get_where("family_planning_view", array('round_master_id' => $round_no));
        } else {
            $query = $this->db->select("COUNT(*) as num")->get("family_planning_view");
        }

        $result = $query->row();
        if (isset($result))
            return $result->num;
        return 0;
    }

    public function edit_family_planning($id) {
//        echo $id; exit();
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Family planning";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_family_planning';
        $data['shortName'] = "Family planning";
        $data['boxTitle'] = 'List';

        $data['familyPlanningRecord'] = $this->modelName->getFPDetails($id);

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


        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_family_planning', $data);
        $this->load->view('includes/footer');
    }

    function update_family_planning() {
        $family_planning_id = $this->input->post('family_planning_id', true);
        $getCurrentRound = $this->modelName->getCurrentRound();

        $this->load->library('form_validation');

        $this->form_validation->set_rules('maritial_status', 'Maritial status', 'trim|required|numeric');

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->controller . '/edit_family_planning/' . $baselineID . '?baseID=' . $baseID);
        } else {
            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_family_planning/' . $baselineID . '?baseID=' . $baseID);
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

            $this->db->trans_start();

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
                'updateBy' => $this->vendorId,
                'updatedOn' => date('Y-m-d H:i:s')
            );
            
            //                echo "<pre/>";
//                print_r($IdInfo); exit();


            try {

                $this->modelName->edit($IdInfo, $family_planning_id, $this->config->item('householdFamilyPlanningTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating Family planning.');
                redirect($this->controller . '/edit_family_planning/' . $baselineID . '?baseID=' . $baseID);
            }
            $this->db->trans_commit();

            $this->session->set_flashdata('success', 'Family planning info updated successfully.');
            if ($this->input->post('update_exit')) {
                redirect($this->controller . '?baseID=' . $baseID);
            }
            redirect($this->controller . '/edit_family_planning/'.$family_planning_id. '?baseID=' . $baseID);
        }
    }

    //.sav and .dta file exporting system

    public function sav_format_family_planning() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->data_via_table_view_family_planning('family_planning_view');

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/Family planning_report' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "family_planning_List_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'family_planning_List_Report.sav';
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

    public function dta_format_family_planning() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->data_via_table_view_family_planning('family_planning_view');

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/Family planning_report' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "family_planning_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'family_planning_List_Report.dta';
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

    public function sav_format($file_name) {

        $command = escapeshellcmd("a.py $file_name");
        $output = shell_exec($command);

        $file = $file_name . '.sav';
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

    public function dta_format($file_name) {

        $command = escapeshellcmd("b.py $file_name");
        $output = shell_exec($command);

        $file = $file_name . '.dta';
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

    public function excel_format($file_name) {

        $command = escapeshellcmd("c.py $file_name");
        $output = shell_exec($command);

        $file = $file_name . '.xlsx';
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

}

?>