<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Baseline_census_report extends BaseController {

    /**
     * This is default constructor of the class
     */
    public $controller = "Baseline_census_report";
    public $pageTitle = 'Baseline census report management';
    public $pageShortName = 'Data';

    public function __construct() {
        parent::__construct();
        $this->load->model('Householdbaseline_model', 'modelName');
        $this->load->model('menu_model', 'menuModel');
        $this->load->model('master_model', 'masterName');
        $this->load->library('pagination');
        $this->isLoggedIn();
        $menu_key = 'baseline_census_report';
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
        $data['pageTitle'] = 'Baseline Census';
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'baseline_census';
        $data['editMethod'] = 'edit_baseline_census';
        $data['shortName'] = 'Baseline Census';
        $data['boxTitle'] = 'List';

        $data['all_round_info'] = $this->modelName->all_round_info($this->config->item('roundTable'));
        $data['round_no'] = 0;

        if ($this->input->post('round_no') && $this->input->post('Clear') != 'Clear') {
            $data['round_no'] = $this->input->post('round_no');
        }

        $data['baseline_census_info'] = array();

        if ($data['round_no'] > 0) {
            $data['baseline_census_info'] = $this->modelName->all_baseline_census_info($data['round_no'], $this->config->item('baselineCensusTable'), 0);
        }

        $data['list_fields'] = $this->modelName->all_baseline_census_info(1, $this->config->item('baselineCensusTable'), 1);
//        echo "<pre/>";
//        
//        print_r($data['baseline_census_info']); exit();

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/index', $data);
        $this->load->view('includes/footer');
    }

    public function edit_baseline_census($id) {
//        echo $id; exit();
        $baseID = $this->input->get('baseID', TRUE);
        $this->global['menu'] = $this->menuModel->getMenu($this->role);

        $this->global['pageTitle'] = $this->config->item('prefix') . ' : ' . $this->pageTitle;
        $data['pageTitle'] = "Baseline Census";
        $data['controller'] = $this->controller;
        $data['actionMethod'] = 'update_baseline_census';
        $data['shortName'] = "Baseline Census";
        $data['boxTitle'] = 'List';

        $data['baseline_record'] = $this->modelName->getBaselineDetails($this->config->item('baselineCensusTable'), $id);


        $data['divisions'] = $this->masterName->listingdiv($this->config->item('divTable'));
        $data['migReasons'] = $this->masterName->getLookUpList($this->config->item('migReason'));
        $data['yes_no_dont_know'] = $this->masterName->getLookUpList($this->config->item('yes_no_dont_know'));
//        $data['house_owner'] = $this->modelName->getLookUpList($this->config->item('house_owner'));
//        $data['land_owner'] = $this->modelName->getLookUpList($this->config->item('land_owner'));
        $data['roof_build_with'] = $this->masterName->getLookUpList($this->config->item('roof_build_with'));
        $data['floor_build_with'] = $this->masterName->getLookUpList($this->config->item('floor_build_with'));
        $data['water_source'] = $this->masterName->getLookUpList($this->config->item('water_source'));
        $data['water_source_location'] = $this->masterName->getLookUpList($this->config->item('water_source_location'));
        $data['water_collector'] = $this->masterName->getLookUpList($this->config->item('water_collector'));
        $data['yes_no'] = $this->masterName->getLookUpList($this->config->item('yes_no'));
        $data['water_supplier'] = $this->masterName->getLookUpList($this->config->item('water_supplier'));
        $data['toilet_cleaner'] = $this->masterName->getLookUpList($this->config->item('toilet_cleaner'));
        $data['toilet_dirt_remover'] = $this->masterName->getLookUpList($this->config->item('toilet_dirt_remover'));
        $data['light_source'] = $this->masterName->getLookUpList($this->config->item('light_source'));
        $data['hand_washing_place'] = $this->masterName->getLookUpList($this->config->item('hand_washing_place'));
        $data['toilet_type'] = $this->masterName->getLookUpList($this->config->item('toilet_type'));
        $data['dirt_removing_type'] = $this->masterName->getLookUpList($this->config->item('dirt_removing_type'));
        $data['hand_washing_arrangement'] = $this->masterName->getLookUpList($this->config->item('hand_washing_arrangement'));
        $data['spontaneously_afterTelling_dontKnow'] = $this->masterName->getLookUpList($this->config->item('spontaneously_afterTelling_dontKnow'));
        $data['fuel_type'] = $this->masterName->getLookUpList($this->config->item('fuel_type'));
        $data['dirt_taken_place'] = $this->masterName->getLookUpList($this->config->item('dirt_taken_place'));
        $data['dirt_collection_time'] = $this->masterName->getLookUpList($this->config->item('dirt_collection_time'));

        $data['editPerm'] = $this->getPermission($baseID, $this->role, 'edit');

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/script');
        $this->load->view($this->controller . '/edit_baseline_census', $data);
        $this->load->view('includes/footer');
    }

    function update_baseline_census() {
        $baselineID = $this->input->post('baselineID', true);
        $getCurrentRound = $this->modelName->getCurrentRound();

        $this->load->library('form_validation');

        $this->form_validation->set_rules('upazilla_name', 'Upazilla Name', 'trim|required');
        $this->form_validation->set_rules('division_id', 'Division Name', 'trim|required');
      //  $this->form_validation->set_rules('pregnancy_status', 'Pregnancy status', 'trim|required');
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
            redirect($this->controller . '/edit_baseline_census/' . $baselineID . '?baseID=' . $baseID);
        } else {
            if ($getCurrentRound->active == 0) {
                $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                redirect($this->controller . '/edit_baseline_census/' . $baselineID . '?baseID=' . $baseID);
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


            try {

                $this->modelName->edit($IdInfo, $baselineID, $this->config->item('baselineCensusTable'));
            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Error occurred while updating Conception.');
                redirect($this->controller . '/edit_baseline_census/' . $baselineID . '?baseID=' . $baseID);
            }
            $this->db->trans_commit();

            $this->session->set_flashdata('success', 'Baseline census info updated successfully.');
            if ($this->input->post('update_exit')) {
                redirect($this->controller . '?baseID=' . $baseID);
            }
            redirect($this->controller . '/edit_baseline_census/' . $baselineID . '?baseID=' . $baseID);
        }
    }

    //.sav and .dta file exporting system

    public function sav_format_baseline_census() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_baseline_census_info(0, $this->config->item('baselineCensusTable'), 0);

        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/baseline_census' . '?baseID=' . $baseID);
        }

        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "baseline_census_List_Report";
        $command = escapeshellcmd("sav.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'baseline_census_List_Report.sav';
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

    public function dta_format_baseline_census() {

        $baseID = $this->input->get('baseID', TRUE);

        $result = $this->modelName->all_baseline_census_info(0, $this->config->item('baselineCensusTable'), 0);


        if ($result == false) {
            $this->session->set_flashdata('error', 'No data is there, nothing to export.');
            redirect($this->controller . '/baseline_census' . '?baseID=' . $baseID);
        }



        $uniqid = uniqid();

        $fp = fopen($uniqid . '.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp); //exit();
        $file_name = "baseline_census_List_Report";
        $command = escapeshellcmd("dta.py $uniqid $file_name");
        $output = shell_exec($command);

        $file = 'baseline_census_List_Report.dta';
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