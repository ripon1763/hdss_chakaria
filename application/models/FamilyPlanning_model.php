<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FamilyPlanning_model extends CI_Model {

    function addNew($IdInfo, $tableName) {
        $this->db->trans_start();
        $this->db->insert($tableName, $IdInfo);
        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    function edit($IDInfo, $id, $tableName) {
        $this->db->where('id', $id);
        $this->db->update($tableName, $IDInfo);

        return TRUE;
    }
    
    function getCurrentRound() {
        $this->db->select('*');
        $this->db->from('tbl_round_master');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->row();
    }

    function getFamilyPlanningHistory($household_master_id, $round_master_id) {
        $this->db->select('det.id,det.member_master_id, det.household_master_id,maritial_status.name as maritial_status_name,mm.member_code, mm.member_name,mm.birth_date,household_master_id_hh');
        $this->db->from('tbl_member_family_planning  det');
        $this->db->join('tbl_member_master mm', 'mm.id=det.member_master_id', 'inner');
        $this->db->join('tbl_lookup_details maritial_status', 'maritial_status.id=det.maritial_status', 'inner');
        $this->db->where('det.household_master_id', $household_master_id);
        $this->db->where('det.round_master_id', $round_master_id);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get();

        return $query->result();
    }

    function getFPDetailsByIdnHousehold($id, $household_master_id, $round_master_id) {
        $this->db->select('det.*,mm.member_code,mm.member_name,mm.birth_date,mm.fk_followup_exit_type,mm.followup_exit_date,mm.folowup_exit_round');
        $this->db->from('tbl_member_family_planning  det');
        $this->db->join('tbl_member_master mm', 'mm.id=det.member_master_id', 'inner');
        $this->db->join('tbl_round_master rm', 'rm.id=det.round_master_id', 'inner');
        $this->db->where('det.household_master_id', $household_master_id);
        $this->db->where('det.round_master_id', $round_master_id);
        $this->db->where('det.id', $id);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get();

        return $query->row();
    }
    
    function getFPDetails($id) {
        $this->db->select('det.*,mm.member_code,mm.member_name,mm.birth_date,mm.fk_followup_exit_type,mm.followup_exit_date,mm.folowup_exit_round');
        $this->db->from('tbl_member_family_planning  det');
        $this->db->join('tbl_member_master mm', 'mm.id=det.member_master_id', 'inner');
        $this->db->join('tbl_round_master rm', 'rm.id=det.round_master_id', 'inner');
        
        $this->db->where('det.id', $id);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get();

        return $query->row();
    }
    
    function getLookUpList($lookup_master_code)
    {
        $this->db->select('a.id, a.code, a.name');
        $this->db->from('tbl_lookup_details as a');
        $this->db->join('tbl_lookup_master b', 'b.id = a.lookup_master_id', 'inner');
        $this->db->where('b.code', $lookup_master_code);
        $this->db->where('a.active', 1);
        $this->db->order_by('a.display_order', 'asc');
       
        $query = $this->db->get();
        return $query->result();
    }

    function all_family_planning_info($round_no, $tableName, $list_fields) {
        $this->db->select($tableName . '.id,'
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as DOB,"
                . ",FORMAT(tbl_member_master.birth_date,'MMM dd yyyy') as DOBN,"
                . 'household_master.household_code,tbl_member_master.member_code,'
                . 'maritial_status.code as maritial_status_code,'
                . 'current_pregnancy_status.code as current_pregnancy_status_code,'
                . 'husband_living_place.code as husband_living_place_code,'
                . 'birth_control_method_usage_status.code as birth_control_method_usage_status_code,'
                . 'birth_control_method.code as birth_control_method_code,'
                . 'birth_control_method_other_value,'
                . 'continuously_using_how_many_month,'
                . 'continuously_using_how_many_year,'
                . 'birth_control_method_suggestion_from_where.code as birth_control_method_suggestion_from_where_status_code,'
                . 'birth_control_method_suggestion_from_where_other_value,'
                . 'whose_decision.code as whose_decision_code,'
                . 'whose_decision_other_value,'
                . 'reason_behind_not_using.code as reason_behind_not_using_code,'
                . 'reason_behind_not_using_other_value,'
                . 'future_desire.code as future_desire_code,'
                . 'reason_behind_not_having_future_desire.code as reason_behind_not_having_future_desire_code,'
                . 'reason_behind_not_having_future_desire_other_value,'
                . 'do_you_know_from_where.code as do_you_know_from_where_code,'
                . 'available_govt_hospital,'
                . 'available_central_dist_hospital,'
                . 'available_matri_sonod,'
                . 'available_ngo_facility,'
                . 'available_upazilla_sasthokendro,'
                . 'available_union_sastho_poribar_kollan_kendro,'
                . 'available_satellite_clinic,'
                . 'available_community_clinic,'
                . 'available_ngo_and_satellite_clinic,'
                . 'available_ngo_and_static_clinic,'
                . 'available_private_hospital,'
                . 'available_mbbs_doctor_chamber,'
                . 'available_doctor_without_degrees,'
                . 'available_pharmacy,'
                . 'available_other,'
                . 'available_other_value,'
                . 'taking_desire_more_children.code as taking_desire_more_children_code,'
                . 'taking_desire_more_children_after_year,'
                . 'how_many_children_you_want.code as how_many_children_you_want_code,'
                . 'alive_children.code as alive_children_code,'
                . 'alive_boy_number,'
                . 'alive_girl_number,'
                . 'alive_children_yes_availability.code as alive_children_yes_availability_code,'
                . 'alive_children_yes_availability_other_value,'
                . 'alive_children_yes_availability_how_many,'
                . 'alive_children_no_availability.code as alive_children_no_availability_code,'
                . 'alive_children_no_availability_other_value,'
                . 'alive_children_no_availability_how_many,'
                . 'how_many_male_female_children.code as how_many_male_female_children_code,'
                . 'how_many_male_female_children_other_value,'
                . 'how_many_male,'
                . 'how_many_female,'
                . 'how_many_any,'
                . 'comment,'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ',insertedBy.name as insertedBy_name'
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ',updateBy.name as updateBy_name'
        );
        $this->db->from($tableName);

        $this->db->join('tbl_lookup_details as how_many_male_female_children', $tableName . '.how_many_male_female_children = how_many_male_female_children.id', 'left');
        $this->db->join('tbl_lookup_details as alive_children_no_availability', $tableName . '.alive_children_no_availability = alive_children_no_availability.id', 'left');
        $this->db->join('tbl_lookup_details as alive_children_yes_availability', $tableName . '.alive_children_yes_availability = alive_children_yes_availability.id', 'left');
        $this->db->join('tbl_lookup_details as alive_children', $tableName . '.alive_children = alive_children.id', 'left');
        $this->db->join('tbl_lookup_details as how_many_children_you_want', $tableName . '.how_many_children_you_want = how_many_children_you_want.id', 'left');
        $this->db->join('tbl_lookup_details as taking_desire_more_children', $tableName . '.taking_desire_more_children = taking_desire_more_children.id', 'left');
        $this->db->join('tbl_lookup_details as do_you_know_from_where', $tableName . '.do_you_know_from_where = do_you_know_from_where.id', 'left');
        $this->db->join('tbl_lookup_details as reason_behind_not_having_future_desire', $tableName . '.reason_behind_not_having_future_desire = reason_behind_not_having_future_desire.id', 'left');
        $this->db->join('tbl_lookup_details as future_desire', $tableName . '.future_desire = future_desire.id', 'left');
        $this->db->join('tbl_lookup_details as reason_behind_not_using', $tableName . '.reason_behind_not_using = reason_behind_not_using.id', 'left');
        $this->db->join('tbl_lookup_details as whose_decision', $tableName . '.whose_decision = whose_decision.id', 'left');

        $this->db->join('tbl_lookup_details as maritial_status', $tableName . '.maritial_status = maritial_status.id', 'left');
        $this->db->join('tbl_lookup_details as current_pregnancy_status', $tableName . '.current_pregnancy_status = current_pregnancy_status.id', 'left');
        $this->db->join('tbl_lookup_details as husband_living_place', $tableName . '.husband_living_place = husband_living_place.id', 'left');
        $this->db->join('tbl_lookup_details as birth_control_method_usage_status', $tableName . '.birth_control_method_usage_status = birth_control_method_usage_status.id', 'left');
        $this->db->join('tbl_lookup_details as birth_control_method', $tableName . '.birth_control_method = birth_control_method.id', 'left');
        $this->db->join('tbl_lookup_details as birth_control_method_suggestion_from_where', $tableName . '.birth_control_method_suggestion_from_where = birth_control_method_suggestion_from_where.id', 'left');


        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');

        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');



        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
//        return $this->db->last_query();
        if ($list_fields == 0)
            return $query->result();
        if ($list_fields == 1)
            return $query->list_fields();
    }

    function all_round_info($table_name) {
        $this->db->from($table_name);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function data_via_table_view_family_planning($view_table) {
        $this->db->select(
                'DOB',
                'DOBN',
                'household_code',
                'member_code',
                'maritial_status_code',
                'current_pregnancy_status_code',
                'husband_living_place_code',
                'birth_control_method_usage_status_code',
                'birth_control_method_code',
                'birth_control_method_other_value',
                'continuously_using_how_many_month',
                'continuously_using_how_many_year',
                'birth_control_method_suggestion_from_where_status_code',
                'birth_control_method_suggestion_from_where_other_value',
                'whose_decision_code',
                'whose_decision_other_value',
                'reason_behind_not_using_code',
                'reason_behind_not_using_other_value',
                'future_desire_code',
                'reason_behind_not_having_future_desire_code',
                'reason_behind_not_having_future_desire_other_value',
                'do_you_know_from_where_code',
                'available_govt_hospital',
                'available_central_dist_hospital',
                'available_matri_sonod',
                'available_ngo_facility',
                'available_upazilla_sasthokendro',
                'available_union_sastho_poribar_kollan_kendro',
                'available_satellite_clinic',
                'available_community_clinic',
                'available_ngo_and_satellite_clinic',
                'available_ngo_and_static_clinic',
                'available_private_hospital',
                'available_mbbs_doctor_chamber',
                'available_doctor_without_degrees',
                'available_pharmacy',
                'available_other',
                'available_other_value',
                'taking_desire_more_children_code',
                'taking_desire_more_children_after_year',
                'how_many_children_you_want_code',
                'alive_children_code',
                'alive_boy_number',
                'alive_girl_number',
                'alive_children_yes_availability_code',
                'alive_children_yes_availability_other_value',
                'alive_children_yes_availability_how_many',
                'alive_children_no_availability_code',
                'alive_children_no_availability_other_value',
                'alive_children_no_availability_how_many',
                'how_many_male_female_children_code',
                'how_many_male_female_children_other_value',
                'how_many_male',
                'how_many_female',
                'how_many_any',
                'comment',
                'insertedDate',
                'insertedTime',
                'insertedBy_name',
                'updatedDate',
                'updatedTime',
                'updateBy_name'
        );
        $this->db->from($view_table);
        $query = $this->db->get();
        return $query->result();
    }

}
