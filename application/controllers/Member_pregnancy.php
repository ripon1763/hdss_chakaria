<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Member_pregnancy extends BaseController {

    /**
     * This is default constructor of the class
     */
    public $controller = "member_pregnancy";
    public $pageTitle = 'Member Pregnancy Management';
    public $pageShortName = 'Member Pregnancy';

    public function __construct() {
        parent::__construct();
        $this->load->model('pregnancy_model', 'modelName');
        $this->load->model('menu_model', 'menuModel');
        $this->load->library('pagination');
        $this->isLoggedIn();
        $menu_key = 'mp';
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
        $data['shortName'] = $this->pageShortName;
        $data['boxTitle'] = 'List';
		
		$data['roundlist'] = $this->modelName->getRoundListList();
		$round_master_id = 0;
		$data['round_master_id'] = 0;
		
		if($this->input->post('Clear'))
		{
			$this->session->unset_userdata('round_master_id'); 
			$data['round_master_id'] = 0;
		}
		
		$round_master_id = $this->input->post('round_master_id',true);
		
		$data['round_master_id'] = $this->session->userdata('round_master_id');
		
		if($this->input->post('search'))
		{
		
			 $this->session->set_userdata('round_master_id', $round_master_id);
			 $data['round_master_id'] = $this->session->userdata('round_master_id');
		
		}
		
		if ((!empty($data['round_master_id'])))
		{
		
		  $data['userRecords'] = $this->modelName->listing($this->config->item('pregnancyTable'),$data['round_master_id']);
		}


       // $data['userRecords'] = $this->modelName->listing($this->config->item('pregnancyTable'));

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
    function addNew($id) {
        
        $data['VA_Relation'] = $this->modelName->getLookUpList($this->config->item('VA_Relation'));
        $data['va_yes_no'] = $this->modelName->getLookUpList($this->config->item('va_yes_no'));
        $data['va_gender'] = $this->modelName->getLookUpList($this->config->item('va_gender'));
        $data['VA_Marital_Status'] = $this->modelName->getLookUpList($this->config->item('VA_Marital_Status'));
        $data['VA_Yes_No_Reluctant_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Yes_No_Reluctant_Unknown'));
        $data['VA_Education_Institute_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Education_Institute_Type'));
        $data['VA_Occupation_Type'] = $this->modelName->getLookUpList($this->config->item('VA_Occupation_Type'));
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
        $data['VA_Weight_Specific'] = $this->modelName->getLookUpList($this->config->item('VA_Weight_Specific'));
        $data['VA_Organ_Distortion'] = $this->modelName->getLookUpList($this->config->item('VA_Organ_Distortion'));
        $data['VA_Day_Hour_Reluctant_Unknown'] = $this->modelName->getLookUpList($this->config->item('VA_Day_Hour_Reluctant_Unknown'));


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
        $data['member_pregnancy_id'] = $id;
		
		$data['userRecords'] = $this->modelName->get_member_info($this->config->item('pregnancyTable'), $data['member_pregnancy_id']);
		
		


        $this->load->view('includes/header', $this->global);
        $this->load->view($this->controller . '/addNew', $data);
        $this->load->view('includes/footer');
    }

    /**
     * This function is used to add new
     */
    function addNewList() {

        $baseID = $this->input->get('baseID', TRUE);

        $Q2_6_DATE = "";

        if (!empty($this->input->post('Q2_6_DATE'))) {
            $parts = explode('/', $this->input->post('Q2_6_DATE'));
            $Q2_6_DATE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $Q2_14_DOE = "";
        if (!empty($this->input->post('Q2_14_DOE'))) {
            $parts = explode('/', $this->input->post('Q2_14_DOE'));
            $Q2_14_DOE = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        $IdInfo = array(
            'member_pregnancy_id'=>$this->input->post('member_pregnancy_id'),
            
            'Q1_1_N1' => $this->input->post('Q1_1_N1'),
            'Q1_6' => $this->input->post('Q1_6'),
            'Q1_7' => $this->input->post('Q1_7'),
            'Q1_8' => $this->input->post('Q1_8'),
            'Q1_1_CID' => $this->input->post('Q1_1_CID'),
            'Q1_1_LPODT' => $this->input->post('Q1_1_LPODT'),
            'Q1_2' => $this->input->post('Q1_2'),
            'Q1_3' => $this->input->post('Q1_3'),
            'Q1_4' => $this->input->post('Q1_4'),
            'Q1_4_DAY_OR_MONTH' => $this->input->post('Q1_4_DAY_OR_MONTH'),
            'Q1_5a' => $this->input->post('Q1_5a'),
            'Q1_5b' => $this->input->post('Q1_5b'),
            'Q1_9' => $this->input->post('Q1_9'),
            'Q1_10' => $this->input->post('Q1_10'),
            'Q1_11' => $this->input->post('Q1_11'),
            'Q1_12' => $this->input->post('Q1_12'),
            'Q1_13' => $this->input->post('Q1_13'),
            'Q1_13_kg' => $this->input->post('Q1_13_kg'),
            'Q1_14' => $this->input->post('Q1_14'),
            'Q1_15' => $this->input->post('Q1_15'),
            'Q1_15_OTHER' => $this->input->post('Q1_15_OTHER'),
            'Q2_A' => $this->input->post('Q2_A'),
            'Q2_B' => $this->input->post('Q2_B'),
            'Q2_C' => $this->input->post('Q2_C'),
            'Q2_D' => $this->input->post('Q2_D'),
            'Q2_E' => $this->input->post('Q2_E'),
            'Q2_F' => $this->input->post('Q2_F'),
            'Q2_G' => $this->input->post('Q2_G'),
            'Q2_G_OTHER' => $this->input->post('Q2_G_OTHER'),
            'Q2_1_1' => $this->input->post('Q2_1_1'),
            'Q2_1_2' => $this->input->post('Q2_1_2'),
            'Q2_1_3' => $this->input->post('Q2_1_3'),
            'Q2_1_4' => $this->input->post('Q2_1_4'),
            'Q2_1_5' => $this->input->post('Q2_1_5'),
            'Q2_1_6' => $this->input->post('Q2_1_6'),
            'Q2_1_7' => $this->input->post('Q2_1_7'),
            'Q2_1_8' => $this->input->post('Q2_1_8'),
            'Q2_1_9' => $this->input->post('Q2_1_9'),
            'Q2_1_10' => $this->input->post('Q2_1_10'),
            'Q2_1_11' => $this->input->post('Q2_1_11'),
            'Q2_1_12' => $this->input->post('Q2_1_12'),
            'Q2_1_13' => $this->input->post('Q2_1_13'),
            'Q2_1_14' => $this->input->post('Q2_1_14'),
            'Q2_1_15' => $this->input->post('Q2_1_15'),
            'Q2_1_16' => $this->input->post('Q2_1_16'),
            'Q2_1_17' => $this->input->post('Q2_1_17'),
            'Q2_1_18' => $this->input->post('Q2_1_18'),
            'Q2_1_19' => $this->input->post('Q2_1_19'),
            'Q2_1_20' => $this->input->post('Q2_1_20'),
            'Q2_1_21' => $this->input->post('Q2_1_21'),
            'Q2_1_22' => $this->input->post('Q2_1_22'),
            'Q2_1_23' => $this->input->post('Q2_1_23'),
            'Q2_1_23_OTHER' => $this->input->post('Q2_1_23_OTHER'),
            'Q2_2' => $this->input->post('Q2_2'),
            'Q2_3' => $this->input->post('Q2_3'),
            'Q2_4_A' => $this->input->post('Q2_4_A'),
            'Q2_4_B' => $this->input->post('Q2_4_B'),
            'Q2_4_C' => $this->input->post('Q2_4_C'),
            'Q2_5_alive' => $this->input->post('Q2_5_alive'),
            'Q2_5_dead' => $this->input->post('Q2_5_dead'),
            'Q2_5_mr' => $this->input->post('Q2_5_mr'),
            'Q2_6_DATE' => $Q2_6_DATE,
            'Q2_7' => $this->input->post('Q2_7'),
            'Q2_8' => $this->input->post('Q2_8'),
            'Q2_9' => $this->input->post('Q2_9'),
            'Q2_10' => $this->input->post('Q2_10'),
            'Q2_10_DAY_OR_HOUR' => $this->input->post('Q2_10_DAY_OR_HOUR'),
            'Q2_11' => $this->input->post('Q2_11'),
            'Q2_12' => $this->input->post('Q2_12'),
            'Q2_12_OTHER' => $this->input->post('Q2_12_OTHER'),
            'Q2_13' => $this->input->post('Q2_13'),
            'Q2_14' => $this->input->post('Q2_14'),
            'Q2_14_comment' => $this->input->post('Q2_14_comment'),
            'Q2_14_DOE' => $Q2_14_DOE,
            'Q2_14_SUP_CODE' => $this->input->post('Q2_14_SUP_CODE'),
            
            'insertedBy' => $this->vendorId,
            'insertedOn' => date('Y-m-d H:i:s')
        );
        
//        echo "<pre/>";
//        print_r($IdInfo); exit();

        $result = $this->modelName->InsertInfo($IdInfo, $this->config->item('stillBirthTable'));

        if ($result > 0) {
            $this->session->set_flashdata('success', $this->pageShortName . ' created successfully');
        } else {
            $this->session->set_flashdata('error', $this->pageShortName . ' creation failed');
        }

       // redirect($this->controller . '?baseID=' . $baseID);
	   
	   redirect('member_stillbirth/editStillBirth/'.$result.'?baseID=' . $baseID);
    }

}

?>