<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class MemberPregnancy extends BaseController
{
    /**
     * This is default constructor of the class
     */
	 
	public $controller = "memberPregnancy";
	public $pageTitle = 'Member Pregnancy';
	public $pageShortName = 'Member Pregnancy';
	
	 
    public function __construct()
    {
        parent::__construct();
		    $this->load->model('master_model','modelName');
        $this->load->model('member_model','memberModel');
        $this->load->model('householdVisit_model','visitModel');
        $this->load->model('memberPregnancy_model','pregnancyModel');
        $this->load->model('memberConception_model','conceptionModel');
        $this->load->model('menu_model','menuModel');
        $this->load->library('pagination');
        $this->isLoggedIn(); 
        $menu_key = 'visit';
        $baseID = $this->input->get('baseID',TRUE);
        $result = $this->loadThisForAccess($this->role,$baseID,$menu_key);
        if ($result != true) 
        {
            redirect('access');
        }
			
    }
    

    public function addEditPregnancy($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id_current = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Pregnancy' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';



            if ($this->getCurrentRound()[0]->active == 0)
            {

              $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
              redirect($this->controller.'?baseID='.$baseID);
            }

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;

            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if ($household_master_id_current != $household_master_id_current)
            {

                 $this->session->set_flashdata('error', 'You can not change household ID. This strictly prohibited.');
                 redirect('householdvisit/visit?baseID='.$baseID);
            }
          
            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['pregRecord'] = $this->pregnancyModel->getPregnancyDetailsByIdnHousehold($id,$data['household_master_id_sub'],$data['round_master_id']);

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
            
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/pregnancy_edit_details', $data);
            $this->load->view('includes/footer');
        
    }

    function editPregnancyDetails()
    {
          
            //print_r($this->input->post()); die();


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $member_master_id = $this->input->post('member_master_id',true);
            $conceptionID = $this->input->post('conceptionID',true);
            $pregnancyID = $this->input->post('pregnancyID',true);

            $this->load->library('form_validation');

            

            $this->form_validation->set_rules('pregnancy_outcome_date','pregnancy outcome Date','trim|required');
            $this->form_validation->set_rules('spontaneous_abortion','spontaneous abortion','trim|required|numeric');
            $this->form_validation->set_rules('induced_abortion','induced abortion','trim|required|numeric');
            $this->form_validation->set_rules('still_birth','still birth','trim|required|numeric');
			
            $this->form_validation->set_rules('live_birth','live birth','trim|required|numeric');
            $this->form_validation->set_rules('fk_conception_result','conception result','trim|required|numeric');
            $this->form_validation->set_rules('fk_delivery_methodology','Delivery methodology','trim|required|numeric');
            $this->form_validation->set_rules('fk_delivery_assist_type','Delivery assist type','trim|required|numeric');
			
            $this->form_validation->set_rules('fk_delivery_term_place','Delivery Termination Place','trim|required|numeric');
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
            $this->form_validation->set_rules('conceptionID','Conception ID','trim|required|numeric');
            $this->form_validation->set_rules('checkupTypeRoutine','Routine check-up in pregnancy  for mother','trim|required|numeric');
            $this->form_validation->set_rules('checkupType','Within 42 days of the birth of the baby you ever had a check-up','trim|required|numeric');
              
            $baseID = $this->input->get('baseID', TRUE);
           
           if($this->form_validation->run() == FALSE)
            {
                redirect('memberPregnancy/addEditPregnancy/'. $pregnancyID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#pregnancy');
            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }

                
            	$spontaneous_abortion = $this->input->post('spontaneous_abortion',true);
                $induced_abortion = $this->input->post('induced_abortion',true);
                $still_birth = $this->input->post('still_birth',true);
                $live_birth = $this->input->post('live_birth',true);
                $fk_conception_result = $this->input->post('fk_conception_result',true);
                $fk_delivery_methodology = $this->input->post('fk_delivery_methodology',true);
                $fk_delivery_assist_type = $this->input->post('fk_delivery_assist_type',true);
                $fk_delivery_term_place = $this->input->post('fk_delivery_term_place',true);
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
                $conceptionDate = $this->input->post('conceptionDate',true);


                $fk_facility_delivery = $this->input->post('fk_facility_delivery',true);

                if (($fk_conception_result == 95) || ($fk_conception_result == 199))
                {
                    $fk_colostrum = 0;
                    $fk_first_milk = 0;
                    $milk_day = 0;
                }
                else{

                    $fk_colostrum = $this->input->post('fk_colostrum',true);
                    $fk_first_milk = $this->input->post('fk_first_milk',true);
                    $milk_hours = $this->input->post('milk_hours',true);
                    $milk_day = $this->input->post('milk_day',true);
    

                }

                if (($fk_delivery_term_place == 103) || ($fk_delivery_term_place == 104) || ($fk_delivery_term_place == 205) )
                {
                    $fk_facility_delivery = 0;
                }
                else{
                    $fk_facility_delivery = $this->input->post('fk_facility_delivery',true) ?  $this->input->post('fk_facility_delivery',true) : 0;
                }
                
               
                $fk_preg_complication = $this->input->post('fk_preg_complication',true) ?  $this->input->post('fk_preg_complication',true) : 0;
                $fk_delivery_complication = $this->input->post('fk_delivery_complication',true) ?  $this->input->post('fk_delivery_complication',true) : 0;
                $fk_preg_violence = $this->input->post('fk_preg_violence',true) ?  $this->input->post('fk_preg_violence',true) : 0;
                $fk_litter_size = $this->input->post('fk_litter_size',true) ?  $this->input->post('fk_litter_size',true) : 0;

               

				
                $pregnancy_outcome_date = $this->input->post('pregnancy_outcome_date',true);
			  
                $new_pregnancy_outcome_date = null;

                if (!empty($pregnancy_outcome_date)) {
                    $parts3 = explode('/', $pregnancy_outcome_date);
                    $new_pregnancy_outcome_date = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }

                // anc
                $checkupTypeRoutine = $this->input->post('checkupTypeRoutine',true);

                if ($checkupTypeRoutine == 1)
                {

                    $afterTotalTimesRoutine = $this->input->post('afterTotalTimesRoutine',true) ?  $this->input->post('afterTotalTimesRoutine',true) : 0;
                    
                    $routineFirstVisitAsist = $this->input->post('routineFirstVisitAsist',true);
                    $routineFirstVisit = $this->input->post('routineFirstVisit',true);
                    $routineFirstVisitMonthss = $this->input->post('routineFirstVisitMonthss',true) ?  $this->input->post('routineFirstVisitMonthss',true) : 0;
                
                    $routineSecondVisitAsist = $this->input->post('routineSecondVisitAsist',true);
                    $routineSecondVisit = $this->input->post('routineSecondVisit',true);
                    $routineSecondVisitMonths = $this->input->post('routineSecondVisitMonths',true) ?  $this->input->post('routineSecondVisitMonths',true) : 0;
                    
                    $routineThirdVisitAsist = $this->input->post('routineThirdVisitAsist',true);
                    $routineThirdVisit = $this->input->post('routineThirdVisit',true);
                    $routineThirdVisitMonths = $this->input->post('routineThirdVisitMonths',true) ?  $this->input->post('routineThirdVisitMonths',true) : 0;
                
                    $routineFourthVisitAsist = $this->input->post('routineFourthVisitAsist',true);
                    $routineFourthVisit = $this->input->post('routineFourthVisit',true);
                    $routineFourthVisitMonths = $this->input->post('routineFourthVisitMonths',true) ?  $this->input->post('routineFourthVisitMonths',true) : 0;
                    
                    $routineFifthVisitAsist = $this->input->post('routineFifthVisitAsist',true);
                    $routineFifthVisit = $this->input->post('routineFifthVisit',true);
                    $routineFifthVisitMonths = $this->input->post('routineFifthVisitMonths',true) ?  $this->input->post('routineFifthVisitMonths',true) : 0;
                
                }

                else
                {
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

                $fk_supliment = $this->input->post('fk_supliment',true);
                if ($fk_supliment == 1)
                {
                    $fk_supliment_received_way = $this->input->post('fk_supliment_received_way',true) ?  $this->input->post('fk_supliment_received_way',true) : 0;
                    $fk_how_many_tab = $this->input->post('fk_how_many_tab',true) ?  $this->input->post('fk_how_many_tab',true) : 0;

                    if ($fk_how_many_tab == 226)
                    {
                        $totalNumberTablet = $this->input->post('totalNumberTablet',true) ?  $this->input->post('totalNumberTablet',true) : 0;
                    }
                    else{
                        $totalNumberTablet = 0;
                    }
                   
                }
                else{
                    $fk_supliment_received_way = 0;
                    $fk_how_many_tab = 0;
                    $totalNumberTablet = 0;
                }
                
               

                // Basic components of ANC
                $fk_anc_weight_taken = $this->input->post('fk_anc_weight_taken',true);
                $fk_anc_blood_pressure = $this->input->post('fk_anc_blood_pressure',true);
                $fk_anc_urine = $this->input->post('fk_anc_urine',true);
                $fk_anc_blood = $this->input->post('fk_anc_blood',true);
                $fk_anc_denger_sign = $this->input->post('fk_anc_denger_sign',true);
                $fk_anc_nutrition = $this->input->post('fk_anc_nutrition',true);
                $fk_anc_birth_prepare = $this->input->post('fk_anc_birth_prepare',true);

                // Newborn care practices

                $fk_anc_delivery_kit = $this->input->post('fk_anc_delivery_kit',true);
                $fk_anc_soap = $this->input->post('fk_anc_soap',true);
                $fk_anc_care_chix = $this->input->post('fk_anc_care_chix',true);

                $fk_anc_dried = $this->input->post('fk_anc_dried',true);
                $fk_anc_bathing = $this->input->post('fk_anc_bathing',true);
                $fk_anc_breast_feed = $this->input->post('fk_anc_breast_feed',true);
                $fk_anc_skin_contact = $this->input->post('fk_anc_skin_contact',true);
                $fk_anc_enc = $this->input->post('fk_anc_enc',true);
               

                //  sepsis

                $fk_suspecred_infection = $this->input->post('fk_suspecred_infection',true);

                if ($fk_suspecred_infection == 228)
                {

                    $fk_baby_antibiotics = $this->input->post('fk_baby_antibiotics',true) ?  $this->input->post('fk_baby_antibiotics',true) : 0;
                    if ($fk_baby_antibiotics == 1)
                    {
                        $fk_prescribe_antibiotics = $this->input->post('fk_prescribe_antibiotics',true) ?  $this->input->post('fk_prescribe_antibiotics',true) : 0;
                        $fk_seek_treatment = $this->input->post('fk_seek_treatment',true) ?  $this->input->post('fk_seek_treatment',true) : 0;
        
                    }
                    else{
                        $fk_prescribe_antibiotics = 0;
                        $fk_seek_treatment = 0;
                    }
                    
                    
                }
                else 
                {
                    $fk_baby_antibiotics = 0;
                    $fk_prescribe_antibiotics = 0;
                    $fk_seek_treatment = 0;
                }

               
                
                //  Knowledge and Behavior 

                $fk_anc_vaginal_bleeding = $this->input->post('fk_anc_vaginal_bleeding',true);
                $fk_anc_convulsions = $this->input->post('fk_anc_convulsions',true);
                $fk_anc_severe_headache = $this->input->post('fk_anc_severe_headache',true);
                $fk_anc_fever = $this->input->post('fk_anc_fever',true);
                $fk_anc_abdominal_pain = $this->input->post('fk_anc_abdominal_pain',true);
                $fk_anc_diff_breath = $this->input->post('fk_anc_diff_breath',true);

                // danger signs of delivery
                $fk_anc_water_break = $this->input->post('fk_anc_water_break',true);
                $fk_anc_vaginal_bleed_aph = $this->input->post('fk_anc_vaginal_bleed_aph',true);
                $fk_anc_obstructed_labour = $this->input->post('fk_anc_obstructed_labour',true);
                $fk_anc_convulsion = $this->input->post('fk_anc_convulsion',true);
                $fk_anc_sepsis = $this->input->post('fk_anc_sepsis',true);
                $fk_anc_severe_headache_delivery = $this->input->post('fk_anc_severe_headache_delivery',true);
                $fk_anc_consciousness = $this->input->post('fk_anc_consciousness',true);

                // signs of postnatal period

                $fk_anc_vaginal_bleeding_post = $this->input->post('fk_anc_vaginal_bleeding_post',true);
                $fk_anc_convulsion_eclampsia_post = $this->input->post('fk_anc_convulsion_eclampsia_post',true);
                $fk_anc_high_feaver_post = $this->input->post('fk_anc_high_feaver_post',true);
                $fk_anc_smelling_discharge_post = $this->input->post('fk_anc_smelling_discharge_post',true);
                $fk_anc_severe_headache_post = $this->input->post('fk_anc_severe_headache_post',true);
                $fk_anc_consciousness_post = $this->input->post('fk_anc_consciousness_post',true);

                // signs of newborn baby
                $fk_anc_inability_baby = $this->input->post('fk_anc_inability_baby',true);
                $fk_anc_baby_small_baby = $this->input->post('fk_anc_baby_small_baby',true);
                $fk_anc_fast_breathing_baby = $this->input->post('fk_anc_fast_breathing_baby',true);
                $fk_anc_convulsions_baby = $this->input->post('fk_anc_convulsions_baby',true);
                $fk_anc_drowsy_baby = $this->input->post('fk_anc_drowsy_baby',true);
                $fk_anc_movement_baby = $this->input->post('fk_anc_movement_baby',true);
                $fk_anc_grunting_baby = $this->input->post('fk_anc_grunting_baby',true);
                $fk_anc_indrawing_baby = $this->input->post('fk_anc_indrawing_baby',true);
                $fk_anc_temperature_baby = $this->input->post('fk_anc_temperature_baby',true);
                $fk_anc_hypothermia_baby = $this->input->post('fk_anc_hypothermia_baby',true);
                $fk_anc_central_cyanosis_baby = $this->input->post('fk_anc_central_cyanosis_baby',true);
                $fk_anc_umbilicus_baby = $this->input->post('fk_anc_umbilicus_baby',true);

                //complicated pregnancy

                $fk_anc_labour_preg = $this->input->post('fk_anc_labour_preg',true);
                $fk_anc_excessive_bld_pre = $this->input->post('fk_anc_excessive_bld_pre',true);
                $fk_anc_severe_headache_preg = $this->input->post('fk_anc_severe_headache_preg',true);
                $fk_anc_obstructed_preg = $this->input->post('fk_anc_obstructed_preg',true);
                $fk_anc_convulsion_preg = $this->input->post('fk_anc_convulsion_preg',true);
                $fk_anc_placenta_preg = $this->input->post('fk_anc_placenta_preg',true);


                //newborn and child
                $fk_anc_breath_child = $this->input->post('fk_anc_breath_child',true);
                $fk_anc_suck_baby = $this->input->post('fk_anc_suck_baby',true);
                $fk_anc_hot_cold_child = $this->input->post('fk_anc_hot_cold_child',true);
                $fk_anc_blue_child = $this->input->post('fk_anc_blue_child',true);
                $fk_anc_convulsion_child = $this->input->post('fk_anc_convulsion_child',true);
                $fk_anc_indrawing_child = $this->input->post('fk_anc_indrawing_child',true);


                $remarks = $this->input->post('remarks',true);
                
                // pnc
                $fk_supliment_post = $this->input->post('fk_supliment_post',true);


                // pnc
                $checkupType = $this->input->post('checkupType',true);


                if ($checkupType == 1)
                {

                    $fk_post_natal_visit = $this->input->post('fk_post_natal_visit',true) ?  $this->input->post('fk_post_natal_visit',true) : 0;
                    $afterTotalTimes = $this->input->post('afterTotalTimes',true) ?  $this->input->post('afterTotalTimes',true) : 0;

                    $pncFirstVisitAsist = $this->input->post('pncFirstVisitAsist',true);
                    $firstVisit = $this->input->post('firstVisit',true);
                    $firstVisitDays = $this->input->post('firstVisitDays',true) ?  $this->input->post('firstVisitDays',true) : 0;

                    $pncSecondVisitAsist = $this->input->post('pncSecondVisitAsist',true);
                    $secondVisit = $this->input->post('secondVisit',true);
                    $secondVisitDays = $this->input->post('secondVisitDays',true) ?  $this->input->post('secondVisitDays',true) : 0;
                
                }

                else
                {
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
				
				if ($live_birth > 0)	
				{
					if (!empty($conceptionDate))
					{
						$concept=date_create($conceptionDate);
						$preg=date_create($new_pregnancy_outcome_date);
						$diff=date_diff($concept,$preg);
						$days = $diff->format("%a");
						
						
						if ($days <= 160)
						{
							$this->session->set_flashdata('error', 'Pregnancy out come date is less than 160 days.');
							//redirect('memberPregnancy/addEditPregnancy/'. $pregnancyID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#pregnancy');
           
						}
						
						if ($days >= 320)
						{
							$this->session->set_flashdata('error', 'Pregnancy out come date is greater than 320 days.');
							//redirect('memberPregnancy/addEditPregnancy/'. $pregnancyID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#pregnancy');
           
						}
					}
				
				}
				

                $this->db->trans_start();

                try
                { 
				
				
					// check same pregnancy date
					$whereHouseholdPregDate = array('pregnancy_outcome_date' =>$new_pregnancy_outcome_date,'member_master_id'=>$member_master_id);

					$countRowDate = $this->db->select('count(id) as countRowDate')->from($this->config->item('pregnancyTable'))->where($whereHouseholdPregDate)->get()->row()->countRowDate;

					if ($countRowDate > 1)
					{
					  $this->session->set_flashdata('error', 'Same pregnancy outcome date already exists. Please select another date.');
					 redirect('memberPregnancy/addEditPregnancy/'. $pregnancyID.'?household_master_id='.$household_master_id.'&&member_master_id='.$member_master_id.'&&baseID='.$baseID.'#pregnancy');
					}
					
					
					$IdInfo = array(
                        
                        'pregnancy_outcome_date'=>$new_pregnancy_outcome_date,  
                        //'breast_milk_day'=>$breast_milk_day, 
                        //'breast_milk_hour'=>$breast_milk_hour,
                        'induced_abortion'=>$induced_abortion,
                        'spontaneous_abortion'=>$spontaneous_abortion,
                        'live_birth'=>$live_birth,
                        'still_birth'=>$still_birth,
                        'fk_delivery_methodology'=>$fk_delivery_methodology,
                        'fk_delivery_assist_type'=>$fk_delivery_assist_type,
                        'fk_delivery_term_place'=>$fk_delivery_term_place,
                        'fk_litter_size'=>$fk_litter_size,
                        'fk_colostrum'=>$fk_colostrum,
                        'fk_first_milk'=>$fk_first_milk,
                        'milk_hours'=>$milk_hours,
                        'milk_day'=>$milk_day,
                        'fk_facility_delivery'=>$fk_facility_delivery,
                        'fk_preg_complication'=>$fk_preg_complication,
                        'fk_delivery_complication'=>$fk_delivery_complication,
                        'fk_preg_violence'=>$fk_preg_violence,
                        'fk_anc_first_assist_id'=>$routineFirstVisitAsist,
                        'fk_anc_second_assist_id'=>$routineSecondVisitAsist,
                        'fk_anc_third_assist_id'=>$routineThirdVisitAsist,
                        'fk_anc_fourth_assist_id'=>$routineFourthVisitAsist,
                        'fk_anc_fifth_assist_id'=>$routineFifthVisitAsist,                   
                        'fk_anc_supliment'=>$fk_supliment,
                        'fk_supliment_received_way'=>$fk_supliment_received_way,
                        'fk_how_many_tab'=>$fk_how_many_tab,
                        'totalnumbertab'=>$totalNumberTablet,
                        'fk_anc_weight_taken'=>$fk_anc_weight_taken,
                        'fk_anc_blood_pressure'=>$fk_anc_blood_pressure,
                        'fk_anc_urine'=>$fk_anc_urine,
                        'fk_anc_blood'=>$fk_anc_blood,
                        'fk_anc_denger_sign'=>$fk_anc_denger_sign,
                        'fk_anc_nutrition'=>$fk_anc_nutrition,
                        'fk_anc_birth_prepare'=>$fk_anc_birth_prepare,
                        'fk_anc_delivery_kit'=>$fk_anc_delivery_kit,
                        'fk_anc_soap'=>$fk_anc_soap,
                        'fk_anc_care_chix'=>$fk_anc_care_chix,
                        'fk_anc_dried'=>$fk_anc_dried,
                        'fk_anc_bathing'=>$fk_anc_bathing,
                        'fk_anc_breast_feed'=>$fk_anc_breast_feed,
                        'fk_anc_skin_contact'=>$fk_anc_skin_contact,
                        'fk_anc_enc'=>$fk_anc_enc,
                        'fk_suspecred_infection'=>$fk_suspecred_infection,
                        'fk_baby_antibiotics'=>$fk_baby_antibiotics,
                        'fk_prescribe_antibiotics'=>$fk_prescribe_antibiotics,
                        'fk_seek_treatment'=>$fk_seek_treatment,
                        'fk_anc_vaginal_bleeding'=>$fk_anc_vaginal_bleeding,
                        'fk_anc_convulsions'=>$fk_anc_convulsions,
                        'fk_anc_severe_headache'=>$fk_anc_severe_headache,
                        'fk_anc_fever'=>$fk_anc_fever,
                        'fk_anc_abdominal_pain'=>$fk_anc_abdominal_pain,
                        'fk_anc_diff_breath'=>$fk_anc_diff_breath,
                        'fk_anc_water_break'=>$fk_anc_water_break,
                        'fk_anc_vaginal_bleed_aph'=>$fk_anc_vaginal_bleed_aph,
                        'fk_anc_obstructed_labour'=>$fk_anc_obstructed_labour,
                        'fk_anc_convulsion'=>$fk_anc_convulsion,
                        'fk_anc_sepsis'=>$fk_anc_sepsis,
                        'fk_anc_severe_headache_delivery'=>$fk_anc_severe_headache_delivery,
                        'fk_anc_consciousness'=>$fk_anc_consciousness,
                        'fk_anc_vaginal_bleeding_post'=>$fk_anc_vaginal_bleeding_post,
                        'fk_anc_convulsion_eclampsia_post'=>$fk_anc_convulsion_eclampsia_post,
                        'fk_anc_high_feaver_post'=>$fk_anc_high_feaver_post,
                        'fk_anc_smelling_discharge_post'=>$fk_anc_smelling_discharge_post,
                        'fk_anc_severe_headache_post'=>$fk_anc_severe_headache_post,
                        'fk_anc_consciousness_post'=>$fk_anc_consciousness_post,
                        'fk_anc_inability_baby'=>$fk_anc_inability_baby,
                        'fk_anc_baby_small_baby'=>$fk_anc_baby_small_baby,
                        'fk_anc_fast_breathing_baby'=>$fk_anc_fast_breathing_baby,
                        'fk_anc_convulsions_baby'=>$fk_anc_convulsions_baby,
                        'fk_anc_drowsy_baby'=>$fk_anc_drowsy_baby,
                        'fk_anc_movement_baby'=>$fk_anc_movement_baby,
                        'fk_anc_grunting_baby'=>$fk_anc_grunting_baby,
                        'fk_anc_indrawing_baby'=>$fk_anc_indrawing_baby,
                        'fk_anc_temperature_baby'=>$fk_anc_temperature_baby,
                        'fk_anc_hypothermia_baby'=>$fk_anc_hypothermia_baby,
                        'fk_anc_central_cyanosis_baby'=>$fk_anc_central_cyanosis_baby,
                        'fk_anc_umbilicus_baby'=>$fk_anc_umbilicus_baby,
                        'fk_anc_labour_preg'=>$fk_anc_labour_preg,
                        'fk_anc_severe_headache_preg'=>$fk_anc_severe_headache_preg,
                        'fk_anc_excessive_bld_pre'=>$fk_anc_excessive_bld_pre,
                        'fk_anc_convulsion_preg'=>$fk_anc_convulsion_preg,
                        'fk_anc_obstructed_preg'=>$fk_anc_obstructed_preg,
                        'fk_anc_placenta_preg'=>$fk_anc_placenta_preg,
                        'fk_anc_breath_child'=>$fk_anc_breath_child,
                        'fk_anc_suck_baby'=>$fk_anc_suck_baby,
                        'fk_anc_hot_cold_child'=>$fk_anc_hot_cold_child,
                        'fk_anc_blue_child'=>$fk_anc_blue_child,
                        'fk_anc_convulsion_child'=>$fk_anc_convulsion_child,
                        'fk_anc_indrawing_child'=>$fk_anc_indrawing_child,

                        'fk_supliment_post'=>$fk_supliment_post,
                        'fk_post_natal_visit'=>$fk_post_natal_visit,
                        'fk_pnc_first_visit_assist'=>$pncFirstVisitAsist,
                        'fk_pnc_second_visit_assist'=>$pncSecondVisitAsist,
                        'remarks'=>$remarks,
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
                        'fk_routine_anc_chkup_mother_id'=>$checkupTypeRoutine, 
                        'routine_anc_chkup_mother_times'=>$afterTotalTimesRoutine, 
                        'fk_anc_first_visit_id'=>$routineFirstVisit, 
                        'anc_first_visit_months'=>$routineFirstVisitMonthss, 
                        'fk_anc_second_visit_id'=>$routineSecondVisit, 
                        'anc_second_visit_months'=>$routineSecondVisitMonths, 
                        'fk_anc_third_visit_id'=>$routineThirdVisit, 
                        'anc_third_visit_months'=>$routineThirdVisitMonths, 
                        'fk_anc_fourth_visit_id'=>$routineFourthVisit, 
                        'anc_fourth_visit_months'=>$routineFourthVisitMonths, 
                        'fk_anc_fifth_visit_id'=>$routineFifthVisit, 
                        'anc_fifth_visit_months'=>$routineFifthVisitMonths,
                        'fk_pnc_chkup_mother_id'=>$checkupType, 
                        'pnc_chkup_mother_times'=>$afterTotalTimes, 
                        'fk_pnc_first_visit_id'=>$firstVisit, 
                        'pnc_first_visit_days'=>$firstVisitDays, 
                        'fk_pnc_second_visit_id'=>$secondVisit, 
                        'pnc_second_visit_days'=>$secondVisitDays,
                        //'keep_follow_up'=>$keep_follow_up,
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );
					
					
                        
                    $this->pregnancyModel->edit($IdInfo,$pregnancyID);
					
					
					$conceptfo = array(
                        
                        'fk_conception_result'=>$fk_conception_result, 
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );
					
					
                        
                    $this->conceptionModel->edit($conceptfo,$conceptionID);
				

                     $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_pregnancy'=>1, 
                        'transfer_complete'=>'No',  
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->modelName->editList($householdVisit,$visitID,$this->config->item('householdVisitTable'));

                     }
                 
                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while updating pregnancy.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','Member pregnancy updated successfully.');
                
                redirect('householdvisit/pregnancy?baseID='.$baseID.'#pregnancy');
            }
        
    }


    public function addPregnancy($id)
    {

            $baseID = $this->input->get('baseID', TRUE);
            $household_master_id_current = $this->input->get('household_master_id', TRUE);
            $member_master_id = $this->input->get('member_master_id', TRUE);
            $this->global['menu'] =  $this->menuModel->getMenu($this->role);
            
            $this->global['pageTitle'] = $this->config->item('prefix'). ' : Member Pregnancy' ;
            $data['pageTitle'] = $this->pageTitle;
            $data['controller'] = $this->controller;
            $data['shortName'] = $this->pageShortName;
            $data['boxTitle'] = 'List';


            if ($this->getCurrentRound()[0]->active == 0)
            {

              $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
              redirect($this->controller.'?baseID='.$baseID);
            }

            // $this->$rountStatus = $this->getCurrentRound()[0]->active;
            $data['roundNo'] =  $this->getCurrentRound()[0]->roundNo;
            $data['round_master_id'] =  $this->getCurrentRound()[0]->id;
            $data['householdcode'] =  $this->session->userdata('householdcode');

            $data['household_master_id_sub'] = 0;

            $data['household_master_id_sub'] = $this->session->userdata('household_master_id_sub');

            if ($data['household_master_id_sub'] == 0)
            {
                redirect('householdvisit/visit?baseID='.$baseID);
            }

            if ($household_master_id_current != $household_master_id_current)
            {

                 $this->session->set_flashdata('error', 'You can not change household ID. This strictly prohibited.');
                 redirect('householdvisit/visit?baseID='.$baseID);
            }
          
            
            $data['householdVisit'] = $this->visitModel->getHouseholdVisitDet($this->config->item('householdVisitTable'),$data['household_master_id_sub'],$data['round_master_id']);

            $data['memberInfo'] = $this->pregnancyModel->getMemberConceptionInfoByConceptionIds($data['household_master_id_sub'],$id,$member_master_id,$this->config->item('conceptionFollowpID'));
			

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
		
            
            $data['addPerm']  =  $this->getPermission($baseID, $this->role, 'add');
            $data['editPerm'] =  $this->getPermission($baseID, $this->role, 'edit');
    
            $this->load->view('includes/header', $this->global);
             $this->load->view('includes/wizard', $data);
            $this->load->view($this->controller.'/pregnancy_add_details', $data);
            $this->load->view('includes/footer');
        
    }

    function addPregnancyDetails()
    {
          
          
			//print_r($this->input->post()); die();	


            $household_master_id = $this->input->post('household_master_id_sub',true);
            $round_master_id = $this->input->post('round_master_id',true);
            $member_master_id = $this->input->post('member_master_id',true);
            $conceptionID = $this->input->post('conceptionID',true); 

            $this->load->library('form_validation');

            $this->form_validation->set_rules('pregnancy_outcome_date','pregnancy outcome Date','trim|required');
            $this->form_validation->set_rules('spontaneous_abortion','spontaneous abortion','trim|required|numeric');
            $this->form_validation->set_rules('induced_abortion','induced abortion','trim|required|numeric');
            $this->form_validation->set_rules('still_birth','still birth','trim|required|numeric');
			
            $this->form_validation->set_rules('live_birth','live birth','trim|required|numeric');
            $this->form_validation->set_rules('fk_conception_result','Result of Pregnancy','trim|required|numeric');
            $this->form_validation->set_rules('fk_delivery_methodology','Mode of delivery','trim|required|numeric');
            $this->form_validation->set_rules('fk_delivery_assist_type','Birth attended','trim|required|numeric');
            $this->form_validation->set_rules('fk_delivery_term_place','Place of delivery','trim|required|numeric');
           // $this->form_validation->set_rules('given_six_hour_birth','Conception order','trim');
           // $this->form_validation->set_rules('breast_milk_day','breast milk day','trim|required|numeric');
           // $this->form_validation->set_rules('breast_milk_hour','breast milk hour','trim|required|numeric');
           // $this->form_validation->set_rules('fk_health_problem_id','Health Problem','trim|required|numeric');
           // $this->form_validation->set_rules('fk_high_pressure_id','High Pressure','trim|required|numeric');
          //  $this->form_validation->set_rules('fk_diabetis_id','Diabetis','trim|required|numeric');
          //  $this->form_validation->set_rules('fk_preaklampshia_id','Pre aklampshia','trim|required|numeric');
           // $this->form_validation->set_rules('fk_lebar_birth_id','Pre term Laber','trim|required|numeric');
           // $this->form_validation->set_rules('fk_vomiting_id','Vomiting','trim|required|numeric');
           // $this->form_validation->set_rules('fk_amliotic_id','Amliotic','trim|required|numeric');
           // $this->form_validation->set_rules('fk_membrane_id','Membrane','trim|required|numeric');
           // $this->form_validation->set_rules('fk_malposition_id','Malposition','trim|required|numeric');
           // $this->form_validation->set_rules('fk_headache_id','Headache','trim|required|numeric');
           // $this->form_validation->set_rules('keep_follow_up','Follow up','trim|required|numeric');
            $this->form_validation->set_rules('conceptionID','Conception ID','trim|required|numeric');
            $this->form_validation->set_rules('checkupTypeRoutine','Routine check-up in pregnancy  for mother','trim|required|numeric');
            $this->form_validation->set_rules('checkupType','Within 42 days of the birth of the baby you ever had a check-up','trim|required|numeric');

           
            $baseID = $this->input->get('baseID', TRUE);

           
           if($this->form_validation->run() == FALSE)
            {
    
                redirect('memberPregnancy/addPregnancy/'. $conceptionID.'?member_master_id='.$member_master_id.'&&household_master_id='.$household_master_id.'&&baseID='.$baseID.'#pregnancy');
				
	
            }
            else
            {

               if ($this->getCurrentRound()[0]->active == 0)
               {

                  $this->session->set_flashdata('error', 'Currenty round is closed. Please wait until new round is open.');
                  redirect('householdvisit/visit?baseID='.$baseID);
               }
			   
			    $spontaneous_abortion = $this->input->post('spontaneous_abortion',true);
                $induced_abortion = $this->input->post('induced_abortion',true);
                $still_birth = $this->input->post('still_birth',true);
                $live_birth = $this->input->post('live_birth',true);
                $fk_conception_result = $this->input->post('fk_conception_result',true);
                $fk_delivery_methodology = $this->input->post('fk_delivery_methodology',true);
                $fk_delivery_assist_type = $this->input->post('fk_delivery_assist_type',true);
                $fk_delivery_term_place = $this->input->post('fk_delivery_term_place',true);
                $fk_facility_delivery = $this->input->post('fk_facility_delivery',true);

                if (($fk_conception_result == 95) || ($fk_conception_result == 199))
                {
                    $fk_colostrum = 0;
                    $fk_first_milk = 0;
                    $milk_day = 0;
                }
                else{

                    $fk_colostrum = $this->input->post('fk_colostrum',true);
                    $fk_first_milk = $this->input->post('fk_first_milk',true);
                    $milk_hours = $this->input->post('milk_hours',true);
                    $milk_day = $this->input->post('milk_day',true);
    

                }

                if (($fk_delivery_term_place == 103) || ($fk_delivery_term_place == 104) || ($fk_delivery_term_place == 205) )
                {
                    $fk_facility_delivery = 0;
                }
                else{
                    $fk_facility_delivery = $this->input->post('fk_facility_delivery',true) ?  $this->input->post('fk_facility_delivery',true) : 0;
                }
                
               
                $fk_preg_complication = $this->input->post('fk_preg_complication',true) ?  $this->input->post('fk_preg_complication',true) : 0;
                $fk_delivery_complication = $this->input->post('fk_delivery_complication',true) ?  $this->input->post('fk_delivery_complication',true) : 0;
                $fk_preg_violence = $this->input->post('fk_preg_violence',true) ?  $this->input->post('fk_preg_violence',true) : 0;
                $fk_litter_size = $this->input->post('fk_litter_size',true) ?  $this->input->post('fk_litter_size',true) : 0;

               

              //  $given_six_hour_birth = $this->input->post('given_six_hour_birth',true);
              //  $breast_milk_day = $this->input->post('breast_milk_day',true);
              //  $breast_milk_hour = $this->input->post('breast_milk_hour',true);
              //  $fk_health_problem_id = $this->input->post('fk_health_problem_id',true);
             //   $fk_high_pressure_id = $this->input->post('fk_high_pressure_id',true);
              //  $fk_diabetis_id = $this->input->post('fk_diabetis_id',true);
             //   $fk_preaklampshia_id = $this->input->post('fk_preaklampshia_id',true);
              //  $fk_lebar_birth_id = $this->input->post('fk_lebar_birth_id',true);
             //   $fk_vomiting_id = $this->input->post('fk_vomiting_id',true);
             //   $fk_amliotic_id = $this->input->post('fk_amliotic_id',true);
              //  $fk_membrane_id = $this->input->post('fk_membrane_id',true);
             //   $fk_malposition_id = $this->input->post('fk_malposition_id',true);
             //   $fk_headache_id = $this->input->post('fk_headache_id',true);
               // $keep_follow_up = $this->input->post('keep_follow_up',true);
                $conceptionDate = $this->input->post('conceptionDate',true);
				
				
               $pregnancy_outcome_date = $this->input->post('pregnancy_outcome_date',true);
			  
                $new_pregnancy_outcome_date = null;

                if (!empty($pregnancy_outcome_date)) {
                    $parts3 = explode('/', $pregnancy_outcome_date);
                    $new_pregnancy_outcome_date = $parts3[2] . '-' . $parts3[1] . '-' . $parts3[0];
                }
				
				// check same conception
				$whereHouseholdCons = array('conception_id' =>$conceptionID,'member_master_id'=>$member_master_id);

				$countRow = $this->db->select('count(id) as countRow')->from($this->config->item('pregnancyTable'))->where($whereHouseholdCons)->get()->row()->countRow;

			    if ($countRow > 0)
			    {
				  $this->session->set_flashdata('error', 'Same pregnancy outcome already exists. Please select another.');
				  redirect('householdvisit/pregnancy?baseID='.$baseID.'#pregnancy');
			    }
				
				// check same pregnancy date
				$whereHouseholdPregDate = array('pregnancy_outcome_date' =>$new_pregnancy_outcome_date,'member_master_id'=>$member_master_id);

                $countRowDate = $this->db->select('count(id) as countRowDate')->from($this->config->item('pregnancyTable'))->where($whereHouseholdPregDate)->get()->row()->countRowDate;

                if ($countRowDate > 0)
                {
                  $this->session->set_flashdata('error', 'Same pregnancy outcome date already exists. Please select another date.');
                  redirect('memberPregnancy/addPregnancy/'. $conceptionID.'?member_master_id='.$member_master_id.'&&household_master_id='.$household_master_id.'&&baseID='.$baseID.'#pregnancy');
                }


                // anc
                $checkupTypeRoutine = $this->input->post('checkupTypeRoutine',true);

                if ($checkupTypeRoutine == 1)
                {

                    $afterTotalTimesRoutine = $this->input->post('afterTotalTimesRoutine',true) ?  $this->input->post('afterTotalTimesRoutine',true) : 0;
                   
                    $routineFirstVisitAsist = $this->input->post('routineFirstVisitAsist',true);
                    $routineFirstVisit = $this->input->post('routineFirstVisit',true);
                    $routineFirstVisitMonthss = $this->input->post('routineFirstVisitMonthss',true) ?  $this->input->post('routineFirstVisitMonthss',true) : 0;
                   
                    $routineSecondVisitAsist = $this->input->post('routineSecondVisitAsist',true);
                    $routineSecondVisit = $this->input->post('routineSecondVisit',true);
                    $routineSecondVisitMonths = $this->input->post('routineSecondVisitMonths',true) ?  $this->input->post('routineSecondVisitMonths',true) : 0;
                    
                    $routineThirdVisitAsist = $this->input->post('routineThirdVisitAsist',true);
                    $routineThirdVisit = $this->input->post('routineThirdVisit',true);
                    $routineThirdVisitMonths = $this->input->post('routineThirdVisitMonths',true) ?  $this->input->post('routineThirdVisitMonths',true) : 0;
                   
                    $routineFourthVisitAsist = $this->input->post('routineFourthVisitAsist',true);
                    $routineFourthVisit = $this->input->post('routineFourthVisit',true);
                    $routineFourthVisitMonths = $this->input->post('routineFourthVisitMonths',true) ?  $this->input->post('routineFourthVisitMonths',true) : 0;
                    
                    $routineFifthVisitAsist = $this->input->post('routineFifthVisitAsist',true);
                    $routineFifthVisit = $this->input->post('routineFifthVisit',true);
                    $routineFifthVisitMonths = $this->input->post('routineFifthVisitMonths',true) ?  $this->input->post('routineFifthVisitMonths',true) : 0;
                   
                }

                else
                {
                    $afterTotalTimesRoutine = 0;
                    $routineFirstVisitAsist = 0;
                    $routineFirstVisit = 0;
                    $routineFirstVisitMonthss = 0;
                    $routineSecondVisitAsist = 0;
                    $routineSecondVisit = 0;
                    $routineSecondVisitMonths = 0;
                    $routineThirdVisitAsist = 0;
                    $routineThirdVisit = 0;
                    $routineThirdVisitMonths = 0;
                    $routineFourthVisitAsist = 0;
                    $routineFourthVisit = 0;
                    $routineFourthVisitMonths = 0;
                    $routineFifthVisitAsist = 0;
                    $routineFifthVisit = 0;
                    $routineFifthVisitMonths = 0;
                }

                $fk_supliment = $this->input->post('fk_supliment',true);
                if ($fk_supliment == 1)
                {
                    $fk_supliment_received_way = $this->input->post('fk_supliment_received_way',true) ?  $this->input->post('fk_supliment_received_way',true) : 0;
                    $fk_how_many_tab = $this->input->post('fk_how_many_tab',true) ?  $this->input->post('fk_how_many_tab',true) : 0;

                    if ($fk_how_many_tab == 226)
                    {
                        $totalNumberTablet = $this->input->post('totalNumberTablet',true) ?  $this->input->post('totalNumberTablet',true) : 0;
                    }
                    else{
                        $totalNumberTablet = 0;
                    }
                   
                }
                else{
                    $fk_supliment_received_way = 0;
                    $fk_how_many_tab = 0;
                    $totalNumberTablet = 0;
                }
                
               

                // Basic components of ANC
                $fk_anc_weight_taken = $this->input->post('fk_anc_weight_taken',true);
                $fk_anc_blood_pressure = $this->input->post('fk_anc_blood_pressure',true);
                $fk_anc_urine = $this->input->post('fk_anc_urine',true);
                $fk_anc_blood = $this->input->post('fk_anc_blood',true);
                $fk_anc_denger_sign = $this->input->post('fk_anc_denger_sign',true);
                $fk_anc_nutrition = $this->input->post('fk_anc_nutrition',true);
                $fk_anc_birth_prepare = $this->input->post('fk_anc_birth_prepare',true);

                // Newborn care practices

                $fk_anc_delivery_kit = $this->input->post('fk_anc_delivery_kit',true);
                $fk_anc_soap = $this->input->post('fk_anc_soap',true);
                $fk_anc_care_chix = $this->input->post('fk_anc_care_chix',true);

                $fk_anc_dried = $this->input->post('fk_anc_dried',true);
                $fk_anc_bathing = $this->input->post('fk_anc_bathing',true);
                $fk_anc_breast_feed = $this->input->post('fk_anc_breast_feed',true);
                $fk_anc_skin_contact = $this->input->post('fk_anc_skin_contact',true);
                $fk_anc_enc = $this->input->post('fk_anc_enc',true);
               

                //  sepsis

                $fk_suspecred_infection = $this->input->post('fk_suspecred_infection',true);

                if ($fk_suspecred_infection == 228)
                {

                    $fk_baby_antibiotics = $this->input->post('fk_baby_antibiotics',true) ?  $this->input->post('fk_baby_antibiotics',true) : 0;
                    if ($fk_baby_antibiotics == 1)
                    {
                        $fk_prescribe_antibiotics = $this->input->post('fk_prescribe_antibiotics',true) ?  $this->input->post('fk_prescribe_antibiotics',true) : 0;
                        $fk_seek_treatment = $this->input->post('fk_seek_treatment',true) ?  $this->input->post('fk_seek_treatment',true) : 0;
        
                    }
                    else{
                        $fk_prescribe_antibiotics = 0;
                        $fk_seek_treatment = 0;
                    }
                    
                    
                }
                else 
                {
                    $fk_baby_antibiotics = 0;
                    $fk_prescribe_antibiotics = 0;
                    $fk_seek_treatment = 0;
                }

               
                
                //  Knowledge and Behavior 

                $fk_anc_vaginal_bleeding = $this->input->post('fk_anc_vaginal_bleeding',true);
                $fk_anc_convulsions = $this->input->post('fk_anc_convulsions',true);
                $fk_anc_severe_headache = $this->input->post('fk_anc_severe_headache',true);
                $fk_anc_fever = $this->input->post('fk_anc_fever',true);
                $fk_anc_abdominal_pain = $this->input->post('fk_anc_abdominal_pain',true);
                $fk_anc_diff_breath = $this->input->post('fk_anc_diff_breath',true);

                // danger signs of delivery
                $fk_anc_water_break = $this->input->post('fk_anc_water_break',true);
                $fk_anc_vaginal_bleed_aph = $this->input->post('fk_anc_vaginal_bleed_aph',true);
                $fk_anc_obstructed_labour = $this->input->post('fk_anc_obstructed_labour',true);
                $fk_anc_convulsion = $this->input->post('fk_anc_convulsion',true);
                $fk_anc_sepsis = $this->input->post('fk_anc_sepsis',true);
                $fk_anc_severe_headache_delivery = $this->input->post('fk_anc_severe_headache_delivery',true);
                $fk_anc_consciousness = $this->input->post('fk_anc_consciousness',true);

                // signs of postnatal period

                $fk_anc_vaginal_bleeding_post = $this->input->post('fk_anc_vaginal_bleeding_post',true);
                $fk_anc_convulsion_eclampsia_post = $this->input->post('fk_anc_convulsion_eclampsia_post',true);
                $fk_anc_high_feaver_post = $this->input->post('fk_anc_high_feaver_post',true);
                $fk_anc_smelling_discharge_post = $this->input->post('fk_anc_smelling_discharge_post',true);
                $fk_anc_severe_headache_post = $this->input->post('fk_anc_severe_headache_post',true);
                $fk_anc_consciousness_post = $this->input->post('fk_anc_consciousness_post',true);

                // signs of newborn baby
                $fk_anc_inability_baby = $this->input->post('fk_anc_inability_baby',true);
                $fk_anc_baby_small_baby = $this->input->post('fk_anc_baby_small_baby',true);
                $fk_anc_fast_breathing_baby = $this->input->post('fk_anc_fast_breathing_baby',true);
                $fk_anc_convulsions_baby = $this->input->post('fk_anc_convulsions_baby',true);
                $fk_anc_drowsy_baby = $this->input->post('fk_anc_drowsy_baby',true);
                $fk_anc_movement_baby = $this->input->post('fk_anc_movement_baby',true);
                $fk_anc_grunting_baby = $this->input->post('fk_anc_grunting_baby',true);
                $fk_anc_indrawing_baby = $this->input->post('fk_anc_indrawing_baby',true);
                $fk_anc_temperature_baby = $this->input->post('fk_anc_temperature_baby',true);
                $fk_anc_hypothermia_baby = $this->input->post('fk_anc_hypothermia_baby',true);
                $fk_anc_central_cyanosis_baby = $this->input->post('fk_anc_central_cyanosis_baby',true);
                $fk_anc_umbilicus_baby = $this->input->post('fk_anc_umbilicus_baby',true);

                //complicated pregnancy

                $fk_anc_labour_preg = $this->input->post('fk_anc_labour_preg',true);
                $fk_anc_excessive_bld_pre = $this->input->post('fk_anc_excessive_bld_pre',true);
                $fk_anc_severe_headache_preg = $this->input->post('fk_anc_severe_headache_preg',true);
                $fk_anc_obstructed_preg = $this->input->post('fk_anc_obstructed_preg',true);
                $fk_anc_convulsion_preg = $this->input->post('fk_anc_convulsion_preg',true);
                $fk_anc_placenta_preg = $this->input->post('fk_anc_placenta_preg',true);


                //newborn and child
                $fk_anc_breath_child = $this->input->post('fk_anc_breath_child',true);
                $fk_anc_suck_baby = $this->input->post('fk_anc_suck_baby',true);
                $fk_anc_hot_cold_child = $this->input->post('fk_anc_hot_cold_child',true);
                $fk_anc_blue_child = $this->input->post('fk_anc_blue_child',true);
                $fk_anc_convulsion_child = $this->input->post('fk_anc_convulsion_child',true);
                $fk_anc_indrawing_child = $this->input->post('fk_anc_indrawing_child',true);


                $remarks = $this->input->post('remarks',true);



                
                // pnc
                $fk_supliment_post = $this->input->post('fk_supliment_post',true);
                $checkupType = $this->input->post('checkupType',true);

                if ($checkupType == 1)
                {

                    $fk_post_natal_visit = $this->input->post('fk_post_natal_visit',true) ?  $this->input->post('fk_post_natal_visit',true) : 0;
                    $afterTotalTimes = $this->input->post('afterTotalTimes',true) ?  $this->input->post('afterTotalTimes',true) : 0;

                    $pncFirstVisitAsist = $this->input->post('pncFirstVisitAsist',true);
                    $firstVisit = $this->input->post('firstVisit',true);
                    $firstVisitDays = $this->input->post('firstVisitDays',true) ?  $this->input->post('firstVisitDays',true) : 0;

                    $pncSecondVisitAsist = $this->input->post('pncSecondVisitAsist',true);
                    $secondVisit = $this->input->post('secondVisit',true);
                    $secondVisitDays = $this->input->post('secondVisitDays',true) ?  $this->input->post('secondVisitDays',true) : 0;
                   
                }

                else
                {
                    $fk_post_natal_visit = 0;
                    $pncFirstVisitAsist = 0;
                    $pncSecondVisitAsist = 0;
                    $afterTotalTimes = 0;
                    $firstVisit = 0;
                    $firstVisitDays = 0;
                    $secondVisit = 0;
                    $secondVisitDays = 0;
                   
                }
				
				//live_birth
				
				if ($live_birth > 0)	
				{
					if (!empty($conceptionDate))
					{
						$concept=date_create($conceptionDate);
						$preg=date_create($new_pregnancy_outcome_date);
						$diff=date_diff($concept,$preg);
						$days = $diff->format("%a");
						
						
						if ($days <= 160)
						{

							$this->session->set_flashdata('error', 'Pregnancy out come date is less than 160 days.');
							//redirect('memberPregnancy/addPregnancy/'. $conceptionID.'?member_master_id='.$member_master_id.'&&household_master_id='.$household_master_id.'&&baseID='.$baseID.'#pregnancy');
                
						}
						
						if ($days >= 320)
						{
							$this->session->set_flashdata('error', 'Pregnancy out come date is greater than 320 days.');
							//redirect('memberPregnancy/addPregnancy/'. $conceptionID.'?member_master_id='.$member_master_id.'&&household_master_id='.$household_master_id.'&&baseID='.$baseID.'#pregnancy');
                
						}
					}
				
				}


                $round_master_id_entry_round =  $this->getCurrentRound()[0]->id;

                $this->db->trans_start();

                try
                { 
				

                    $IdInfo = array(
                        
                        'pregnancy_outcome_date'=>$new_pregnancy_outcome_date, 
                        'conception_id'=>$conceptionID, 
                      //  'breast_milk_day'=>$breast_milk_day, 
                       // 'breast_milk_hour'=>$breast_milk_hour,
                        'induced_abortion'=>$induced_abortion,
                        'spontaneous_abortion'=>$spontaneous_abortion,
                        'live_birth'=>$live_birth,
                        'still_birth'=>$still_birth,
                        'fk_delivery_methodology'=>$fk_delivery_methodology,
                        'fk_delivery_assist_type'=>$fk_delivery_assist_type,
                        'fk_delivery_term_place'=>$fk_delivery_term_place,
                        'fk_litter_size'=>$fk_litter_size,
                        'fk_colostrum'=>$fk_colostrum,
                        'fk_first_milk'=>$fk_first_milk,
                        'milk_hours'=>$milk_hours,
                        'milk_day'=>$milk_day,
                        'fk_facility_delivery'=>$fk_facility_delivery,
                        'fk_preg_complication'=>$fk_preg_complication,
                        'fk_delivery_complication'=>$fk_delivery_complication,
                        'fk_preg_violence'=>$fk_preg_violence,
                        'fk_anc_first_assist_id'=>$routineFirstVisitAsist,
                        'fk_anc_second_assist_id'=>$routineSecondVisitAsist,
                        'fk_anc_third_assist_id'=>$routineThirdVisitAsist,
                        'fk_anc_fourth_assist_id'=>$routineFourthVisitAsist,
                        'fk_anc_fifth_assist_id'=>$routineFifthVisitAsist,                   
                        'fk_anc_supliment'=>$fk_supliment,
                        'fk_supliment_received_way'=>$fk_supliment_received_way,
                        'fk_how_many_tab'=>$fk_how_many_tab,
                        'totalnumbertab'=>$totalNumberTablet,
                        'fk_anc_weight_taken'=>$fk_anc_weight_taken,
                        'fk_anc_blood_pressure'=>$fk_anc_blood_pressure,
                        'fk_anc_urine'=>$fk_anc_urine,
                        'fk_anc_blood'=>$fk_anc_blood,
                        'fk_anc_denger_sign'=>$fk_anc_denger_sign,
                        'fk_anc_nutrition'=>$fk_anc_nutrition,
                        'fk_anc_birth_prepare'=>$fk_anc_birth_prepare,
                        'fk_anc_delivery_kit'=>$fk_anc_delivery_kit,
                        'fk_anc_soap'=>$fk_anc_soap,
                        'fk_anc_care_chix'=>$fk_anc_care_chix,
                        'fk_anc_dried'=>$fk_anc_dried,
                        'fk_anc_bathing'=>$fk_anc_bathing,
                        'fk_anc_breast_feed'=>$fk_anc_breast_feed,
                        'fk_anc_skin_contact'=>$fk_anc_skin_contact,
                        'fk_anc_enc'=>$fk_anc_enc,
                        'fk_suspecred_infection'=>$fk_suspecred_infection,
                        'fk_baby_antibiotics'=>$fk_baby_antibiotics,
                        'fk_prescribe_antibiotics'=>$fk_prescribe_antibiotics,
                        'fk_seek_treatment'=>$fk_seek_treatment,
                        'fk_anc_vaginal_bleeding'=>$fk_anc_vaginal_bleeding,
                        'fk_anc_convulsions'=>$fk_anc_convulsions,
                        'fk_anc_severe_headache'=>$fk_anc_severe_headache,
                        'fk_anc_fever'=>$fk_anc_fever,
                        'fk_anc_abdominal_pain'=>$fk_anc_abdominal_pain,
                        'fk_anc_diff_breath'=>$fk_anc_diff_breath,
                        'fk_anc_water_break'=>$fk_anc_water_break,
                        'fk_anc_vaginal_bleed_aph'=>$fk_anc_vaginal_bleed_aph,
                        'fk_anc_obstructed_labour'=>$fk_anc_obstructed_labour,
                        'fk_anc_convulsion'=>$fk_anc_convulsion,
                        'fk_anc_sepsis'=>$fk_anc_sepsis,
                        'fk_anc_severe_headache_delivery'=>$fk_anc_severe_headache_delivery,
                        'fk_anc_consciousness'=>$fk_anc_consciousness,
                        'fk_anc_vaginal_bleeding_post'=>$fk_anc_vaginal_bleeding_post,
                        'fk_anc_convulsion_eclampsia_post'=>$fk_anc_convulsion_eclampsia_post,
                        'fk_anc_high_feaver_post'=>$fk_anc_high_feaver_post,
                        'fk_anc_smelling_discharge_post'=>$fk_anc_smelling_discharge_post,
                        'fk_anc_severe_headache_post'=>$fk_anc_severe_headache_post,
                        'fk_anc_consciousness_post'=>$fk_anc_consciousness_post,
                        'fk_anc_inability_baby'=>$fk_anc_inability_baby,
                        'fk_anc_baby_small_baby'=>$fk_anc_baby_small_baby,
                        'fk_anc_fast_breathing_baby'=>$fk_anc_fast_breathing_baby,
                        'fk_anc_convulsions_baby'=>$fk_anc_convulsions_baby,
                        'fk_anc_drowsy_baby'=>$fk_anc_drowsy_baby,
                        'fk_anc_movement_baby'=>$fk_anc_movement_baby,
                        'fk_anc_grunting_baby'=>$fk_anc_grunting_baby,
                        'fk_anc_indrawing_baby'=>$fk_anc_indrawing_baby,
                        'fk_anc_temperature_baby'=>$fk_anc_temperature_baby,
                        'fk_anc_hypothermia_baby'=>$fk_anc_hypothermia_baby,
                        'fk_anc_central_cyanosis_baby'=>$fk_anc_central_cyanosis_baby,
                        'fk_anc_umbilicus_baby'=>$fk_anc_umbilicus_baby,
                        'fk_anc_labour_preg'=>$fk_anc_labour_preg,
                        'fk_anc_severe_headache_preg'=>$fk_anc_severe_headache_preg,
                        'fk_anc_excessive_bld_pre'=>$fk_anc_excessive_bld_pre,
                        'fk_anc_convulsion_preg'=>$fk_anc_convulsion_preg,
                        'fk_anc_obstructed_preg'=>$fk_anc_obstructed_preg,
                        'fk_anc_placenta_preg'=>$fk_anc_placenta_preg,
                        'fk_anc_breath_child'=>$fk_anc_breath_child,
                        'fk_anc_suck_baby'=>$fk_anc_suck_baby,
                        'fk_anc_hot_cold_child'=>$fk_anc_hot_cold_child,
                        'fk_anc_blue_child'=>$fk_anc_blue_child,
                        'fk_anc_convulsion_child'=>$fk_anc_convulsion_child,
                        'fk_anc_indrawing_child'=>$fk_anc_indrawing_child,

                        'fk_supliment_post'=>$fk_supliment_post,
                        'fk_post_natal_visit'=>$fk_post_natal_visit,
                        'fk_pnc_first_visit_assist'=>$pncFirstVisitAsist,
                        'fk_pnc_second_visit_assist'=>$pncSecondVisitAsist,
                        'remarks'=>$remarks,
                
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
                        'fk_routine_anc_chkup_mother_id'=>$checkupTypeRoutine, 
                        'routine_anc_chkup_mother_times'=>$afterTotalTimesRoutine, 
                        'fk_anc_first_visit_id'=>$routineFirstVisit, 
                        'anc_first_visit_months'=>$routineFirstVisitMonthss, 
                        'fk_anc_second_visit_id'=>$routineSecondVisit, 
                        'anc_second_visit_months'=>$routineSecondVisitMonths, 
                        'fk_anc_third_visit_id'=>$routineThirdVisit, 
                        'anc_third_visit_months'=>$routineThirdVisitMonths, 
                        'fk_anc_fourth_visit_id'=>$routineFourthVisit, 
                        'anc_fourth_visit_months'=>$routineFourthVisitMonths, 
                        'fk_anc_fifth_visit_id'=>$routineFifthVisit, 
                        'anc_fifth_visit_months'=>$routineFifthVisitMonths,
                        'fk_pnc_chkup_mother_id'=>$checkupType, 
                        'pnc_chkup_mother_times'=>$afterTotalTimes, 
                        'fk_pnc_first_visit_id'=>$firstVisit, 
                        'pnc_first_visit_days'=>$firstVisitDays, 
                        'fk_pnc_second_visit_id'=>$secondVisit, 
                        'pnc_second_visit_days'=>$secondVisitDays,
                       // 'keep_follow_up'=>$keep_follow_up,
                        'transfer_complete'=>'No',  
                        'member_master_id'=>$member_master_id, 
                        'round_master_id'=>$round_master_id_entry_round, 
                        'household_master_id'=>$household_master_id, 
                        'insertedBy'=>$this->vendorId, 
                        'insertedOn'=>date('Y-m-d H:i:s')
                    );
					
					
                        
                    $this->pregnancyModel->addNew($IdInfo,$this->config->item('pregnancyTable'));
					
					
					$conceptfo = array(
                        
                        'fk_conception_result'=>$fk_conception_result, 
                        'fk_conception_followup_status'=>$this->config->item('pregnancyOutID'),  
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                    );
					
					
                        
                    $this->conceptionModel->edit($conceptfo,$conceptionID);



                     $whereHouseholdVisit = array('household_master_id' =>$household_master_id,'round_master_id'=>$round_master_id);

                     $countVisit = $this->db->select('count(id) as countVisit')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->countVisit;

                     if ($countVisit > 0)
                     {

                        $visitID = $this->db->select('id')->from($this->config->item('householdVisitTable'))->where($whereHouseholdVisit)->get()->row()->id;

                        $householdVisit= array(
                        'any_pregnancy'=>1, 
                        'transfer_complete'=>'No',  
                        'updateBy'=>$this->vendorId, 
                        'updatedOn'=>date('Y-m-d H:i:s')
                        );

                        $this->modelName->editList($householdVisit,$visitID,$this->config->item('householdVisitTable'));

                     }

                   
                    
                    
                }
                catch(Exception $e)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'Error occurred while creating pregnancy out.');
                }

                $this->db->trans_commit();
                $this->session->set_flashdata('success','pregnancy out created successfully.');
                
                redirect('householdvisit/pregnancy?baseID='.$baseID.'#pregnancy');
            }
        
    }


   
  
    
    
}

?>