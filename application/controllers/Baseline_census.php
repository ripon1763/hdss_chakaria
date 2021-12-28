<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Baseline_census extends BaseController {

    /**
     * This is default constructor of the class
     */
    public $controller = "Baseline_census";
    public $pageTitle = 'Baseline census';
    public $pageShortName = 'Baseline census';

    public function __construct() {
        parent::__construct();
        $this->load->model('master_model', 'modelName');
        $this->load->model('householdVisit_model', 'visitModel');
        $this->load->model('Householdasset_model', 'assetModel');
        $this->load->model('Householdbaseline_model', 'baselineModel');
        $this->load->model('menu_model', 'menuModel');
        $this->load->library('pagination');
        $this->isLoggedIn();
        $menu_key = 'baseline_census';
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
                redirect('Baseline_census/visit?baseID=' . $baseID);
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
                redirect('Baseline_census/baseline_census_info?baseID=' . $baseID . '#baseline_census_info');
            }
        } else {
            redirect('Baseline_census/visit?baseID=' . $baseID);
        }


        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard_baseline_census');
        $this->load->view($this->controller . '/baseline_census', $data);
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

    public function baseline_census_info() {
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
            redirect('Baseline_census/visit?baseID=' . $baseID);
        }

        if ($this->input->post('submit')) {
            $this->session->unset_userdata('household_master_id_sub');
            redirect('Baseline_census/visit?baseID=' . $baseID);
        }

        $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'), $data['household_master_id_sub'], $data['round_master_id']);
        $data['assetHistory'] = $this->assetModel->getHouseholdAssetHistory($this->config->item('householdAssetTable'), $data['household_master_id_sub']);
        $data['baselineHistory'] = $this->baselineModel->getHouseholdBaselineHistory($this->config->item('baselineCensusTable'), $data['household_master_id_sub']);
		


