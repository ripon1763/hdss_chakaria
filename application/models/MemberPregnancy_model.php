<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MemberPregnancy_model extends CI_Model
{
	
    function addNew($IdInfo,$tableName)
    {
        $this->db->trans_start();
        $this->db->insert($tableName, $IdInfo);
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function edit($IDInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_member_pregnancy', $IDInfo);
        
        return TRUE;
    }
	
	function getMemberConceptionInfoByConceptionIds($household_master_id,$conceptionID,$member_master_id,$conceptionFollowpID)
    {
        $this->db->select('consp.id, consp.household_master_id,consp.member_master_id,mm.member_code, consp.round_master_id,mm.member_name,
        mm.birth_date, roundNo, conception_date, fk_conception_order, fk_conception_plan, fk_conception_followup_status,mar.name as marriageName, 
		mar.code as marriageCode,mm.household_master_id_hh,order.name as conceptOrder');
        $this->db->from('tbl_member_conception  consp');
        $this->db->join('tbl_member_master mm','mm.id=consp.member_master_id','inner');
        $this->db->join('tbl_round_master rm','rm.id=consp.round_master_id','inner');
        $this->db->join('household_master hm', 'hm.id = mm.household_master_id_hh', 'inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details mar', 'mar.id = mm.fk_marital_status', 'left');
        $this->db->join('tbl_lookup_details order', 'order.id = consp.fk_conception_order', 'left');
        $this->db->where('mm.household_master_id_hh', $household_master_id);
        $this->db->where('consp.id', $conceptionID);
        $this->db->where('consp.member_master_id', $member_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->where('consp.fk_conception_followup_status', $conceptionFollowpID);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get();
        
        return $query->result();
    }

    function getRoundwisePregnancy($household_master_id,$round_master_id)
    {
        $this->db->select('preg.id,preg.member_master_id, preg.household_master_id,mm.member_code, mm.member_name,mm.birth_date,household_master_id_hh,
		consp.conception_date,pregnancy_outcome_date');
        $this->db->from('tbl_member_pregnancy  preg');
        $this->db->join('tbl_member_conception  consp','consp.id=preg.conception_id','inner');
        $this->db->join('tbl_member_master mm','mm.id=preg.member_master_id','inner');
        $this->db->where('preg.household_master_id', $household_master_id);
        $this->db->where('preg.round_master_id', $round_master_id);
        $this->db->order_by('mm.member_code', 'asc');
        //$this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getPregnancyDetailsByIdnHousehold($id,$household_master_id,$round_master_id)
    {
        $this->db->select('preg.id,preg.conception_id, preg.household_master_id,preg.member_master_id,mm.member_code, preg.round_master_id,mm.member_name,
		mm.birth_date, roundNo, consp.conception_date,consp.fk_conception_result, preg.pregnancy_outcome_date, preg.breast_milk_day, preg.breast_milk_hour, preg.induced_abortion, 
		preg.spontaneous_abortion, preg.live_birth, preg.still_birth, preg.fk_delivery_methodology, preg.fk_delivery_assist_type, preg.fk_delivery_term_place, 
		preg.given_six_hour_birth, preg.fk_health_problem_id, preg.fk_high_pressure_id, preg.fk_diabetis_id, preg.fk_preaklampshia_id, preg.fk_lebar_birth_id, 
        preg.fk_vomiting_id, preg.fk_amliotic_id, preg.fk_membrane_id, preg.fk_malposition_id, preg.fk_headache_id, preg.keep_follow_up,corder.name as conceptOrder, 
        preg.fk_routine_anc_chkup_mother_id, preg.routine_anc_chkup_mother_times, preg.fk_anc_first_visit_id, preg.anc_first_visit_months, preg.fk_anc_second_visit_id,
        preg.anc_second_visit_months, preg.fk_anc_third_visit_id, preg.anc_third_visit_months, preg.fk_anc_fourth_visit_id, preg.anc_fourth_visit_months, preg.fk_anc_fifth_visit_id, 
        preg.anc_fifth_visit_months, preg.fk_pnc_chkup_mother_id, preg.pnc_chkup_mother_times, preg.fk_pnc_first_visit_id, preg.pnc_first_visit_days, preg.fk_pnc_second_visit_id, preg.pnc_second_visit_days,
        fk_litter_size, fk_colostrum,fk_first_milk,milk_hours, milk_day, fk_facility_delivery,fk_preg_complication, fk_delivery_complication, fk_preg_violence,
        fk_anc_first_assist_id,fk_anc_second_assist_id,fk_anc_third_assist_id,fk_anc_fourth_assist_id,fk_anc_fifth_assist_id,                   
        fk_anc_supliment,fk_supliment_received_way,fk_how_many_tab,totalnumbertab,fk_anc_weight_taken,fk_anc_blood_pressure,
        fk_anc_urine,fk_anc_blood,fk_anc_denger_sign,fk_anc_nutrition,fk_anc_birth_prepare,fk_anc_delivery_kit,fk_anc_soap,
        fk_anc_care_chix,fk_anc_dried,fk_anc_bathing,fk_anc_breast_feed,fk_anc_skin_contact, fk_anc_enc,fk_suspecred_infection,fk_baby_antibiotics,
        fk_prescribe_antibiotics, fk_seek_treatment,fk_anc_vaginal_bleeding, fk_anc_convulsions, fk_anc_severe_headache, fk_anc_fever,
        fk_anc_abdominal_pain,fk_anc_diff_breath, fk_anc_water_break,fk_anc_vaginal_bleed_aph,fk_anc_obstructed_labour,
        fk_anc_convulsion, fk_anc_sepsis, fk_anc_severe_headache_delivery,fk_anc_consciousness,fk_anc_vaginal_bleeding_post,
        fk_anc_convulsion_eclampsia_post,fk_anc_high_feaver_post,fk_anc_smelling_discharge_post, fk_anc_severe_headache_post, 
        fk_anc_consciousness_post,fk_anc_inability_baby, fk_anc_baby_small_baby,
        fk_anc_fast_breathing_baby,fk_anc_convulsions_baby,fk_anc_drowsy_baby, fk_anc_movement_baby,fk_anc_grunting_baby,
        fk_anc_indrawing_baby, fk_anc_temperature_baby,fk_anc_hypothermia_baby,fk_anc_central_cyanosis_baby,fk_anc_umbilicus_baby,
        fk_anc_labour_preg,fk_anc_severe_headache_preg,fk_anc_excessive_bld_pre,fk_anc_convulsion_preg,fk_anc_obstructed_preg,
        fk_anc_placenta_preg,fk_anc_breath_child,fk_anc_suck_baby,fk_anc_hot_cold_child, fk_anc_blue_child,fk_anc_convulsion_child,
        fk_anc_indrawing_child,fk_supliment_post,fk_post_natal_visit,fk_pnc_first_visit_assist,fk_pnc_second_visit_assist,remarks');
        $this->db->from('tbl_member_pregnancy  preg');
        $this->db->join('tbl_member_conception  consp','consp.id=preg.conception_id');
        $this->db->join('tbl_member_master mm','mm.id=preg.member_master_id','inner');
        $this->db->join('tbl_round_master rm','rm.id=preg.round_master_id','inner');
        $this->db->join('tbl_lookup_details corder','corder.id=consp.fk_conception_order','inner');
        $this->db->where('preg.household_master_id', $household_master_id);
        $this->db->where('preg.round_master_id', $round_master_id);
        $this->db->where('preg.id', $id);
        $this->db->order_by('mm.member_code', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	
	
	
	



    

  


  



    
    
    
 
}

  