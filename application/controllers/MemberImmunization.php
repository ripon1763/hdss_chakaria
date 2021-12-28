<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberImmunization extends BaseController {

    /**
     * This is default constructor of the class
     */
    public $controller = "MemberImmunization";
    public $pageTitle = 'Member Immunization';
    public $pageShortName = 'Member Immunization';

    public function __construct() {
        parent::__construct();
        $this->load->model('master_model', 'modelName');
        $this->load->model('member_model', 'memberModel');
        $this->load->model('householdVisit_model', 'visitModel');
        $this->load->model('memberImmunization_model', 'immunizationModel');
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

    public function addEditImmunization($id) {

        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id_current = $this->input->get('household_master_id', TRUE);
        $member_master_id_current = $this->input->get('member_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : Member Immunization';
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

        $data['immunizationRecord'] = $this->immunizationModel->getImmunizationDetailsByIdnHousehold($id, $data['household_master_id_sub'], $data['round_master_id']);

       //echo "<pre/>";
       //print_r($data['immunizationRecord']); exit();

        $data['why_not_seen_card'] = $this->modelName->getLookUpList($this->config->item('why_not_seen_card'));
        $data['interview_status_immunization'] = $this->modelName->getLookUpList($this->config->item('interview_status_immunization'));
        $data['information_recorded_from'] = $this->modelName->getLookUpList($this->config->item('information_recorded_from'));
        $data['yes_no'] = $this->modelName->getLookUpList($this->config->item('yes_no'));

        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard', $data);
        $this->load->view($this->controller . '/immunization_edit_details', $data);
        $this->load->view('includes/footer');
    }

    function editImmunizationDetails() {

        $household_master_id = $this->input->post('household_master_id_sub', true);
        $round_master_id = $this->input->post('round_master_id', true);
        $immunizationID = $this->input->post('immunizationID', true);
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('CH1', 'Did the child get any vaccine?', 'trim|required|numeric');
        $this->form_validation->set_rules('interview_status', 'Interview status', 'trim|required|numeric');
        $this->form_validation->set_rules('followup_exit_date', 'Child follow up exit date', 'trim|required');
        $this->form_validation->set_rules('folowup_exit_round', 'Child follow up exit round', 'trim|required|numeric');
        $this->form_validation->set_rules('Q20', 'Have the vaccination card?', 'trim|required|numeric');

        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {
            redirect('memberDeath/addEditImmunization/' . $immunizationID . '?household_master_id=' . $household_master_id . '&&member_master_id=' . $member_master_id . '&&baseID=' . $baseID . '#immunization');
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect('householdvisit/visit?baseID=' . $baseID);
            }


            $BCG = $this->input->post('BCG', true);
            $new_BCG = null;
            if (!empty($BCG)) {
                $parts3 = explode('/', $BCG);
                $new_BCG = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $PENTA1 = $this->input->post('PENTA1', true);
            $new_PENTA1 = null;
            if (!empty($PENTA1)) {
                $parts3 = explode('/', $PENTA1);
                $new_PENTA1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $PENTA2 = $this->input->post('PENTA2', true);
            $new_PENTA2 = null;
            if (!empty($PENTA2)) {
                $parts3 = explode('/', $PENTA2);
                $new_PENTA2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $PENTA3 = $this->input->post('PENTA3', true);
            $new_PENTA3 = null;
            if (!empty($PENTA3)) {
                $parts3 = explode('/', $PENTA3);
                $new_PENTA3 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $PCV1 = $this->input->post('PCV1', true);
            $new_PCV1 = null;
            if (!empty($PCV1)) {
                $parts3 = explode('/', $PCV1);
                $new_PCV1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }
            $PCV2 = $this->input->post('PCV2', true);
            $new_PCV2 = null;
            if (!empty($PCV2)) {
                $parts3 = explode('/', $PCV2);
                $new_PCV2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $PPV3 = $this->input->post('PPV3', true);
            $new_PPV3 = null;
            if (!empty($PPV3)) {
                $parts3 = explode('/', $PPV3);
                $new_PPV3 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $OPV1 = $this->input->post('OPV1', true);
            $new_OPV1 = null;
            if (!empty($OPV1)) {
                $parts3 = explode('/', $OPV1);
                $new_OPV1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $OPV2 = $this->input->post('OPV2', true);
            $new_OPV2 = null;
            if (!empty($OPV2)) {
                $parts3 = explode('/', $OPV2);
                $new_OPV2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $OPV3 = $this->input->post('OPV3', true);
            $new_OPV3 = null;
            if (!empty($OPV3)) {
                $parts3 = explode('/', $OPV3);
                $new_OPV3 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $MR1 = $this->input->post('MR1', true);
            $new_MR1 = null;
            if (!empty($MR1)) {
                $parts3 = explode('/', $MR1);
                $new_MR1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $MR2 = $this->input->post('MR2', true);
            $new_MR2 = null;
            if (!empty($MR2)) {
                $parts3 = explode('/', $MR2);
                $new_MR2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $FIPV1 = $this->input->post('FIPV1', true);
            $new_FIPV1 = null;
            if (!empty($FIPV1)) {
                $parts3 = explode('/', $FIPV1);
                $new_FIPV1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $FIPV2 = $this->input->post('FIPV2', true);
            $new_FIPV2 = null;
            if (!empty($FIPV2)) {
                $parts3 = explode('/', $FIPV2);
                $new_FIPV2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }
            $FIPV3 = $this->input->post('FIPV3', true);
            $new_FIPV3 = null;
            if (!empty($FIPV3)) {
                $parts3 = explode('/', $FIPV3);
                $new_FIPV3 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $VITA1 = $this->input->post('VITA1', true);
            $new_VITA1 = null;
            if (!empty($VITA1)) {
                $parts3 = explode('/', $VITA1);
                $new_VITA1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }
            $VITA2 = $this->input->post('VITA2', true);
            $new_VITA2 = null;
            if (!empty($VITA2)) {
                $parts3 = explode('/', $VITA2);
                $new_VITA2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $followup_exit_date = $this->input->post('followup_exit_date', true);

            $new_followup_exit_date = null;
            if (!empty($followup_exit_date)) {
                $parts3 = explode('/', $followup_exit_date);
                $new_followup_exit_date = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $Q20 = $this->input->post('Q20', true);
            $Q21 = 0;
            $Q22 = 0;
            if ($Q20 == 1) {
                $Q21 = $this->input->post('Q21', true);
            }
            $Q21 = $this->input->post('Q21', true);
            if ($Q21 != 1) {
                $Q22 = $this->input->post('Q22', true);
            }

            $Q22OTH = NULL;

            if ($Q22 == 436) {
                $Q22OTH = $this->input->post('Q22OTH', true);
            }
            $CH1 = $this->input->post('CH1', true);


            if ($CH1 == 1) {
                $info_first_part = array(
                    'BCG' => $new_BCG,
                    'BCGFROM' => $this->input->post('BCGFROM', true),
                    'BCGFROM' => $this->input->post('BCGFROM', true),
                    'BCGOTH' => $this->input->post('BCGOTH', true),
                    'PENTA1' => $new_PENTA1,
                    'PENTA1FROM' => $this->input->post('PENTA1FROM', true),
                    'PENTA1OTH' => $this->input->post('PENTA1OTH', true),
                    'PENTA2' => $new_PENTA2,
                    'PENTA2FROM' => $this->input->post('PENTA2FROM', true),
                    'PENTA2OTH' => $this->input->post('PENTA2OTH', true),
                    'PENTA3' => $new_PENTA3,
                    'PENTA3FROM' => $this->input->post('PENTA3FROM', true),
                    'PENTA3OTH' => $this->input->post('PENTA3OTH', true),
                    'PCV1' => $new_PCV1,
                    'PCV1FROM' => $this->input->post('PCV1FROM', true),
                    'PCV1OTH' => $this->input->post('PCV1OTH', true),
                    'PCV2' => $new_PCV2,
                    'PCV2FROM' => $this->input->post('PCV2FROM', true),
                    'PCV2OTH' => $this->input->post('PCV2OTH', true),
                    'PPV3' => $new_PPV3,
                    'PPV3FROM' => $this->input->post('PPV3FROM', true),
                    'PPV3OTH' => $this->input->post('PPV3OTH', true),
                    'OPV1' => $new_OPV1,
                    'OPV1FROM' => $this->input->post('OPV1FROM', true),
                    'OPV1OTH' => $this->input->post('OPV1OTH', true),
                    'OPV2' => $new_OPV2,
                    'OPV2FROM' => $this->input->post('OPV2FROM', true),
                    'OPV2OTH' => $this->input->post('OPV2OTH', true),
                    'OPV3' => $new_OPV3,
                    'OPV3FROM' => $this->input->post('OPV3FROM', true),
                    'OPV3OTH' => $this->input->post('OPV3OTH', true),
                    'MR1' => $new_MR1,
                    'MR1FROM' => $this->input->post('MR1FROM', true),
                    'MR1OTH' => $this->input->post('MR1OTH', true),
                    'MR2' => $new_MR2,
                    'MR2FROM' => $this->input->post('MR2FROM', true),
                    'MR2OTH' => $this->input->post('MR2OTH', true),
                    'FIPV1' => $new_FIPV1,
                    'FIPV1FROM' => $this->input->post('FIPV1FROM', true),
                    'FIPV1OTH' => $this->input->post('FIPV1OTH', true),
                    'FIPV2' => $new_FIPV2,
                    'FIPV2FROM' => $this->input->post('FIPV2FROM', true),
                    'FIPV2OTH' => $this->input->post('FIPV2OTH', true),
                    'FIPV3' => $new_FIPV3,
                    'FIPV3FROM' => $this->input->post('FIPV3FROM', true),
                    'FIPV3OTH' => $this->input->post('FIPV3OTH', true),
                    'VITA1' => $new_VITA1,
                    'VITA1FROM' => $this->input->post('VITA1FROM', true),
                    'VITA1OTH' => $this->input->post('VITA1OTH', true),
                    'VITA2' => $new_VITA2,
                    'VITA2FROM' => $this->input->post('VITA2FROM', true),
                    'VITA2OTH' => $this->input->post('VITA2OTH', true)
                );
            } else {
                $info_first_part = array(
                    'BCG' => NULL,
                    'BCGFROM' => NULL,
                    'BCGFROM' => NULL,
                    'BCGOTH' => NULL,
                    'PENTA1' => NULL,
                    'PENTA1FROM' => NULL,
                    'PENTA1OTH' => NULL,
                    'PENTA2' => NULL,
                    'PENTA2FROM' => NULL,
                    'PENTA2OTH' => NULL,
                    'PENTA3' => NULL,
                    'PENTA3FROM' => NULL,
                    'PENTA3OTH' => NULL,
                    'PCV1' => NULL,
                    'PCV1FROM' => NULL,
                    'PCV1OTH' => NULL,
                    'PCV2' => NULL,
                    'PCV2FROM' => NULL,
                    'PCV2OTH' => NULL,
                    'PPV3' => NULL,
                    'PPV3FROM' => NULL,
                    'PPV3OTH' => NULL,
                    'OPV1' => NULL,
                    'OPV1FROM' => NULL,
                    'OPV1OTH' => NULL,
                    'OPV2' => NULL,
                    'OPV2FROM' => NULL,
                    'OPV2OTH' => NULL,
                    'OPV3' => NULL,
                    'OPV3FROM' => NULL,
                    'OPV3OTH' => NULL,
                    'MR1' => NULL,
                    'MR1FROM' => NULL,
                    'MR1OTH' => NULL,
                    'MR2' => NULL,
                    'MR2FROM' => NULL,
                    'MR2OTH' => NULL,
                    'FIPV1' => NULL,
                    'FIPV1FROM' => NULL,
                    'FIPV1OTH' => NULL,
                    'FIPV2' => NULL,
                    'FIPV2FROM' => NULL,
                    'FIPV2OTH' => NULL,
                    'FIPV3' => NULL,
                    'FIPV3FROM' => NULL,
                    'FIPV3OTH' => NULL,
                    'VITA1' => NULL,
                    'VITA1FROM' => NULL,
                    'VITA1OTH' => NULL,
                    'VITA2' => NULL,
                    'VITA2FROM' => NULL,
                    'VITA2OTH' => NULL
                );
            }

            $this->db->trans_start();

            try {
                $info_second_part = array(
                    'CH1' => $this->input->post('CH1', true),
                    'Q20' => $Q20,
                    'Q21' => $Q21,
                    'Q22' => $Q22,
                    'Q22OTH' => $Q22OTH,
                    'interview_status' => $this->input->post('interview_status', true),
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $IdInfo = array_merge($info_first_part, $info_second_part);

                $this->immunizationModel->edit($IdInfo, $immunizationID);
                
                $fk_followup_exit_type=0;
                
                if($this->input->post('interview_status', true)==437||$this->input->post('interview_status', true)==438){
                    $fk_followup_exit_type=$this->input->post('interview_status', true);
                }

                $memberUpdate = array(
                    'fk_followup_exit_type' =>$fk_followup_exit_type,
                    'followup_exit_date' => $new_followup_exit_date,
                    'folowup_exit_round' => $this->input->post('folowup_exit_round', true),
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );



                $this->modelName->editList($memberUpdate, $member_master_id, $this->config->item('memberMasterTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating Immunization.');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Member Immunization updated successfully.');

            redirect('householdvisit/immunization?baseID=' . $baseID . '#immunization');
        }
    }

    public function addImmunization($id) {

        $baseID = $this->input->get('baseID', TRUE);
        $household_master_id_current = $this->input->get('household_master_id', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : Member Immunization';
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

        $data['why_not_seen_card'] = $this->modelName->getLookUpList($this->config->item('why_not_seen_card'));
        $data['interview_status_immunization'] = $this->modelName->getLookUpList($this->config->item('interview_status_immunization'));
        $data['information_recorded_from'] = $this->modelName->getLookUpList($this->config->item('information_recorded_from'));
        $data['yes_no'] = $this->modelName->getLookUpList($this->config->item('yes_no'));

        $data['addPerm'] = $this->getPermission($baseID, $this->role, 'add');
        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/wizard', $data);
        $this->load->view($this->controller . '/immunization_add_details', $data);
        $this->load->view('includes/footer');
    }

    function addImmunizationDetails() {
        $household_master_id = $this->input->post('household_master_id_sub', true);
        $round_master_id = $this->input->post('round_master_id', true);
        $member_master_id = $this->input->post('member_master_id', true);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('CH1', 'Did the child get any vaccine?', 'trim|required|numeric');
        $this->form_validation->set_rules('interview_status', 'Interview Status', 'trim|required|numeric');
        $this->form_validation->set_rules('followup_exit_date', 'Child follow up exit date', 'trim|required');
        $this->form_validation->set_rules('folowup_exit_round', 'Child follow up exit round', 'trim|required|numeric');
        $this->form_validation->set_rules('Q20', 'Have the vaccination card?', 'trim|required|numeric');




        $baseID = $this->input->get('baseID', TRUE);

        if ($this->form_validation->run() == FALSE) {

            redirect('memberImmunization/addImmunization/' . $member_master_id . '?household_master_id=' . $household_master_id . '&&baseID=' . $baseID . '#immunization');
        } else {

            if ($this->getCurrentRound()[0]->active == 0) {

                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect('householdvisit/visit?baseID=' . $baseID);
            }

            $whereHouseholdimmunization = array('household_master_id' => $household_master_id, 'round_master_id' => $round_master_id, 'member_master_id' => $member_master_id);

            $countRow = $this->db->select('count(id) as countRow')->from($this->config->item('memberImmunizationTable'))->where($whereHouseholdimmunization)->get()->row()->countRow;

            if ($countRow > 0) {
                $this->session->set_flashdata('error', 'Immunization already exists for this round.');
                redirect('householdvisit/immunization?baseID=' . $baseID . '#immunization');
            }
            
            
            $BCG = $this->input->post('BCG', true);
            $new_BCG = null;
            if (!empty($BCG)) {
                $parts3 = explode('/', $BCG);
                $new_BCG = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $PENTA1 = $this->input->post('PENTA1', true);
            $new_PENTA1 = null;
            if (!empty($PENTA1)) {
                $parts3 = explode('/', $PENTA1);
                $new_PENTA1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $PENTA2 = $this->input->post('PENTA2', true);
            $new_PENTA2 = null;
            if (!empty($PENTA2)) {
                $parts3 = explode('/', $PENTA2);
                $new_PENTA2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $PENTA3 = $this->input->post('PENTA3', true);
            $new_PENTA3 = null;
            if (!empty($PENTA3)) {
                $parts3 = explode('/', $PENTA3);
                $new_PENTA3 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $PCV1 = $this->input->post('PCV1', true);
            $new_PCV1 = null;
            if (!empty($PCV1)) {
                $parts3 = explode('/', $PCV1);
                $new_PCV1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }
            $PCV2 = $this->input->post('PCV2', true);
            $new_PCV2 = null;
            if (!empty($PCV2)) {
                $parts3 = explode('/', $PCV2);
                $new_PCV2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $PPV3 = $this->input->post('PPV3', true);
            $new_PPV3 = null;
            if (!empty($PPV3)) {
                $parts3 = explode('/', $PPV3);
                $new_PPV3 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $OPV1 = $this->input->post('OPV1', true);
            $new_OPV1 = null;
            if (!empty($OPV1)) {
                $parts3 = explode('/', $OPV1);
                $new_OPV1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $OPV2 = $this->input->post('OPV2', true);
            $new_OPV2 = null;
            if (!empty($OPV2)) {
                $parts3 = explode('/', $OPV2);
                $new_OPV2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $OPV3 = $this->input->post('OPV3', true);
            $new_OPV3 = null;
            if (!empty($OPV3)) {
                $parts3 = explode('/', $OPV3);
                $new_OPV3 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $MR1 = $this->input->post('MR1', true);
            $new_MR1 = null;
            if (!empty($MR1)) {
                $parts3 = explode('/', $MR1);
                $new_MR1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $MR2 = $this->input->post('MR2', true);
            $new_MR2 = null;
            if (!empty($MR2)) {
                $parts3 = explode('/', $MR2);
                $new_MR2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $FIPV1 = $this->input->post('FIPV1', true);
            $new_FIPV1 = null;
            if (!empty($FIPV1)) {
                $parts3 = explode('/', $FIPV1);
                $new_FIPV1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $FIPV2 = $this->input->post('FIPV2', true);
            $new_FIPV2 = null;
            if (!empty($FIPV2)) {
                $parts3 = explode('/', $FIPV2);
                $new_FIPV2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }
            $FIPV3 = $this->input->post('FIPV3', true);
            $new_FIPV3 = null;
            if (!empty($FIPV3)) {
                $parts3 = explode('/', $FIPV3);
                $new_FIPV3 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $VITA1 = $this->input->post('VITA1', true);
            $new_VITA1 = null;
            if (!empty($VITA1)) {
                $parts3 = explode('/', $VITA1);
                $new_VITA1 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }
            $VITA2 = $this->input->post('VITA2', true);
            $new_VITA2 = null;
            if (!empty($VITA2)) {
                $parts3 = explode('/', $VITA2);
                $new_VITA2 = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $followup_exit_date = $this->input->post('followup_exit_date', true);

            $new_followup_exit_date = null;
            if (!empty($followup_exit_date)) {
                $parts3 = explode('/', $followup_exit_date);
                $new_followup_exit_date = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
            }

            $Q20 = $this->input->post('Q20', true);
            $Q21 = 0;
            $Q22 = 0;
            if ($Q20 == 1) {
                $Q21 = $this->input->post('Q21', true);
            }
            $Q21 = $this->input->post('Q21', true);
			
            if ($Q21 != 1) {
                $Q22 = $this->input->post('Q22', true);
            }

            $Q22OTH = NULL;

            if ($Q22 == 436) {
                $Q22OTH = $this->input->post('Q22OTH', true);
            }
            $CH1 = $this->input->post('CH1', true);


            if ($CH1 == 1) {
                $info_first_part = array(
                    'BCG' => $new_BCG,
                    'BCGFROM' => $this->input->post('BCGFROM', true),
                    'BCGFROM' => $this->input->post('BCGFROM', true),
                    'BCGOTH' => $this->input->post('BCGOTH', true),
                    'PENTA1' => $new_PENTA1,
                    'PENTA1FROM' => $this->input->post('PENTA1FROM', true),
                    'PENTA1OTH' => $this->input->post('PENTA1OTH', true),
                    'PENTA2' => $new_PENTA2,
                    'PENTA2FROM' => $this->input->post('PENTA2FROM', true),
                    'PENTA2OTH' => $this->input->post('PENTA2OTH', true),
                    'PENTA3' => $new_PENTA3,
                    'PENTA3FROM' => $this->input->post('PENTA3FROM', true),
                    'PENTA3OTH' => $this->input->post('PENTA3OTH', true),
                    'PCV1' => $new_PCV1,
                    'PCV1FROM' => $this->input->post('PCV1FROM', true),
                    'PCV1OTH' => $this->input->post('PCV1OTH', true),
                    'PCV2' => $new_PCV2,
                    'PCV2FROM' => $this->input->post('PCV2FROM', true),
                    'PCV2OTH' => $this->input->post('PCV2OTH', true),
                    'PPV3' => $new_PPV3,
                    'PPV3FROM' => $this->input->post('PPV3FROM', true),
                    'PPV3OTH' => $this->input->post('PPV3OTH', true),
                    'OPV1' => $new_OPV1,
                    'OPV1FROM' => $this->input->post('OPV1FROM', true),
                    'OPV1OTH' => $this->input->post('OPV1OTH', true),
                    'OPV2' => $new_OPV2,
                    'OPV2FROM' => $this->input->post('OPV2FROM', true),
                    'OPV2OTH' => $this->input->post('OPV2OTH', true),
                    'OPV3' => $new_OPV3,
                    'OPV3FROM' => $this->input->post('OPV3FROM', true),
                    'OPV3OTH' => $this->input->post('OPV3OTH', true),
                    'MR1' => $new_MR1,
                    'MR1FROM' => $this->input->post('MR1FROM', true),
                    'MR1OTH' => $this->input->post('MR1OTH', true),
                    'MR2' => $new_MR2,
                    'MR2FROM' => $this->input->post('MR2FROM', true),
                    'MR2OTH' => $this->input->post('MR2OTH', true),
                    'FIPV1' => $new_FIPV1,
                    'FIPV1FROM' => $this->input->post('FIPV1FROM', true),
                    'FIPV1OTH' => $this->input->post('FIPV1OTH', true),
                    'FIPV2' => $new_FIPV2,
                    'FIPV2FROM' => $this->input->post('FIPV2FROM', true),
                    'FIPV2OTH' => $this->input->post('FIPV2OTH', true),
                    'FIPV3' => $new_FIPV3,
                    'FIPV3FROM' => $this->input->post('FIPV3FROM', true),
                    'FIPV3OTH' => $this->input->post('FIPV3OTH', true),
                    'VITA1' => $new_VITA1,
                    'VITA1FROM' => $this->input->post('VITA1FROM', true),
                    'VITA1OTH' => $this->input->post('VITA1OTH', true),
                    'VITA2' => $new_VITA2,
                    'VITA2FROM' => $this->input->post('VITA2FROM', true),
                    'VITA2OTH' => $this->input->post('VITA2OTH', true)
                );
            } else {
                $info_first_part = array(
                    'BCG' => NULL,
                    'BCGFROM' => NULL,
                    'BCGFROM' => NULL,
                    'BCGOTH' => NULL,
                    'PENTA1' => NULL,
                    'PENTA1FROM' => NULL,
                    'PENTA1OTH' => NULL,
                    'PENTA2' => NULL,
                    'PENTA2FROM' => NULL,
                    'PENTA2OTH' => NULL,
                    'PENTA3' => NULL,
                    'PENTA3FROM' => NULL,
                    'PENTA3OTH' => NULL,
                    'PCV1' => NULL,
                    'PCV1FROM' => NULL,
                    'PCV1OTH' => NULL,
                    'PCV2' => NULL,
                    'PCV2FROM' => NULL,
                    'PCV2OTH' => NULL,
                    'PPV3' => NULL,
                    'PPV3FROM' => NULL,
                    'PPV3OTH' => NULL,
                    'OPV1' => NULL,
                    'OPV1FROM' => NULL,
                    'OPV1OTH' => NULL,
                    'OPV2' => NULL,
                    'OPV2FROM' => NULL,
                    'OPV2OTH' => NULL,
                    'OPV3' => NULL,
                    'OPV3FROM' => NULL,
                    'OPV3OTH' => NULL,
                    'MR1' => NULL,
                    'MR1FROM' => NULL,
                    'MR1OTH' => NULL,
                    'MR2' => NULL,
                    'MR2FROM' => NULL,
                    'MR2OTH' => NULL,
                    'FIPV1' => NULL,
                    'FIPV1FROM' => NULL,
                    'FIPV1OTH' => NULL,
                    'FIPV2' => NULL,
                    'FIPV2FROM' => NULL,
                    'FIPV2OTH' => NULL,
                    'FIPV3' => NULL,
                    'FIPV3FROM' => NULL,
                    'FIPV3OTH' => NULL,
                    'VITA1' => NULL,
                    'VITA1FROM' => NULL,
                    'VITA1OTH' => NULL,
                    'VITA2' => NULL,
                    'VITA2FROM' => NULL,
                    'VITA2OTH' => NULL
                );
            }

            $round_master_id_entry_round = $this->getCurrentRound()[0]->id;
            $this->db->trans_start();

            try {
                $info_second_part = array(
                    'CH1' => $this->input->post('CH1', true),
                    'Q20' => $Q20,
                    'Q21' => $Q21,
                    'Q22' => $Q22,
                    'Q22OTH' => $Q22OTH,
                    'interview_status' => $this->input->post('interview_status', true),
                    'member_master_id' => $member_master_id,
                    'round_master_id' => $round_master_id_entry_round,
                    'household_master_id' => $household_master_id,
                    'insertedBy' => $this->vendorId,
                    'insertedOn' => date('Y-m-d H:i:s')
                );

                $IdInfo = array_merge($info_first_part, $info_second_part);


                $this->immunizationModel->addNew($IdInfo, $this->config->item('memberImmunizationTable'));

                $fk_followup_exit_type=0;
                
                if($this->input->post('interview_status', true)==437||$this->input->post('interview_status', true)==438){
                    $fk_followup_exit_type=$this->input->post('interview_status', true);
                }
                
                $memberUpdate = array(
                    'fk_followup_exit_type' =>$fk_followup_exit_type,
                    'followup_exit_date' => $new_followup_exit_date,
                    'folowup_exit_round' => $this->input->post('folowup_exit_round', true),
                    'updateBy' => $this->vendorId,
                    'updatedOn' => date('Y-m-d H:i:s')
                );

                $this->modelName->editList($memberUpdate, $member_master_id, $this->config->item('memberMasterTable'));


                $whereHouseholdVisit = array('household_master_id' => $household_master_id, 'round_master_id' => $round_master_id);

                $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                if ($countVisit > 0) {

                    $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                    $householdVisit = array(
                        'any_immunization' => 1,
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
            $this->session->set_flashdata('success', 'Immunization created successfully.');

            redirect('householdvisit/immunization?baseID=' . $baseID . '#immunization');
        }
    }

}

?>