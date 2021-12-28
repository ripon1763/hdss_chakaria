<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberChildIllness extends BaseController {

    /**
     * This is default constructor of the class
     */
    public $controller = "MemberChildIllness";
    public $pageTitle = 'Member Child Illness';
    public $pageShortName = 'Member Child Illness';

    public function __construct() {
        parent::__construct();
        $this->load->model('master_model', 'modelName');
        $this->load->model('member_model', 'memberModel');
        $this->load->model('householdVisit_model', 'visitModel');
        $this->load->model('memberChildIllness_model', 'ChildIllnessModel');
        $this->load->model('menu_model', 'menuModel');
        $this->load->library('pagination');
        $this->isLoggedIn();
        $menu_key = 'visit';
        $baseID = $this->input->get('baseID', TRUE);
        $result = $this->loadThisForAccess($this->role, $baseID, $menu_key);
        if ($result != true) {
            redirect('access');
        }
    }

    public function addEditChildIllness($id) {

        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id_current = $this->input->get('household_master_id', TRUE);
        $member_master_id_current = $this->input->get('member_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : Member Child Illness';
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
            redirect('householdvisit/visit?baseID=' . $baseID);
        }

        if ($household_master_id_current != $household_master_id_current) {

            $this->session->set_flashdata('error', 'You can not change household ID. This strictly prohibited.');
            redirect('householdvisit/visit?baseID=' . $baseID);
        }


        $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'), $data['household_master_id_sub'], $data['round_master_id']);

        $data['ChildIllnessRecord'] = $this->ChildIllnessModel->getChildIllnessDetailsByIdnHousehold($id, $data['household_master_id_sub'], $data['round_master_id']);

        //echo "<pre/>";
        //print_r($data['immunizationRecord']); exit();

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

        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard', $data);
        $this->load->view($this->controller . '/child_illness_edit_details', $data);
        $this->load->view('includes/footer');
    }

    function editChildIllnessDetails() {

        $household_master_id = $this->input->post('household_master_id_sub', true);
        $round_master_id = $this->input->post('round_master_id', true);
        $childIllnessID = $this->input->post('childIllnessID', true);
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
            redirect('memberChildIllness/addEditChildIllness/' . $childIllnessID . '?household_master_id=' . $household_master_id . '&&member_master_id=' . $member_master_id . '&&baseID=' . $baseID . '#child_illness');
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect('householdvisit/visit?baseID=' . $baseID);
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

            $round_master_id_entry_round = $this->getCurrentRound()[0]->id;

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
                    'member_master_id' => $member_master_id,
                    'round_master_id' => $round_master_id_entry_round,
                    'household_master_id' => $household_master_id,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->ChildIllnessModel->edit($IdInfo, $childIllnessID);

                $fk_followup_exit_type = 0;

                if ($this->input->post('interview_status', true) == 559 || $this->input->post('interview_status', true) == 560) {
                    $fk_followup_exit_type = $this->input->post('interview_status', true);
                }

                $memberUpdate = array(
                    'fk_followup_exit_type' => $fk_followup_exit_type,
                    
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );



                $this->modelName->editList($memberUpdate, $member_master_id, $this->config->item('memberMasterTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating Child Illness.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Member Child Illness updated successfully.');

            redirect('householdvisit/child_illness?baseID=' . $baseID . '#child_illness');
        }
    }

    public function addChildIllness($id) {

        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id_current = $this->input->get('household_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : Member Child Illness';
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
            redirect('householdvisit/visit?baseID=' . $baseID);
        }

        if ($household_master_id_current != $household_master_id_current) {

            $this->session->set_flashdata('error', 'You can not change household ID. This strictly prohibited.');
            redirect('householdvisit/visit?baseID=' . $baseID);
        }


        $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'), $data['household_master_id_sub'], $data['round_master_id']);

        $data['memberInfo'] = $this->memberModel->getListInfo($id, $this->config->item('memberMasterTable'));

        //

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

        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard', $data);
        $this->load->view($this->controller . '/child_illness_add_details', $data);
        $this->load->view('includes/footer');
    }

    function addChildIllnessDetails() {
        $household_master_id = $this->input->post('household_master_id_sub', true);
        $round_master_id = $this->input->post('round_master_id', true);
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

            redirect('memberChildIllness/addChildIllness/' . $member_master_id . '?household_master_id=' . $household_master_id . '&&baseID=' . $baseID . '#child_illness');
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect('householdvisit/visit?baseID=' . $baseID);
            }

            $whereHouseholdChildIllness = array('household_master_id' => $household_master_id, 'round_master_id' => $round_master_id, 'member_master_id' => $member_master_id);

            $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberChildIllnessTable'))->where($whereHouseholdChildIllness)->get()->row()->countRow;

            if ($countRow > 0) {
                $this->session->set_flashdata('error', 'Child Illness already exists for this round.');
                redirect('householdvisit/child_illness?baseID=' . $baseID . '#child_illness');
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


            $round_master_id_entry_round = $this->getCurrentRound()[0]->id;

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
                    'member_master_id' => $member_master_id,
                    'round_master_id' => $round_master_id_entry_round,
                    'household_master_id' => $household_master_id,
                    'insertedBy' => $this->vendorId,
                    'insertedOn' => date('Y-m-d H:i:s')
                );

                $this->ChildIllnessModel->addNew($IdInfo, $this->config->item('memberChildIllnessTable'));

                $fk_followup_exit_type = 0;

                if ($this->input->post('interview_status', true) == 559 || $this->input->post('interview_status', true) == 560) {
                    $fk_followup_exit_type = $this->input->post('interview_status', true);
                }

                $memberUpdate = array(
                    'fk_followup_exit_type' => $fk_followup_exit_type,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->editList($memberUpdate, $member_master_id, $this->config->item('memberMasterTable'));


                $whereHouseholdVisit = array('household_master_id' => $household_master_id, 'round_master_id' => $round_master_id);

                $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                if ($countVisit > 0) {

                    $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                    $householdVisit = array(
                        'any_child_illness' => 1,
                        'transfer_complete' => 'No',
                        'updateBy' => $this->vendorId,
                        'updatedOn' => date('Y-m-d H:i:s')
                    );

                    $this->modelName->editList($householdVisit, $visitID, $this->config->item('householdVisitTable'));
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while creating death.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Child illness info saved successfully.');

            redirect('householdvisit/child_illness?baseID=' . $baseID . '#child_illness');
        }
    }

}

?>