<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Verbal_autopsy extends BaseController {

    /**
     * This is default constructor of the class
     */
    public $controller = "verbal_autopsy";
    public $pageTitle = 'Verbal Autopsy Management';
    public $pageShortName = 'Verbal Autopsy';

    public function __construct() {
        
        parent::__construct();
        
        $this->load->model('death_model', 'modelName');
        $this->load->model('master_model', 'masterModel');
        $this->load->model('menu_model', 'menuModel');
        $this->load->library('pagination');
        $this->isLoggedIn();
        $menu_key = 'vp';
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
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['addMethod'] = 'addNew';
        $data['editMethod'] = 'editOld';
        $data['editMethodNew'] = 'editNeonatal';
        $data['editMethodChild'] = 'editChild';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';


        $data['roundlist'] = $this->modelName->getRoundListList();

        $round_master_id = 0;
        $data['round_master_id'] = 0;

        if ($this->input->post('Clear')) {
            $this->session->unset_userdata('round_master_id');
            $data['round_master_id'] = 0;
        }

        $round_master_id = $this->input->post('round_master_id', true);

        $data['round_master_id'] = $this->session->userdata('round_master_id');

        if ($this->input->post('search')) {

            $this->session->set_userdata('round_master_id', $round_master_id);
            $data['round_master_id'] = $this->session->userdata('round_master_id');
        }

        if ((!empty($data['round_master_id']))) {

            $data['userRecords'] = $this->modelName->listing($this->config->item('deathTable'), $data['round_master_id']);
        }


        //$data['userRecords'] = $this->modelName->listing($this->config->item('deathTable'));

        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/index', $data);
        $this->load->view('includes/footer');
    }

    /**
     * This function is used to load the add new form
     */
    function addNew() {

        $baseID = $this->input->get('baseID', TRUE);

        $addPerm = $this->getPermission($baseID, $this->role, 'add');

        if ($addPerm == 0) {
            $this->session->set_flashdata('error', "Unauthorized Access");
            redirect($this->controller . '?baseID=' . $baseID);
        }

        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'addNewList';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'Add';


        $this->load->view('includes/header', $this->global);
        $this->load->view($this->controller . '/addNew', $data);
        $this->load->view('includes/footer');
    }

    /**
     * This function is used to add new
     */
    function addNewList() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('id_name', 'ID Name', 'trim|required|max_length[255]|xss_clean');

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->addNew();
        } else {

            $id_name = $this->input->post('id_name');
            $active = $this->input->post('active');

            $IdInfo = array('name' => $id_name, 'active' => $active, 'insertedBy' => $this->vendorId, 'insertedOn' => date('Y-m-d H:i:s'));

            $result = $this->modelName->addNewList($IdInfo, $this->config->item('deathTable'));

            if ($result > 0) {
                $this->session->set_flashdata('success', $this->pageShortName . ' created successfully');
            } else {
                $this->session->set_flashdata('error', $this->pageShortName . ' creation failed');
            }

            redirect($this->controller . '?baseID=' . $baseID);
        }
    }

    function editOld($id = NULL) {
        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id = $this->input->get('household_master_id', TRUE);
        if ($id == null) {
            $this->session->set_flashdata('error', "Someting went wrong!! Please try Again");
            redirect($this->controller . '?baseID=' . $baseID);
        }

        $editPerm = $this->getPermission($baseID, $this->role, 'edit');
        if ($editPerm == 0) {
            $this->session->set_flashdata('error', "Unauthorized Access");
            redirect($this->controller . '?baseID=' . $baseID);
        }

        //dynamic options end

        $data['VA_Relation'] = $this->modelName->getLookUpList($this->config->item('VA_Relation'));
        $data['va_yes_no'] = $this->modelName->getLookUpList($this->config->item('va_yes_no'));

        //$data['va_gender'] = $this->modelName->getLookUpList($this->config->item('va_gender'));
        //$data['VA_Marital_Status'] = $this->modelName->getLookUpList($this->config->item('VA_Marital_Status'));

        $data['va_gender'] = $this->masterModel->getLookUpList($this->config->item('membersextype'));
        $data['VA_Marital_Status'] = $this->masterModel->getLookUpList($this->config->item('maritalstatustyp'));

        $data['VA_Yes_No_Reluctant_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Yes_No_Reluctant_Unknown'));
        $data['VA_Education_Institute_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Education_Institute_Type'));
        // $data['VA_Occupation_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Occupation_Type'));
        $data['VA_Occupation_Type'] = $this->masterModel->getLookUpList($this->config->item('occupationtyp'));

        $data['VA_INJURY_OR_ACCIDENT_TYPE'] = $this->modelName->getLookUpList($this->config->item('VA_INJURY_OR_ACCIDENT_TYPE'));
        $data['VA_Road_OR_Water_Vehicle_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Road_OR_Water_Vehicle_Type'));
        $data['VA_Medicine_Or_Poison_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Medicine_Or_Poison_Type'));
        $data['VA_Yes_No_Reluctant_NotApplicable_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Yes_No_Reluctant_NotApplicable_Unknown'));
        $data['VA_Death_When'] = $this->modelName->getLookUpList($this->config->item('VA_Death_When'));
        $data['VA_Delivery_Result'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Result'));
        $data['VA_Delivery_Durability'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Durability'));
        $data['VA_Delivery_Place'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Place'));
        $data['VA_Delivery_Method'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Method'));
        $data['VA_Fever_Dimension'] = $this->modelName->getLookUpList($this->config->item('VA_Fever_Dimension'));
        $data['VA_Fever_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Fever_Type'));
        $data['VA_Body_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Body_Where'));
        $data['VA_Grain_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Grain_Type'));
        $data['VA_Arsenic_Identification_Hospital'] = $this->modelName->getLookUpList($this->config->item('VA_Arsenic_Identification_Hospital'));
        $data['VA_Swollen_Body_Part'] = $this->modelName->getLookUpList($this->config->item('VA_Swollen_Body_Part'));
        $data['VA_Glands_Swollen_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Glands_Swollen_Where'));
        $data['VA_Shortness_of_breath_Body_Condition'] = $this->modelName->getLookUpList($this->config->item('VA_Shortness_of_breath_Body_Condition'));
        $data['VA_Yes_No_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Yes_No_Unknown'));
        $data['VA_Chest_Pain_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Where'));
        $data['VA_Chest_Pain_Continuous'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Continuous'));
        $data['VA_Chest_Pain_Suddenly'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Suddenly'));
        $data['VA_Chest_Pain_Stability'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Stability'));
        $data['VA_Stool_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Stool_Type'));
        $data['VA_Diarrhea_Continuous'] = $this->modelName->getLookUpList($this->config->item('VA_Diarrhea_Continuous'));
        $data['VA_Vomit_Looks_Like'] = $this->modelName->getLookUpList($this->config->item('VA_Vomit_Looks_Like'));
        $data['VA_Abdominal_Pain_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Abdominal_Pain_Type'));
        $data['VA_Abdominal_Pain_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Abdominal_Pain_Where'));
        $data['VA_Pain_Dimension'] = $this->modelName->getLookUpList($this->config->item('VA_Pain_Dimension'));
        $data['VA_Abdominal_Pain_Stool_Look_Like'] = $this->modelName->getLookUpList($this->config->item('VA_Abdominal_Pain_Stool_Look_Like'));
        $data['VA_ABDOMINAL_DISTENSION_QUICK'] = $this->modelName->getLookUpList($this->config->item('VA_ABDOMINAL_DISTENSION_QUICK'));
        $data['VA_MASS_in_Abdomen_Strong_Wheel_Position'] = $this->modelName->getLookUpList($this->config->item('VA_MASS_in_Abdomen_Strong_Wheel_Position'));
        $data['VA_Headache_Quick_Or_Slow'] = $this->modelName->getLookUpList($this->config->item('VA_Headache_Quick_Or_Slow'));
        $data['VA_Suddenly_Slowly_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Suddenly_Slowly_Unknown'));
        $data['VA_Status_Before_Swoon'] = $this->modelName->getLookUpList($this->config->item('VA_Status_Before_Swoon'));
        $data['VA_Paralyzed_Body_Part'] = $this->modelName->getLookUpList($this->config->item('VA_Paralyzed_Body_Part'));
        $data['VA_Paralyzed_When'] = $this->modelName->getLookUpList($this->config->item('VA_Paralyzed_When'));
        $data['VA_Urine_Color'] = $this->modelName->getLookUpList($this->config->item('VA_Urine_Color'));
        $data['VA_Urine_Dimension'] = $this->modelName->getLookUpList($this->config->item('VA_Urine_Dimension'));
        $data['VA_Drug_Collection_Place'] = $this->modelName->getLookUpList($this->config->item('VA_Drug_Collection_Place'));
        $data['VA_Treatment_Provider'] = $this->modelName->getLookUpList($this->config->item('VA_Treatment_Provider'));
        $data['VA_Death_Place'] = $this->modelName->getLookUpList($this->config->item('VA_Death_Place'));
        $data['VA_Reason_Teller'] = $this->modelName->getLookUpList($this->config->item('VA_Reason_Teller'));
        $data['VA_Hospital_List'] = $this->modelName->getLookUpList($this->config->item('VA_Hospital_List'));
        $data['VA_Supervisor_List'] = $this->modelName->getLookUpList($this->config->item('VA_Supervisor_List'));
        $data['VA_Leg_Wound'] = $this->modelName->getLookUpList($this->config->item('VA_Leg_Wound'));
        $data['VA_Weight_Loss_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Weight_Loss_Type'));
        $data['VA_Breathing_Problem_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Breathing_Problem_Type'));
        $data['VA_Daily_Work_Hampered_By_Breathing_Problem'] = $this->modelName->getLookUpList($this->config->item('VA_Daily_Work_Hampered_By_Breathing_Problem'));
        $data['VA_Breathing_Problem_When'] = $this->modelName->getLookUpList($this->config->item('VA_Breathing_Problem_When'));

        $data['Covid_Positive_Negative'] = $this->modelName->getLookUpList($this->config->item('Covid_Positive_Negative'));
        $data['verbal_autopsy_specialist_name'] = $this->modelName->getLookUpList($this->config->item('verbal_autopsy_specialist_name'));
        $data['logged_in_user_role_id'] =$this->role[0];

        $this->global['menu'] = $this->menuModel->getMenu($this->role);
        $data['userInfo'] = $this->modelName->getListInfo($id, $this->config->item('deathTable'));


        $data['household_member'] = $this->modelName->getMemberMasterPresentListByHouseholdIds($household_master_id);

        $data['intervcode'] = $this->vendorId;


        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'updateInfo';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'Edit';


        $this->load->view('includes/header', $this->global);
        $this->load->view($this->controller . '/editOld', $data);
        $this->load->view('includes/footer');
    }

    /**
     * This function is used to edit information
     */
    function updateInfo() {

        $this->load->library('form_validation');

        $member_death_table_id = $this->input->post('ID');
        $household_master_id = $this->input->post('household_master_id');

        $baseID = $this->input->get('baseID', TRUE);

        $Q2_2_INTV_DATE = null;

        if (!empty($this->input->post('Q2_2_INTV_DATE'))) {
            $parts = explode('/', $this->input->post('Q2_2_INTV_DATE'));
            $Q2_2_INTV_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q2_3_1ST_INTV_DATE = null;
        if (!empty($this->input->post('Q2_3_1ST_INTV_DATE'))) {
            $parts = explode('/', $this->input->post('Q2_3_1ST_INTV_DATE'));
            $Q2_3_1ST_INTV_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q2_4_2ND_INTV_DATE = null;
        if (!empty($this->input->post('Q2_4_2ND_INTV_DATE'))) {
            $parts = explode('/', $this->input->post('Q2_4_2ND_INTV_DATE'));
            $Q2_4_2ND_INTV_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q3_5_DOB = null;
        if (!empty($this->input->post('Q3_5_DOB'))) {
            $parts = explode('/', $this->input->post('Q3_5_DOB'));
            $Q3_5_DOB = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q3_6_DOD = null;
        if (!empty($this->input->post('Q3_6_DOD'))) {
            $parts = explode('/', $this->input->post('Q3_6_DOD'));
            $Q3_6_DOD = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q3_9_2_DOM = null;
        if (!empty($this->input->post('Q3_9_2_DOM'))) {
            $parts = explode('/', $this->input->post('Q3_9_2_DOM'));
            $Q3_9_2_DOM = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q6_2_2 = null;
        if (!empty($this->input->post('Q6_2_2'))) {
            $parts = explode('/', $this->input->post('Q6_2_2'));
            $Q6_2_2 = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q9_2_1_1_DATE = null;
        if (!empty($this->input->post('Q9_2_1_1_DATE'))) {
            $parts = explode('/', $this->input->post('Q9_2_1_1_DATE'));
            $Q9_2_1_1_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q9_2_1_2_DATE = null;
        if (!empty($this->input->post('Q9_2_1_2_DATE'))) {
            $parts = explode('/', $this->input->post('Q9_2_1_2_DATE'));
            $Q9_2_1_2_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q9_2_1_3_DATE = null;
        if (!empty($this->input->post('Q9_2_1_3_DATE'))) {
            $parts = explode('/', $this->input->post('Q9_2_1_3_DATE'));
            $Q9_2_1_3_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q10_1_1_VDATE = null;
        if (!empty($this->input->post('Q10_1_1_VDATE'))) {
            $parts = explode('/', $this->input->post('Q10_1_1_VDATE'));
            $Q10_1_1_VDATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q10_3_2_DRD = null;
        if (!empty($this->input->post('Q10_3_2_DRD'))) {
            $parts = explode('/', $this->input->post('Q10_3_2_DRD'));
            $Q10_3_2_DRD = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q11_DOE = null;
        if (!empty($this->input->post('Q11_DOE'))) {
            $parts = explode('/', $this->input->post('Q11_DOE'));
            $Q11_DOE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        $IDInfo = array(
            'Q1_1_N1' => $this->input->post('Q1_1_N1'),
            'Q1_1_N2' => $this->input->post('Q1_1_N2'),
            'Q1_1_N3' => $this->input->post('Q1_1_N3'),
            'Q1_1_R1' => $this->input->post('Q1_1_R1'),
            'Q1_1_R2' => $this->input->post('Q1_1_R2'),
            'Q1_1_R3' => $this->input->post('Q1_1_R3'),
            'Q1_1_P1' => $this->input->post('Q1_1_P1'),
            'Q1_1_P2' => $this->input->post('Q1_1_P2'),
            'Q1_1_P3' => $this->input->post('Q1_1_P3'),
            'Q1_1_R1_other' => $this->input->post('Q1_1_R1_other'),
            'Q1_1_R2_other' => $this->input->post('Q1_1_R2_other'),
            'Q1_1_R3_other' => $this->input->post('Q1_1_R3_other'),
            'Q1_2_LINE' => $this->input->post('Q1_2_LINE'),
            'Q1_2_SEX' => $this->input->post('Q1_2_SEX'),
            'Q1_3_REL' => $this->input->post('Q1_3_REL'),
            'Q1_3_REL_OTHER' => $this->input->post('Q1_3_REL_OTHER'),
            'Q1_4_AGE' => $this->input->post('Q1_4_AGE'),
            'Q1_5_EDU' => $this->input->post('Q1_5_EDU'),
            'Q2_1_INTV_NAME' => $this->input->post('Q2_1_INTV_NAME'),
            'Q2_1_INTV_CODE' => $this->input->post('Q2_1_INTV_CODE'),
            'Q2_2_INTV_DATE' => $Q2_2_INTV_DATE,
            'Q2_3_1ST_INTV_DATE' => $Q2_3_1ST_INTV_DATE,
            'Q2_4_2ND_INTV_DATE' => $Q2_4_2ND_INTV_DATE,
            'Q3_1_DNAME' => $this->input->post('Q3_1_DNAME'),
            'Q3_2_RID' => $this->input->post('Q3_2_RID'),
            'Q3_2_CID' => $this->input->post('Q3_2_CID'),
            'Q3_2_1_NID' => $this->input->post('Q3_2_1_NID'),
            'Q3_3_V_NAME' => $this->input->post('Q3_3_V_NAME'),
            'Q3_4_B_CODE' => $this->input->post('Q3_4_B_CODE'),
            'Q3_4_B_NAME' => $this->input->post('Q3_4_B_NAME'),
            'Q3_5_DOB' => $Q3_5_DOB,
            'Q3_6_DOD' => $Q3_6_DOD,
            'Q3_7_AGE_Y' => $this->input->post('Q3_7_AGE_Y'),
            'Q3_8_SEX' => $this->input->post('Q3_8_SEX'),
            'Q3_9_MSTATUS' => $this->input->post('Q3_9_MSTATUS'),
            'Q3_9_1_MD' => $this->input->post('Q3_9_1_MD'),
            'Q3_9_2_DOM' => $Q3_9_2_DOM,
            'Q3_10_EDU' => $this->input->post('Q3_10_EDU'),
            'Q3_10_1' => $this->input->post('Q3_10_1'),
            'Q3_10_2_ES' => $this->input->post('Q3_10_2_ES'),
            'Q3_11_CODE' => $this->input->post('Q3_11_CODE'),
            'Q4_1_death_reasons' => $this->input->post('Q4_1_death_reasons'),
            'Q4_2_A' => $this->input->post('Q4_2_A'),
            'Q4_2_B' => $this->input->post('Q4_2_B'),
            'Q4_2_C' => $this->input->post('Q4_2_C'),
            'Q4_2_D' => $this->input->post('Q4_2_D'),
            'Q4_2_E' => $this->input->post('Q4_2_E'),
            'Q4_2_F' => $this->input->post('Q4_2_F'),
            'Q4_2_F_SPECIFY' => $this->input->post('Q4_2_F_SPECIFY'),
            'Q4_2_G' => $this->input->post('Q4_2_G'),
            'Q4_2_H' => $this->input->post('Q4_2_H'),
            'Q4_2_I' => $this->input->post('Q4_2_I'),
            'Q4_2_J' => $this->input->post('Q4_2_J'),
            'Q4_2_K' => $this->input->post('Q4_2_K'),
            'Q4_2_L' => $this->input->post('Q4_2_L'),
            'Q4_2_M' => $this->input->post('Q4_2_M'),
            'Q4_2_N' => $this->input->post('Q4_2_N'),
            'Q4_2_O' => $this->input->post('Q4_2_O'),
            'Q4_2_P' => $this->input->post('Q4_2_P'),
            'Q4_2_Q' => $this->input->post('Q4_2_Q'),
            'Q4_2_R' => $this->input->post('Q4_2_R'),
            'Q4_2_S' => $this->input->post('Q4_2_S'),
            'Q4_2_T' => $this->input->post('Q4_2_T'),
            'Q4_2_U' => $this->input->post('Q4_2_U'),
            'Q4_2_V' => $this->input->post('Q4_2_V'),
            'Q4_2_W' => $this->input->post('Q4_2_W'),
            'Q4_2_X' => $this->input->post('Q4_2_X'),
            'Q4_2_Y' => $this->input->post('Q4_2_Y'),
            'Q4_2_DEN' => $this->input->post('Q4_2_DEN'),
            'Q4_2_MEA' => $this->input->post('Q4_2_MEA'),
            'Q4_2_CHI' => $this->input->post('Q4_2_CHI'),
            'Q4_2_Z' => $this->input->post('Q4_2_Z'),
            'Q4_2_Z_OTHER' => $this->input->post('Q4_2_Z_OTHER'),
            'Q4_3_M' => $this->input->post('Q4_3_M'),
            'Q4_3_D' => $this->input->post('Q4_3_D'),
            'Q4_4' => $this->input->post('Q4_4'),
            'Q5_1' => $this->input->post('Q5_1'),
            'Q5_1_1' => $this->input->post('Q5_1_1'),
            'Q5_1_1_OTHER' => $this->input->post('Q5_1_1_OTHER'),
            'Q5_1_2' => $this->input->post('Q5_1_2'),
            'Q5_1_2_OTHER' => $this->input->post('Q5_1_2_OTHER'),
            'Q5_1_3' => $this->input->post('Q5_1_3'),
            'Q5_1_3_OTHER' => $this->input->post('Q5_1_3_OTHER'),
            'Q5_1_4' => $this->input->post('Q5_1_4'),
            'Q5_1_5' => $this->input->post('Q5_1_5'),
            'Q5_1_6' => $this->input->post('Q5_1_6'),
            'Q5_1_7_D' => $this->input->post('Q5_1_7_D'),
            'Q5_1_7_H' => $this->input->post('Q5_1_7_H'),
            'Q5_1_8' => $this->input->post('Q5_1_8'),
            'Q6_1_1' => $this->input->post('Q6_1_1'),
            'Q6_1_2_M' => $this->input->post('Q6_1_2_M'),
            'Q6_1_2_D' => $this->input->post('Q6_1_2_D'),
            'Q6_1_3' => $this->input->post('Q6_1_3'),
            'Q6_1_4_M' => $this->input->post('Q6_1_4_M'),
            'Q6_1_4_D' => $this->input->post('Q6_1_4_D'),
            'Q6_1_5' => $this->input->post('Q6_1_5'),
            'Q6_1_6' => $this->input->post('Q6_1_6'),
            'Q6_1_7' => $this->input->post('Q6_1_7'),
            'Q6_1_8' => $this->input->post('Q6_1_8'),
            'Q6_1_9_W' => $this->input->post('Q6_1_9_W'),
            'Q6_1_10' => $this->input->post('Q6_1_10'),
            'Q6_2_1_A' => $this->input->post('Q6_2_1_A'),
            'Q6_2_1_B' => $this->input->post('Q6_2_1_B'),
            'Q6_2_1_C' => $this->input->post('Q6_2_1_C'),
            'Q6_2_1_D' => $this->input->post('Q6_2_1_D'),
            'Q6_2_1_E' => $this->input->post('Q6_2_1_E'),
            'Q6_2_2' => $Q6_2_2,
            'Q6_2_3' => $this->input->post('Q6_2_3'),
            'Q6_2_4' => $this->input->post('Q6_2_4'),
            'Q6_2_5' => $this->input->post('Q6_2_5'),
            'Q6_2_6' => $this->input->post('Q6_2_6'),
            'Q6_2_7_1' => $this->input->post('Q6_2_7_1'),
            'Q6_2_7_2' => $this->input->post('Q6_2_7_2'),
            'Q6_2_7_3' => $this->input->post('Q6_2_7_3'),
            'Q6_2_7_4' => $this->input->post('Q6_2_7_4'),
            'Q6_2_7_5' => $this->input->post('Q6_2_7_5'),
            'Q6_2_7_6' => $this->input->post('Q6_2_7_6'),
            'Q6_2_7_7' => $this->input->post('Q6_2_7_7'),
            'Q6_2_7_8' => $this->input->post('Q6_2_7_8'),
            'Q6_2_7_9' => $this->input->post('Q6_2_7_9'),
            'Q6_2_7_10' => $this->input->post('Q6_2_7_10'),
            'Q6_2_7_11' => $this->input->post('Q6_2_7_11'),
            'Q6_2_7_12' => $this->input->post('Q6_2_7_12'),
            'Q6_2_7_13' => $this->input->post('Q6_2_7_13'),
            'Q6_2_7_14' => $this->input->post('Q6_2_7_14'),
            'Q6_2_7_15' => $this->input->post('Q6_2_7_15'),
            'Q6_2_7_15_OTHER' => $this->input->post('Q6_2_7_15_OTHER'),
            'Q6_2_7A' => $this->input->post('Q6_2_7A'),
            'Q6_2_7B' => $this->input->post('Q6_2_7B'),
            'Q6_2_8' => $this->input->post('Q6_2_8'),
            'Q6_2_9' => $this->input->post('Q6_2_9'),
            'Q6_2_10' => $this->input->post('Q6_2_10'),
            'Q6_2_11_A' => $this->input->post('Q6_2_11_A'),
            'Q6_2_11_B' => $this->input->post('Q6_2_11_B'),
            'Q6_2_11_C' => $this->input->post('Q6_2_11_C'),
            'Q6_2_11_D' => $this->input->post('Q6_2_11_D'),
            'Q6_2_11_E' => $this->input->post('Q6_2_11_E'),
            'Q6_2_11_F' => $this->input->post('Q6_2_11_F'),
            'Q6_2_11_F_OTHER' => $this->input->post('Q6_2_11_F_OTHER'),
            'Q6_2_12' => $this->input->post('Q6_2_12'),
            'Q6_2_13' => $this->input->post('Q6_2_13'),
            'Q6_2_13_OTHER' => $this->input->post('Q6_2_13_OTHER'),
            'Q6_2_12_1' => $this->input->post('Q6_2_12_1'),
            'Q6_2_14_A' => $this->input->post('Q6_2_14_A'),
            'Q6_2_14_B' => $this->input->post('Q6_2_14_B'),
            'Q6_2_14_C' => $this->input->post('Q6_2_14_C'),
            'Q6_2_14_D' => $this->input->post('Q6_2_14_D'),
            'Q6_2_14_E' => $this->input->post('Q6_2_14_E'),
            'Q6_2_14_F' => $this->input->post('Q6_2_14_F'),
            'Q6_2_14_G' => $this->input->post('Q6_2_14_G'),
            'Q6_2_14_H' => $this->input->post('Q6_2_14_H'),
            'Q6_2_14_I' => $this->input->post('Q6_2_14_I'),
            'Q6_2_14_J' => $this->input->post('Q6_2_14_J'),
            'Q6_2_14_K' => $this->input->post('Q6_2_14_K'),
            'Q6_2_14_K_OTHER' => $this->input->post('Q6_2_14_K_OTHER'),
            'Q6_2_15' => $this->input->post('Q6_2_15'),
            'Q6_2_16' => $this->input->post('Q6_2_16'),
            'Q6_2_17_M' => $this->input->post('Q6_2_17_M'),
            'Q6_2_17_1' => $this->input->post('Q6_2_17_1'),
            'Q6_2_18' => $this->input->post('Q6_2_18'),
            'Q7_1_1' => $this->input->post('Q7_1_1'),
            'Q7_1_2_D' => $this->input->post('Q7_1_2_D'),
            'Q7_1_3' => $this->input->post('Q7_1_3'),
            'Q7_1_4' => $this->input->post('Q7_1_4'),
            'Q7_1_5' => $this->input->post('Q7_1_5'),
            'Q7_1_6' => $this->input->post('Q7_1_6'),
            'Q7_1_7' => $this->input->post('Q7_1_7'),
            'Q7_2_1' => $this->input->post('Q7_2_1'),
            'Q7_2_2' => $this->input->post('Q7_2_2'),
            'Q7_2_2_OTHER' => $this->input->post('Q7_2_2_OTHER'),
            'Q7_2_3_D' => $this->input->post('Q7_2_3_D'),
            'Q7_2_4' => $this->input->post('Q7_2_4'),
            'Q7_2_4_OTHER' => $this->input->post('Q7_2_4_OTHER'),
            'Q7_2_5' => $this->input->post('Q7_2_5'),
            'Q7_2_5A' => $this->input->post('Q7_2_5A'),
            'Q7_2_6' => $this->input->post('Q7_2_6'),
            'Q7_2_6_1' => $this->input->post('Q7_2_6_1'),
            'Q7_2_7' => $this->input->post('Q7_2_7'),
            'Q7_2_8_A' => $this->input->post('Q7_2_8_A'),
            'Q7_2_8_B' => $this->input->post('Q7_2_8_B'),
            'Q7_2_8_C' => $this->input->post('Q7_2_8_C'),
            'Q7_2_8_D' => $this->input->post('Q7_2_8_D'),
            'Q7_2_8_E' => $this->input->post('Q7_2_8_E'),
            'Q7_2_8_F' => $this->input->post('Q7_2_8_F'),
            'Q7_2_8_F_OTHER' => $this->input->post('Q7_2_8_F_OTHER'),
            'Q7_2_9' => $this->input->post('Q7_2_9'),
            'Q7_2_10' => $this->input->post('Q7_2_10'),
            'Q7_2_11' => $this->input->post('Q7_2_11'),
            'Q7_2_12' => $this->input->post('Q7_2_12'),
            'Q7_2_13' => $this->input->post('Q7_2_13'),
            'Q7_2_14_D' => $this->input->post('Q7_2_14_D'),
            'Q7_3_1_A' => $this->input->post('Q7_3_1_A'),
            'Q7_3_1_B' => $this->input->post('Q7_3_1_B'),
            'Q7_3_1_C' => $this->input->post('Q7_3_1_C'),
            'Q7_3_1_D' => $this->input->post('Q7_3_1_D'),
            'Q7_3_1_E' => $this->input->post('Q7_3_1_E'),
            'Q7_3_1_F' => $this->input->post('Q7_3_1_F'),
            'Q7_3_1_F_OTHER' => $this->input->post('Q7_3_1_F_OTHER'),
            'Q7_3_2_Y' => $this->input->post('Q7_3_2_Y'),
            'Q7_3_2_M' => $this->input->post('Q7_3_2_M'),
            'Q7_3_3' => $this->input->post('Q7_3_3'),
            'Q7_3_4_Y' => $this->input->post('Q7_3_4_Y'),
            'Q7_3_4_M' => $this->input->post('Q7_3_4_M'),
            'Q7_3_5' => $this->input->post('Q7_3_5'),
            'Q7_3_6' => $this->input->post('Q7_3_6'),
            'Q7_3_6_OTHER' => $this->input->post('Q7_3_6_OTHER'),
            'Q7_3_7' => $this->input->post('Q7_3_7'),
            'Q7_3_8_A' => $this->input->post('Q7_3_8_A'),
            'Q7_3_8_B' => $this->input->post('Q7_3_8_B'),
            'Q7_3_8_C' => $this->input->post('Q7_3_8_C'),
            'Q7_3_8_D' => $this->input->post('Q7_3_8_D'),
            'Q7_3_8_E' => $this->input->post('Q7_3_8_E'),
            'Q7_3_8_F' => $this->input->post('Q7_3_8_F'),
            'Q7_3_8_G' => $this->input->post('Q7_3_8_G'),
            'Q7_3_8_G_OTHER' => $this->input->post('Q7_3_8_G_OTHER'),
            'Q7_4_1' => $this->input->post('Q7_4_1'),
            'Q7_4_2_M' => $this->input->post('Q7_4_2_M'),
            'Q7_4_2_D' => $this->input->post('Q7_4_2_D'),
            'Q7_4_3' => $this->input->post('Q7_4_3'),
            'Q7_4_4' => $this->input->post('Q7_4_4'),
            'Q7_4_5' => $this->input->post('Q7_4_5'),
            'Q7_4_6_M' => $this->input->post('Q7_4_6_M'),
            'Q7_4_6_D' => $this->input->post('Q7_4_6_D'),
            'Q7_5_1' => $this->input->post('Q7_5_1'),
            'Q7_5_2_M' => $this->input->post('Q7_5_2_M'),
            'Q7_5_2_D' => $this->input->post('Q7_5_2_D'),
            'Q7_5_3' => $this->input->post('Q7_5_3'),
            'Q7_5_4_D' => $this->input->post('Q7_5_4_D'),
            'Q7_5_5' => $this->input->post('Q7_5_5'),
            'Q7_6_1' => $this->input->post('Q7_6_1'),
            'Q7_6_2_A' => $this->input->post('Q7_6_2_A'),
            'Q7_6_2_B' => $this->input->post('Q7_6_2_B'),
            'Q7_6_2_C' => $this->input->post('Q7_6_2_C'),
            'Q7_6_2_D' => $this->input->post('Q7_6_2_D'),
            'Q7_6_2_E' => $this->input->post('Q7_6_2_E'),
            'Q7_6_2_F' => $this->input->post('Q7_6_2_F'),
            'Q7_6_2_G' => $this->input->post('Q7_6_2_G'),
            'Q7_6_2_G_OTHER' => $this->input->post('Q7_6_2_G_OTHER'),
            'Q7_6_3_M' => $this->input->post('Q7_6_3_M'),
            'Q7_6_3_D' => $this->input->post('Q7_6_3_D'),
            'Q7_6_4' => $this->input->post('Q7_6_4'),
            'Q7_6_4_OTHER' => $this->input->post('Q7_6_4_OTHER'),
            'Q7_6_5' => $this->input->post('Q7_6_5'),
            'Q7_6_6_M' => $this->input->post('Q7_6_6_M'),
            'Q7_6_6_D' => $this->input->post('Q7_6_6_D'),
            'Q7_6_7' => $this->input->post('Q7_6_7'),
            'Q7_6_8' => $this->input->post('Q7_6_8'),
            'Q7_7_1' => $this->input->post('Q7_7_1'),
            'Q7_7_2_M' => $this->input->post('Q7_7_2_M'),
            'Q7_7_2_D' => $this->input->post('Q7_7_2_D'),
            'Q7_7_3' => $this->input->post('Q7_7_3'),
            'Q7_7_4' => $this->input->post('Q7_7_4'),
            'Q7_7_5' => $this->input->post('Q7_7_5'),
            'Q7_8_1' => $this->input->post('Q7_8_1'),
            'Q7_8_2_M' => $this->input->post('Q7_8_2_M'),
            'Q7_8_2_D' => $this->input->post('Q7_8_2_D'),
            'Q7_8_3' => $this->input->post('Q7_8_3'),
            'Q7_8_4' => $this->input->post('Q7_8_4'),
            'Q7_8_5_M' => $this->input->post('Q7_8_5_M'),
            'Q7_8_5_D' => $this->input->post('Q7_8_5_D'),
            'Q7_8_6' => $this->input->post('Q7_8_6'),
            'Q7_8_7_M' => $this->input->post('Q7_8_7_M'),
            'Q7_8_7_D' => $this->input->post('Q7_8_7_D'),
            'Q7_8_8' => $this->input->post('Q7_8_8'),
            'Q7_8_9' => $this->input->post('Q7_8_9'),
            'Q7_8_10' => $this->input->post('Q7_8_10'),
            'Q7_8_11' => $this->input->post('Q7_8_11'),
            'Q7_8_12' => $this->input->post('Q7_8_12'),
            'Q7_8_13' => $this->input->post('Q7_8_13'),
            'Q7_8_14' => $this->input->post('Q7_8_14'),
            'Q7_9_1' => $this->input->post('Q7_9_1'),
            'Q7_9_2_D' => $this->input->post('Q7_9_2_D'),
            'Q7_9_3' => $this->input->post('Q7_9_3'),
            'Q7_9_3_OTHER' => $this->input->post('Q7_9_3_OTHER'),
            'Q7_9_4' => $this->input->post('Q7_9_4'),
            'Q7_9_5' => $this->input->post('Q7_9_5'),
            'Q7_9_6' => $this->input->post('Q7_9_6'),
            'Q7_9_7' => $this->input->post('Q7_9_7'),
            'Q7_9_8' => $this->input->post('Q7_9_8'),
            'Q7_9_9' => $this->input->post('Q7_9_9'),
            'Q7_10_1' => $this->input->post('Q7_10_1'),
            'Q7_10_2_D' => $this->input->post('Q7_10_2_D'),
            'Q7_10_3' => $this->input->post('Q7_10_3'),
            'Q7_10_4_N' => $this->input->post('Q7_10_4_N'),
            'Q7_10_5' => $this->input->post('Q7_10_5'),
            'Q7_10_6' => $this->input->post('Q7_10_6'),
            'Q7_10_7' => $this->input->post('Q7_10_7'),
            'Q7_10_8' => $this->input->post('Q7_10_8'),
            'Q7_10_9' => $this->input->post('Q7_10_9'),
            'Q7_11_1' => $this->input->post('Q7_11_1'),
            'Q7_11_2_D' => $this->input->post('Q7_11_2_D'),
            'Q7_11_3_N' => $this->input->post('Q7_11_3_N'),
            'Q7_11_4' => $this->input->post('Q7_11_4'),
            'Q7_11_4_OTHER' => $this->input->post('Q7_11_4_OTHER'),
            'Q7_12_1' => $this->input->post('Q7_12_1'),
            'Q7_12_2' => $this->input->post('Q7_12_2'),
            'Q7_12_2_OTHER' => $this->input->post('Q7_12_2_OTHER'),
            'Q7_12_3_M' => $this->input->post('Q7_12_3_M'),
            'Q7_12_3_D' => $this->input->post('Q7_12_3_D'),
            'Q7_12_4' => $this->input->post('Q7_12_4'),
            'Q7_12_4_OTHER' => $this->input->post('Q7_12_4_OTHER'),
            'Q7_12_5' => $this->input->post('Q7_12_5'),
            'Q7_12_6' => $this->input->post('Q7_12_6'),
            'Q7_12_7' => $this->input->post('Q7_12_7'),
            'Q7_12_8' => $this->input->post('Q7_12_8'),
            'Q7_12_8_OTHER' => $this->input->post('Q7_12_8_OTHER'),
            'Q7_13_1' => $this->input->post('Q7_13_1'),
            'Q7_13_2_M' => $this->input->post('Q7_13_2_M'),
            'Q7_13_2_D' => $this->input->post('Q7_13_2_D'),
            'Q7_13_3' => $this->input->post('Q7_13_3'),
            'Q7_13_4' => $this->input->post('Q7_13_4'),
            'Q7_13_5' => $this->input->post('Q7_13_5'),
            'Q7_13_6_M' => $this->input->post('Q7_13_6_M'),
            'Q7_13_6_D' => $this->input->post('Q7_13_6_D'),
            'Q7_14_1' => $this->input->post('Q7_14_1'),
            'Q7_14_2_M' => $this->input->post('Q7_14_2_M'),
            'Q7_14_2_D' => $this->input->post('Q7_14_2_D'),
            'Q7_14_3' => $this->input->post('Q7_14_3'),
            'Q7_14_4_M' => $this->input->post('Q7_14_4_M'),
            'Q7_14_4_D' => $this->input->post('Q7_14_4_D'),
            'Q7_14_5' => $this->input->post('Q7_14_5'),
            'Q7_15_1' => $this->input->post('Q7_15_1'),
            'Q7_15_1' => $this->input->post('Q7_15_1'),
            'Q7_15_2' => $this->input->post('Q7_15_2'),
            'Q7_15_2_OTHER' => $this->input->post('Q7_15_2_OTHER'),
            'Q7_15_3' => $this->input->post('Q7_15_3'),
            'Q7_15_4_M' => $this->input->post('Q7_15_4_M'),
            'Q7_15_4_D' => $this->input->post('Q7_15_4_D'),
            'Q7_16_1' => $this->input->post('Q7_16_1'),
            'Q7_16_2_M' => $this->input->post('Q7_16_2_M'),
            'Q7_16_2_D' => $this->input->post('Q7_16_2_D'),
            'Q7_16_3' => $this->input->post('Q7_16_3'),
            'Q7_16_4' => $this->input->post('Q7_16_4'),
            'Q7_17_1' => $this->input->post('Q7_17_1'),
            'Q7_17_2_D' => $this->input->post('Q7_17_2_D'),
            'Q7_17_3' => $this->input->post('Q7_17_3'),
            'Q7_17_4_M' => $this->input->post('Q7_17_4_M'),
            'Q7_17_4_D' => $this->input->post('Q7_17_4_D'),
            'Q7_17_5' => $this->input->post('Q7_17_5'),
            'Q7_17_6' => $this->input->post('Q7_17_6'),
            'Q7_18_1' => $this->input->post('Q7_18_1'),
            'Q7_18_2_D' => $this->input->post('Q7_18_2_D'),
            'Q7_18_2_H' => $this->input->post('Q7_18_2_H'),
            'Q7_18_3' => $this->input->post('Q7_18_3'),
            'Q7_18_4' => $this->input->post('Q7_18_4'),
            'Q7_19_0' => $this->input->post('Q7_19_0'),
            'Q7_19_1_M' => $this->input->post('Q7_19_1_M'),
            'Q7_19_1_D' => $this->input->post('Q7_19_1_D'),
            'Q7_19_2' => $this->input->post('Q7_19_2'),
            'Q7_19_3_M' => $this->input->post('Q7_19_3_M'),
            'Q7_19_3_D' => $this->input->post('Q7_19_3_D'),
            'Q7_19_3_H' => $this->input->post('Q7_19_3_H'),
            'Q7_19_4' => $this->input->post('Q7_19_4'),
            'Q7_19_5_N' => $this->input->post('Q7_19_5_N'),
            'Q7_19_6' => $this->input->post('Q7_19_6'),
            'Q7_19_7' => $this->input->post('Q7_19_7'),
            'Q7_19_8' => $this->input->post('Q7_19_8'),
            'Q7_19_9' => $this->input->post('Q7_19_9'),
            'Q7_19_10_D' => $this->input->post('Q7_19_10_D'),
            'Q7_19_11' => $this->input->post('Q7_19_11'),
            'Q7_19_12_M' => $this->input->post('Q7_19_12_M'),
            'Q7_19_12_D' => $this->input->post('Q7_19_12_D'),
            'Q7_20_1' => $this->input->post('Q7_20_1'),
            'Q7_20_2' => $this->input->post('Q7_20_2'),
            'Q7_20_2_OTHER' => $this->input->post('Q7_20_2_OTHER'),
            'Q7_20_3_M' => $this->input->post('Q7_20_3_M'),
            'Q7_20_3_D' => $this->input->post('Q7_20_3_D'),
            'Q7_20_4' => $this->input->post('Q7_20_4'),
            'Q7_21_1' => $this->input->post('Q7_21_1'),
            'Q7_21_2' => $this->input->post('Q7_21_2'),
            'Q7_21_3_D' => $this->input->post('Q7_21_3_D'),
            'Q7_22_1' => $this->input->post('Q7_22_1'),
            'Q7_22_2' => $this->input->post('Q7_22_2'),
            'Q7_22_3_M' => $this->input->post('Q7_22_3_M'),
            'Q7_22_3_D' => $this->input->post('Q7_22_3_D'),
            'Q7_22_4' => $this->input->post('Q7_22_4'),
            'Q7_22_5_A' => $this->input->post('Q7_22_5_A'),
            'Q7_22_5_B' => $this->input->post('Q7_22_5_B'),
            'Q7_22_5_C' => $this->input->post('Q7_22_5_C'),
            'Q7_22_5_D' => $this->input->post('Q7_22_5_D'),
            'Q7_22_5_D_OTHER' => $this->input->post('Q7_22_5_D_OTHER'),
            'Q7_22_6' => $this->input->post('Q7_22_6'),
            'Q7_23_1' => $this->input->post('Q7_23_1'),
            'Q7_23_2_D' => $this->input->post('Q7_23_2_D'),
            'Q7_23_3_NAME' => $this->input->post('Q7_23_3_NAME'),
            'Q8_1_1_1' => $this->input->post('Q8_1_1_1'),
            'Q8_1_1_2' => $this->input->post('Q8_1_1_2'),
            'Q8_1_1_3' => $this->input->post('Q8_1_1_3'),
            'Q8_1_1_4' => $this->input->post('Q8_1_1_4'),
            'Q8_1_1_5' => $this->input->post('Q8_1_1_5'),
            'Q8_1_1_6' => $this->input->post('Q8_1_1_6'),
            'Q8_1_1_7' => $this->input->post('Q8_1_1_7'),
            'Q8_1_2_1_N' => $this->input->post('Q8_1_2_1_N'),
            'Q8_1_2_2_N' => $this->input->post('Q8_1_2_2_N'),
            'Q8_1_2_3_N' => $this->input->post('Q8_1_2_3_N'),
            'Q8_1_2_4_N' => $this->input->post('Q8_1_2_4_N'),
            'Q8_1_2_5_N' => $this->input->post('Q8_1_2_5_N'),
            'Q8_1_2_6_N' => $this->input->post('Q8_1_2_6_N'),
            'Q8_1_2_7_N' => $this->input->post('Q8_1_2_7_N'),
            'Q8_1_3_1_Y' => $this->input->post('Q8_1_3_1_Y'),
            'Q8_1_3_1_M' => $this->input->post('Q8_1_3_1_M'),
            'Q8_1_3_2_Y' => $this->input->post('Q8_1_3_2_Y'),
            'Q8_1_3_2_M' => $this->input->post('Q8_1_3_2_M'),
            'Q8_1_3_3_Y' => $this->input->post('Q8_1_3_3_Y'),
            'Q8_1_3_3_M' => $this->input->post('Q8_1_3_3_M'),
            'Q8_1_3_4_Y' => $this->input->post('Q8_1_3_4_Y'),
            'Q8_1_3_4_M' => $this->input->post('Q8_1_3_4_M'),
            'Q8_1_3_5_Y' => $this->input->post('Q8_1_3_5_Y'),
            'Q8_1_3_5_M' => $this->input->post('Q8_1_3_5_M'),
            'Q8_1_3_6_Y' => $this->input->post('Q8_1_3_6_Y'),
            'Q8_1_3_6_M' => $this->input->post('Q8_1_3_6_M'),
            'Q8_1_3_7_Y' => $this->input->post('Q8_1_3_7_Y'),
            'Q8_1_3_7_M' => $this->input->post('Q8_1_3_7_M'),
            'Q8_1_4_1_Y' => $this->input->post('Q8_1_4_1_Y'),
            'Q8_1_4_1_M' => $this->input->post('Q8_1_4_1_M'),
            'Q8_1_4_2_Y' => $this->input->post('Q8_1_4_2_Y'),
            'Q8_1_4_2_M' => $this->input->post('Q8_1_4_2_M'),
            'Q8_1_4_3_Y' => $this->input->post('Q8_1_4_3_Y'),
            'Q8_1_4_3_M' => $this->input->post('Q8_1_4_3_M'),
            'Q8_1_4_4_Y' => $this->input->post('Q8_1_4_4_Y'),
            'Q8_1_4_4_M' => $this->input->post('Q8_1_4_4_M'),
            'Q8_1_4_5_Y' => $this->input->post('Q8_1_4_5_Y'),
            'Q8_1_4_5_M' => $this->input->post('Q8_1_4_5_M'),
            'Q8_1_4_6_Y' => $this->input->post('Q8_1_4_6_Y'),
            'Q8_1_4_6_M' => $this->input->post('Q8_1_4_6_M'),
            'Q8_1_4_7_Y' => $this->input->post('Q8_1_4_7_Y'),
            'Q8_1_4_7_M' => $this->input->post('Q8_1_4_7_M'),
            'Q8_2_1_A' => $this->input->post('Q8_2_1_A'),
            'Q8_2_1_B' => $this->input->post('Q8_2_1_B'),
            'Q8_2_1_C' => $this->input->post('Q8_2_1_C'),
            'Q8_2_1_D' => $this->input->post('Q8_2_1_D'),
            'Q8_2_1_E' => $this->input->post('Q8_2_1_E'),
            'Q8_2_1_F' => $this->input->post('Q8_2_1_F'),
            'Q8_2_1_G' => $this->input->post('Q8_2_1_G'),
            'Q8_2_1_H' => $this->input->post('Q8_2_1_H'),
            'Q8_2_1_I' => $this->input->post('Q8_2_1_I'),
            'Q8_2_1_J' => $this->input->post('Q8_2_1_J'),
            'Q8_2_1_J_OTHER' => $this->input->post('Q8_2_1_J_OTHER'),
            'Q8_2_2_Y' => $this->input->post('Q8_2_2_Y'),
            'Q8_2_2_M' => $this->input->post('Q8_2_2_M'),
            'Q8_2_3' => $this->input->post('Q8_2_3'),
            'Q8_2_3_OTHER' => $this->input->post('Q8_2_3_OTHER'),
            'Q9_0_A' => $this->input->post('Q9_0_A'),
            'Q9_0_A_D' => $this->input->post('Q9_0_A_D'),
            'Q9_0_B' => $this->input->post('Q9_0_B'),
            'Q9_0_B_D' => $this->input->post('Q9_0_B_D'),
            'Q9_0_C' => $this->input->post('Q9_0_C'),
            'Q9_0_C_D' => $this->input->post('Q9_0_C_D'),
            'Q9_0_D' => $this->input->post('Q9_0_D'),
            'Q9_0_D_D' => $this->input->post('Q9_0_D_D'),
            'Q9_0_E' => $this->input->post('Q9_0_E'),
            'Q9_0_E_D' => $this->input->post('Q9_0_E_D'),
            'Q9_0_F' => $this->input->post('Q9_0_F'),
            'Q9_0_F_OTHER' => $this->input->post('Q9_0_F_OTHER'),
            'Q9_0_F_D' => $this->input->post('Q9_0_F_D'),
            'Q9_1' => $this->input->post('Q9_1'),
            'Q9_1_1_AP' => $this->input->post('Q9_1_1_AP'),
            'Q9_1_1_AP_OTHER' => $this->input->post('Q9_1_1_AP_OTHER'),
            'Q9_1_1_BP' => $this->input->post('Q9_1_1_BP'),
            'Q9_1_1_BP_OTHER' => $this->input->post('Q9_1_1_BP_OTHER'),
            'Q9_1_1_CP' => $this->input->post('Q9_1_1_CP'),
            'Q9_1_1_CP_OTHER' => $this->input->post('Q9_1_1_CP_OTHER'),
            'Q9_1_1_DP' => $this->input->post('Q9_1_1_DP'),
            'Q9_1_1_DP_OTHER' => $this->input->post('Q9_1_1_DP_OTHER'),
            'Q9_1_2_A' => $this->input->post('Q9_1_2_A'),
            'Q9_1_2_B' => $this->input->post('Q9_1_2_B'),
            'Q9_1_2_C' => $this->input->post('Q9_1_2_C'),
            'Q9_1_2_D' => $this->input->post('Q9_1_2_D'),
            'Q9_1_2_E' => $this->input->post('Q9_1_2_E'),
            'Q9_1_2_F' => $this->input->post('Q9_1_2_F'),
            'Q9_1_2_G' => $this->input->post('Q9_1_2_G'),
            'Q9_1_2_H' => $this->input->post('Q9_1_2_H'),
            'Q9_1_2_I' => $this->input->post('Q9_1_2_I'),
            'Q9_1_2_J' => $this->input->post('Q9_1_2_J'),
            'Q9_1_2_K' => $this->input->post('Q9_1_2_K'),
            'Q9_1_2_K_OTHER' => $this->input->post('Q9_1_2_K_OTHER'),
            'Q9_1_2_L' => $this->input->post('Q9_1_2_L'),
            'Q9_1_3_N' => $this->input->post('Q9_1_3_N'),
            'Q9_1_4_A' => $this->input->post('Q9_1_4_A'),
            'Q9_1_4_B' => $this->input->post('Q9_1_4_B'),
            'Q9_1_4_C' => $this->input->post('Q9_1_4_C'),
            'Q9_1_4_D' => $this->input->post('Q9_1_4_D'),
            'Q9_1_4_E' => $this->input->post('Q9_1_4_E'),
            'Q9_1_4_F' => $this->input->post('Q9_1_4_F'),
            'Q9_1_4_G' => $this->input->post('Q9_1_4_G'),
            'Q9_1_4_G_OTHER' => $this->input->post('Q9_1_4_G_OTHER'),
            'Q9_1_5' => $this->input->post('Q9_1_5'),
            'Q9_2' => $this->input->post('Q9_2'),
            'Q9_2_1_1_HCODE' => $this->input->post('Q9_2_1_1_HCODE'),
            'Q9_2_1_1_DATE' => $Q9_2_1_1_DATE,
            'Q9_2_1_1_CAUSE' => $this->input->post('Q9_2_1_1_CAUSE'),
            'Q9_2_1_2_HCODE' => $this->input->post('Q9_2_1_2_HCODE'),
            'Q9_2_1_2_DATE' => $Q9_2_1_2_DATE,
            'Q9_2_1_2_CAUSE' => $this->input->post('Q9_2_1_2_CAUSE'),
            'Q9_2_1_3_HCODE' => $this->input->post('Q9_2_1_3_HCODE'),
            'Q9_2_1_3_DATE' => $Q9_2_1_3_DATE,
            'Q9_2_1_3_CAUSE' => $this->input->post('Q9_2_1_3_CAUSE'),
            'Q9_2_2' => $this->input->post('Q9_2_2'),
            'Q9_2_3_A' => $this->input->post('Q9_2_3_A'),
            'Q9_2_3_B' => $this->input->post('Q9_2_3_B'),
            'Q9_2_3_C' => $this->input->post('Q9_2_3_C'),
            'Q9_2_3_D' => $this->input->post('Q9_2_3_D'),
            'Q9_2_4' => $this->input->post('Q9_2_4'),
            'Q9_2_5' => $this->input->post('Q9_2_5'),
            'Q9_2_6' => $this->input->post('Q9_2_6'),
            'Q9_2_7' => $this->input->post('Q9_2_7'),
            'Q9_3' => $this->input->post('Q9_3'),
            'Q9_3_OTHER' => $this->input->post('Q9_3_OTHER'),
            'Q9_3_1_HCODE' => $this->input->post('Q9_3_1_HCODE'),
            'Q9_3_1_ADDRESS' => $this->input->post('Q9_3_1_ADDRESS'),
            'Q9_3_2' => $this->input->post('Q9_3_2'),
            'Q9_3_3' => $this->input->post('Q9_3_3'),
            'Q9_3_3_OTHER' => $this->input->post('Q9_3_3_OTHER'),
            'Q9_3_4_CAUSE' => $this->input->post('Q9_3_4_CAUSE'),
            'Q10_1' => $this->input->post('Q10_1'),
            'Q10_1_1' => $this->input->post('Q10_1_1'),
            'Q10_1_1_VDATE' => $Q10_1_1_VDATE,
            'Q10_1_1_HIGH' => $this->input->post('Q10_1_1_HIGH'),
            'Q10_1_1_WEIG' => $this->input->post('Q10_1_1_WEIG'),
            'Q10_1_1_SYMP' => $this->input->post('Q10_1_1_SYMP'),
            'Q10_1_1_DIAG' => $this->input->post('Q10_1_1_DIAG'),
            'Q10_1_1_TRET' => $this->input->post('Q10_1_1_TRET'),
            'Q10_2' => $this->input->post('Q10_2'),
            'Q10_2_1' => $this->input->post('Q10_2_1'),
            'Q10_2_2_ICAUSE' => $this->input->post('Q10_2_2_ICAUSE'),
            'Q10_2_2_ICODE' => $this->input->post('Q10_2_2_ICODE'),
            'Q10_2_2_ACAUSE' => $this->input->post('Q10_2_2_ACAUSE'),
            'Q10_2_2_ACODE' => $this->input->post('Q10_2_2_ACODE'),
            'Q10_2_2_UCAUSE' => $this->input->post('Q10_2_2_UCAUSE'),
            'Q10_2_2_UCODE' => $this->input->post('Q10_2_2_UCODE'),
            'Q10_2_2_CCAUSE' => $this->input->post('Q10_2_2_CCAUSE'),
            'Q10_2_2_CCODE' => $this->input->post('Q10_2_2_CCODE'),
            'Q10_3_DR' => $this->input->post('Q10_3_DR'),
            'Q10_3_1_DRS' => $this->input->post('Q10_3_1_DRS'),
            'Q10_3_2_DRD' => $Q10_3_2_DRD,
            'Q10_3_3_DRN' => $this->input->post('Q10_3_3_DRN'),
            'Q11_INTERVIEW' => $this->input->post('Q11_INTERVIEW'),
            'Q11_SO' => $this->input->post('Q11_SO'),
            'Q11_CSQ' => $this->input->post('Q11_CSQ'),
            'Q11_AOC' => $this->input->post('Q11_AOC'),
            'Q11_DOE' => $Q11_DOE,
            'Q11_SUP_CODE' => $this->input->post('Q11_SUP_CODE'),
            'inv_status' => $this->input->post('inv_status'),
            'updateBy' => $this->vendorId,
            'updatedOn' => date('Y-m-d H:i:s'),
            'VA_TYPE' => 1
        );

        $member_death_extended_info = array(
            'member_death_id' => $member_death_table_id,
            'Q7_24_1_A' => $this->input->post('Q7_24_1_A'),
            'Q7_24_2_A' => $this->input->post('Q7_24_2_A'),
            'Q7_24_3_A' => $this->input->post('Q7_24_3_A'),
            'Q7_24_4_A' => $this->input->post('Q7_24_4_A'),
            'Q7_24_5_A' => $this->input->post('Q7_24_5_A'),
            'Q7_24_6_A' => $this->input->post('Q7_24_6_A'),
            'Q7_24_7_A' => $this->input->post('Q7_24_7_A'),
            'Q7_24_8_A' => $this->input->post('Q7_24_8_A'),
            'I_A' => $this->input->post('I_A'),
            'I_B' => $this->input->post('I_B'),
            'I_C' => $this->input->post('I_C'),
            'I_D' => $this->input->post('I_D'),
            'II_A' => $this->input->post('II_A'),
            'II_B' => $this->input->post('II_B'),
            'verbal_autopsy_specialist_name' => $this->input->post('verbal_autopsy_specialist_name')
        );

        $this->db->trans_start();

        $result = $this->modelName->updateInfo($IDInfo, $member_death_table_id, $this->config->item('deathTable'));

        $this->db->from($this->config->item('deathTableExtended'));
        $this->db->where('member_death_id', $member_death_table_id);
        $query = $this->db->get();
        $deathTableExtended_existence = $query->row();

        if ($deathTableExtended_existence == true) {
            $result_2 = $this->modelName->updateExtendedTable($member_death_extended_info, $member_death_table_id, $this->config->item('deathTableExtended'));
        } else {
            $result_2 = $this->modelName->InsertInfo($member_death_extended_info, $this->config->item('deathTableExtended'));
        }

        $this->db->trans_complete();

        if ($result == true && $result_2 == true) {
            $this->session->set_flashdata('success', $this->pageShortName . ' updated successfully');
        } else {
            $this->session->set_flashdata('error', $this->pageShortName . ' update failed');
        }

        redirect($this->controller . '/editOld/' . $member_death_table_id . '?household_master_id=' . $household_master_id . '&&baseID=' . $baseID);
    }

    function editNeonatal($id = NULL) {
        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id = $this->input->get('household_master_id', TRUE);



        if ($id == null) {
            $this->session->set_flashdata('error', "Someting went wrong!! Please try Again");
            redirect($this->controller . '?baseID=' . $baseID);
        }

        $editPerm = $this->getPermission($baseID, $this->role, 'edit');
        if ($editPerm == 0) {
            $this->session->set_flashdata('error', "Unauthorized Access");
            redirect($this->controller . '?baseID=' . $baseID);
        }

        //dynamic options end

        $data['VA_Relation'] = $this->modelName->getLookUpList($this->config->item('VA_Relation'));
        $data['va_yes_no'] = $this->modelName->getLookUpList($this->config->item('va_yes_no'));

        //$data['va_gender'] = $this->modelName->getLookUpList($this->config->item('va_gender'));
        // $data['VA_Marital_Status'] = $this->modelName->getLookUpList($this->config->item('VA_Marital_Status'));

        $data['va_gender'] = $this->masterModel->getLookUpList($this->config->item('membersextype'));
        $data['VA_Marital_Status'] = $this->masterModel->getLookUpList($this->config->item('maritalstatustyp'));

        $data['VA_Yes_No_Reluctant_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Yes_No_Reluctant_Unknown'));
        $data['VA_Education_Institute_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Education_Institute_Type'));

        $data['VA_Occupation_Type'] = $this->masterModel->getLookUpList($this->config->item('occupationtyp'));

        //$data['VA_Occupation_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Occupation_Type'));

        $data['VA_INJURY_OR_ACCIDENT_TYPE'] = $this->modelName->getLookUpList($this->config->item('VA_INJURY_OR_ACCIDENT_TYPE'));
        $data['VA_Road_OR_Water_Vehicle_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Road_OR_Water_Vehicle_Type'));
        $data['VA_Medicine_Or_Poison_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Medicine_Or_Poison_Type'));
        $data['VA_Yes_No_Reluctant_NotApplicable_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Yes_No_Reluctant_NotApplicable_Unknown'));
        $data['VA_Death_When'] = $this->modelName->getLookUpList($this->config->item('VA_Death_When'));
        $data['VA_Delivery_Result'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Result'));
        $data['VA_Delivery_Durability'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Durability'));
        $data['VA_Delivery_Place'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Place'));
        $data['VA_Delivery_Method'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Method'));
        $data['VA_Fever_Dimension'] = $this->modelName->getLookUpList($this->config->item('VA_Fever_Dimension'));
        $data['VA_Fever_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Fever_Type'));
        $data['VA_Body_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Body_Where'));
        $data['VA_Grain_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Grain_Type'));
        $data['VA_Arsenic_Identification_Hospital'] = $this->modelName->getLookUpList($this->config->item('VA_Arsenic_Identification_Hospital'));
        $data['VA_Swollen_Body_Part'] = $this->modelName->getLookUpList($this->config->item('VA_Swollen_Body_Part'));
        $data['VA_Glands_Swollen_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Glands_Swollen_Where'));
        $data['VA_Shortness_of_breath_Body_Condition'] = $this->modelName->getLookUpList($this->config->item('VA_Shortness_of_breath_Body_Condition'));
        $data['VA_Yes_No_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Yes_No_Unknown'));
        $data['VA_Chest_Pain_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Where'));
        $data['VA_Chest_Pain_Continuous'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Continuous'));
        $data['VA_Chest_Pain_Suddenly'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Suddenly'));
        $data['VA_Chest_Pain_Stability'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Stability'));
        $data['VA_Stool_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Stool_Type'));
        $data['VA_Diarrhea_Continuous'] = $this->modelName->getLookUpList($this->config->item('VA_Diarrhea_Continuous'));
        $data['VA_Vomit_Looks_Like'] = $this->modelName->getLookUpList($this->config->item('VA_Vomit_Looks_Like'));
        $data['VA_Abdominal_Pain_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Abdominal_Pain_Type'));
        $data['VA_Abdominal_Pain_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Abdominal_Pain_Where'));
        $data['VA_Pain_Dimension'] = $this->modelName->getLookUpList($this->config->item('VA_Pain_Dimension'));
        $data['VA_Abdominal_Pain_Stool_Look_Like'] = $this->modelName->getLookUpList($this->config->item('VA_Abdominal_Pain_Stool_Look_Like'));
        $data['VA_ABDOMINAL_DISTENSION_QUICK'] = $this->modelName->getLookUpList($this->config->item('VA_ABDOMINAL_DISTENSION_QUICK'));
        $data['VA_MASS_in_Abdomen_Strong_Wheel_Position'] = $this->modelName->getLookUpList($this->config->item('VA_MASS_in_Abdomen_Strong_Wheel_Position'));
        $data['VA_Headache_Quick_Or_Slow'] = $this->modelName->getLookUpList($this->config->item('VA_Headache_Quick_Or_Slow'));
        $data['VA_Suddenly_Slowly_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Suddenly_Slowly_Unknown'));
        $data['VA_Status_Before_Swoon'] = $this->modelName->getLookUpList($this->config->item('VA_Status_Before_Swoon'));
        $data['VA_Paralyzed_Body_Part'] = $this->modelName->getLookUpList($this->config->item('VA_Paralyzed_Body_Part'));
        $data['VA_Paralyzed_When'] = $this->modelName->getLookUpList($this->config->item('VA_Paralyzed_When'));
        $data['VA_Urine_Color'] = $this->modelName->getLookUpList($this->config->item('VA_Urine_Color'));
        $data['VA_Urine_Dimension'] = $this->modelName->getLookUpList($this->config->item('VA_Urine_Dimension'));
        $data['VA_Drug_Collection_Place'] = $this->modelName->getLookUpList($this->config->item('VA_Drug_Collection_Place'));
        $data['VA_Treatment_Provider'] = $this->modelName->getLookUpList($this->config->item('VA_Treatment_Provider'));
        $data['VA_Death_Place'] = $this->modelName->getLookUpList($this->config->item('VA_Death_Place'));
        $data['VA_Reason_Teller'] = $this->modelName->getLookUpList($this->config->item('VA_Reason_Teller'));
        $data['VA_Hospital_List'] = $this->modelName->getLookUpList($this->config->item('VA_Hospital_List'));
        $data['VA_Supervisor_List'] = $this->modelName->getLookUpList($this->config->item('VA_Supervisor_List'));
        $data['VA_Leg_Wound'] = $this->modelName->getLookUpList($this->config->item('VA_Leg_Wound'));
        $data['VA_Weight_Loss_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Weight_Loss_Type'));
        $data['VA_Breathing_Problem_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Breathing_Problem_Type'));
        $data['VA_Daily_Work_Hampered_By_Breathing_Problem'] = $this->modelName->getLookUpList($this->config->item('VA_Daily_Work_Hampered_By_Breathing_Problem'));
        $data['VA_Breathing_Problem_When'] = $this->modelName->getLookUpList($this->config->item('VA_Breathing_Problem_When'));


        $data['VA_Mother_Death_When'] = $this->modelName->getLookUpList($this->config->item('VA_Mother_Death_When'));
        $data['VA_Day_Month_Reluctant_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Day_Month_Reluctant_Unknown'));
        $data['VA_Birth_Order'] = $this->modelName->getLookUpList($this->config->item('VA_Birth_Order'));
        $data['VA_Pregnancy_Ending_Time'] = $this->modelName->getLookUpList($this->config->item('VA_Pregnancy_Ending_Time'));
        $data['VA_Related_To_EDD'] = $this->modelName->getLookUpList($this->config->item('VA_Related_To_EDD'));
        $data['VA_Baby_Movement_Feeling'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Movement_Feeling'));
        $data['VA_Water_Broken'] = $this->modelName->getLookUpList($this->config->item('VA_Water_Broken'));
        $data['VA_Baby_Single_Double'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Single_Double'));
        $data['VA_Baby_Weight'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Weight'));
        $data['VA_Baby_Body_Color'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Body_Color'));
        $data['VA_Pate_Status'] = $this->modelName->getLookUpList($this->config->item('VA_Pate_Status'));
        $data['VA_Frequently_Breathing'] = $this->modelName->getLookUpList($this->config->item('VA_Frequently_Breathing'));
        $data['VA_Baby_Cry'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Cry'));
        $data['VA_Baby_Milk'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Milk'));
        $data['VA_Baby_Drinking_Milk_Shut_Down'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Drinking_Milk_Shut_Down'));
        $data['VA_Diarrhea_Situation'] = $this->modelName->getLookUpList($this->config->item('VA_Diarrhea_Situation'));
        $data['VA_Baby_Vomit_Looks_Like'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Vomit_Looks_Like'));

        $data['verbal_autopsy_specialist_name'] = $this->modelName->getLookUpList($this->config->item('verbal_autopsy_specialist_name'));


        $this->global['menu'] = $this->menuModel->getMenu($this->role);
        $data['userInfo'] = $this->modelName->getListInfo($id, $this->config->item('deathTable'));

        $data['household_member'] = $this->modelName->getMemberMasterPresentListByHouseholdIds($household_master_id);

        $data['intervcode'] = $this->vendorId;



        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'updateNeonatal';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'Edit';


        $this->load->view('includes/header', $this->global);
        $this->load->view($this->controller . '/editNeonatal', $data);
        $this->load->view('includes/footer');
    }

    function test() {
        $data = $this->db->list_fields('member_death');
//        echo '<pre/>';
//        print_r($data);

        $p = "";
        for ($i = 103; $i <= 665; $i++) {
            if ($p == "")
                $p .= "'" . $data[$i] . "'";
            else
                $p .= ",'" . $data[$i] . "'";
        }
        echo $p;
    }

    function updateNeonatal() {

        $this->load->library('form_validation');
        $member_death_table_id = $this->input->post('ID');
        $household_master_id = $this->input->post('household_master_id');
        $baseID = $this->input->get('baseID', TRUE);

        $Q2_2_INTV_DATE = null;

        if (!empty($this->input->post('Q2_2_INTV_DATE'))) {
            $parts = explode('/', $this->input->post('Q2_2_INTV_DATE'));
            $Q2_2_INTV_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q2_3_1ST_INTV_DATE = null;
        if (!empty($this->input->post('Q2_3_1ST_INTV_DATE'))) {
            $parts = explode('/', $this->input->post('Q2_3_1ST_INTV_DATE'));
            $Q2_3_1ST_INTV_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q2_4_2ND_INTV_DATE = null;
        if (!empty($this->input->post('Q2_4_2ND_INTV_DATE'))) {
            $parts = explode('/', $this->input->post('Q2_4_2ND_INTV_DATE'));
            $Q2_4_2ND_INTV_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q3_5_DOB = null;
        if (!empty($this->input->post('Q3_5_DOB'))) {
            $parts = explode('/', $this->input->post('Q3_5_DOB'));
            $Q3_5_DOB = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q3_6_DOD = null;
        if (!empty($this->input->post('Q3_6_DOD'))) {
            $parts = explode('/', $this->input->post('Q3_6_DOD'));
            $Q3_6_DOD = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q3_9_2_DOM = null;
        if (!empty($this->input->post('Q3_9_2_DOM'))) {
            $parts = explode('/', $this->input->post('Q3_9_2_DOM'));
            $Q3_9_2_DOM = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q6_2_4_DATE = null;
        if (!empty($this->input->post('Q6_2_4_DATE'))) {
            $parts = explode('/', $this->input->post('Q6_2_4_DATE'));
            $Q6_2_4_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        $Q8_2_1_DATE_ADMISSION_1 = null;
        if (!empty($this->input->post('Q8_2_1_DATE_ADMISSION_1'))) {
            $parts = explode('/', $this->input->post('Q8_2_1_DATE_ADMISSION_1'));
            $Q8_2_1_DATE_ADMISSION_1 = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        $Q8_2_1_DATE_ADMISSION_2 = null;
        if (!empty($this->input->post('Q8_2_1_DATE_ADMISSION_2'))) {
            $parts = explode('/', $this->input->post('Q8_2_1_DATE_ADMISSION_2'));
            $Q8_2_1_DATE_ADMISSION_2 = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        $Q8_2_1_DATE_ADMISSION_3 = null;
        if (!empty($this->input->post('Q8_2_1_DATE_ADMISSION_3'))) {
            $parts = explode('/', $this->input->post('Q8_2_1_DATE_ADMISSION_3'));
            $Q8_2_1_DATE_ADMISSION_3 = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }


        $Q9_2_VDATE = null;
        if (!empty($this->input->post('Q9_2_VDATE'))) {
            $parts = explode('/', $this->input->post('Q9_2_VDATE'));
            $Q9_2_VDATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        $Q9_9_2 = null;
        if (!empty($this->input->post('Q9_9_2'))) {
            $parts = explode('/', $this->input->post('Q9_9_2'));
            $Q9_9_2 = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }


        $Q10_DOE = null;
        if (!empty($this->input->post('Q10_DOE'))) {
            $parts = explode('/', $this->input->post('Q10_DOE'));
            $Q10_DOE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        $IDInfo = array(
            'Q1_1_N1' => $this->input->post('Q1_1_N1'),
            'Q1_1_N2' => $this->input->post('Q1_1_N2'),
            'Q1_1_N3' => $this->input->post('Q1_1_N3'),
            'Q1_1_R1' => $this->input->post('Q1_1_R1'),
            'Q1_1_R2' => $this->input->post('Q1_1_R2'),
            'Q1_1_R3' => $this->input->post('Q1_1_R3'),
            'Q1_1_P1' => $this->input->post('Q1_1_P1'),
            'Q1_1_P2' => $this->input->post('Q1_1_P2'),
            'Q1_1_P3' => $this->input->post('Q1_1_P3'),
            'Q1_1_R1_other' => $this->input->post('Q1_1_R1_other'),
            'Q1_1_R2_other' => $this->input->post('Q1_1_R2_other'),
            'Q1_1_R3_other' => $this->input->post('Q1_1_R3_other'),
            'Q1_2_LINE' => $this->input->post('Q1_2_LINE'),
            'Q1_2_SEX' => $this->input->post('Q1_2_SEX'),
            'Q1_3_REL' => $this->input->post('Q1_3_REL'),
            'Q1_3_REL_OTHER' => $this->input->post('Q1_3_REL_OTHER'),
            'Q1_4_AGE' => $this->input->post('Q1_4_AGE'),
            'Q1_5_EDU' => $this->input->post('Q1_5_EDU'),
            'Q1_6' => $this->input->post('Q1_6'),
            'Q1_7' => $this->input->post('Q1_7'),
            'Q1_8' => $this->input->post('Q1_8'),
            'Q1_8_DAY_OR_MONTH' => $this->input->post('Q1_8_DAY_OR_MONTH'),
            'Q2_1_INTV_NAME' => $this->input->post('Q2_1_INTV_NAME'),
            'Q2_1_INTV_CODE' => $this->input->post('Q2_1_INTV_CODE'),
            'Q2_1_INTV_LANGUAGE' => $this->input->post('Q2_1_INTV_LANGUAGE'),
            'Q2_2_INTV_DATE' => $Q2_2_INTV_DATE,
            'Q2_3_1ST_INTV_DATE' => $Q2_3_1ST_INTV_DATE,
            'Q2_4_2ND_INTV_DATE' => $Q2_4_2ND_INTV_DATE,
            'Q3_1_DNAME' => $this->input->post('Q3_1_DNAME'),
            'Q3_2_RID' => $this->input->post('Q3_2_RID'),
            'Q3_2_CID' => $this->input->post('Q3_2_CID'),
            'Q3_2_1_NID' => $this->input->post('Q3_2_1_NID'),
            'Q3_3_V_NAME' => $this->input->post('Q3_3_V_NAME'),
            'Q3_4_B_CODE' => $this->input->post('Q3_4_B_CODE'),
            'Q3_4_B_NAME' => $this->input->post('Q3_4_B_NAME'),
            'Q3_5_DOB' => $Q3_5_DOB,
            'Q3_6_DOD' => $Q3_6_DOD,
            'Q3_7_AGE_Y' => $this->input->post('Q3_7_AGE_Y'),
            'Q3_8_SEX' => $this->input->post('Q3_8_SEX'),
            'Q3_9_MSTATUS' => $this->input->post('Q3_9_MSTATUS'),
            'Q3_9_1_MD' => $this->input->post('Q3_9_1_MD'),
            'Q3_9_2_DOM' => $Q3_9_2_DOM,
            'Q3_10_EDU' => $this->input->post('Q3_10_EDU'),
            'Q3_10_1' => $this->input->post('Q3_10_1'),
            'Q3_10_2_ES' => $this->input->post('Q3_10_2_ES'),
            'Q3_11_CODE' => $this->input->post('Q3_11_CODE'),
            'Q4_1_death_reasons' => $this->input->post('Q4_1_death_reasons'),
            'Q4_2_A' => $this->input->post('Q4_2_A'),
            'Q4_2_B' => $this->input->post('Q4_2_B'),
            'Q4_2_C' => $this->input->post('Q4_2_C'),
            'Q4_2_D' => $this->input->post('Q4_2_D'),
            'Q4_2_E' => $this->input->post('Q4_2_E'),
            'Q4_2_F' => $this->input->post('Q4_2_F'),
            'Q4_2_F_SPECIFY' => $this->input->post('Q4_2_F_SPECIFY'),
            'Q4_2_G' => $this->input->post('Q4_2_G'),
            'Q4_2_H' => $this->input->post('Q4_2_H'),
            'Q4_2_I' => $this->input->post('Q4_2_I'),
            'Q4_2_J' => $this->input->post('Q4_2_J'),
            'Q4_2_K' => $this->input->post('Q4_2_K'),
            'Q4_2_L' => $this->input->post('Q4_2_L'),
            'Q4_2_M' => $this->input->post('Q4_2_M'),
            'Q4_2_N' => $this->input->post('Q4_2_N'),
            'Q4_2_O' => $this->input->post('Q4_2_O'),
            'Q4_2_P' => $this->input->post('Q4_2_P'),
            'Q4_2_Q' => $this->input->post('Q4_2_Q'),
            'Q4_2_R' => $this->input->post('Q4_2_R'),
            'Q4_2_S' => $this->input->post('Q4_2_S'),
            'Q4_2_T' => $this->input->post('Q4_2_T'),
            'Q4_2_U' => $this->input->post('Q4_2_U'),
            'Q4_2_V' => $this->input->post('Q4_2_V'),
            'Q4_2_W' => $this->input->post('Q4_2_W'),
            'Q4_2_X' => $this->input->post('Q4_2_X'),
            'Q4_2_Y' => $this->input->post('Q4_2_Y'),
            'Q4_2_DEN' => $this->input->post('Q4_2_DEN'),
            'Q4_2_MEA' => $this->input->post('Q4_2_MEA'),
            'Q4_2_CHI' => $this->input->post('Q4_2_CHI'),
            'Q4_2_Z' => $this->input->post('Q4_2_Z'),
            'Q4_2_Z_OTHER' => $this->input->post('Q4_2_Z_OTHER'),
            'Q4_3_M' => $this->input->post('Q4_3_M'),
            'Q4_3_D' => $this->input->post('Q4_3_D'),
            'Q4_4' => $this->input->post('Q4_4'),
            'Q5_1' => $this->input->post('Q5_1'),
            'Q5_1_1' => $this->input->post('Q5_1_1'),
            'Q5_1_1_OTHER' => $this->input->post('Q5_1_1_OTHER'),
            'Q5_1_2' => $this->input->post('Q5_1_2'),
            'Q5_1_2_OTHER' => $this->input->post('Q5_1_2_OTHER'),
            'Q5_1_3' => $this->input->post('Q5_1_3'),
            'Q5_1_3_OTHER' => $this->input->post('Q5_1_3_OTHER'),
            'Q5_1_4_D' => $this->input->post('Q5_1_4_D'),
            'Q5_1_4_H' => $this->input->post('Q5_1_4_H'),
            'Q5_1_5' => $this->input->post('Q5_1_5'),
            'Q6_1_A' => $this->input->post('Q6_1_A'),
            'Q6_1_B' => $this->input->post('Q6_1_B'),
            'Q6_1_C' => $this->input->post('Q6_1_C'),
            'Q6_1_D' => $this->input->post('Q6_1_D'),
            'Q6_1_E' => $this->input->post('Q6_1_E'),
            'Q6_1_F' => $this->input->post('Q6_1_F'),
            'Q6_1_G' => $this->input->post('Q6_1_G'),
            'Q6_1_G_OTHER' => $this->input->post('Q6_1_G_OTHER'),
            'Q6_2_1_A' => $this->input->post('Q6_2_1_A'),
            'Q6_2_1_B' => $this->input->post('Q6_2_1_B'),
            'Q6_2_1_C' => $this->input->post('Q6_2_1_C'),
            'Q6_2_1_D' => $this->input->post('Q6_2_1_D'),
            'Q6_2_1_E' => $this->input->post('Q6_2_1_E'),
            'Q6_2_2_N' => $this->input->post('Q6_2_2_N'),
            'Q6_2_3_BIRTH_ORDER' => $this->input->post('Q6_2_3_BIRTH_ORDER'),
            'Q6_2_3_1_BIRTH_ORDER' => $this->input->post('Q6_2_3_1_BIRTH_ORDER'),
            'Q6_2_4_DATE' => $Q6_2_4_DATE,
            'Q6_2_5_M' => $this->input->post('Q6_2_5_M'),
            'Q6_2_6' => $this->input->post('Q6_2_6'),
            'Q6_2_6_1' => $this->input->post('Q6_2_6_1'),
            'Q6_2_6_1_week' => $this->input->post('Q6_2_6_1_week'),
            'Q6_2_7' => $this->input->post('Q6_2_7'),
            'Q6_2_8' => $this->input->post('Q6_2_8'),
            'Q6_2_8_DAY_MONTH' => $this->input->post('Q6_2_8_DAY_MONTH'),
            'Q6_3_A' => $this->input->post('Q6_3_A'),
            'Q6_3_B' => $this->input->post('Q6_3_B'),
            'Q6_3_C' => $this->input->post('Q6_3_C'),
            'Q6_3_D' => $this->input->post('Q6_3_D'),
            'Q6_3_E' => $this->input->post('Q6_3_E'),
            'Q6_3_F' => $this->input->post('Q6_3_F'),
            'Q6_3_G' => $this->input->post('Q6_3_G'),
            'Q6_3_H' => $this->input->post('Q6_3_H'),
            'Q6_3_I' => $this->input->post('Q6_3_I'),
            'Q6_3_J' => $this->input->post('Q6_3_J'),
            'Q6_3_K' => $this->input->post('Q6_3_K'),
            'Q6_3_L' => $this->input->post('Q6_3_L'),
            'Q6_3_M' => $this->input->post('Q6_3_M'),
            'Q6_3_N' => $this->input->post('Q6_3_N'),
            'Q6_3_O' => $this->input->post('Q6_3_O'),
            'Q6_3_P' => $this->input->post('Q6_3_P'),
            'Q6_3_Q' => $this->input->post('Q6_3_Q'),
            'Q6_3_R' => $this->input->post('Q6_3_R'),
            'Q6_3_S' => $this->input->post('Q6_3_S'),
            'Q6_3_T' => $this->input->post('Q6_3_T'),
            'Q6_3_U' => $this->input->post('Q6_3_U'),
            'Q6_3_V' => $this->input->post('Q6_3_V'),
            'Q6_3_W' => $this->input->post('Q6_3_W'),
            'Q6_3_W_OTHER' => $this->input->post('Q6_3_W_OTHER'),
            'Q6_3_1' => $this->input->post('Q6_3_1'),
            'Q6_3_2' => $this->input->post('Q6_3_2'),
            'Q6_4' => $this->input->post('Q6_4'),
            'Q6_5' => $this->input->post('Q6_5'),
            'Q6_5_OTHER' => $this->input->post('Q6_5_OTHER'),
            'Q6_5_1' => $this->input->post('Q6_5_1'),
            'Q6_5_2_A' => $this->input->post('Q6_5_2_A'),
            'Q6_5_2_B' => $this->input->post('Q6_5_2_B'),
            'Q6_5_2_C' => $this->input->post('Q6_5_2_C'),
            'Q6_5_2_D' => $this->input->post('Q6_5_2_D'),
            'Q6_5_2_E' => $this->input->post('Q6_5_2_E'),
            'Q6_5_2_F' => $this->input->post('Q6_5_2_F'),
            'Q6_5_2_G' => $this->input->post('Q6_5_2_G'),
            'Q6_5_2_H' => $this->input->post('Q6_5_2_H'),
            'Q6_5_2_I' => $this->input->post('Q6_5_2_I'),
            'Q6_5_2_J' => $this->input->post('Q6_5_2_J'),
            'Q6_5_2_K' => $this->input->post('Q6_5_2_K'),
            'Q6_5_2_K_OTHER' => $this->input->post('Q6_5_2_K_OTHER'),
            'Q6_5_3_NAME' => $this->input->post('Q6_5_3_NAME'),
            'Q6_5_3_ADDRESS' => $this->input->post('Q6_5_3_ADDRESS'),
            'Q6_5_4_A' => $this->input->post('Q6_5_4_A'),
            'Q6_5_4_B' => $this->input->post('Q6_5_4_B'),
            'Q6_5_4_C' => $this->input->post('Q6_5_4_C'),
            'Q6_5_4_D' => $this->input->post('Q6_5_4_D'),
            'Q6_5_4_E' => $this->input->post('Q6_5_4_E'),
            'Q6_5_4_F' => $this->input->post('Q6_5_4_F'),
            'Q6_5_4_G' => $this->input->post('Q6_5_4_G'),
            'Q6_5_4_H' => $this->input->post('Q6_5_4_H'),
            'Q6_5_4_I' => $this->input->post('Q6_5_4_I'),
            'Q6_5_4_J' => $this->input->post('Q6_5_4_J'),
            'Q6_5_4_K' => $this->input->post('Q6_5_4_K'),
            'Q6_5_4_K_OTHER' => $this->input->post('Q6_5_4_K_OTHER'),
            'Q6_5_5' => $this->input->post('Q6_5_5'),
            'Q6_5_6_A' => $this->input->post('Q6_5_6_A'),
            'Q6_5_6_B' => $this->input->post('Q6_5_6_B'),
            'Q6_5_6_C' => $this->input->post('Q6_5_6_C'),
            'Q6_5_6_D' => $this->input->post('Q6_5_6_D'),
            'Q6_5_6_E' => $this->input->post('Q6_5_6_E'),
            'Q6_5_6_F' => $this->input->post('Q6_5_6_F'),
            'Q6_5_6_F_OTHER' => $this->input->post('Q6_5_6_F_OTHER'),
            'Q6_6' => $this->input->post('Q6_6'),
            'Q6_6_1' => $this->input->post('Q6_6_1'),
            'Q6_6_2_A' => $this->input->post('Q6_6_2_A'),
            'Q6_6_2_B' => $this->input->post('Q6_6_2_B'),
            'Q6_6_2_C' => $this->input->post('Q6_6_2_C'),
            'Q6_6_2_D' => $this->input->post('Q6_6_2_D'),
            'Q6_6_3' => $this->input->post('Q6_6_3'),
            'Q6_6_4' => $this->input->post('Q6_6_4'),
            'Q6_6_5' => $this->input->post('Q6_6_5'),
            'Q6_6_6' => $this->input->post('Q6_6_6'),
            'Q6_6_7' => $this->input->post('Q6_6_7'),
            'Q6_6_8' => $this->input->post('Q6_6_8'),
            'Q6_6_9' => $this->input->post('Q6_6_9'),
            'Q6_6_10' => $this->input->post('Q6_6_10'),
            'Q6_6_11' => $this->input->post('Q6_6_11'),
            'Q6_6_12' => $this->input->post('Q6_6_12'),
            'Q6_6_13' => $this->input->post('Q6_6_13'),
            'Q7_1' => $this->input->post('Q7_1'),
            'Q7_1_0' => $this->input->post('Q7_1_0'),
            'Q7_1_1_D' => $this->input->post('Q7_1_1_D'),
            'Q7_1_1_H' => $this->input->post('Q7_1_1_H'),
            'Q7_2' => $this->input->post('Q7_2'),
            'Q7_2_1' => $this->input->post('Q7_2_1'),
            'Q7_2_2' => $this->input->post('Q7_2_2'),
            'Q7_3' => $this->input->post('Q7_3'),
            'Q7_3a' => $this->input->post('Q7_3a'),
            'Q7_3b' => $this->input->post('Q7_3b'),
            'Q7_3_1' => $this->input->post('Q7_3_1'),
            'Q7_4' => $this->input->post('Q7_4'),
            'Q7_4_1' => $this->input->post('Q7_4_1'),
            'Q7_5' => $this->input->post('Q7_5'),
            'Q7_5_1' => $this->input->post('Q7_5_1'),
            'Q7_5_2' => $this->input->post('Q7_5_2'),
            'Q7_6' => $this->input->post('Q7_6'),
            'Q7_6_0' => $this->input->post('Q7_6_0'),
            'Q7_6_0_D' => $this->input->post('Q7_6_0_D'),
            'Q7_6_1_D' => $this->input->post('Q7_5_4_D'),
            'Q7_6_1_H' => $this->input->post('Q7_5_5'),
            'Q7_7' => $this->input->post('Q7_7'),
            'Q7_7_1_D' => $this->input->post('Q7_7_1_D'),
            'Q7_7_1_H' => $this->input->post('Q7_7_1_H'),
            'Q7_7_2' => $this->input->post('Q7_7_2'),
            'Q7_7_2_D' => $this->input->post('Q7_7_2_D'),
            'Q7_7_3' => $this->input->post('Q7_7_3'),
            'Q7_7_4_D' => $this->input->post('Q7_7_4_D'),
            'Q7_7_4_H' => $this->input->post('Q7_7_4_H'),
            'Q7_8' => $this->input->post('Q7_8'),
            'Q7_9' => $this->input->post('Q7_9'),
            'Q7_9_1' => $this->input->post('Q7_9_1'),
            'Q7_9_2' => $this->input->post('Q7_9_2'),
            'Q7_10' => $this->input->post('Q7_10'),
            'Q7_11' => $this->input->post('Q7_11'),
            'Q7_11_1' => $this->input->post('Q7_11_1'),
            'Q7_11_2_D' => $this->input->post('Q7_11_2_D'),
            'Q7_11_2_H' => $this->input->post('Q7_11_2_H'),
            'Q7_12' => $this->input->post('Q7_12'),
            'Q7_12_1_D' => $this->input->post('Q7_12_1_D'),
            'Q7_12_1_H' => $this->input->post('Q7_12_1_H'),
            'Q7_12_2' => $this->input->post('Q7_12_2'),
            'Q7_12_2_D' => $this->input->post('Q7_12_2_D'),
            'Q7_12_2_H' => $this->input->post('Q7_12_2_H'),
            'Q7_13' => $this->input->post('Q7_13'),
            'Q7_14' => $this->input->post('Q7_14'),
            'Q7_14_1' => $this->input->post('Q7_14_1'),
            'Q7_15' => $this->input->post('Q7_15'),
            'Q7_15_1' => $this->input->post('Q7_15_1'),
            'Q7_15_2_D' => $this->input->post('Q7_15_2_D'),
            'Q7_15_2_H' => $this->input->post('Q7_15_2_H'),
            'Q7_15_3' => $this->input->post('Q7_15_3'),
            'Q7_15_4' => $this->input->post('Q7_15_4'),
            'Q7_15_5' => $this->input->post('Q7_15_5'),
            'Q7_16' => $this->input->post('Q7_16'),
            'Q7_16_1' => $this->input->post('Q7_16_1'),
            'Q7_16_2' => $this->input->post('Q7_16_2'),
            'Q7_18' => $this->input->post('Q7_18'),
            'Q7_18_0' => $this->input->post('Q7_18_0'),
            'Q7_18_1' => $this->input->post('Q7_18_1'),
            'Q7_18_2' => $this->input->post('Q7_18_2'),
            'Q7_18_3' => $this->input->post('Q7_18_3'),
            'Q7_18_4' => $this->input->post('Q7_18_4'),
            'Q7_19' => $this->input->post('Q7_19'),
            'Q7_20' => $this->input->post('Q7_20'),
            'Q7_20_1_A' => $this->input->post('Q7_20_1_A'),
            'Q7_20_1_B' => $this->input->post('Q7_20_1_B'),
            'Q7_20_1_C' => $this->input->post('Q7_20_1_C'),
            'Q7_20_1_D' => $this->input->post('Q7_20_1_D'),
            'Q7_20_1_E' => $this->input->post('Q7_20_1_E'),
            'Q7_20_1_E_OTHER' => $this->input->post('Q7_20_1_E_OTHER'),
            'Q7_21' => $this->input->post('Q7_21'),
            'Q7_21_1' => $this->input->post('Q7_21_1'),
            'Q7_21_2' => $this->input->post('Q7_21_2'),
            'Q7_21_3' => $this->input->post('Q7_21_3'),
            'Q7_22' => $this->input->post('Q7_22'),
            'Q7_22_1' => $this->input->post('Q7_22_1'),
            'Q7_22_2' => $this->input->post('Q7_22_2'),
            'Q7_22_3' => $this->input->post('Q7_22_3'),
            'Q7_23' => $this->input->post('Q7_23'),
            'Q7_23_1_D' => $this->input->post('Q7_23_1_D'),
            'Q7_23_1_H' => $this->input->post('Q7_23_1_H'),
            'Q7_24' => $this->input->post('Q7_24'),
            'Q7_24_1' => $this->input->post('Q7_24_1'),
            'Q7_24_2' => $this->input->post('Q7_24_2'),
            'Q7_25' => $this->input->post('Q7_25'),
            'Q8_0_A' => $this->input->post('Q8_0_A'),
            'Q8_0_B' => $this->input->post('Q8_0_B'),
            'Q8_0_C' => $this->input->post('Q8_0_C'),
            'Q8_1' => $this->input->post('Q8_1'),
            'Q8_1_1_A' => $this->input->post('Q8_1_1_A'),
            'Q8_1_1_A_OTHER' => $this->input->post('Q8_1_1_A_OTHER'),
            'Q8_1_1_B' => $this->input->post('Q8_1_1_B'),
            'Q8_1_1_B_OTHER' => $this->input->post('Q8_1_1_B_OTHER'),
            'Q8_1_1_C' => $this->input->post('Q8_1_1_C'),
            'Q8_1_1_C_OTHER' => $this->input->post('Q8_1_1_C_OTHER'),
            'Q8_1_1_D' => $this->input->post('Q8_1_1_D'),
            'Q8_1_1_D_OTHER' => $this->input->post('Q8_1_1_D_OTHER'),
            'Q8_1_2' => $this->input->post('Q8_1_2'),
            'Q8_1_2_OTHER' => $this->input->post('Q8_1_2_OTHER'),
            'Q8_1_3_A' => $this->input->post('Q8_1_3_A'),
            'Q8_1_3_B' => $this->input->post('Q8_1_3_B'),
            'Q8_1_3_C' => $this->input->post('Q8_1_3_C'),
            'Q8_1_3_D' => $this->input->post('Q8_1_3_D'),
            'Q8_1_3_E' => $this->input->post('Q8_1_3_E'),
            'Q8_1_3_F' => $this->input->post('Q8_1_3_F'),
            'Q8_1_3_G' => $this->input->post('Q8_1_3_G'),
            'Q8_1_3_G_OTHER' => $this->input->post('Q8_1_3_G_OTHER'),
            'Q8_1_4' => $this->input->post('Q8_1_4'),
            'Q8_2' => $this->input->post('Q8_2'),
            'Q8_2_1_HOSPITAL_1' => $this->input->post('Q8_2_1_HOSPITAL_1'),
            'Q8_2_1_DATE_ADMISSION_1' => $Q8_2_1_DATE_ADMISSION_1,
            'Q8_2_1_REASON_1' => $this->input->post('Q8_2_1_REASON_1'),
            'Q8_2_1_HOSPITAL_2' => $this->input->post('Q8_2_1_HOSPITAL_2'),
            'Q8_2_1_DATE_ADMISSION_2' => $Q8_2_1_DATE_ADMISSION_2,
            'Q8_2_1_REASON_2' => $this->input->post('Q8_2_1_REASON_2'),
            'Q8_2_1_HOSPITAL_3' => $this->input->post('Q8_2_1_HOSPITAL_3'),
            'Q8_2_1_DATE_ADMISSION_3' => $Q8_2_1_DATE_ADMISSION_3,
            'Q8_2_1_REASON_3' => $this->input->post('Q8_2_1_REASON_3'),
            'Q8_2_2' => $this->input->post('Q8_2_2'),
            'Q8_2_3_A' => $this->input->post('Q8_2_3_A'),
            'Q8_2_3_B' => $this->input->post('Q8_2_3_B'),
            'Q8_2_3_C' => $this->input->post('Q8_2_3_C'),
            'Q8_2_3_D' => $this->input->post('Q8_2_3_D'),
            'Q8_2_3_E' => $this->input->post('Q8_2_3_E'),
            'Q8_2_4' => $this->input->post('Q8_2_4'),
            'Q8_2_5' => $this->input->post('Q8_2_5'),
            'Q8_2_6' => $this->input->post('Q8_2_6'),
            'Q8_2_7' => $this->input->post('Q8_2_7'),
            'Q8_3' => $this->input->post('Q8_3'),
            'Q8_3_OTHER' => $this->input->post('Q8_3_OTHER'),
            'Q8_3_1_VILL_NAME' => $this->input->post('Q8_3_1_VILL_NAME'),
            'Q8_3_1_BLOCK_NAME' => $this->input->post('Q8_3_1_BLOCK_NAME'),
            'Q8_3_1_BLOCK_CODE' => $this->input->post('Q8_3_1_BLOCK_CODE'),
            'Q8_3_2_HOSPITAL_NAME' => $this->input->post('Q8_3_2_HOSPITAL_NAME'),
            'Q8_3_2_HOSPITAL_ADDRESS' => $this->input->post('Q8_3_2_HOSPITAL_ADDRESS'),
            'Q8_4' => $this->input->post('Q8_4'),
            'Q8_4_1' => $this->input->post('Q8_4_1'),
            'Q8_4_1_OTHER' => $this->input->post('Q8_4_1_OTHER'),
            'Q8_4_2' => $this->input->post('Q8_4_2'),
            'Q9_1' => $this->input->post('Q9_1'),
            'Q9_2' => $this->input->post('Q9_2'),
            'Q9_2_VDATE' => $Q9_2_VDATE,
            'Q9_2_HIGH' => $this->input->post('Q9_2_HIGH'),
            'Q9_2_WEIG' => $this->input->post('Q9_2_WEIG'),
            'Q9_2_SYMP' => $this->input->post('Q9_2_SYMP'),
            'Q9_2_DIAG' => $this->input->post('Q9_2_DIAG'),
            'Q9_2_TRET' => $this->input->post('Q9_2_TRET'),
            'Q9_3' => $this->input->post('Q9_3'),
            'Q9_4' => $this->input->post('Q9_4'),
            'Q9_5_ICAUSE' => $this->input->post('Q9_5_ICAUSE'),
            'Q9_5_ICODE' => $this->input->post('Q9_5_ICODE'),
            'Q9_5_ACAUSE' => $this->input->post('Q9_5_ACAUSE'),
            'Q9_5_ACODE' => $this->input->post('Q9_5_ACODE'),
            'Q9_5_UCAUSE' => $this->input->post('Q9_5_UCAUSE'),
            'Q9_5_UCODE' => $this->input->post('Q9_5_UCODE'),
            'Q9_5_CCAUSE' => $this->input->post('Q9_5_CCAUSE'),
            'Q9_5_CCODE' => $this->input->post('Q9_5_CCODE'),
            'Q9_6' => $this->input->post('Q9_6'),
            'Q9_7' => $this->input->post('Q9_7'),
            'Q9_8' => $this->input->post('Q9_8'),
            'Q9_9' => $this->input->post('Q9_9'),
            'Q9_9_1' => $this->input->post('Q9_9_1'),
            'Q9_9_2' => $Q9_9_2,
            'Q9_9_3' => $this->input->post('Q9_9_3'),
            'Q10_INTERVIEW' => $this->input->post('Q10_INTERVIEW'),
            'Q10_CSQ' => $this->input->post('Q10_CSQ'),
            'Q10_AOC' => $this->input->post('Q10_AOC'),
            'Q10_SO' => $this->input->post('Q10_SO'),
            'Q10_DOE' => $Q10_DOE,
            'Q10_SUP_CODE' => $this->input->post('Q10_SUP_CODE'),
            'inv_status' => $this->input->post('inv_status'),
            'updateBy' => $this->vendorId,
            'updatedOn' => date('Y-m-d H:i:s'),
            'VA_TYPE' => 3
        );

        $result = $this->modelName->updateInfo($IDInfo, $member_death_table_id, $this->config->item('deathTable'));

        //added by Ripon

        $member_death_extended_info = array(
            'member_death_id' => $member_death_table_id,
            'neonatal_A' => $this->input->post('neonatal_A'),
            'neonatal_B' => $this->input->post('neonatal_B'),
            'maternal_C' => $this->input->post('maternal_C'),
            'maternal_D' => $this->input->post('maternal_D'),
            'others_E' => $this->input->post('others_E'),
            'verbal_autopsy_specialist_name' => $this->input->post('verbal_autopsy_specialist_name')
        );

        $this->db->from($this->config->item('deathTableExtended'));
        $this->db->where('member_death_id', $member_death_table_id);
        $query = $this->db->get();
        $deathTableExtended_existence = $query->row();

        if ($deathTableExtended_existence == true) {
            $result_2 = $this->modelName->updateExtendedTable($member_death_extended_info, $member_death_table_id, $this->config->item('deathTableExtended'));
        } else {
            $result_2 = $this->modelName->InsertInfo($member_death_extended_info, $this->config->item('deathTableExtended'));
        }

        //added by Ripon

        if ($result == true && $result_2 == true) {
            $this->session->set_flashdata('success', $this->pageShortName . ' updated successfully');
        } else {
            $this->session->set_flashdata('error', $this->pageShortName . ' update failed');
        }

        //redirect($this->controller . '/EditNeonatal/'.$member_death_table_id.'?baseID=' . $baseID);
        redirect($this->controller . '/editNeonatal/' . $member_death_table_id . '?household_master_id=' . $household_master_id . '&&baseID=' . $baseID);
    }

    function editChild($id = NULL) {
        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id = $this->input->get('household_master_id', TRUE);
        if ($id == null) {
            $this->session->set_flashdata('error', "Someting went wrong!! Please try Again");
            redirect($this->controller . '?baseID=' . $baseID);
        }

        $editPerm = $this->getPermission($baseID, $this->role, 'edit');
        if ($editPerm == 0) {
            $this->session->set_flashdata('error', "Unauthorized Access");
            redirect($this->controller . '?baseID=' . $baseID);
        }

        //dynamic options end

        $data['VA_Relation'] = $this->modelName->getLookUpList($this->config->item('VA_Relation'));
        $data['va_yes_no'] = $this->modelName->getLookUpList($this->config->item('va_yes_no'));
        //$data['va_gender'] = $this->modelName->getLookUpList($this->config->item('va_gender'));
        //$data['VA_Marital_Status'] = $this->modelName->getLookUpList($this->config->item('VA_Marital_Status'));

        $data['va_gender'] = $this->masterModel->getLookUpList($this->config->item('membersextype'));
        $data['VA_Marital_Status'] = $this->masterModel->getLookUpList($this->config->item('maritalstatustyp'));
        $data['VA_Occupation_Type'] = $this->masterModel->getLookUpList($this->config->item('occupationtyp'));

        $data['VA_Yes_No_Reluctant_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Yes_No_Reluctant_Unknown'));
        $data['VA_Education_Institute_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Education_Institute_Type'));
        //$data['VA_Occupation_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Occupation_Type'));
        $data['VA_INJURY_OR_ACCIDENT_TYPE'] = $this->modelName->getLookUpList($this->config->item('VA_INJURY_OR_ACCIDENT_TYPE'));
        $data['VA_Road_OR_Water_Vehicle_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Road_OR_Water_Vehicle_Type'));
        $data['VA_Medicine_Or_Poison_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Medicine_Or_Poison_Type'));
        $data['VA_Yes_No_Reluctant_NotApplicable_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Yes_No_Reluctant_NotApplicable_Unknown'));
        $data['VA_Death_When'] = $this->modelName->getLookUpList($this->config->item('VA_Death_When'));
        $data['VA_Delivery_Result'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Result'));
        $data['VA_Delivery_Durability'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Durability'));
        $data['VA_Delivery_Place'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Place'));
        $data['VA_Delivery_Method'] = $this->modelName->getLookUpList($this->config->item('VA_Delivery_Method'));
        $data['VA_Fever_Dimension'] = $this->modelName->getLookUpList($this->config->item('VA_Fever_Dimension'));
        $data['VA_Fever_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Fever_Type'));
        $data['VA_Body_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Body_Where'));
        $data['VA_Grain_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Grain_Type'));
        $data['VA_Arsenic_Identification_Hospital'] = $this->modelName->getLookUpList($this->config->item('VA_Arsenic_Identification_Hospital'));
        $data['VA_Swollen_Body_Part'] = $this->modelName->getLookUpList($this->config->item('VA_Swollen_Body_Part'));
        $data['VA_Glands_Swollen_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Glands_Swollen_Where'));
        $data['VA_Shortness_of_breath_Body_Condition'] = $this->modelName->getLookUpList($this->config->item('VA_Shortness_of_breath_Body_Condition'));
        $data['VA_Yes_No_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Yes_No_Unknown'));
        $data['VA_Chest_Pain_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Where'));
        $data['VA_Chest_Pain_Continuous'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Continuous'));
        $data['VA_Chest_Pain_Suddenly'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Suddenly'));
        $data['VA_Chest_Pain_Stability'] = $this->modelName->getLookUpList($this->config->item('VA_Chest_Pain_Stability'));
        $data['VA_Stool_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Stool_Type'));
        $data['VA_Diarrhea_Continuous'] = $this->modelName->getLookUpList($this->config->item('VA_Diarrhea_Continuous'));
        $data['VA_Vomit_Looks_Like'] = $this->modelName->getLookUpList($this->config->item('VA_Vomit_Looks_Like'));
        $data['VA_Abdominal_Pain_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Abdominal_Pain_Type'));
        $data['VA_Abdominal_Pain_Where'] = $this->modelName->getLookUpList($this->config->item('VA_Abdominal_Pain_Where'));
        $data['VA_Pain_Dimension'] = $this->modelName->getLookUpList($this->config->item('VA_Pain_Dimension'));
        $data['VA_Abdominal_Pain_Stool_Look_Like'] = $this->modelName->getLookUpList($this->config->item('VA_Abdominal_Pain_Stool_Look_Like'));
        $data['VA_ABDOMINAL_DISTENSION_QUICK'] = $this->modelName->getLookUpList($this->config->item('VA_ABDOMINAL_DISTENSION_QUICK'));
        $data['VA_MASS_in_Abdomen_Strong_Wheel_Position'] = $this->modelName->getLookUpList($this->config->item('VA_MASS_in_Abdomen_Strong_Wheel_Position'));
        $data['VA_Headache_Quick_Or_Slow'] = $this->modelName->getLookUpList($this->config->item('VA_Headache_Quick_Or_Slow'));
        $data['VA_Suddenly_Slowly_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Suddenly_Slowly_Unknown'));
        $data['VA_Status_Before_Swoon'] = $this->modelName->getLookUpList($this->config->item('VA_Status_Before_Swoon'));
        $data['VA_Paralyzed_Body_Part'] = $this->modelName->getLookUpList($this->config->item('VA_Paralyzed_Body_Part'));
        $data['VA_Paralyzed_When'] = $this->modelName->getLookUpList($this->config->item('VA_Paralyzed_When'));
        $data['VA_Urine_Color'] = $this->modelName->getLookUpList($this->config->item('VA_Urine_Color'));
        $data['VA_Urine_Dimension'] = $this->modelName->getLookUpList($this->config->item('VA_Urine_Dimension'));
        $data['VA_Drug_Collection_Place'] = $this->modelName->getLookUpList($this->config->item('VA_Drug_Collection_Place'));
        $data['VA_Treatment_Provider'] = $this->modelName->getLookUpList($this->config->item('VA_Treatment_Provider'));
        $data['VA_Death_Place'] = $this->modelName->getLookUpList($this->config->item('VA_Death_Place'));
        $data['VA_Reason_Teller'] = $this->modelName->getLookUpList($this->config->item('VA_Reason_Teller'));
        $data['VA_Hospital_List'] = $this->modelName->getLookUpList($this->config->item('VA_Hospital_List'));
        $data['VA_Supervisor_List'] = $this->modelName->getLookUpList($this->config->item('VA_Supervisor_List'));
        $data['VA_Leg_Wound'] = $this->modelName->getLookUpList($this->config->item('VA_Leg_Wound'));
        $data['VA_Weight_Loss_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Weight_Loss_Type'));
        $data['VA_Breathing_Problem_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Breathing_Problem_Type'));
        $data['VA_Daily_Work_Hampered_By_Breathing_Problem'] = $this->modelName->getLookUpList($this->config->item('VA_Daily_Work_Hampered_By_Breathing_Problem'));
        $data['VA_Breathing_Problem_When'] = $this->modelName->getLookUpList($this->config->item('VA_Breathing_Problem_When'));


        $data['VA_Mother_Death_When'] = $this->modelName->getLookUpList($this->config->item('VA_Mother_Death_When'));
        $data['VA_Day_Month_Reluctant_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Day_Month_Reluctant_Unknown'));
        $data['VA_Birth_Order'] = $this->modelName->getLookUpList($this->config->item('VA_Birth_Order'));
        $data['VA_Pregnancy_Ending_Time'] = $this->modelName->getLookUpList($this->config->item('VA_Pregnancy_Ending_Time'));
        $data['VA_Related_To_EDD'] = $this->modelName->getLookUpList($this->config->item('VA_Related_To_EDD'));
        $data['VA_Baby_Movement_Feeling'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Movement_Feeling'));
        $data['VA_Water_Broken'] = $this->modelName->getLookUpList($this->config->item('VA_Water_Broken'));
        $data['VA_Baby_Single_Double'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Single_Double'));
        $data['VA_Baby_Weight'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Weight'));
        $data['VA_Baby_Body_Color'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Body_Color'));
        $data['VA_Pate_Status'] = $this->modelName->getLookUpList($this->config->item('VA_Pate_Status'));
        $data['VA_Frequently_Breathing'] = $this->modelName->getLookUpList($this->config->item('VA_Frequently_Breathing'));
        $data['VA_Baby_Cry'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Cry'));
        $data['VA_Baby_Milk'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Milk'));
        $data['VA_Baby_Drinking_Milk_Shut_Down'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Drinking_Milk_Shut_Down'));
        $data['VA_Diarrhea_Situation'] = $this->modelName->getLookUpList($this->config->item('VA_Diarrhea_Situation'));
        $data['VA_Baby_Vomit_Looks_Like'] = $this->modelName->getLookUpList($this->config->item('VA_Baby_Vomit_Looks_Like'));
        $data['VA_Birth_Weight_Source'] = $this->modelName->getLookUpList($this->config->item('VA_Birth_Weight_Source'));
        $data['VA_Child_Age'] = $this->modelName->getLookUpList($this->config->item('VA_Child_Age'));
        $data['VA_Sitting_Style'] = $this->modelName->getLookUpList($this->config->item('VA_Sitting_Style'));
        $data['va_dysentery_stop_situation'] = $this->modelName->getLookUpList($this->config->item('va_dysentery_stop_situation'));
        $data['VA_Body_Curves_Like_Bow'] = $this->modelName->getLookUpList($this->config->item('VA_Body_Curves_Like_Bow'));

        $data['verbal_autopsy_specialist_name'] = $this->modelName->getLookUpList($this->config->item('verbal_autopsy_specialist_name'));


        $this->global['menu'] = $this->menuModel->getMenu($this->role);
        $data['userInfo'] = $this->modelName->getListInfo($id, $this->config->item('deathTable'));


        $data['household_member'] = $this->modelName->getMemberMasterPresentListByHouseholdIds($household_master_id);
        $data['intervcode'] = $this->vendorId;

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'updateChild';
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'Edit';


        $this->load->view('includes/header', $this->global);
        $this->load->view($this->controller . '/EditChild', $data);
        $this->load->view('includes/footer');
    }

    function updateChild() {

        $this->load->library('form_validation');
        $member_death_table_id = $this->input->post('ID');
        $household_master_id = $this->input->post('household_master_id');
        $baseID = $this->input->get('baseID', TRUE);

        $Q2_2_INTV_DATE = null;

        if (!empty($this->input->post('Q2_2_INTV_DATE'))) {
            $parts = explode('/', $this->input->post('Q2_2_INTV_DATE'));
            $Q2_2_INTV_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q2_3_1ST_INTV_DATE = null;
        if (!empty($this->input->post('Q2_3_1ST_INTV_DATE'))) {
            $parts = explode('/', $this->input->post('Q2_3_1ST_INTV_DATE'));
            $Q2_3_1ST_INTV_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q2_4_2ND_INTV_DATE = null;
        if (!empty($this->input->post('Q2_4_2ND_INTV_DATE'))) {
            $parts = explode('/', $this->input->post('Q2_4_2ND_INTV_DATE'));
            $Q2_4_2ND_INTV_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q3_5_DOB = null;
        if (!empty($this->input->post('Q3_5_DOB'))) {
            $parts = explode('/', $this->input->post('Q3_5_DOB'));
            $Q3_5_DOB = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q3_6_DOD = null;
        if (!empty($this->input->post('Q3_6_DOD'))) {
            $parts = explode('/', $this->input->post('Q3_6_DOD'));
            $Q3_6_DOD = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q3_9_2_DOM = null;
        if (!empty($this->input->post('Q3_9_2_DOM'))) {
            $parts = explode('/', $this->input->post('Q3_9_2_DOM'));
            $Q3_9_2_DOM = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q6_2_4_DATE = null;
        if (!empty($this->input->post('Q6_2_4_DATE'))) {
            $parts = explode('/', $this->input->post('Q6_2_4_DATE'));
            $Q6_2_4_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q7_2_1_1_DATE = null;
        if (!empty($this->input->post('Q7_2_1_1_DATE'))) {
            $parts = explode('/', $this->input->post('Q7_2_1_1_DATE'));
            $Q7_2_1_1_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q7_2_1_2_DATE = null;
        if (!empty($this->input->post('Q7_2_1_2_DATE'))) {
            $parts = explode('/', $this->input->post('Q7_2_1_2_DATE'));
            $Q7_2_1_2_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        $Q7_2_1_3_DATE = null;
        if (!empty($this->input->post('Q7_2_1_3_DATE'))) {
            $parts = explode('/', $this->input->post('Q7_2_1_3_DATE'));
            $Q7_2_1_3_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q8_3_2 = null;
        if (!empty($this->input->post('Q8_3_2'))) {
            $parts = explode('/', $this->input->post('Q8_3_2'));
            $Q8_3_2 = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }



        $Q10_DOE = null;
        if (!empty($this->input->post('Q10_DOE'))) {
            $parts = explode('/', $this->input->post('Q10_DOE'));
            $Q10_DOE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }



        $member_death_info = array(
            'Q1_1_N1' => $this->input->post('Q1_1_N1'),
            'Q1_1_N2' => $this->input->post('Q1_1_N2'),
            'Q1_1_N3' => $this->input->post('Q1_1_N3'),
            'Q1_1_R1' => $this->input->post('Q1_1_R1'),
            'Q1_1_R2' => $this->input->post('Q1_1_R2'),
            'Q1_1_R3' => $this->input->post('Q1_1_R3'),
            'Q1_1_P1' => $this->input->post('Q1_1_P1'),
            'Q1_1_P2' => $this->input->post('Q1_1_P2'),
            'Q1_1_P3' => $this->input->post('Q1_1_P3'),
            'Q1_1_R1_other' => $this->input->post('Q1_1_R1_other'),
            'Q1_1_R2_other' => $this->input->post('Q1_1_R2_other'),
            'Q1_1_R3_other' => $this->input->post('Q1_1_R3_other'),
            'Q1_2_LINE' => $this->input->post('Q1_2_LINE'),
            'Q1_2_SEX' => $this->input->post('Q1_2_SEX'),
            'Q1_3_REL' => $this->input->post('Q1_3_REL'),
            'Q1_3_REL_OTHER' => $this->input->post('Q1_3_REL_OTHER'),
            'Q1_4_AGE' => $this->input->post('Q1_4_AGE'),
            'Q1_5_EDU' => $this->input->post('Q1_5_EDU'),
            'Q1_6' => $this->input->post('Q1_6'),
            'Q1_6a' => $this->input->post('Q1_6a'),
            'Q1_6_1' => $this->input->post('Q1_6_1'),
            'Q1_6_2' => $this->input->post('Q1_6_2'),
            'Q1_6_2_DAY_OR_MONTH' => $this->input->post('Q1_6_2_DAY_OR_MONTH'),
            'Q2_1_INTV_NAME' => $this->input->post('Q2_1_INTV_NAME'),
            'Q2_1_INTV_CODE' => $this->input->post('Q2_1_INTV_CODE'),
            'Q2_1_INTV_LANGUAGE' => $this->input->post('Q2_1_INTV_LANGUAGE'),
            'Q2_2_INTV_DATE' => $Q2_2_INTV_DATE,
            'Q2_3_1ST_INTV_DATE' => $Q2_3_1ST_INTV_DATE,
            'Q2_4_2ND_INTV_DATE' => $Q2_4_2ND_INTV_DATE,
            'Q3_1_DNAME' => $this->input->post('Q3_1_DNAME'),
            'Q3_2_RID' => $this->input->post('Q3_2_RID'),
            'Q3_2_CID' => $this->input->post('Q3_2_CID'),
            'Q3_2_1_NID' => $this->input->post('Q3_2_1_NID'),
            'Q3_3_V_NAME' => $this->input->post('Q3_3_V_NAME'),
            'Q3_4_B_CODE' => $this->input->post('Q3_4_B_CODE'),
            'Q3_4_B_NAME' => $this->input->post('Q3_4_B_NAME'),
            'Q3_5_DOB' => $Q3_5_DOB,
            'Q3_6_DOD' => $Q3_6_DOD,
            'Q3_7_AGE_Y' => $this->input->post('Q3_7_AGE_Y'),
            'Q3_8_SEX' => $this->input->post('Q3_8_SEX'),
            'Q3_9_MSTATUS' => $this->input->post('Q3_9_MSTATUS'),
            'Q3_9_1_MD' => $this->input->post('Q3_9_1_MD'),
            'Q3_9_2_DOM' => $Q3_9_2_DOM,
            'Q3_10_EDU' => $this->input->post('Q3_10_EDU'),
            'Q3_10_1' => $this->input->post('Q3_10_1'),
            'Q3_10_2_ES' => $this->input->post('Q3_10_2_ES'),
            'Q3_11_CODE' => $this->input->post('Q3_11_CODE'),
            'Q4_1_death_reasons' => $this->input->post('Q4_1_death_reasons'),
            'Q4_2_A' => $this->input->post('Q4_2_A'),
            'Q4_2_B' => $this->input->post('Q4_2_B'),
            'Q4_2_C' => $this->input->post('Q4_2_C'),
            'Q4_2_D' => $this->input->post('Q4_2_D'),
            'Q4_2_E' => $this->input->post('Q4_2_E'),
            'Q4_2_F' => $this->input->post('Q4_2_F'),
            'Q4_2_F_SPECIFY' => $this->input->post('Q4_2_F_SPECIFY'),
            'Q4_2_G' => $this->input->post('Q4_2_G'),
            'Q4_2_H' => $this->input->post('Q4_2_H'),
            'Q4_2_I' => $this->input->post('Q4_2_I'),
            'Q4_2_J' => $this->input->post('Q4_2_J'),
            'Q4_2_K' => $this->input->post('Q4_2_K'),
            'Q4_2_L' => $this->input->post('Q4_2_L'),
            'Q4_2_M' => $this->input->post('Q4_2_M'),
            'Q4_2_N' => $this->input->post('Q4_2_N'),
            'Q4_2_O' => $this->input->post('Q4_2_O'),
            'Q4_2_P' => $this->input->post('Q4_2_P'),
            'Q4_2_Q' => $this->input->post('Q4_2_Q'),
            'Q4_2_R' => $this->input->post('Q4_2_R'),
            'Q4_2_S' => $this->input->post('Q4_2_S'),
            'Q4_2_T' => $this->input->post('Q4_2_T'),
            'Q4_2_U' => $this->input->post('Q4_2_U'),
            'Q4_2_V' => $this->input->post('Q4_2_V'),
            'Q4_2_W' => $this->input->post('Q4_2_W'),
            'Q4_2_X' => $this->input->post('Q4_2_X'),
            'Q4_2_Y' => $this->input->post('Q4_2_Y'),
            'Q4_2_Z' => $this->input->post('Q4_2_Z'),
            'Q4_2_Z_OTHER' => $this->input->post('Q4_2_Z_OTHER'),
            'Q4_3_M' => $this->input->post('Q4_3_M'),
            'Q4_3_D' => $this->input->post('Q4_3_D'),
            'Q4_4' => $this->input->post('Q4_4'),
            'Q5_1' => $this->input->post('Q5_1'),
            'Q5_1_1' => $this->input->post('Q5_1_1'),
            'Q5_1_1_OTHER' => $this->input->post('Q5_1_1_OTHER'),
            'Q5_1_2' => $this->input->post('Q5_1_2'),
            'Q5_1_2_OTHER' => $this->input->post('Q5_1_2_OTHER'),
            'Q5_1_3' => $this->input->post('Q5_1_3'),
            'Q5_1_3_OTHER' => $this->input->post('Q5_1_3_OTHER'),
            'Q5_1_4' => $this->input->post('Q5_1_4'),
            'Q5_1_5' => $this->input->post('Q5_1_5'),
            'Q5_1_6' => $this->input->post('Q5_1_6'),
            'Q5_1_7_D' => $this->input->post('Q5_1_7_D'),
            'Q5_1_7_H' => $this->input->post('Q5_1_7_H'),
            'Q5_1_8' => $this->input->post('Q5_1_8'),
            'Q6_1' => $this->input->post('Q6_1'),
            'Q6_1_1' => $this->input->post('Q6_1_1'),
            'Q6_1_2' => $this->input->post('Q6_1_2'),
            'Q6_1_3' => $this->input->post('Q6_1_3'),
            'Q6_1_4_D' => $this->input->post('Q6_1_4_D'),
            'Q6_1_5' => $this->input->post('Q6_1_5'),
            'Q6_1_6' => $this->input->post('Q6_1_6'),
            'Q6_1_7' => $this->input->post('Q6_1_7'),
            'Q6_1_8' => $this->input->post('Q6_1_8'),
            'Q6_1_8_OTHER' => $this->input->post('Q6_1_8_OTHER'),
            'Q6_1_9_0' => $this->input->post('Q6_1_9_0'),
            'Q6_1_9_1' => $this->input->post('Q6_1_9_1'),
            'Q6_1_9_2' => $this->input->post('Q6_1_9_2'),
            'Q6_1_9_3_alive' => $this->input->post('Q6_1_9_3_alive'),
            'Q6_1_9_3_dead' => $this->input->post('Q6_1_9_3_dead'),
            'Q6_1_9_3_Normal_delivery' => $this->input->post('Q6_1_9_3_Normal_delivery'),
            'Q6_1_9_4' => $this->input->post('Q6_1_9_4'),
            'Q6_1_9_5' => $this->input->post('Q6_1_9_5'),
            'Q6_2_1' => $this->input->post('Q6_2_1'),
            'Q6_2_2_M' => $this->input->post('Q6_2_2_M'),
            'Q6_2_2_D' => $this->input->post('Q6_2_2_D'),
            'Q6_2_3' => $this->input->post('Q6_2_3'),
            'Q6_2_4' => $this->input->post('Q6_2_4'),
            'Q6_2_5' => $this->input->post('Q6_2_5'),
            'Q6_2_6' => $this->input->post('Q6_2_6'),
            'Q6_2_7' => $this->input->post('Q6_2_7'),
            //till 25-06-2020
            'Q6_3_1' => $this->input->post('Q6_3_1'),
            'Q6_3_2_M' => $this->input->post('Q6_3_2_M'),
            'Q6_3_2_D' => $this->input->post('Q6_3_2_D'),
            'Q6_3_3' => $this->input->post('Q6_3_3'),
            'Q6_3_3_OTHER' => $this->input->post('Q6_3_3_OTHER'),
            'Q6_3_4' => $this->input->post('Q6_3_4'),
            'Q6_3_4_OTHER' => $this->input->post('Q6_3_4_OTHER'),
            'Q6_3_5' => $this->input->post('Q6_3_5'),
            'Q6_3_6' => $this->input->post('Q6_3_6'),
            'Q6_3_6_OTHER' => $this->input->post('Q6_3_6_OTHER'),
            'Q6_3_7' => $this->input->post('Q6_3_7'),
            'Q6_3_8' => $this->input->post('Q6_3_8'),
            'Q6_3_9' => $this->input->post('Q6_3_9'),
            'Q6_3_10_A' => $this->input->post('Q6_3_10_A'),
            'Q6_3_10_B' => $this->input->post('Q6_3_10_B'),
            'Q6_3_10_C' => $this->input->post('Q6_3_10_C'),
            'Q6_3_10_D' => $this->input->post('Q6_3_10_D'),
            'Q6_3_10_E' => $this->input->post('Q6_3_10_E'),
            'Q6_3_10_E_OTHER' => $this->input->post('Q6_3_10_E_OTHER'),
            'Q6_3_11' => $this->input->post('Q6_3_11'),
            'Q6_3_12' => $this->input->post('Q6_3_12'),
            'Q6_3_13' => $this->input->post('Q6_3_13'),
            'Q6_3_14' => $this->input->post('Q6_3_14'),
            'Q6_3_15_A' => $this->input->post('Q6_3_15_A'),
            'Q6_3_15_B' => $this->input->post('Q6_3_15_B'),
            'Q6_3_15_C' => $this->input->post('Q6_3_15_C'),
            'Q6_3_15_D' => $this->input->post('Q6_3_15_D'),
            'Q6_3_15_E' => $this->input->post('Q6_3_15_E'),
            'Q6_3_15_F' => $this->input->post('Q6_3_15_F'),
            'Q6_3_15_F_OTHER' => $this->input->post('Q6_3_15_F_OTHER'),
            'Q6_3_16_Y' => $this->input->post('Q6_3_16_Y'),
            'Q6_3_16_M' => $this->input->post('Q6_3_16_M'),
            'Q6_3_17' => $this->input->post('Q6_3_17'),
            'Q6_3_18_Y' => $this->input->post('Q6_3_18_Y'),
            'Q6_3_18_M' => $this->input->post('Q6_3_18_M'),
            'Q6_3_19' => $this->input->post('Q6_3_19'),
            'Q6_3_20' => $this->input->post('Q6_3_20'),
            'Q6_3_20_OTHER' => $this->input->post('Q6_3_20_OTHER'),
            'Q6_3_21' => $this->input->post('Q6_3_21'),
            'Q6_3_22' => $this->input->post('Q6_3_22'),
            'Q6_3_22_OTHER' => $this->input->post('Q6_3_22_OTHER'),
            'Q6_3_23' => $this->input->post('Q6_3_23'),
            'Q6_4' => $this->input->post('Q6_4'),
            'Q6_4a' => $this->input->post('Q6_4a'),
            'Q6_4b' => $this->input->post('Q6_4b'),
            'Q6_4c' => $this->input->post('Q6_4c'),
            'Q6_4d_M' => $this->input->post('Q6_4d_M'),
            'Q6_4d_D' => $this->input->post('Q6_4d_D'),
            'Q6_4_1' => $this->input->post('Q6_4_1'),
            'Q6_4_2' => $this->input->post('Q6_4_2'),
            'Q6_4_3' => $this->input->post('Q6_4_3'),
            'Q6_4_4_M' => $this->input->post('Q6_4_4_M'),
            'Q6_4_4_D' => $this->input->post('Q6_4_4_D'),
            'Q6_4_5_A' => $this->input->post('Q6_4_5_A'),
            'Q6_4_5_B' => $this->input->post('Q6_4_5_B'),
            'Q6_4_5_C' => $this->input->post('Q6_4_5_C'),
            'Q6_4_5_D' => $this->input->post('Q6_4_5_D'),
            'Q6_4_5_E' => $this->input->post('Q6_4_5_E'),
            'Q6_4_5_F' => $this->input->post('Q6_4_5_F'),
            'Q6_4_5_G' => $this->input->post('Q6_4_5_G'),
            'Q6_4_5_G_OTHER' => $this->input->post('Q6_4_5_G_OTHER'),
            'Q6_4_6' => $this->input->post('Q6_4_6'),
//            
            'Q6_5_1' => $this->input->post('Q6_5_1'),
            'Q6_5_1_1' => $this->input->post('Q6_5_1_1'),
//            
            'Q6_5_2_M' => $this->input->post('Q6_5_2_M'),
            'Q6_5_2_D' => $this->input->post('Q6_5_2_D'),
//            
            'Q6_5_3' => $this->input->post('Q6_5_3'),
            'Q6_5_4' => $this->input->post('Q6_5_4'),
            'Q6_5_5' => $this->input->post('Q6_5_5'),
//            
            'Q6_6_1' => $this->input->post('Q6_6_1'),
            'Q6_6_2_A' => $this->input->post('Q6_6_2_A'),
            'Q6_6_2_B' => $this->input->post('Q6_6_2_B'),
            'Q6_6_2_C' => $this->input->post('Q6_6_2_C'),
            'Q6_6_2_D' => $this->input->post('Q6_6_2_D'),
            'Q6_6_2_E' => $this->input->post('Q6_6_2_E'),
            'Q6_6_2_F' => $this->input->post('Q6_6_2_F'),
            'Q6_6_2_F_OTHER' => $this->input->post('Q6_6_2_F_OTHER'),
            'Q6_6_3' => $this->input->post('Q6_6_3'),
            'Q6_6_3_OTHER' => $this->input->post('Q6_6_3_OTHER'),
            'Q6_6_3_1' => $this->input->post('Q6_6_3_1'),
            'Q6_6_3_2_M' => $this->input->post('Q6_6_3_2_M'),
            'Q6_6_3_2_D' => $this->input->post('Q6_6_3_2_D'),
            'Q6_6_4_A' => $this->input->post('Q6_6_4_A'),
            'Q6_6_4_B' => $this->input->post('Q6_6_4_B'),
            'Q6_6_4_C' => $this->input->post('Q6_6_4_C'),
            'Q6_6_4_D' => $this->input->post('Q6_6_4_D'),
            'Q6_6_4_E' => $this->input->post('Q6_6_4_E'),
            'Q6_6_4_E_OTHER' => $this->input->post('Q6_6_4_E_OTHER'),
            'Q6_6_5_M' => $this->input->post('Q6_6_5_M'),
            'Q6_6_5_D' => $this->input->post('Q6_6_5_D'),
            'Q6_6_6' => $this->input->post('Q6_6_6'),
            'Q6_6_7' => $this->input->post('Q6_6_7'),
            'Q6_7_1' => $this->input->post('Q6_7_1'),
            'Q6_7_1a' => $this->input->post('Q6_7_1a'),
            'Q6_7_2_M' => $this->input->post('Q6_7_2_M'),
            'Q6_7_2_D' => $this->input->post('Q6_7_2_D'),
            'Q6_7_3' => $this->input->post('Q6_7_3'),
            'Q6_7_4' => $this->input->post('Q6_7_4'),
            'Q6_7_5' => $this->input->post('Q6_7_5'),
            'Q6_7_6' => $this->input->post('Q6_7_6'),
            'Q6_7_7' => $this->input->post('Q6_7_7'),
            'Q6_8_1' => $this->input->post('Q6_8_1'),
            'Q6_8_2_M' => $this->input->post('Q6_8_2_M'),
            'Q6_8_2_D' => $this->input->post('Q6_8_2_D'),
            'Q6_8_3' => $this->input->post('Q6_8_3'),
            'Q6_8_4_M' => $this->input->post('Q6_8_4_M'),
            'Q6_8_4_D' => $this->input->post('Q6_8_4_D'),
            'Q6_8_4_1' => $this->input->post('Q6_8_4_1'),
            'Q6_8_4_2_M' => $this->input->post('Q6_8_4_2_M'),
            'Q6_8_4_2_D' => $this->input->post('Q6_8_4_2_D'),
            'Q6_8_5' => $this->input->post('Q6_8_5'),
            'Q6_8_6' => $this->input->post('Q6_8_6'),
            'Q6_8_7' => $this->input->post('Q6_8_7'),
            'Q6_8_8' => $this->input->post('Q6_8_8'),
            'Q6_8_9' => $this->input->post('Q6_8_9'),
            'Q6_8_10' => $this->input->post('Q6_8_10'),
            'Q6_8_11' => $this->input->post('Q6_8_11'),
            'Q6_8_12' => $this->input->post('Q6_8_12'),
            'Q6_8_13' => $this->input->post('Q6_8_13'),
            'Q6_8_14' => $this->input->post('Q6_8_14'),
            'Q6_9_1' => $this->input->post('Q6_9_1'),
            'Q6_9_2' => $this->input->post('Q6_9_2'),
            'Q6_9_3' => $this->input->post('Q6_9_3'),
            'Q6_9_4' => $this->input->post('Q6_9_4'),
            'Q6_9_5' => $this->input->post('Q6_9_5'),
            'Q6_9_6' => $this->input->post('Q6_9_6'),
            'Q6_9_6_1' => $this->input->post('Q6_9_6_1'),
            'Q6_9_7' => $this->input->post('Q6_9_7'),
            'Q6_12_1' => $this->input->post('Q6_12_1'),
            'Q7_1' => $this->input->post('Q7_1'),
            'Q7_1_1_D' => $this->input->post('Q7_1_1_D'),
            'Q7_1_4' => $this->input->post('Q7_1_4'),
            'Q7_2' => $this->input->post('Q7_2'),
            'Q7_2_2' => $this->input->post('Q7_2_2'),
            'Q7_2_3_D' => $this->input->post('Q7_2_3_D'),
            'Q7_2_4' => $this->input->post('Q7_2_4'),
            'Q7_2_5' => $this->input->post('Q7_2_5'),
            'Q7_2_6' => $this->input->post('Q7_2_6'),
            'Q7_2_7' => $this->input->post('Q7_2_7'),
            'Q7_3' => $this->input->post('Q7_3'),
            'Q7_3_3' => $this->input->post('Q7_3_3'),
            'Q8_1' => $this->input->post('Q8_1'),
            'Q8_2' => $this->input->post('Q8_2'),
            'Q8_1_3_A' => $this->input->post('Q8_1_3_A'),
            'Q8_1_3_B' => $this->input->post('Q8_1_3_B'),
            'Q8_1_3_C' => $this->input->post('Q8_1_3_C'),
            'Q8_1_3_D' => $this->input->post('Q8_1_3_D'),
            'Q8_1_3_E' => $this->input->post('Q8_1_3_E'),
            'Q8_1_3_F' => $this->input->post('Q8_1_3_F'),
            'Q8_1_3_G' => $this->input->post('Q8_1_3_G'),
            'Q8_2_3' => $this->input->post('Q8_2_3'),
            'Q8_2_4' => $this->input->post('Q8_2_4'),
            'Q8_2_5' => $this->input->post('Q8_2_5'),
            'Q8_3' => $this->input->post('Q8_3'),
            'Q10_INTERVIEW' => $this->input->post('Q10_INTERVIEW'),
            'Q10_CSQ' => $this->input->post('Q10_CSQ'),
            'Q10_AOC' => $this->input->post('Q10_AOC'),
            'Q10_SO' => $this->input->post('Q10_SO'),
            'Q10_DOE' => $Q10_DOE,
            'Q10_SUP_CODE' => $this->input->post('Q10_SUP_CODE'),
            'inv_status' => $this->input->post('inv_status'),
            'updateBy' => $this->vendorId,
            'updatedOn' => date('Y-m-d H:i:s'),
            'VA_TYPE' => 2);


        //below data for member_death_extended table

        $member_death_extended_info = array(
            'member_death_id' => $member_death_table_id,
            'Q6_13_4' => $this->input->post('Q6_13_4'),
            'Q6_15_1' => $this->input->post('Q6_15_1'),
            'Q6_18_2' => $this->input->post('Q6_18_2'),
            'Q6_18_2_OTHER' => $this->input->post('Q6_18_2_OTHER'),
            'Q6_18_3_Y' => $this->input->post('Q6_18_3_Y'),
            'Q6_18_3_M' => $this->input->post('Q6_18_3_M'),
            'Q6_18_3_D' => $this->input->post('Q6_18_3_D'),
            'Q6_19_1' => $this->input->post('Q6_19_1'),
            'Q6_19_2' => $this->input->post('Q6_19_2'),
            'Q6_19_3' => $this->input->post('Q6_19_3'),
            'Q6_20_1' => $this->input->post('Q6_20_1'),
            'Q6_20_2' => $this->input->post('Q6_20_2'),
            'Q6_20_3' => $this->input->post('Q6_20_3'),
            'Q6_20_4a' => $this->input->post('Q6_20_4a'),
            'Q6_20_4b' => $this->input->post('Q6_20_4b'),
            'Q6_20_5_A' => $this->input->post('Q6_20_5_A'),
            'Q6_20_5_B' => $this->input->post('Q6_20_5_B'),
            'Q6_20_5_C' => $this->input->post('Q6_20_5_C'),
            'Q6_20_5_D' => $this->input->post('Q6_20_5_D'),
            'Q6_20_5_D_OTHER' => $this->input->post('Q6_20_5_D_OTHER'),
            'Q6_21_1' => $this->input->post('Q6_21_1'),
            'Q6_21_2_M' => $this->input->post('Q6_21_2_M'),
            'Q6_21_2_D' => $this->input->post('Q6_21_2_D'),
            'Q6_21_3' => $this->input->post('Q6_21_3'),
            'Q7_1_1_A' => $this->input->post('Q7_1_1_A'),
            'Q7_1_1_A_OTHER' => $this->input->post('Q7_1_1_A_OTHER'),
            'Q7_1_1_B' => $this->input->post('Q7_1_1_B'),
            'Q7_1_1_B_OTHER' => $this->input->post('Q7_1_1_B_OTHER'),
            'Q7_1_1_C' => $this->input->post('Q7_1_1_C'),
            'Q7_1_1_C_OTHER' => $this->input->post('Q7_1_1_C_OTHER'),
            'Q7_1_1_D_OTHER' => $this->input->post('Q7_1_1_D_OTHER'),
            'Q7_1_2' => $this->input->post('Q7_1_2'),
            'Q7_1_2_OTHER' => $this->input->post('Q7_1_2_OTHER'),
            'Q7_1_3_A' => $this->input->post('Q7_1_3_A'),
            'Q7_1_3_B' => $this->input->post('Q7_1_3_B'),
            'Q7_1_3_C' => $this->input->post('Q7_1_3_C'),
            'Q7_1_3_D' => $this->input->post('Q7_1_3_D'),
            'Q7_1_3_E' => $this->input->post('Q7_1_3_E'),
            'Q7_1_3_F' => $this->input->post('Q7_1_3_F'),
            'Q7_1_3_F_OTHER' => $this->input->post('Q7_1_3_F_OTHER'),
            'Q7_2_1_1_HCODE' => $this->input->post('Q7_2_1_1_HCODE'),
            'Q7_2_1_1_DATE' => $Q7_2_1_1_DATE,
            'Q7_2_1_1_CAUSE' => $this->input->post('Q7_2_1_1_CAUSE'),
            'Q7_2_1_2_HCODE' => $this->input->post('Q7_2_1_2_HCODE'),
            'Q7_2_1_2_DATE' => $Q7_2_1_2_DATE,
            'Q7_2_1_2_CAUSE' => $this->input->post('Q7_2_1_2_CAUSE'),
            'Q7_2_1_3_HCODE' => $this->input->post('Q7_2_1_3_HCODE'),
            'Q7_2_1_3_DATE' => $Q7_2_1_3_DATE,
            'Q7_2_1_3_CAUSE' => $this->input->post('Q7_2_1_3_CAUSE'),
            'Q7_2_3_A' => $this->input->post('Q7_2_3_A'),
            'Q7_2_3_B' => $this->input->post('Q7_2_3_B'),
            'Q7_2_3_C' => $this->input->post('Q7_2_3_C'),
            'Q7_2_3_D_OTHER' => $this->input->post('Q7_2_3_D_OTHER'),
            'Q7_3_OTHER' => $this->input->post('Q7_3_OTHER'),
            'Q7_3_1_Hname_Haddress' => $this->input->post('Q7_3_1_Hname_Haddress'),
            'Q7_3_2' => $this->input->post('Q7_3_2'),
            'Q7_3_3_OTHER' => $this->input->post('Q7_3_3_OTHER'),
            'Q7_3_4' => $this->input->post('Q7_3_4'),
            'Q8_1_1' => $this->input->post('Q8_1_1'),
            'Q8_1_1_SYMP' => $this->input->post('Q8_1_1_SYMP'),
            'Q8_1_1_DIAG' => $this->input->post('Q8_1_1_DIAG'),
            'Q8_1_1_TRET' => $this->input->post('Q8_1_1_TRET'),
            'Q8_1_2_weight_1' => $this->input->post('Q8_1_2_weight_1'),
            'Q8_1_2_weight_2' => $this->input->post('Q8_1_2_weight_2'),
            'Q8_1_3_H' => $this->input->post('Q8_1_3_H'),
            'Q8_1_3_I' => $this->input->post('Q8_1_3_I'),
            'Q8_1_3_J' => $this->input->post('Q8_1_3_J'),
            'Q8_1_3_J_OTHER' => $this->input->post('Q8_1_3_J_OTHER'),
            'Q8_2_1' => $this->input->post('Q8_2_1'),
            'Q8_2_2_ICAUSE' => $this->input->post('Q8_2_2_ICAUSE'),
            'Q8_2_2_ICODE' => $this->input->post('Q8_2_2_ICODE'),
            'Q8_2_2_ACAUSE' => $this->input->post('Q8_2_2_ACAUSE'),
            'Q8_2_2_ACODE' => $this->input->post('Q8_2_2_ACODE'),
            'Q8_2_2_UCAUSE' => $this->input->post('Q8_2_2_UCAUSE'),
            'Q8_2_2_UCODE' => $this->input->post('Q8_2_2_UCODE'),
            'Q8_2_2_CCAUSE' => $this->input->post('Q8_2_2_CCAUSE'),
            'Q8_2_2_CCODE' => $this->input->post('Q8_2_2_CCODE'),
            'Q8_3_1' => $this->input->post('Q8_3_1'),
            'Q8_3_2' => $Q8_3_2,
            'Q8_3_3' => $this->input->post('Q8_3_3'),
            'Q6_9_8' => $this->input->post('Q6_9_8'), //shiftable
            'Q6_9_8_OTHER' => $this->input->post('Q6_9_8_OTHER'), //shiftable
            'Q6_10_1' => $this->input->post('Q6_10_1'), //shiftable
            'Q6_10_2_D' => $this->input->post('Q6_10_2_D'), //shiftable
            'Q6_10_2_H' => $this->input->post('Q6_10_2_H'), //shiftable
            'Q6_10_3' => $this->input->post('Q6_10_3'), //shiftable
            'Q6_10_3_OTHER' => $this->input->post('Q6_10_3_OTHER'), //shiftable
            'Q6_10_4' => $this->input->post('Q6_10_4'), //shiftable
            'Q6_11_1' => $this->input->post('Q6_11_1'), //shiftable
            'Q6_11_2' => $this->input->post('Q6_11_2'), //shiftable
            'Q6_11_2_OTHER' => $this->input->post('Q6_11_2_OTHER'), //shiftable
            'Q6_11_3' => $this->input->post('Q6_11_3'), //shiftable
            'Q6_11_3_OTHER' => $this->input->post('Q6_11_3_OTHER'), //shiftable
            'Q6_11_4' => $this->input->post('Q6_11_4'), //shiftable
            'Q6_11_5_D' => $this->input->post('Q6_11_5_D'), //shiftable
            'Q6_11_5_H' => $this->input->post('Q6_11_5_H'), //shiftable
            'Q6_12_1a' => $this->input->post('Q6_12_1a'), //shiftable
            //till 01-07-2020
            'Q6_12_2_D' => $this->input->post('Q6_12_2_D'), //shiftable
            'Q6_12_2_H' => $this->input->post('Q6_12_2_H'), //shiftable
            'Q6_12_3' => $this->input->post('Q6_12_3'), //shiftable
            'Q6_12_4' => $this->input->post('Q6_12_4'), //shiftable
            'Q6_13_1' => $this->input->post('Q6_13_1'), //shiftable
            'Q6_13_2' => $this->input->post('Q6_13_2'), //shiftable
            'Q6_13_2_OTHER' => $this->input->post('Q6_13_2_OTHER'), //shiftable
            'Q6_13_3' => $this->input->post('Q6_13_3'), //shiftable
            'Q6_14_1' => $this->input->post('Q6_14_1'), //shiftable
            'Q6_14_2' => $this->input->post('Q6_14_2'), //shiftable
            'Q6_14_3_M' => $this->input->post('Q6_14_3_M'), //shiftable
            'Q6_14_3_D' => $this->input->post('Q6_14_3_D'), //shiftable
            'Q6_15_2' => $this->input->post('Q6_15_2'), //shiftable
            'Q6_15_3_M' => $this->input->post('Q6_15_3_M'), //shiftable
            'Q6_15_3_D' => $this->input->post('Q6_15_3_D'), //shiftable
            'Q6_15_4' => $this->input->post('Q6_15_4'), //shiftable
            'Q6_15_5' => $this->input->post('Q6_15_5'), //shiftable
            'Q6_16' => $this->input->post('Q6_16'), //shiftable
            'Q6_16a' => $this->input->post('Q6_16a'), //shiftable
            'Q6_16b' => $this->input->post('Q6_16b'), //shiftable
            'Q6_16_1' => $this->input->post('Q6_16_1'), //shiftable
            'Q6_16_2' => $this->input->post('Q6_16_2'), //shiftable
            'Q6_16_3' => $this->input->post('Q6_16_3'), //shiftable
            'Q6_16_4' => $this->input->post('Q6_16_4'), //shiftable
            'Q6_17_1' => $this->input->post('Q6_17_1'), //shiftable
            'Q6_17_2_D' => $this->input->post('Q6_17_2_D'), //shiftable
            'Q6_17_2_H' => $this->input->post('Q6_17_2_H'), //shiftable
            'Q6_17_3' => $this->input->post('Q6_17_3'), //shiftable
            'Q6_17_4_D' => $this->input->post('Q6_17_4_D'), //shiftable
            'Q6_17_4_H' => $this->input->post('Q6_17_4_H'), //shiftable
            'Q6_17_5' => $this->input->post('Q6_17_5'), //shiftable
            'Q6_17_6' => $this->input->post('Q6_17_6'), //shiftable
            'Q6_18_1' => $this->input->post('Q6_18_1'), //shiftable
            
            'I_A' => $this->input->post('I_A'),
            'I_B' => $this->input->post('I_B'),
            'I_C' => $this->input->post('I_C'),
            'I_D' => $this->input->post('I_D'),
            'II_A' => $this->input->post('II_A'),
            'II_B' => $this->input->post('II_B'),
            'verbal_autopsy_specialist_name' => $this->input->post('verbal_autopsy_specialist_name')
        );


//        echo '<pre/>';
//        print_r($IDInfo);
//        exit();
        //inputs

        $this->db->trans_start();

        $result_1 = $this->modelName->updateInfo($member_death_info, $member_death_table_id, $this->config->item('deathTable'));

        $this->db->from($this->config->item('deathTableExtended'));
        $this->db->where('member_death_id', $member_death_table_id);
        $query = $this->db->get();
        $deathTableExtended_existence = $query->row();

        if ($deathTableExtended_existence == true) {
            $result_2 = $this->modelName->updateExtendedTable($member_death_extended_info, $member_death_table_id, $this->config->item('deathTableExtended'));
        } else {
            $result_2 = $this->modelName->InsertInfo($member_death_extended_info, $this->config->item('deathTableExtended'));
        }

        $this->db->trans_complete();


        if ($result_1 == true && $result_2 == true) {
            $this->session->set_flashdata('success', $this->pageShortName . ' updated successfully');
        } else {
            $this->session->set_flashdata('error', $this->pageShortName . ' update failed');
        }

        //redirect($this->controller . '/EditChild/'.$member_death_table_id.'?baseID=' . $baseID);
        redirect($this->controller . '/editChild/' . $member_death_table_id . '?household_master_id=' . $household_master_id . '&&baseID=' . $baseID);
    }

    public function adult() {


        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['addMethod'] = 'addNew';
        $data['editMethod'] = 'editOld';
        $data['shortName'] = 'Adult';
        $data['boxTitle'] = 'List';




        $data['userRecords'] = $this->modelName->adultListing($this->config->item('deathTable'));


        $data['fields'] = $this->modelName->getFields($this->config->item('deathTable'));
        $data['lookUp'] = $this->modelName->getLookUpInfo();
        $data['textField'] = $this->modelName->getTextField();
        $data['dateFields'] = $this->modelName->getDateFields();

        $data['dropdown'] = $this->modelName->getDropdown($data['fields'], $data['textField'], $data['dateFields']);


        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');



        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/index_adult', $data);
        $this->load->view('includes/footer');
    }

    public function sav_format_adult() {

        $columns = $this->modelName->column_names_adult($this->config->item('deathTable'));

        $variables = array();

        $array = $this->modelName->adultListing($this->config->item('deathTable'));

        foreach ($columns as $col_value) {

            $new_array = array_column($array, $col_value);

            $variable = [
                'name' => $col_value,
                'format' => 2, // String Type
                'width' => 50,
                'data' => $new_array
            ];

            array_push($variables, $variable);
        }

//        echo "<pre/>";
//        print_r($variables); exit();

        require_once __DIR__ . '/../../sav_vendor/autoload.php';

        $writer = new \SPSS\Sav\Writer([
            'header' => [
                'prodName' => 'Adult List Report',
                'layoutCode' => 2,
                'compression' => 1,
                'weightIndex' => 0,
                'bias' => 100,
                'creationDate' => date('Y-m-d'),
                'creationTime' => date('H:i:s')
            ],
            'variables' => $variables
        ]);

        $writer->save('Adult_List_Report.sav');

        $file = 'Adult_List_Report.sav';
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

    public function dta_format_adult() {

        $result = $this->modelName->adultListing($this->config->item('deathTable'));

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "Adult_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'Adult_List_Report.dta';
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

    public function child() {

        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['addMethod'] = 'addNew';
        $data['editMethod'] = 'editOld';
        $data['shortName'] = 'Child';
        $data['boxTitle'] = 'List';
        $data['userRecords'] = $this->modelName->ChildListing($this->config->item('deathTable'));

//            echo '<pre/>';
//            print_r($data['userRecords']); exit();

        $data['fields'] = $this->modelName->getChildFields($this->config->item('deathTable'));

        //print_r($data['fields']);
        $data['lookUp'] = $this->modelName->getLookUpInfo();
        $data['textField'] = $this->modelName->getChildTextField();
        $data['dateFields'] = $this->modelName->getChildDateFields();

        $data['textarea'] = ["Q4_1_death_reasons", "Q7_3_1_Hname_Haddress", "Q7_3_4", "Q10_INTERVIEW", "Q10_CSQ", "Q10_AOC", "Q10_SO"];
        $data['dropdown'] = $this->modelName->getChildDropdown($data['fields'], $data['textField'], $data['dateFields'], $data['textarea']);

        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');


        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/index_child', $data);
        $this->load->view('includes/footer');
    }

    public function sav_format_child() {

        $columns = $this->modelName->column_names_child($this->config->item('deathTable'));

        $variables = array();

        $array = $this->modelName->ChildListing($this->config->item('deathTable'));

        foreach ($columns as $col_value) {

            $new_array = array_column($array, $col_value);

            $variable = [
                'name' => $col_value,
                'format' => 2, // String Type
                'width' => 50,
                'data' => $new_array
            ];

            array_push($variables, $variable);
        }

//        echo "<pre/>";
//        print_r($variables); exit();

        require_once __DIR__ . '/../../sav_vendor/autoload.php';

        $writer = new \SPSS\Sav\Writer([
            'header' => [
                'prodName' => 'Child List Report',
                'layoutCode' => 2,
                'compression' => 1,
                'weightIndex' => 0,
                'bias' => 100,
                'creationDate' => date('Y-m-d'),
                'creationTime' => date('H:i:s')
            ],
            'variables' => $variables
        ]);

        $writer->save('Child_List_Report.sav');

        $file = 'Child_List_Report.sav';
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

    public function dta_format_child() {

        $result = $this->modelName->ChildListing($this->config->item('deathTable'));

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "Child_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'Child_List_Report.dta';
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

    public function neonate() {


        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = $this->pageTitle;
        $data['controller'] = $this->controller;
        $data['addMethod'] = 'addNew';
        $data['editMethod'] = 'editOld';
        $data['shortName'] = 'Adult';
        $data['boxTitle'] = 'List';

        // $data['userRecords'] = $this->modelName->adultListing($this->config->item('deathTable'));
        $data['userRecords'] = $this->modelName->NeonateListing($this->config->item('deathTable'));
        $data['fields'] = $this->modelName->getNeonateFields($this->config->item('deathTable'));
        $data['lookUp'] = $this->modelName->getLookUpInfo();
        $data['textField'] = $this->modelName->getNeonateTextField();
        $data['dateFields'] = $this->modelName->getNeonateDateFields();
        $data['textarea'] = ["Q4_1_death_reasons", "Q6_5_1", "Q6_5_3_ADDRESS", "Q6_6_4", "Q6_6_12", "Q8_3_2_HOSPITAL_ADDRESS", "Q8_4_2", "Q10_INTERVIEW", "Q10_CSQ", "Q10_AOC", "Q10_SO"];

        $data['dropdown'] = $this->modelName->getNeonateDropdown($data['fields'], $data['textField'], $data['dateFields'], $data['textarea']);


        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');


        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/index_neonatal', $data);
        $this->load->view('includes/footer');
    }

}

?>