//        echo "<pre/>";
//        print_r($data['baselineHistory']); exit();


        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard_baseline_census', $data);
        $this->load->view($this->controller . '/assets', $data);
        $this->load->view('includes/footer');
    }

    public function addEditAsset() {
        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id_current = $this->input->get('household_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : Household Assets';
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
            redirect('Baseline_census/visit?baseID=' . $baseID);
        }


        $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'), $data['household_master_id_sub'], $data['round_master_id']);

        $data['assetYesNo'] = $this->modelName->getLookUpList($this->config->item('asset_yes_no'));
        $data['house_owner'] = $this->modelName->getLookUpList($this->config->item('house_owner'));
        $data['land_owner'] = $this->modelName->getLookUpList($this->config->item('land_owner'));

        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard_baseline_census', $data);
        $this->load->view($this->controller . '/assets_details', $data);
        $this->load->view('includes/footer');
    }

    function addNewAsset() {
        $household_master_id = $this->input->post('household_master_id_sub', true);
        $round_master_id = $this->input->post('round_master_id', true);
        $householdvisitID = $this->input->post('householdvisitID', true);

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
            redirect('Baseline_census/addEditAsset?household_master_id=' . $household_master_id . '&&baseID=' . $baseID . '#baseline_census_info');
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect('Baseline_census/visit?baseID=' . $baseID);
            }

            $whereHouseholdAsset = array('household_master_id' => $household_master_id, 'round_master_id' => $round_master_id);

            $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('householdAssetTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

            if ($countRow > 0) {
                $this->session->set_flashdata('error', 'Asset already exists for this round.');
                redirect('Baseline_census/baseline_census_info?baseID=' . $baseID . '#baseline_census_info');
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

            $round_master_id_entry_round = $this->getCurrentRound()[0]->id;

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
                    'fk_tv' => $fk_tv,
                    'fk_freeze' => $fk_freeze,
                    'fk_sofa' => $fk_sofa,
                    'fk_mobile' => $fk_mobile,
                    'fk_electric_fan' => $fk_electric_fan,
                    'fk_hand_watch' => $fk_hand_watch,
                    'fk_rickshow' => $fk_rickshow,
                    'fk_computer' => $fk_computer,
                    'fk_sewing_machine' => $fk_sewing_machine,
                    'fk_cycle' => $fk_cycle,
                    'fk_motor_cycle' => $fk_motor_cycle,
                    'round_master_id' => $round_master_id_entry_round,
                    'household_master_id' => $household_master_id,
                    'baseline' => 1, //to track only baseline related assets
                    'insertedBy' => $this->vendorId,
                    'insertedOn' => date('Y-m-d H:i:s')
                );

                $resultID = $this->assetModel->addNew($IdInfo, $this->config->item('householdAssetTable'));

                $masterData = array(
                    'household_asset_id_last' => $resultID,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->assetModel->edit($masterData, $household_master_id, $this->config->item('householdMasterTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while creating household Asset.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Household Asset created successfully.');

            redirect('Baseline_census/baseline_census_info?baseID=' . $baseID . '#baseline_census_info');
        }
    }

    public function editAsset($id) {
        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id_current = $this->input->get('household_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : Household Assets';
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
            redirect('Baseline_census/visit?baseID=' . $baseID);
        }

        $data['assetrecord'] = $this->assetModel->getAssetDetails($this->config->item('householdAssetTable'), $data['household_master_id_sub'], $id);


        $data['assetYesNo'] = $this->modelName->getLookUpList($this->config->item('asset_yes_no'));
        $data['house_owner'] = $this->modelName->getLookUpList($this->config->item('house_owner'));
        $data['land_owner'] = $this->modelName->getLookUpList($this->config->item('land_owner'));

        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard_baseline_census', $data);
        $this->load->view($this->controller . '/assets_details_edit', $data);
        $this->load->view('includes/footer');
    }

    function editAssetDetails() {
        $household_master_id = $this->input->post('household_master_id_sub', true);
        $round_master_id = $this->input->post('round_master_id', true);
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
            redirect('Baseline_census/editAsset/' . $assetID . '?household_master_id=' . $household_master_id . '&&baseID=' . $baseID . '#baseline_census_info');
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect('Baseline_census/visit?baseID=' . $baseID);
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

                $resultID = $this->assetModel->edit($IdInfo, $assetID, $this->config->item('householdAssetTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating household Asset.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Household Asset updated successfully.');

            redirect('Baseline_census/baseline_census_info?baseID=' . $baseID . '#baseline_census_info');
        }
    }

    //baseline census starts here

    public function addEditBaseline() {
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
            redirect('Baseline_census/visit?baseID=' . $baseID);
        }


        $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'), $data['household_master_id_sub'], $data['round_master_id']);
		$data['presentMemberList'] = $this->baselineModel->getMemberMasterPresentListByHouseholdIds($data['household_master_id_sub']);
       


	   $data['divisions'] = $this->modelName->listingdiv($this->config->item('divTable'));
        $data['migReasons'] = $this->modelName->getLookUpList($this->config->item('migReason'));
        $data['yes_no_dont_know'] = $this->modelName->getLookUpList($this->config->item('yes_no_dont_know'));
//        $data['house_owner'] = $this->modelName->getLookUpList($this->config->item('house_owner'));
//        $data['land_owner'] = $this->modelName->getLookUpList($this->config->item('land_owner'));
        $data['roof_build_with'] = $this->modelName->getLookUpList($this->config->item('roof_build_with'));
        $data['floor_build_with'] = $this->modelName->getLookUpList($this->config->item('floor_build_with'));
        $data['water_source'] = $this->modelName->getLookUpList($this->config->item('water_source'));
        $data['water_source_location'] = $this->modelName->getLookUpList($this->config->item('water_source_location'));
        $data['water_collector'] = $this->modelName->getLookUpList($this->config->item('water_collector'));
        $data['yes_no'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
        $data['water_supplier'] = $this->modelName->getLookUpList($this->config->item('water_supplier'));
        $data['toilet_cleaner'] = $this->modelName->getLookUpList($this->config->item('toilet_cleaner'));
        $data['toilet_dirt_remover'] = $this->modelName->getLookUpList($this->config->item('toilet_dirt_remover'));
        $data['light_source'] = $this->modelName->getLookUpList($this->config->item('light_source'));
        $data['hand_washing_place'] = $this->modelName->getLookUpList($this->config->item('hand_washing_place'));
        $data['toilet_type'] = $this->modelName->getLookUpList($this->config->item('toilet_type'));
        $data['dirt_removing_type'] = $this->modelName->getLookUpList($this->config->item('dirt_removing_type'));
        $data['hand_washing_arrangement'] = $this->modelName->getLookUpList($this->config->item('hand_washing_arrangement'));
        $data['spontaneously_afterTelling_dontKnow'] = $this->modelName->getLookUpList($this->config->item('spontaneously_afterTelling_dontKnow'));
        $data['fuel_type'] = $this->modelName->getLookUpList($this->config->item('fuel_type'));
        $data['dirt_taken_place'] = $this->modelName->getLookUpList($this->config->item('dirt_taken_place'));
        $data['dirt_collection_time'] = $this->modelName->getLookUpList($this->config->item('dirt_collection_time'));


        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard_baseline_census', $data);
        $this->load->view($this->controller . '/baseline_details', $data);
        $this->load->view('includes/footer');
    }

    function addNewBaseLineCensus() {
//        echo 'fff'; exit();
        $household_master_id = $this->input->post('household_master_id_sub', true);
        $round_master_id = $this->input->post('round_master_id', true);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('upazilla_name', 'Upazilla Name', 'trim|required');
        $this->form_validation->set_rules('division_id', 'Division Name', 'trim|required');
       // $this->form_validation->set_rules('pregnancy_status', 'Pregnancy status', 'trim|required');
        $this->form_validation->set_rules('roof', 'Roof made with', 'trim|required');
        $this->form_validation->set_rules('wall', 'Wall made with', 'trim|required');
        $this->form_validation->set_rules('floor', 'Floor made with', 'trim|required');
        $this->form_validation->set_rules('room', 'Total room', 'trim|required');
        $this->form_validation->set_rules('room1l', 'Room1 length', 'trim|required');
        $this->form_validation->set_rules('room1b', 'Room1 breadth', 'trim|required');
        
        
        
        
        $this->form_validation->set_rules('Q42A', 'Monthly expense', 'trim|required');
        $this->form_validation->set_rules('Q42B', 'Monthly food expense', 'trim|required');
        $this->form_validation->set_rules('water', 'Water source', 'trim|required');
        $this->form_validation->set_rules('winside', 'Water source location', 'trim|required');
        $this->form_validation->set_rules('wat_coll', 'Water collector', 'trim|required');
        $this->form_validation->set_rules('wshare', 'Water sharing', 'trim|required');
        $this->form_validation->set_rules('wat_supp', 'Water supplier', 'trim|required');
        $this->form_validation->set_rules('w_safe', 'Water safe status', 'trim|required');
        $this->form_validation->set_rules('w_suff', 'Water sufficient status', 'trim|required');
        $this->form_validation->set_rules('toilet', 'Toilet type', 'trim|required');
        $this->form_validation->set_rules('toilet_ct', 'Toilet cleaning type', 'trim|required');
        $this->form_validation->set_rules('toilte_mf', 'Gender wise toilet', 'trim|required');
        $this->form_validation->set_rules('toilet_cl', 'Toilet cleaner', 'trim|required');
        $this->form_validation->set_rules('toilet_dis', 'Toilet dirt remover', 'trim|required');
        $this->form_validation->set_rules('tinside', 'Toilet location', 'trim|required');
        $this->form_validation->set_rules('tshare', 'Toilet sharing', 'trim|required');
        $this->form_validation->set_rules('light', 'Light source', 'trim|required');
        $this->form_validation->set_rules('Q61', 'Hand washing arrangement', 'trim|required');
        $this->form_validation->set_rules('Q63', 'Hand washing arrangement type', 'trim|required');
        $this->form_validation->set_rules('Q65A', 'Q65A', 'trim|required');
        $this->form_validation->set_rules('Q65B', 'Q65B', 'trim|required');
        $this->form_validation->set_rules('Q65C', 'Q65C', 'trim|required');
        $this->form_validation->set_rules('Q65D', 'Q65D', 'trim|required');
        $this->form_validation->set_rules('Q65E', 'Q65E', 'trim|required');
        $this->form_validation->set_rules('Q65F', 'Q65F', 'trim|required');
        $this->form_validation->set_rules('cook', 'Cooking fuel type', 'trim|required');
        $this->form_validation->set_rules('cinside', 'Kitchen room location', 'trim|required');
        $this->form_validation->set_rules('cshare', 'Kitchen sharing status', 'trim|required');
        $this->form_validation->set_rules('garbage', 'Garbage taking place', 'trim|required');
        $this->form_validation->set_rules('gcollect', 'Garbage collection time density', 'trim|required');
        $this->form_validation->set_rules('voterid', 'Voterid availability', 'trim|required');
        $this->form_validation->set_rules('imobile', 'Respondent mobile', 'trim|required');


        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('Baseline_census/addEditBaseline?household_master_id=' . $household_master_id . '&&baseID=' . $baseID . '#baseline_census_info');
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect('Baseline_census/visit?baseID=' . $baseID);
            }

            $whereHouseholdAsset = array('household_master_id' => $household_master_id, 'round_master_id' => $round_master_id);

            $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('baselineCensusTable'))->where($whereHouseholdAsset)->get()->row()->countRow;

            if ($countRow > 0) {
                $this->session->set_flashdata('error', 'Baseline census already exists for this round.');
                redirect('Baseline_census/baseline_census_info?baseID=' . $baseID . '#baseline_census_info');
            }


            $upazilla_name = $this->input->post('upazilla_name', true);
            $division_id = $this->input->post('division_id', true);

            //Question 3
            $looking_for_work = $this->input->post('looking_for_work', true) > 0 ? $this->input->post('looking_for_work', true) : 0;
            $for_earning_more_money = $this->input->post('for_earning_more_money', true) > 0 ? $this->input->post('for_earning_more_money', true) : 0;
            $river_erosion = $this->input->post('river_erosion', true) > 0 ? $this->input->post('river_erosion', true) : 0;
            $for_family = $this->input->post('for_family', true) > 0 ? $this->input->post('for_family', true) : 0;
            $for_children_education = $this->input->post('for_children_education', true) > 0 ? $this->input->post('for_children_education', true) : 0;
            $for_own_education = $this->input->post('for_own_education', true) > 0 ? $this->input->post('for_own_education', true) : 0;
            $for_marriage = $this->input->post('for_marriage', true) > 0 ? $this->input->post('for_marriage', true) : 0;
            $na_as_birth_here = $this->input->post('na_as_birth_here', true) > 0 ? $this->input->post('na_as_birth_here', true) : 0;
            $coming_reason_other = $this->input->post('coming_reason_other', true) > 0 ? $this->input->post('coming_reason_other', true) : 0;

            $coming_reason_other_specify = NULL;
            if ($coming_reason_other == 99) {
                $coming_reason_other_specify = $this->input->post('coming_reason_other_specify', true);
            }

            // $pregnancy_status = $this->input->post('pregnancy_status', true);

            // $new_pregnancy_status_since_when = null;
            
            // if ($pregnancy_status == 331) {
                // $pregnancy_status_since_when = $this->input->post('pregnancy_status_since_when', true);
                // if (!empty($pregnancy_status_since_when)) {
                    // $parts3 = explode('/', $pregnancy_status_since_when);
                    // $new_pregnancy_status_since_when = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                // }
            // }

            $roof = $this->input->post('roof', true);
            $wall = $this->input->post('wall', true);
            $floor = $this->input->post('floor', true);
            $room = $this->input->post('room', true);
            $room1l = $this->input->post('room1l', true);
            $room1b = $this->input->post('room1b', true);
            $room2l = $this->input->post('room2l', true);
            $room2b = $this->input->post('room2b', true);
            $room3l = $this->input->post('room3l', true);
            $room3b = $this->input->post('room3b', true);
            $Q42A = $this->input->post('Q42A', true);
            $Q42B = $this->input->post('Q42B', true);
            $water = $this->input->post('water', true);
            $winside = $this->input->post('winside', true);
            $wat_coll = $this->input->post('wat_coll', true);
            $wshare = $this->input->post('wshare', true);
            $wat_supp = $this->input->post('wat_supp', true);
            $w_safe = $this->input->post('w_safe', true);
            $w_suff = $this->input->post('w_suff', true);
            $toilet = $this->input->post('toilet', true);
            $toilet_ct = $this->input->post('toilet_ct', true);
            $toilte_mf = $this->input->post('toilte_mf', true);
            $toilet_cl = $this->input->post('toilet_cl', true);
            $toilet_dis = $this->input->post('toilet_dis', true);
            $tinside = $this->input->post('tinside', true);
            $tshare = $this->input->post('tshare', true);
            $light = $this->input->post('light', true);
            $Q61 = $this->input->post('Q61', true);
            $Q63 = $this->input->post('Q63', true);
            $Q65A = $this->input->post('Q65A', true);
            $Q65B = $this->input->post('Q65B', true);
            $Q65C = $this->input->post('Q65C', true);
            $Q65D = $this->input->post('Q65D', true);
            $Q65E = $this->input->post('Q65E', true);
            $Q65F = $this->input->post('Q65F', true);
            $cook = $this->input->post('cook', true);
            $cinside = $this->input->post('cinside', true);
            $cshare = $this->input->post('cshare', true);
            $garbage = $this->input->post('garbage', true);
            $gcollect = $this->input->post('gcollect', true);
            $voterid = $this->input->post('voterid', true);
            $imobile = $this->input->post('imobile', true);
            $remarks = $this->input->post('remarks', true);
            $ten_perceent = $this->input->post('ten_perceent', true);

            $roof_other = NULL;

            if ($roof == 338) {
                $roof_other = $this->input->post('roof_other', true);
            }

            $wall_other = NULL;

            if ($wall == 338) {
                $wall_other = $this->input->post('wall_other', true);
            }

            $wcol_time = 0;
            $wait_time = 0;

            if ($winside == 350 || $winside == 351) {
                $wcol_time = $this->input->post('wcol_time', true);
                $wait_time = $this->input->post('wait_time', true);
            }


            $watcoloth = NULL;

            if ($wat_coll == 357) {
                $watcoloth = $this->input->post('watcoloth', true);
            }

            $wsharef = 0;

            if ($wshare == 1) {
                $wsharef = $this->input->post('wsharef', true);
            }

            $w_suppoth = NULL;

            if ($wat_supp == 363) {
                $w_suppoth = $this->input->post('w_suppoth', true);
            }

            $toilet_ct_ot = NULL;
            if ($toilet_ct == 398) {
                $toilet_ct_ot = $this->input->post('toilet_ct_ot', true);
            }

            $tmf_usep = 0;
            if ($toilte_mf == 1) {
                $tmf_usep = $this->input->post('tmf_usep', true);
            }

            $toilet_coth = NULL;
            if ($toilet_cl == 370) {
                $toilet_coth = $this->input->post('toilet_coth', true);
            }

            $toilet_dot = NULL;
            if ($toilet_dis == 377) {
                $toilet_dot = $this->input->post('toilet_dot', true);
            }


            $tsharef = 0;
            if ($tshare == 1) {
                $tsharef = $this->input->post('tsharef', true);
            }

            $light_oth = NULL;
            if ($light == 382) {
                $light_oth = $this->input->post('light_oth', true);
            }

            $Q62 = 0;
            if ($Q61 == 1) {
                $Q62 = $this->input->post('Q62', true);
            }

            $Q62oth = NULL;
            if ($Q62 == 385) {
                $Q62oth = $this->input->post('Q62oth', true);
            }

            $Q63oth = NULL;
            if ($Q63 == 404) {
                $Q63oth = $this->input->post('Q63oth', true);
            }

            $cookoth = NULL;
            if ($cook == 414) {
                $cookoth = $this->input->post('cookoth', true);
            }

            $csharef = 0;
            if ($cshare == 1) {
                $csharef = $this->input->post('csharef', true);
            }

            $garbageoth = NULL;
            if ($garbage == 418) {
                $garbageoth = $this->input->post('garbageoth', true);
            }
            $resp_ind = $this->input->post('resp_ind', true);

            // $resp_ind = NULL;
            // if ($voterid == 1) {
            // }

            $round_master_id_entry_round = $this->getCurrentRound()[0]->id;

            $this->db->trans_start();

            try {

                $IdInfo = array(
                    'upazilla_name' => $upazilla_name,
                    'division_id' => $division_id,
                    'looking_for_work' => $looking_for_work,
                    'for_earning_more_money' => $for_earning_more_money,
                    'river_erosion' => $river_erosion,
                    'for_family' => $for_family,
                    'for_children_education' => $for_children_education,
                    'for_own_education' => $for_own_education,
                    'for_marriage' => $for_marriage,
                    'na_as_birth_here' => $na_as_birth_here,
                    'coming_reason_other' => $coming_reason_other,
                    'coming_reason_other_specify' => $coming_reason_other_specify,
                    'ten_perceent' => $ten_perceent,
                   // 'pregnancy_status_since_when' => $new_pregnancy_status_since_when,
                    'roof' => $roof,
                    'roof_other' => $roof_other,
                    'wall' => $wall,
                    'wall_other' => $wall_other,
                    'floor' => $floor,
                    'room' => $room,
                    'room1l' => $room1l,
                    'room1b' => $room1b,
                    'room2l' => $room2l,
                    'room2b' => $room2b,
                    'room3l' => $room3l,
                    'room3b' => $room3b,
                    'Q42A' => $Q42A,
                    'Q42B' => $Q42B,
                    'water' => $water,
                    'winside' => $winside,
                    'wcol_time' => $wcol_time,
                    'wait_time' => $wait_time,
                    'wat_coll' => $wat_coll,
                    'watcoloth' => $watcoloth,
                    'wshare' => $wshare,
                    'wsharef' => $wsharef,
                    'wat_supp' => $wat_supp,
                    'w_suppoth' => $w_suppoth,
                    'w_safe' => $w_safe,
                    'w_suff' => $w_suff,
                    'toilet' => $toilet,
                    'toilet_ct' => $toilet_ct,
                    'toilet_ct_ot' => $toilet_ct_ot,
                    'toilte_mf' => $toilte_mf,
                    'tmf_usep' => $tmf_usep,
                    'toilet_cl' => $toilet_cl,
                    'toilet_coth' => $toilet_coth,
                    'toilet_dis' => $toilet_dis,
                    'toilet_dot' => $toilet_dot,
                    'tinside' => $tinside,
                    'tshare' => $tshare,
                    'tsharef' => $tsharef,
                    'light' => $light,
                    'light_oth' => $light_oth,
                    'Q61' => $Q61,
                    'Q62' => $Q62,
                    'Q62oth' => $Q62oth,
                    'Q63' => $Q63,
                    'Q63oth' => $Q63oth,
                    'Q65A' => $Q65A,
                    'Q65B' => $Q65B,
                    'Q65C' => $Q65C,
                    'Q65D' => $Q65D,
                    'Q65E' => $Q65E,
                    'Q65F' => $Q65F,
                    'cook' => $cook,
                    'cookoth' => $cookoth,
                    'cinside' => $cinside,
                    'cshare' => $cshare,
                    'csharef' => $csharef,
                    'garbage' => $garbage,
                    'garbageoth' => $garbageoth,
                    'gcollect' => $gcollect,
                    'voterid' => $voterid,
                    'resp_ind' => $resp_ind,
                    'imobile' => $imobile,
                    'remarks' => $remarks,
                    'household_master_id' => $household_master_id,
                    'round_master_id' => $round_master_id,
                    'insertedBy' => $this->vendorId,
                    'insertedOn' => date('Y-m-d H:i:s')
                );

//                echo "<pre/>";
//                print_r($IdInfo); exit();

                $resultID = $this->assetModel->addNew($IdInfo, $this->config->item('baselineCensusTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while creating baseline census.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Baseline census created successfully.');

            redirect('Baseline_census/baseline_census_info?baseID=' . $baseID . '#baseline_census_info');
        }
    }

    public function editBaseline($id) {
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
            redirect('Baseline_census/visit?baseID=' . $baseID);
        }

        $data['baseline_record'] = $this->baselineModel->getBaselineDetails($this->config->item('baselineCensusTable'), $id);

//        echo "<pre/>";
//        print_r($data['baseline_record']); exit();

        $data['divisions'] = $this->modelName->listingdiv($this->config->item('divTable'));
        $data['migReasons'] = $this->modelName->getLookUpList($this->config->item('migReason'));
        $data['yes_no_dont_know'] = $this->modelName->getLookUpList($this->config->item('yes_no_dont_know'));
//        $data['house_owner'] = $this->modelName->getLookUpList($this->config->item('house_owner'));
//        $data['land_owner'] = $this->modelName->getLookUpList($this->config->item('land_owner'));
        $data['roof_build_with'] = $this->modelName->getLookUpList($this->config->item('roof_build_with'));
        $data['floor_build_with'] = $this->modelName->getLookUpList($this->config->item('floor_build_with'));
        $data['water_source'] = $this->modelName->getLookUpList($this->config->item('water_source'));
        $data['water_source_location'] = $this->modelName->getLookUpList($this->config->item('water_source_location'));
        $data['water_collector'] = $this->modelName->getLookUpList($this->config->item('water_collector'));
        $data['yes_no'] = $this->modelName->getLookUpList($this->config->item('yes_no'));
        $data['water_supplier'] = $this->modelName->getLookUpList($this->config->item('water_supplier'));
        $data['toilet_cleaner'] = $this->modelName->getLookUpList($this->config->item('toilet_cleaner'));
        $data['toilet_dirt_remover'] = $this->modelName->getLookUpList($this->config->item('toilet_dirt_remover'));
        $data['light_source'] = $this->modelName->getLookUpList($this->config->item('light_source'));
        $data['hand_washing_place'] = $this->modelName->getLookUpList($this->config->item('hand_washing_place'));
        $data['toilet_type'] = $this->modelName->getLookUpList($this->config->item('toilet_type'));
        $data['dirt_removing_type'] = $this->modelName->getLookUpList($this->config->item('dirt_removing_type'));
        $data['hand_washing_arrangement'] = $this->modelName->getLookUpList($this->config->item('hand_washing_arrangement'));
        $data['spontaneously_afterTelling_dontKnow'] = $this->modelName->getLookUpList($this->config->item('spontaneously_afterTelling_dontKnow'));
        $data['fuel_type'] = $this->modelName->getLookUpList($this->config->item('fuel_type'));
        $data['dirt_taken_place'] = $this->modelName->getLookUpList($this->config->item('dirt_taken_place'));
        $data['dirt_collection_time'] = $this->modelName->getLookUpList($this->config->item('dirt_collection_time'));

        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard_baseline_census', $data);
        $this->load->view($this->controller . '/baseline_details_edit', $data);
        $this->load->view('includes/footer');
    }

    function editBaselineDetails() {
        $household_master_id = $this->input->post('household_master_id_sub', true);
        $round_master_id = $this->input->post('round_master_id', true);
        $baselineID = $this->input->post('baselineID', true);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('upazilla_name', 'Upazilla Name', 'trim|required');
        $this->form_validation->set_rules('division_id', 'Division Name', 'trim|required');

       // $this->form_validation->set_rules('pregnancy_status', 'Pregnancy status', 'trim|required');
        $this->form_validation->set_rules('roof', 'Roof made with', 'trim|required');
        $this->form_validation->set_rules('wall', 'Wall made with', 'trim|required');
        $this->form_validation->set_rules('floor', 'Floor made with', 'trim|required');
        $this->form_validation->set_rules('room', 'Total room', 'trim|required');
        $this->form_validation->set_rules('room1l', 'Room1 length', 'trim|required');
        $this->form_validation->set_rules('room1b', 'Room1 breadth', 'trim|required');
        $this->form_validation->set_rules('Q42A', 'Monthly expense', 'trim|required');
        $this->form_validation->set_rules('Q42B', 'Monthly food expense', 'trim|required');
        $this->form_validation->set_rules('water', 'Water source', 'trim|required');
        $this->form_validation->set_rules('winside', 'Water source location', 'trim|required');
        $this->form_validation->set_rules('wat_coll', 'Water collector', 'trim|required');
        $this->form_validation->set_rules('wshare', 'Water sharing', 'trim|required');
        $this->form_validation->set_rules('wat_supp', 'Water supplier', 'trim|required');
        $this->form_validation->set_rules('w_safe', 'Water safe status', 'trim|required');
        $this->form_validation->set_rules('w_suff', 'Water sufficient status', 'trim|required');
        $this->form_validation->set_rules('toilet', 'Toilet type', 'trim|required');
        $this->form_validation->set_rules('toilet_ct', 'Toilet cleaning type', 'trim|required');
        $this->form_validation->set_rules('toilte_mf', 'Gender wise toilet', 'trim|required');
        $this->form_validation->set_rules('toilet_cl', 'Toilet cleaner', 'trim|required');
        $this->form_validation->set_rules('toilet_dis', 'Toilet dirt remover', 'trim|required');
        $this->form_validation->set_rules('tinside', 'Toilet location', 'trim|required');
        $this->form_validation->set_rules('tshare', 'Toilet sharing', 'trim|required');
        $this->form_validation->set_rules('light', 'Light source', 'trim|required');
        $this->form_validation->set_rules('Q61', 'Hand washing arrangement', 'trim|required');
        $this->form_validation->set_rules('Q63', 'Hand washing arrangement type', 'trim|required');
        $this->form_validation->set_rules('Q65A', 'Q65A', 'trim|required');
        $this->form_validation->set_rules('Q65B', 'Q65B', 'trim|required');
        $this->form_validation->set_rules('Q65C', 'Q65C', 'trim|required');
        $this->form_validation->set_rules('Q65D', 'Q65D', 'trim|required');
        $this->form_validation->set_rules('Q65E', 'Q65E', 'trim|required');
        $this->form_validation->set_rules('Q65F', 'Q65F', 'trim|required');
        $this->form_validation->set_rules('cook', 'Cooking fuel type', 'trim|required');
        $this->form_validation->set_rules('cinside', 'Kitchen room location', 'trim|required');
        $this->form_validation->set_rules('cshare', 'Kitchen sharing status', 'trim|required');
        $this->form_validation->set_rules('garbage', 'Garbage taking place', 'trim|required');
        $this->form_validation->set_rules('gcollect', 'Garbage collection time density', 'trim|required');
        $this->form_validation->set_rules('voterid', 'Voterid availability', 'trim|required');
        $this->form_validation->set_rules('imobile', 'Respondent mobile', 'trim|required');


        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            redirect('Baseline_census/editBaseline/' . $baselineID . '?household_master_id=' . $household_master_id . '&&baseID=' . $baseID . '#baseline_census_info');
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect('Baseline_census/visit?baseID=' . $baseID);
            }


            $upazilla_name = $this->input->post('upazilla_name', true);
            $division_id = $this->input->post('division_id', true);
            //Question 3
            $looking_for_work = $this->input->post('looking_for_work', true) > 0 ? $this->input->post('looking_for_work', true) : 0;
            $for_earning_more_money = $this->input->post('for_earning_more_money', true) > 0 ? $this->input->post('for_earning_more_money', true) : 0;
            $river_erosion = $this->input->post('river_erosion', true) > 0 ? $this->input->post('river_erosion', true) : 0;
            $for_family = $this->input->post('for_family', true) > 0 ? $this->input->post('for_family', true) : 0;
            $for_children_education = $this->input->post('for_children_education', true) > 0 ? $this->input->post('for_children_education', true) : 0;
            $for_own_education = $this->input->post('for_own_education', true) > 0 ? $this->input->post('for_own_education', true) : 0;
            $for_marriage = $this->input->post('for_marriage', true) > 0 ? $this->input->post('for_marriage', true) : 0;
            $na_as_birth_here = $this->input->post('na_as_birth_here', true) > 0 ? $this->input->post('na_as_birth_here', true) : 0;
            $coming_reason_other = $this->input->post('coming_reason_other', true) > 0 ? $this->input->post('coming_reason_other', true) : 0;

            $coming_reason_other_specify = NULL;
            if ($coming_reason_other == 99) {
                $coming_reason_other_specify = $this->input->post('coming_reason_other_specify', true);
            }

            // $pregnancy_status = $this->input->post('pregnancy_status', true);

            // $new_pregnancy_status_since_when = null;
            
            // if ($pregnancy_status == 331) {
                // $pregnancy_status_since_when = $this->input->post('pregnancy_status_since_when', true);
                // if (!empty($pregnancy_status_since_when)) {
                    // $parts3 = explode('/', $pregnancy_status_since_when);
                    // $new_pregnancy_status_since_when = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                // }
            // }
            $roof = $this->input->post('roof', true);
            $wall = $this->input->post('wall', true);
            $floor = $this->input->post('floor', true);
            $room = $this->input->post('room', true);
            $room1l = $this->input->post('room1l', true);
            $room1b = $this->input->post('room1b', true);
            $room2l = $this->input->post('room2l', true);
            $room2b = $this->input->post('room2b', true);
            $room3l = $this->input->post('room3l', true);
            $room3b = $this->input->post('room3b', true);
            $Q42A = $this->input->post('Q42A', true);
            $Q42B = $this->input->post('Q42B', true);
            $water = $this->input->post('water', true);
            $winside = $this->input->post('winside', true);
            $wat_coll = $this->input->post('wat_coll', true);
            $wshare = $this->input->post('wshare', true);
            $wat_supp = $this->input->post('wat_supp', true);
            $w_safe = $this->input->post('w_safe', true);
            $w_suff = $this->input->post('w_suff', true);
            $toilet = $this->input->post('toilet', true);
            $toilet_ct = $this->input->post('toilet_ct', true);
            $toilte_mf = $this->input->post('toilte_mf', true);
            $toilet_cl = $this->input->post('toilet_cl', true);
            $toilet_dis = $this->input->post('toilet_dis', true);
            $tinside = $this->input->post('tinside', true);
            $tshare = $this->input->post('tshare', true);
            $light = $this->input->post('light', true);
            $Q61 = $this->input->post('Q61', true);
            $Q63 = $this->input->post('Q63', true);
            $Q65A = $this->input->post('Q65A', true);
            $Q65B = $this->input->post('Q65B', true);
            $Q65C = $this->input->post('Q65C', true);
            $Q65D = $this->input->post('Q65D', true);
            $Q65E = $this->input->post('Q65E', true);
            $Q65F = $this->input->post('Q65F', true);
            $cook = $this->input->post('cook', true);
            $cinside = $this->input->post('cinside', true);
            $cshare = $this->input->post('cshare', true);
            $garbage = $this->input->post('garbage', true);
            $gcollect = $this->input->post('gcollect', true);
            $voterid = $this->input->post('voterid', true);
            $imobile = $this->input->post('imobile', true);
            $remarks = $this->input->post('remarks', true);
            $ten_perceent = $this->input->post('ten_perceent', true);

            $roof_other = NULL;

            if ($roof == 338) {
                $roof_other = $this->input->post('roof_other', true);
            }

            $wall_other = NULL;

            if ($wall == 338) {
                $wall_other = $this->input->post('wall_other', true);
            }

            $wcol_time = 0;
            $wait_time = 0;

            if ($winside == 350 || $winside == 351) {
                $wcol_time = $this->input->post('wcol_time', true);
                $wait_time = $this->input->post('wait_time', true);
            }


            $watcoloth = NULL;

            if ($wat_coll == 357) {
                $watcoloth = $this->input->post('watcoloth', true);
            }

            $wsharef = 0;

            if ($wshare == 1) {
                $wsharef = $this->input->post('wsharef', true);
            }

            $w_suppoth = NULL;

            if ($wat_supp == 363) {
                $w_suppoth = $this->input->post('w_suppoth', true);
            }

            $toilet_ct_ot = NULL;
            if ($toilet_ct == 398) {
                $toilet_ct_ot = $this->input->post('toilet_ct_ot', true);
            }

            $tmf_usep = 0;
            if ($toilte_mf == 1) {
                $tmf_usep = $this->input->post('tmf_usep', true);
            }

            $toilet_coth = NULL;
            if ($toilet_cl == 370) {
                $toilet_coth = $this->input->post('toilet_coth', true);
            }

            $toilet_dot = NULL;
            if ($toilet_dis == 377) {
                $toilet_dot = $this->input->post('toilet_dot', true);
            }


            $tsharef = 0;
            if ($tshare == 1) {
                $tsharef = $this->input->post('tsharef', true);
            }

            $light_oth = NULL;
            if ($light == 382) {
                $light_oth = $this->input->post('light_oth', true);
            }

            $Q62 = 0;
            if ($Q61 == 1) {
                $Q62 = $this->input->post('Q62', true);
            }

            $Q62oth = NULL;
            if ($Q62 == 385) {
                $Q62oth = $this->input->post('Q62oth', true);
            }

            $Q63oth = NULL;
            if ($Q63 == 404) {
                $Q63oth = $this->input->post('Q63oth', true);
            }

            $cookoth = NULL;
            if ($cook == 414) {
                $cookoth = $this->input->post('cookoth', true);
            }

            $csharef = 0;
            if ($cshare == 1) {
                $csharef = $this->input->post('csharef', true);
            }

            $garbageoth = NULL;
            if ($garbage == 418) {
                $garbageoth = $this->input->post('garbageoth', true);
            }

            $resp_ind = $this->input->post('resp_ind', true);
            // $resp_ind = NULL;
            // if ($voterid == 1) {
            // }

            $this->db->trans_start();

            try {

                $IdInfo = array(
                    'upazilla_name' => $upazilla_name,
                    'division_id' => $division_id,
                    'looking_for_work' => $looking_for_work,
                    'for_earning_more_money' => $for_earning_more_money,
                    'river_erosion' => $river_erosion,
                    'for_family' => $for_family,
                    'for_children_education' => $for_children_education,
                    'for_own_education' => $for_own_education,
                    'for_marriage' => $for_marriage,
                    'na_as_birth_here' => $na_as_birth_here,
                    'coming_reason_other' => $coming_reason_other,
                    'coming_reason_other_specify' => $coming_reason_other_specify,
                    'ten_perceent' => $ten_perceent,
                    //'pregnancy_status_since_when' => $new_pregnancy_status_since_when,
                    'roof' => $roof,
                    'roof_other' => $roof_other,
                    'wall' => $wall,
                    'wall_other' => $wall_other,
                    'floor' => $floor,
                    'room' => $room,
                    'room1l' => $room1l,
                    'room1b' => $room1b,
                    'room2l' => $room2l,
                    'room2b' => $room2b,
                    'room3l' => $room3l,
                    'room3b' => $room3b,
                    'Q42A' => $Q42A,
                    'Q42B' => $Q42B,
                    'water' => $water,
                    'winside' => $winside,
                    'wcol_time' => $wcol_time,
                    'wait_time' => $wait_time,
                    'wat_coll' => $wat_coll,
                    'watcoloth' => $watcoloth,
                    'wshare' => $wshare,
                    'wsharef' => $wsharef,
                    'wat_supp' => $wat_supp,
                    'w_suppoth' => $w_suppoth,
                    'w_safe' => $w_safe,
                    'w_suff' => $w_suff,
                    'toilet' => $toilet,
                    'toilet_ct' => $toilet_ct,
                    'toilet_ct_ot' => $toilet_ct_ot,
                    'toilte_mf' => $toilte_mf,
                    'tmf_usep' => $tmf_usep,
                    'toilet_cl' => $toilet_cl,
                    'toilet_coth' => $toilet_coth,
                    'toilet_dis' => $toilet_dis,
                    'toilet_dot' => $toilet_dot,
                    'tinside' => $tinside,
                    'tshare' => $tshare,
                    'tsharef' => $tsharef,
                    'light' => $light,
                    'light_oth' => $light_oth,
                    'Q61' => $Q61,
                    'Q62' => $Q62,
                    'Q62oth' => $Q62oth,
                    'Q63' => $Q63,
                    'Q63oth' => $Q63oth,
                    'Q65A' => $Q65A,
                    'Q65B' => $Q65B,
                    'Q65C' => $Q65C,
                    'Q65D' => $Q65D,
                    'Q65E' => $Q65E,
                    'Q65F' => $Q65F,
                    'cook' => $cook,
                    'cookoth' => $cookoth,
                    'cinside' => $cinside,
                    'cshare' => $cshare,
                    'csharef' => $csharef,
                    'garbage' => $garbage,
                    'garbageoth' => $garbageoth,
                    'gcollect' => $gcollect,
                    'voterid' => $voterid,
                    'resp_ind' => $resp_ind,
                    'imobile' => $imobile,
                    'remarks' => $remarks,
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

//                echo "<pre/>";
//                
//                print_r($IdInfo); exit();

                $resultID = $this->baselineModel->edit($IdInfo, $baselineID, $this->config->item('baselineCensusTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating baseline census.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Baseline census updated successfully.');

            redirect('Baseline_census/baseline_census_info?baseID=' . $baseID . '#baseline_census_info');
        }
    }

}

?>