<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports_model extends CI_Model {

    function getLookUpList($lookup_master_code) {
        $this->db->select('a.id, a.code, a.name');
        $this->db->from('tbl_lookup_details as a');
        $this->db->join('tbl_lookup_master b', 'b.id = a.lookup_master_id', 'inner');
        $this->db->where('b.code', $lookup_master_code);
        $this->db->where('a.active', 1);
        $this->db->order_by('a.display_order', 'asc');

        $query = $this->db->get();
        return $query->result();
    }

    function getMemberMasterPresentListByHouseholdIds($household_master_id, $femaleSexCode) {
        $this->db->select('mm.id,member_code,member_name, birth_date,mar.name as marriageName, mar.code as marriageCode,rel.name as relationHead,mm.household_master_id_hh,current_indenttification_id');
        $this->db->from('tbl_member_master mm');
        $this->db->join('household_master hm', 'hm.id = mm.household_master_id_hh', 'inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details mar', 'mar.id = mm.fk_marital_status', 'left');
        $this->db->join('tbl_lookup_details rel', 'rel.id = mm.fk_relation_with_hhh', 'left');
        $this->db->where('mm.household_master_id_hh', $household_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->where('mm.fk_sex', $femaleSexCode);
        $this->db->where('(DATEDIFF(DAY, birth_date, GetDate()) / 365) >= 15');
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get()->result();

        return $query;
    }

    function getLookUpListSpecific($lookup_master_code, $array) {
        $this->db->select('a.id, a.code, a.name');
        $this->db->from('tbl_lookup_details as a');
        $this->db->join('tbl_lookup_master b', 'b.id = a.lookup_master_id', 'inner');
        $this->db->where('b.code', $lookup_master_code);
        $this->db->where_in('a.code', $array);
        $this->db->where('a.active', 1);
        $this->db->order_by('a.display_order', 'asc');

        $query = $this->db->get();

        return $query->result();
    }

    function getLookUpListNotSpecific($lookup_master_code, $array) {
        $this->db->select('a.id, a.code, a.name');
        $this->db->from('tbl_lookup_details as a');
        $this->db->join('tbl_lookup_master b', 'b.id = a.lookup_master_id', 'inner');
        $this->db->where('b.code', $lookup_master_code);
        $this->db->where_not_in('a.code', $array);
        $this->db->where('a.active', 1);
        $this->db->order_by('a.display_order', 'asc');

        $query = $this->db->get();

        return $query->result();
    }

    function getCurrentRound() {
        $this->db->select('*');
        $this->db->from('tbl_round_master');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->row();
    }

    function UpdateInfo($Info, $id, $table) {
        $this->db->where('id', $id);
        return $this->db->update($table, $Info);
    }

    function UpdateInfo_HeadTable($Info, $household_master_id, $member_master_id, $round_master_id, $table) {
        $this->db->where('household_master_id', $household_master_id);
        $this->db->where('member_master_id', $member_master_id);
        $this->db->where('round_master_id', $round_master_id);
        return $this->db->update($table, $Info);
    }

    function pregnancy_info($id, $table) {
        $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'gender.code as gender_code,gender.name as gender_name,'
                . 'tbl_member_conception.id as conceptionID,tbl_member_conception.conception_date,tbl_member_conception.fk_conception_result');
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_member_conception', $table . '.conception_id = tbl_member_conception.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($table . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function all_conception_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,'
                . 'FORMAT(' . $tableName . ".conception_date,'dd/MM/yyyy') as conception_date"
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_conception_order.name as fk_conception_order_name,fk_conception_order.code as fk_conception_order_code,'
                . 'fk_conception_plan.name as fk_conception_plan_name,fk_conception_plan.code as fk_conception_plan_code,'
                . 'fk_conception_followup_status.name as fk_conception_followup_status_name,fk_conception_followup_status.code as fk_conception_followup_status_code,'
                . 'fk_conception_result.name as fk_conception_result_name,fk_conception_result.code as fk_conception_result_code,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as fk_conception_order', $tableName . '.fk_conception_order = fk_conception_order.id', 'left');
        $this->db->join('tbl_lookup_details as fk_conception_plan', $tableName . '.fk_conception_plan = fk_conception_plan.id', 'left');
        $this->db->join('tbl_lookup_details as fk_conception_followup_status', $tableName . '.fk_conception_followup_status = fk_conception_followup_status.id', 'left');
        $this->db->join('tbl_lookup_details as fk_conception_result', $tableName . '.fk_conception_result = fk_conception_result.id', 'left');

        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function conception_info($id, $table) {
        $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($table . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function education_info($id, $table) {
        $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($table . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function marriage_start_info($id, $table) {
        $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,tbl_member_master.spouse_code,'
                . 'gender.code as gender_code,gender.name as gender_name,sp.member_name as spauseName');
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('tbl_member_master sp', 'sp.id=tbl_member_master.fk_spouse_id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($table . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function marriage_end_info($id, $table) {
        $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,tbl_member_master.spouse_code,'
                . 'gender.code as gender_code,gender.name as gender_name,sp.member_name as spouseName,sp.member_code as spouseCode');
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('tbl_member_master sp', 'sp.id=tbl_member_master.fk_spouse_id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($table . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function relation_info($id, $household_master_id_current, $member_master_id_current, $round_master_id_current, $fk_relation_current, $table) {

        if ($fk_relation_current == 27) {
            $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,tbl_household_head.change_date,tbl_household_head.fk_hhh_cause,'
                    . 'gender.code as gender_code,gender.name as gender_name');
        } else {
            $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                    . 'gender.code as gender_code,gender.name as gender_name');
        }
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        if ($fk_relation_current == 27) {
            $this->db->join('tbl_household_head', $table . '.member_master_id = tbl_household_head.member_master_id', 'left');
        }
        $this->db->where($table . '.id', $id);
        if ($fk_relation_current == 27) {
            $this->db->where('tbl_household_head.household_master_id', $household_master_id_current);
            $this->db->where('tbl_household_head.member_master_id', $member_master_id_current);
            $this->db->where('tbl_household_head.round_master_id', $round_master_id_current);
        }
        $query = $this->db->get();
        return $query->row();
    }

    function household_head_info($id, $table) {

        $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,tbl_member_relation.fk_relation,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_member_relation', $table . '.member_master_id = tbl_member_relation.member_master_id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($table . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function internal_in_info($id, $table) {
        $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($table . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function migration_in_info($id, $table) {
        $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($table . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function migration_out_info($id, $table) {
        $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($table . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function internal_out_info($id, $table) {
        $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($table . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function all_member_info($district_id = "", $upazilla_id = "", $slum_id = "", $slum_area_id = "", $round_no = "", $tableName) {
        $this->db->select(
                $tableName . '.id,' .
                $tableName . '.household_master_id_hh,' .
                $tableName . '.member_code,' .
                $tableName . '.member_name,' .
                'FORMAT(' . $tableName . ".birth_date,'dd/MM/yyyy') as birth_date,"
                . $tableName . '.father_code,'
                . $tableName . '.mother_code,'
                . $tableName . '.spouse_code,'
                . $tableName . '.national_id,'
                . 'FORMAT(' . $tableName . ".birth_registration_date,'dd/MM/yyyy') as birth_registration_date,"
                . $tableName . '.afterYear,'
                . $tableName . '.contactNoOne,'
                . $tableName . '.contactNoTwo'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ',marital_status.code as marital_status_code,marital_status.name as marital_status_name,fk_sex.code as fk_sex_code,fk_sex.name as fk_sex_name,fk_religion.code as fk_religion_code,fk_religion.name as fk_religion_name,fk_relation_with_hhh.code as fk_relation_with_hhh_code,fk_relation_with_hhh.name as fk_relation_with_hhh_name,fk_mother_live_birth_order.code as fk_mother_live_birth_order_code,fk_mother_live_birth_order.name as fk_mother_live_birth_order_name'
                . ',fk_birth_registration.code as fk_birth_registration_code, fk_birth_registration.name as fk_birth_registration_name'
                . ',fk_why_not_birth_registration.code as fk_why_not_birth_registration_code, fk_why_not_birth_registration.name as fk_why_not_birth_registration_name'
                . ',fk_additionalChild.code as fk_additionalChild_code, fk_additionalChild.name as fk_additionalChild_name'
                . ',insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('household_master', $tableName . '.household_master_id_hh =household_master.id', 'left');
        $this->db->join('tbl_lookup_details as marital_status', $tableName . '.fk_marital_status = marital_status.id', 'left');
        $this->db->join('tbl_lookup_details as fk_sex', $tableName . '.fk_sex = fk_sex.id', 'left');
        $this->db->join('tbl_lookup_details as fk_religion', $tableName . '.fk_religion = fk_religion.id', 'left');
        $this->db->join('tbl_lookup_details as fk_relation_with_hhh', $tableName . '.fk_relation_with_hhh = fk_relation_with_hhh.id', 'left');
        $this->db->join('tbl_lookup_details as fk_mother_live_birth_order', $tableName . '.fk_mother_live_birth_order = fk_mother_live_birth_order.id', 'left');
        $this->db->join('tbl_lookup_details as fk_birth_registration', $tableName . '.fk_birth_registration = fk_birth_registration.id', 'left');
        $this->db->join('tbl_lookup_details as fk_why_not_birth_registration', $tableName . '.fk_why_not_birth_registration = fk_why_not_birth_registration.id', 'left');
        $this->db->join('tbl_lookup_details as fk_additionalChild', $tableName . '.fk_additionalChild = fk_additionalChild.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if (empty($district_id) == false) {
            $this->db->where('household_master.fk_district_id', $district_id);
        }
        if (empty($upazilla_id) == false) {
            $this->db->where('household_master.fk_thana_id', $upazilla_id);
        }
        if (empty($slum_id) == false) {
            $this->db->where('household_master.fk_slum_id', $slum_id);
        }
        if (empty($slum_area_id) == false) {
            $this->db->where('household_master.fk_slum_area_id', $slum_area_id);
        }
        if (empty($round_no) == false) {
            $this->db->where('household_master.round_master_id_entry_round', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_pregnancy_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,'
                . 'FORMAT(' . $tableName . ".pregnancy_outcome_date,'dd/MM/yyyy') as pregnancy_outcome_date,"
                . $tableName . '.breast_milk_day,'
                . $tableName . '.induced_abortion,'
                . $tableName . '.spontaneous_abortion,'
                . $tableName . '.live_birth,'
                . $tableName . '.still_birth,'
                . $tableName . '.milk_hours,'
                . $tableName . '.milk_day,'
                . $tableName . '.keep_follow_up,'
                . $tableName . '.routine_anc_chkup_mother_times,'
                . $tableName . '.anc_first_visit_months,'
                . $tableName . '.anc_second_visit_months,'
                . $tableName . '.anc_third_visit_months,'
                . $tableName . '.anc_fourth_visit_months,'
                . $tableName . '.anc_fifth_visit_months,'
                . $tableName . '.totalnumbertab,'
                . $tableName . '.pnc_chkup_mother_times,'
                . $tableName . '.pnc_first_visit_days,'
                . $tableName . '.pnc_second_visit_days,'
                . $tableName . '.remarks'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_litter_size.name as fk_litter_size_name,fk_litter_size.code as fk_litter_size_code,'
                . 'fk_delivery_methodology.name as fk_delivery_methodology_name,fk_delivery_methodology.code as fk_delivery_methodology_code,'
                . 'fk_delivery_assist_type.name as fk_delivery_assist_type_name,fk_delivery_assist_type.code as fk_delivery_assist_type_code,'
                . 'fk_delivery_term_place.name as fk_delivery_term_place_name,fk_delivery_term_place.code as fk_delivery_term_place_code,'
                . 'fk_colostrum.name as fk_colostrum_name,fk_colostrum.code as fk_colostrum_code,'
                . 'fk_first_milk.name as fk_first_milk_name,fk_first_milk.code as fk_first_milk_code,'
                . 'fk_facility_delivery.name as fk_facility_delivery_name,fk_facility_delivery.code as fk_facility_delivery_code,'
                . 'fk_preg_complication.name as fk_preg_complication_name,fk_preg_complication.code as fk_preg_complication_code,'
                . 'fk_delivery_complication.name as fk_delivery_complication_name,fk_delivery_complication.code as fk_delivery_complication_code,'
                . 'fk_preg_violence.name as fk_preg_violence_name,fk_preg_violence.code as fk_preg_violence_code,'
                . 'fk_health_problem.name as fk_health_problem_name,fk_health_problem.code as fk_health_problem_code,'
                . 'fk_high_pressure.name as fk_high_pressure_name,fk_high_pressure.code as fk_high_pressure_code,'
                . 'fk_diabetis.name as fk_diabetis_name,fk_diabetis.code as fk_diabetis_code,'
                . 'fk_preaklampshia.name as fk_preaklampshia_name,fk_preaklampshia.code as fk_preaklampshia_code,'
                . 'fk_lebar_birth.name as fk_lebar_birth_name,fk_lebar_birth.code as fk_lebar_birth_code,'
                . 'fk_vomiting.name as fk_vomiting_name,fk_vomiting.code as fk_vomiting_code,'
                . 'fk_amliotic.name as fk_amliotic_name,fk_amliotic.code as fk_amliotic_code,'
                . 'fk_membrane.name as fk_membrane_name,fk_membrane.code as fk_membrane_code,'
                . 'fk_malposition.name as fk_malposition_name,fk_malposition.code as fk_malposition_code,'
                . 'fk_headache.name as fk_headache_name,fk_headache.code as fk_headache_code,'
                . 'fk_routine_anc_chkup_mother.name as fk_routine_anc_chkup_mother_name,fk_routine_anc_chkup_mother.code as fk_routine_anc_chkup_mother_code,'
                . 'fk_anc_first_assist.name as fk_anc_first_assist_name,fk_anc_first_assist.code as fk_anc_first_assist_code,'
                . 'fk_anc_second_assist.name as fk_anc_second_assist_name,fk_anc_second_assist.code as fk_anc_second_assist_code,'
                . 'fk_anc_second_visit.name as fk_anc_second_visit_name,fk_anc_second_visit.code as fk_anc_second_visit_code,'
                . 'fk_anc_third_assist.name as fk_anc_third_assist_name,fk_anc_third_assist.code as fk_anc_third_assist_code,'
                . 'fk_anc_third_visit.name as fk_anc_third_visit_name,fk_anc_third_visit.code as fk_anc_third_visit_code,'
                . 'fk_anc_fourth_assist.name as fk_anc_fourth_assist_name,fk_anc_fourth_assist.code as fk_anc_fourth_assist_code,'
                . 'fk_anc_fourth_visit.name as fk_anc_fourth_visit_name,fk_anc_fourth_visit.code as fk_anc_fourth_visit_code,'
                . 'fk_anc_fifth_assist.name as fk_anc_fifth_assist_name,fk_anc_fifth_assist.code as fk_anc_fifth_assist_code,'
                . 'fk_anc_fifth_visit.name as fk_anc_fifth_visit_name,fk_anc_fifth_visit.code as fk_anc_fifth_visit_code,'
                . 'fk_anc_supliment.name as fk_anc_supliment_name,fk_anc_supliment.code as fk_anc_supliment_code,'
                . 'fk_supliment_received_way.name as fk_supliment_received_way_name,fk_supliment_received_way.code as fk_supliment_received_way_code,'
                . 'fk_how_many_tab.name as fk_how_many_tab_name,fk_how_many_tab.code as fk_how_many_tab_code,'
                . 'fk_anc_weight_taken.name as fk_anc_weight_taken_name,fk_anc_weight_taken.code as fk_anc_weight_taken_code,'
                . 'fk_anc_blood_pressure.name as fk_anc_blood_pressure_name,fk_anc_blood_pressure.code as fk_anc_blood_pressure_code,'
                . 'fk_anc_urine.name as fk_anc_urine_name,fk_anc_urine.code as fk_anc_urine_code,'
                . 'fk_anc_blood.name as fk_anc_blood_name,fk_anc_blood.code as fk_anc_blood_code,'
                . 'fk_anc_denger_sign.name as fk_anc_denger_sign_name,fk_anc_denger_sign.code as fk_anc_denger_sign_code,'
                . 'fk_anc_nutrition.name as fk_anc_nutrition_name,fk_anc_nutrition.code as fk_anc_nutrition_code,'
                . 'fk_anc_birth_prepare.name as fk_anc_birth_prepare_name,fk_anc_birth_prepare.code as fk_anc_birth_prepare_code,'
                . 'fk_anc_delivery_kit.name as fk_anc_delivery_kit_name,fk_anc_delivery_kit.code as fk_anc_delivery_kit_code,'
                . 'fk_anc_soap.name as fk_anc_soap_name,fk_anc_soap.code as fk_anc_soap_code,'
                . 'fk_anc_care_chix.name as fk_anc_care_chix_name,fk_anc_care_chix.code as fk_anc_care_chix_code,'
                . 'fk_anc_dried.name as fk_anc_dried_name,fk_anc_dried.code as fk_anc_dried_code,'
                . 'fk_anc_bathing.name as fk_anc_bathing_name,fk_anc_bathing.code as fk_anc_bathing_code,'
                . 'fk_anc_breast_feed.name as fk_anc_breast_feed_name,fk_anc_breast_feed.code as fk_anc_breast_feed_code,'
                . 'fk_anc_skin_contact.name as fk_anc_skin_contact_name,fk_anc_skin_contact.code as fk_anc_skin_contact_code,'
                . 'fk_anc_enc.name as fk_anc_enc_name,fk_anc_enc.code as fk_anc_enc_code,'
                . 'fk_suspecred_infection.name as fk_suspecred_infection_name,fk_suspecred_infection.code as fk_suspecred_infection_code,'
                . 'fk_baby_antibiotics.name as fk_baby_antibiotics_name,fk_baby_antibiotics.code as fk_baby_antibiotics_code,'
                . 'fk_prescribe_antibiotics.name as fk_prescribe_antibiotics_name,fk_prescribe_antibiotics.code as fk_prescribe_antibiotics_code,'
                . 'fk_seek_treatment.name as fk_seek_treatment_name,fk_seek_treatment.code as fk_seek_treatment_code,'
                . 'fk_anc_vaginal_bleeding.name as fk_anc_vaginal_bleeding_name,fk_anc_vaginal_bleeding.code as fk_anc_vaginal_bleeding_code,'
                . 'fk_anc_convulsions.name as fk_anc_convulsions_name,fk_anc_convulsions.code as fk_anc_convulsions_code,'
                . 'fk_anc_severe_headache.name as fk_anc_severe_headache_name,fk_anc_severe_headache.code as fk_anc_severe_headache_code,'
                . 'fk_anc_fever.name as fk_anc_fever_name,fk_anc_fever.code as fk_anc_fever_code,'
                . 'fk_anc_abdominal_pain.name as fk_anc_abdominal_pain_name,fk_anc_abdominal_pain.code as fk_anc_abdominal_pain_code,'
                . 'fk_anc_diff_breath.name as fk_anc_diff_breath_name,fk_anc_diff_breath.code as fk_anc_diff_breath_code,'
                . 'fk_anc_water_break.name as fk_anc_water_break_name,fk_anc_water_break.code as fk_anc_water_break_code,'
                . 'fk_anc_vaginal_bleed_aph.name as fk_anc_vaginal_bleed_aph_name,fk_anc_vaginal_bleed_aph.code as fk_anc_vaginal_bleed_aph_code,'
                . 'fk_anc_obstructed_labour.name as fk_anc_obstructed_labour_name,fk_anc_obstructed_labour.code as fk_anc_obstructed_labour_code,'
                . 'fk_anc_convulsion.name as fk_anc_convulsion_name,fk_anc_convulsion.code as fk_anc_convulsion_code,'
                . 'fk_anc_sepsis.name as fk_anc_sepsis_name,fk_anc_sepsis.code as fk_anc_sepsis_code,'
                . 'fk_anc_severe_headache_delivery.name as fk_anc_severe_headache_delivery_name,fk_anc_severe_headache_delivery.code as fk_anc_severe_headache_delivery_code,'
                . 'fk_anc_consciousness.name as fk_anc_consciousness_name,fk_anc_consciousness.code as fk_anc_consciousness_code,'
                . 'fk_anc_vaginal_bleeding_post.name as fk_anc_vaginal_bleeding_post_name,fk_anc_vaginal_bleeding_post.code as fk_anc_vaginal_bleeding_post_code,'
                . 'fk_anc_convulsion_eclampsia_post.name as fk_anc_convulsion_eclampsia_post_name,fk_anc_convulsion_eclampsia_post.code as fk_anc_convulsion_eclampsia_post_code,'
                . 'fk_anc_high_feaver_post.name as fk_anc_high_feaver_post_name,fk_anc_high_feaver_post.code as fk_anc_high_feaver_post_code,'
                . 'fk_anc_smelling_discharge_post.name as fk_anc_smelling_discharge_post_name,fk_anc_smelling_discharge_post.code as fk_anc_smelling_discharge_post_code,'
                . 'fk_anc_severe_headache_post.name as fk_anc_severe_headache_post_name,fk_anc_severe_headache_post.code as fk_anc_severe_headache_post_code,'
                . 'fk_anc_consciousness_post.name as fk_anc_consciousness_post_name,fk_anc_consciousness_post.code as fk_anc_consciousness_post_code,'
                . 'fk_anc_inability_baby.name as fk_anc_inability_baby_name,fk_anc_inability_baby.code as fk_anc_inability_baby_code,'
                . 'fk_anc_baby_small_baby.name as fk_anc_baby_small_baby_name,fk_anc_baby_small_baby.code as fk_anc_baby_small_baby_code,'
                . 'fk_anc_fast_breathing_baby.name as fk_anc_fast_breathing_baby_name,fk_anc_fast_breathing_baby.code as fk_anc_fast_breathing_baby_code,'
                . 'fk_anc_convulsions_baby.name as fk_anc_convulsions_baby_name,fk_anc_convulsions_baby.code as fk_anc_convulsions_baby_code,'
                . 'fk_anc_drowsy_baby.name as fk_anc_drowsy_baby_name,fk_anc_drowsy_baby.code as fk_anc_drowsy_baby_code,'
                . 'fk_anc_movement_baby.name as fk_anc_movement_baby_name,fk_anc_movement_baby.code as fk_anc_movement_baby_code,'
                . 'fk_anc_grunting_baby.name as fk_anc_grunting_baby_name,fk_anc_grunting_baby.code as fk_anc_grunting_baby_code,'
                . 'fk_anc_indrawing_baby.name as fk_anc_indrawing_baby_name,fk_anc_indrawing_baby.code as fk_anc_indrawing_baby_code,'
                . 'fk_anc_temperature_baby.name as fk_anc_temperature_baby_name,fk_anc_temperature_baby.code as fk_anc_temperature_baby_code,'
                . 'fk_anc_hypothermia_baby.name as fk_anc_hypothermia_baby_name,fk_anc_hypothermia_baby.code as fk_anc_hypothermia_baby_code,'
                . 'fk_anc_central_cyanosis_baby.name as fk_anc_central_cyanosis_baby_name,fk_anc_central_cyanosis_baby.code as fk_anc_central_cyanosis_baby_code,'
                . 'fk_anc_umbilicus_baby.name as fk_anc_umbilicus_baby_name,fk_anc_umbilicus_baby.code as fk_anc_umbilicus_baby_code,'
                . 'fk_anc_labour_preg.name as fk_anc_labour_preg_name,fk_anc_labour_preg.code as fk_anc_labour_preg_code,'
                . 'fk_anc_excessive_bld_pre.name as fk_anc_excessive_bld_pre_name,fk_anc_excessive_bld_pre.code as fk_anc_excessive_bld_pre_code,'
                . 'fk_anc_severe_headache_preg.name as fk_anc_severe_headache_preg_name,fk_anc_severe_headache_preg.code as fk_anc_severe_headache_preg_code,'
                . 'fk_anc_obstructed_preg.name as fk_anc_obstructed_preg_name,fk_anc_obstructed_preg.code as fk_anc_obstructed_preg_code,'
                . 'fk_anc_convulsion_preg.name as fk_anc_convulsion_preg_name,fk_anc_convulsion_preg.code as fk_anc_convulsion_preg_code,'
                . 'fk_anc_placenta_preg.name as fk_anc_placenta_preg_name,fk_anc_placenta_preg.code as fk_anc_placenta_preg_code,'
                . 'fk_anc_breath_child.name as fk_anc_breath_child_name,fk_anc_breath_child.code as fk_anc_breath_child_code,'
                . 'fk_anc_suck_baby.name as fk_anc_suck_baby_name,fk_anc_suck_baby.code as fk_anc_suck_baby_code,'
                . 'fk_anc_hot_cold_child.name as fk_anc_hot_cold_child_name,fk_anc_hot_cold_child.code as fk_anc_hot_cold_child_code,'
                . 'fk_anc_blue_child.name as fk_anc_blue_child_name,fk_anc_blue_child.code as fk_anc_blue_child_code,'
                . 'fk_anc_convulsion_child.name as fk_anc_convulsion_child_name,fk_anc_convulsion_child.code as fk_anc_convulsion_child_code,'
                . 'fk_anc_indrawing_child.name as fk_anc_indrawing_child_name,fk_anc_indrawing_child.code as fk_anc_indrawing_child_code,'
                . 'fk_supliment_post.name as fk_supliment_post_name,fk_supliment_post.code as fk_supliment_post_code,'
                . 'fk_post_natal_visit.name as fk_post_natal_visit_name,fk_post_natal_visit.code as fk_post_natal_visit_code,'
                . 'fk_pnc_chkup_mother.name as fk_pnc_chkup_mother_name,fk_pnc_chkup_mother.code as fk_pnc_chkup_mother_code,'
                . 'fk_pnc_first_visit_assist.name as fk_pnc_first_visit_assist_name,fk_pnc_first_visit_assist.code as fk_pnc_first_visit_assist_code,'
                . 'fk_pnc_first_visit.name as fk_pnc_first_visit_name,fk_pnc_first_visit.code as fk_pnc_first_visit_code,'
                . 'fk_pnc_second_visit_assist.name as fk_pnc_second_visit_assist_name,fk_pnc_second_visit_assist.code as fk_pnc_second_visit_assist_code,'
                . 'fk_pnc_second_visit.name as fk_pnc_second_visit_name,fk_pnc_second_visit.code as fk_pnc_second_visit_code,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details fk_litter_size', 'fk_litter_size.id=' . $tableName . '.fk_litter_size', 'left');
        $this->db->join('tbl_lookup_details fk_delivery_methodology', 'fk_delivery_methodology.id=' . $tableName . '.fk_delivery_methodology', 'left');
        $this->db->join('tbl_lookup_details fk_delivery_assist_type', 'fk_delivery_assist_type.id=' . $tableName . '.fk_delivery_assist_type', 'left');
        $this->db->join('tbl_lookup_details fk_delivery_term_place', 'fk_delivery_term_place.id=' . $tableName . '.fk_delivery_term_place', 'left');
        $this->db->join('tbl_lookup_details fk_colostrum', 'fk_colostrum.id=' . $tableName . '.fk_colostrum', 'left');
        $this->db->join('tbl_lookup_details fk_first_milk', 'fk_first_milk.id=' . $tableName . '.fk_first_milk', 'left');
        $this->db->join('tbl_lookup_details fk_facility_delivery', 'fk_facility_delivery.id=' . $tableName . '.fk_facility_delivery', 'left');
        $this->db->join('tbl_lookup_details fk_preg_complication', 'fk_preg_complication.id=' . $tableName . '.fk_preg_complication', 'left');
        $this->db->join('tbl_lookup_details fk_delivery_complication', 'fk_delivery_complication.id=' . $tableName . '.fk_delivery_complication', 'left');
        $this->db->join('tbl_lookup_details fk_preg_violence', 'fk_preg_violence.id=' . $tableName . '.fk_preg_violence', 'left');
        $this->db->join('tbl_lookup_details fk_health_problem', 'fk_health_problem.id=' . $tableName . '.fk_health_problem_id', 'left');
        $this->db->join('tbl_lookup_details fk_high_pressure', 'fk_high_pressure.id=' . $tableName . '.fk_high_pressure_id', 'left');
        $this->db->join('tbl_lookup_details fk_diabetis', 'fk_diabetis.id=' . $tableName . '.fk_diabetis_id', 'left');
        $this->db->join('tbl_lookup_details fk_preaklampshia', 'fk_preaklampshia.id=' . $tableName . '.fk_preaklampshia_id', 'left');
        $this->db->join('tbl_lookup_details fk_lebar_birth', 'fk_lebar_birth.id=' . $tableName . '.fk_lebar_birth_id', 'left');
        $this->db->join('tbl_lookup_details fk_vomiting', 'fk_vomiting.id=' . $tableName . '.fk_vomiting_id', 'left');
        $this->db->join('tbl_lookup_details fk_amliotic', 'fk_amliotic.id=' . $tableName . '.fk_amliotic_id', 'left');
        $this->db->join('tbl_lookup_details fk_membrane', 'fk_membrane.id=' . $tableName . '.fk_membrane_id', 'left');
        $this->db->join('tbl_lookup_details fk_malposition', 'fk_malposition.id=' . $tableName . '.fk_malposition_id', 'left');
        $this->db->join('tbl_lookup_details fk_headache', 'fk_headache.id=' . $tableName . '.fk_headache_id', 'left');
        $this->db->join('tbl_lookup_details fk_routine_anc_chkup_mother', 'fk_routine_anc_chkup_mother.id=' . $tableName . '.fk_routine_anc_chkup_mother_id', 'left');
        $this->db->join('tbl_lookup_details fk_anc_first_assist', 'fk_anc_first_assist.id=' . $tableName . '.fk_anc_first_assist_id', 'left');
        $this->db->join('tbl_lookup_details fk_anc_second_assist', 'fk_anc_second_assist.id=' . $tableName . '.fk_anc_second_assist_id', 'left');
        $this->db->join('tbl_lookup_details fk_anc_second_visit', 'fk_anc_second_visit.id=' . $tableName . '.fk_anc_second_visit_id', 'left');
        $this->db->join('tbl_lookup_details fk_anc_third_assist', 'fk_anc_third_assist.id=' . $tableName . '.fk_anc_third_assist_id', 'left');
        $this->db->join('tbl_lookup_details fk_anc_third_visit', 'fk_anc_third_visit.id=' . $tableName . '.fk_anc_third_visit_id', 'left');
        $this->db->join('tbl_lookup_details fk_anc_fourth_assist', 'fk_anc_fourth_assist.id=' . $tableName . '.fk_anc_fourth_assist_id', 'left');
        $this->db->join('tbl_lookup_details fk_anc_fourth_visit', 'fk_anc_fourth_visit.id=' . $tableName . '.fk_anc_fourth_visit_id', 'left');
        $this->db->join('tbl_lookup_details fk_anc_fifth_assist', 'fk_anc_fifth_assist.id=' . $tableName . '.fk_anc_fifth_assist_id', 'left');
        $this->db->join('tbl_lookup_details fk_anc_fifth_visit', 'fk_anc_fifth_visit.id=' . $tableName . '.fk_anc_fifth_visit_id', 'left');
        $this->db->join('tbl_lookup_details fk_anc_supliment', 'fk_anc_supliment.id=' . $tableName . '.fk_anc_supliment', 'left');
        $this->db->join('tbl_lookup_details fk_supliment_received_way', 'fk_supliment_received_way.id=' . $tableName . '.fk_supliment_received_way', 'left');
        $this->db->join('tbl_lookup_details fk_how_many_tab', 'fk_how_many_tab.id=' . $tableName . '.fk_how_many_tab', 'left');
        $this->db->join('tbl_lookup_details fk_anc_weight_taken', 'fk_anc_weight_taken.id=' . $tableName . '.fk_anc_weight_taken', 'left');
        $this->db->join('tbl_lookup_details fk_anc_blood_pressure', 'fk_anc_blood_pressure.id=' . $tableName . '.fk_anc_blood_pressure', 'left');
        $this->db->join('tbl_lookup_details fk_anc_urine', 'fk_anc_urine.id=' . $tableName . '.fk_anc_urine', 'left');
        $this->db->join('tbl_lookup_details fk_anc_blood', 'fk_anc_blood.id=' . $tableName . '.fk_anc_blood', 'left');
        $this->db->join('tbl_lookup_details fk_anc_denger_sign', 'fk_anc_denger_sign.id=' . $tableName . '.fk_anc_denger_sign', 'left');
        $this->db->join('tbl_lookup_details fk_anc_nutrition', 'fk_anc_nutrition.id=' . $tableName . '.fk_anc_nutrition', 'left');
        $this->db->join('tbl_lookup_details fk_anc_birth_prepare', 'fk_anc_birth_prepare.id=' . $tableName . '.fk_anc_birth_prepare', 'left');
        $this->db->join('tbl_lookup_details fk_anc_delivery_kit', 'fk_anc_delivery_kit.id=' . $tableName . '.fk_anc_delivery_kit', 'left');
        $this->db->join('tbl_lookup_details fk_anc_soap', 'fk_anc_soap.id=' . $tableName . '.fk_anc_soap', 'left');
        $this->db->join('tbl_lookup_details fk_anc_care_chix', 'fk_anc_care_chix.id=' . $tableName . '.fk_anc_care_chix', 'left');
        $this->db->join('tbl_lookup_details fk_anc_dried', 'fk_anc_dried.id=' . $tableName . '.fk_anc_dried', 'left');
        $this->db->join('tbl_lookup_details fk_anc_bathing', 'fk_anc_bathing.id=' . $tableName . '.fk_anc_bathing', 'left');
        $this->db->join('tbl_lookup_details fk_anc_breast_feed', 'fk_anc_breast_feed.id=' . $tableName . '.fk_anc_breast_feed', 'left');
        $this->db->join('tbl_lookup_details fk_anc_skin_contact', 'fk_anc_skin_contact.id=' . $tableName . '.fk_anc_skin_contact', 'left');
        $this->db->join('tbl_lookup_details fk_anc_enc', 'fk_anc_enc.id=' . $tableName . '.fk_anc_enc', 'left');
        $this->db->join('tbl_lookup_details fk_suspecred_infection', 'fk_suspecred_infection.id=' . $tableName . '.fk_suspecred_infection', 'left');
        $this->db->join('tbl_lookup_details fk_baby_antibiotics', 'fk_baby_antibiotics.id=' . $tableName . '.fk_baby_antibiotics', 'left');
        $this->db->join('tbl_lookup_details fk_prescribe_antibiotics', 'fk_prescribe_antibiotics.id=' . $tableName . '.fk_prescribe_antibiotics', 'left');
        $this->db->join('tbl_lookup_details fk_seek_treatment', 'fk_seek_treatment.id=' . $tableName . '.fk_seek_treatment', 'left');
        $this->db->join('tbl_lookup_details fk_anc_vaginal_bleeding', 'fk_anc_vaginal_bleeding.id=' . $tableName . '.fk_anc_vaginal_bleeding', 'left');
        $this->db->join('tbl_lookup_details fk_anc_convulsions', 'fk_anc_convulsions.id=' . $tableName . '.fk_anc_convulsions', 'left');
        $this->db->join('tbl_lookup_details fk_anc_severe_headache', 'fk_anc_severe_headache.id=' . $tableName . '.fk_anc_severe_headache', 'left');
        $this->db->join('tbl_lookup_details fk_anc_fever', 'fk_anc_fever.id=' . $tableName . '.fk_anc_fever', 'left');
        $this->db->join('tbl_lookup_details fk_anc_abdominal_pain', 'fk_anc_abdominal_pain.id=' . $tableName . '.fk_anc_abdominal_pain', 'left');
        $this->db->join('tbl_lookup_details fk_anc_diff_breath', 'fk_anc_diff_breath.id=' . $tableName . '.fk_anc_diff_breath', 'left');
        $this->db->join('tbl_lookup_details fk_anc_water_break', 'fk_anc_water_break.id=' . $tableName . '.fk_anc_water_break', 'left');
        $this->db->join('tbl_lookup_details fk_anc_vaginal_bleed_aph', 'fk_anc_vaginal_bleed_aph.id=' . $tableName . '.fk_anc_vaginal_bleed_aph', 'left');
        $this->db->join('tbl_lookup_details fk_anc_obstructed_labour', 'fk_anc_obstructed_labour.id=' . $tableName . '.fk_anc_obstructed_labour', 'left');
        $this->db->join('tbl_lookup_details fk_anc_convulsion', 'fk_anc_convulsion.id=' . $tableName . '.fk_anc_convulsion', 'left');
        $this->db->join('tbl_lookup_details fk_anc_sepsis', 'fk_anc_sepsis.id=' . $tableName . '.fk_anc_sepsis', 'left');
        $this->db->join('tbl_lookup_details fk_anc_severe_headache_delivery', 'fk_anc_severe_headache_delivery.id=' . $tableName . '.fk_anc_severe_headache_delivery', 'left');
        $this->db->join('tbl_lookup_details fk_anc_consciousness', 'fk_anc_consciousness.id=' . $tableName . '.fk_anc_consciousness', 'left');
        $this->db->join('tbl_lookup_details fk_anc_vaginal_bleeding_post', 'fk_anc_vaginal_bleeding_post.id=' . $tableName . '.fk_anc_vaginal_bleeding_post', 'left');
        $this->db->join('tbl_lookup_details fk_anc_convulsion_eclampsia_post', 'fk_anc_convulsion_eclampsia_post.id=' . $tableName . '.fk_anc_convulsion_eclampsia_post', 'left');
        $this->db->join('tbl_lookup_details fk_anc_high_feaver_post', 'fk_anc_high_feaver_post.id=' . $tableName . '.fk_anc_high_feaver_post', 'left');
        $this->db->join('tbl_lookup_details fk_anc_smelling_discharge_post', 'fk_anc_smelling_discharge_post.id=' . $tableName . '.fk_anc_smelling_discharge_post', 'left');
        $this->db->join('tbl_lookup_details fk_anc_severe_headache_post', 'fk_anc_severe_headache_post.id=' . $tableName . '.fk_anc_severe_headache_post', 'left');
        $this->db->join('tbl_lookup_details fk_anc_consciousness_post', 'fk_anc_consciousness_post.id=' . $tableName . '.fk_anc_consciousness_post', 'left');
        $this->db->join('tbl_lookup_details fk_anc_inability_baby', 'fk_anc_inability_baby.id=' . $tableName . '.fk_anc_inability_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_baby_small_baby', 'fk_anc_baby_small_baby.id=' . $tableName . '.fk_anc_baby_small_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_fast_breathing_baby', 'fk_anc_fast_breathing_baby.id=' . $tableName . '.fk_anc_fast_breathing_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_convulsions_baby', 'fk_anc_convulsions_baby.id=' . $tableName . '.fk_anc_convulsions_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_drowsy_baby', 'fk_anc_drowsy_baby.id=' . $tableName . '.fk_anc_drowsy_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_movement_baby', 'fk_anc_movement_baby.id=' . $tableName . '.fk_anc_movement_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_grunting_baby', 'fk_anc_grunting_baby.id=' . $tableName . '.fk_anc_grunting_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_indrawing_baby', 'fk_anc_indrawing_baby.id=' . $tableName . '.fk_anc_indrawing_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_temperature_baby', 'fk_anc_temperature_baby.id=' . $tableName . '.fk_anc_temperature_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_hypothermia_baby', 'fk_anc_hypothermia_baby.id=' . $tableName . '.fk_anc_hypothermia_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_central_cyanosis_baby', 'fk_anc_central_cyanosis_baby.id=' . $tableName . '.fk_anc_central_cyanosis_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_umbilicus_baby', 'fk_anc_umbilicus_baby.id=' . $tableName . '.fk_anc_umbilicus_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_labour_preg', 'fk_anc_labour_preg.id=' . $tableName . '.fk_anc_labour_preg', 'left');
        $this->db->join('tbl_lookup_details fk_anc_excessive_bld_pre', 'fk_anc_excessive_bld_pre.id=' . $tableName . '.fk_anc_excessive_bld_pre', 'left');
        $this->db->join('tbl_lookup_details fk_anc_severe_headache_preg', 'fk_anc_severe_headache_preg.id=' . $tableName . '.fk_anc_severe_headache_preg', 'left');
        $this->db->join('tbl_lookup_details fk_anc_obstructed_preg', 'fk_anc_obstructed_preg.id=' . $tableName . '.fk_anc_obstructed_preg', 'left');
        $this->db->join('tbl_lookup_details fk_anc_convulsion_preg', 'fk_anc_convulsion_preg.id=' . $tableName . '.fk_anc_convulsion_preg', 'left');
        $this->db->join('tbl_lookup_details fk_anc_placenta_preg', 'fk_anc_placenta_preg.id=' . $tableName . '.fk_anc_placenta_preg', 'left');
        $this->db->join('tbl_lookup_details fk_anc_breath_child', 'fk_anc_breath_child.id=' . $tableName . '.fk_anc_breath_child', 'left');
        $this->db->join('tbl_lookup_details fk_anc_suck_baby', 'fk_anc_suck_baby.id=' . $tableName . '.fk_anc_suck_baby', 'left');
        $this->db->join('tbl_lookup_details fk_anc_hot_cold_child', 'fk_anc_hot_cold_child.id=' . $tableName . '.fk_anc_hot_cold_child', 'left');
        $this->db->join('tbl_lookup_details fk_anc_blue_child', 'fk_anc_blue_child.id=' . $tableName . '.fk_anc_blue_child', 'left');
        $this->db->join('tbl_lookup_details fk_anc_convulsion_child', 'fk_anc_convulsion_child.id=' . $tableName . '.fk_anc_convulsion_child', 'left');
        $this->db->join('tbl_lookup_details fk_anc_indrawing_child', 'fk_anc_indrawing_child.id=' . $tableName . '.fk_anc_indrawing_child', 'left');
        $this->db->join('tbl_lookup_details fk_supliment_post', 'fk_supliment_post.id=' . $tableName . '.fk_supliment_post', 'left');
        $this->db->join('tbl_lookup_details fk_post_natal_visit', 'fk_post_natal_visit.id=' . $tableName . '.fk_post_natal_visit', 'left');
        $this->db->join('tbl_lookup_details fk_pnc_chkup_mother', 'fk_pnc_chkup_mother.id=' . $tableName . '.fk_pnc_chkup_mother_id', 'left');
        $this->db->join('tbl_lookup_details fk_pnc_first_visit_assist', 'fk_pnc_first_visit_assist.id=' . $tableName . '.fk_pnc_first_visit_assist', 'left');
        $this->db->join('tbl_lookup_details fk_pnc_first_visit', 'fk_pnc_first_visit.id=' . $tableName . '.fk_pnc_first_visit_id', 'left');
        $this->db->join('tbl_lookup_details fk_pnc_second_visit_assist', 'fk_pnc_second_visit_assist.id=' . $tableName . '.fk_pnc_second_visit_assist', 'left');
        $this->db->join('tbl_lookup_details fk_pnc_second_visit', 'fk_pnc_second_visit.id=' . $tableName . '.fk_pnc_second_visit_id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_birth_info($round_no, $tableName) {
        $this->db->select(
                $tableName . '.id,' .
                $tableName . '.household_master_id_hh,' .
                $tableName . '.member_code,' .
                $tableName . '.member_name,'
                . 'FORMAT(' . $tableName . ".birth_date,'dd/MM/yyyy') as birth_date,"
                . $tableName . '.father_code,'
                . $tableName . '.mother_code,'
                . $tableName . '.spouse_code,'
                . $tableName . '.national_id,'
                . 'FORMAT(' . $tableName . ".birth_registration_date,'dd/MM/yyyy') as birth_registration_date,"
                . $tableName . '.afterYear,'
                . $tableName . '.contactNoOne,'
                . $tableName . '.contactNoTwo'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime,"
                . 'household_master.household_code,marital_status.code as marital_status_code,marital_status.name as marital_status_name,fk_sex.code as fk_sex_code,fk_sex.name as fk_sex_name,fk_religion.code as fk_religion_code,fk_religion.name as fk_religion_name,fk_relation_with_hhh.code as fk_relation_with_hhh_code,fk_relation_with_hhh.name as fk_relation_with_hhh_name,fk_mother_live_birth_order.code as fk_mother_live_birth_order_code,fk_mother_live_birth_order.name as fk_mother_live_birth_order_name'
                . ',fk_birth_registration.code as fk_birth_registration_code, fk_birth_registration.name as fk_birth_registration_name'
                . ',fk_why_not_birth_registration.code as fk_why_not_birth_registration_code, fk_why_not_birth_registration.name as fk_why_not_birth_registration_name'
                . ',fk_additionalChild.code as fk_additionalChild_code, fk_additionalChild.name as fk_additionalChild_name'
                . ',insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_household', $tableName . '.id = tbl_member_household.member_master_id', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id_hh = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as marital_status', $tableName . '.fk_marital_status = marital_status.id', 'left');
        $this->db->join('tbl_lookup_details as fk_sex', $tableName . '.fk_sex = fk_sex.id', 'left');
        $this->db->join('tbl_lookup_details as fk_religion', $tableName . '.fk_religion = fk_religion.id', 'left');
        $this->db->join('tbl_lookup_details as fk_relation_with_hhh', $tableName . '.fk_relation_with_hhh = fk_relation_with_hhh.id', 'left');
        $this->db->join('tbl_lookup_details as fk_mother_live_birth_order', $tableName . '.fk_mother_live_birth_order = fk_mother_live_birth_order.id', 'left');
        $this->db->join('tbl_lookup_details as fk_birth_registration', $tableName . '.fk_birth_registration = fk_birth_registration.id', 'left');
        $this->db->join('tbl_lookup_details as fk_why_not_birth_registration', $tableName . '.fk_why_not_birth_registration = fk_why_not_birth_registration.id', 'left');
        $this->db->join('tbl_lookup_details as fk_additionalChild', $tableName . '.fk_additionalChild = fk_additionalChild.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        $this->db->where('tbl_member_household.fk_entry_type', 21);
        if ($round_no > 0) {
            $this->db->where('tbl_member_household.round_master_id_entry_round', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function birth_info($id, $tableName) {
        $this->db->select($tableName . '.*,household_master.household_code,tbl_member_household.entry_date,tbl_member_household.fk_entry_type,tbl_member_household.round_master_id_entry_round,'
                . 'tbl_member_education.fk_education_type,tbl_member_occupation.fk_main_occupation,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_household', $tableName . '.member_household_id_last=tbl_member_household.id', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id_hh = household_master.id', 'left');
        $this->db->join('tbl_member_education', $tableName . '.fk_education_id_last=tbl_member_education.id', 'left');
        $this->db->join('tbl_member_occupation', $tableName . '.fk_occupation_id_last=tbl_member_occupation.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($tableName . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function member_master_info($id, $tableName) {
        $this->db->select($tableName . '.*,household_master.fk_district_id, household_master.fk_thana_id, household_master.fk_slum_id, household_master.fk_slum_area_id,household_master.household_code,tbl_member_household.entry_date,tbl_member_household.fk_entry_type,tbl_member_household.round_master_id_entry_round,tbl_household_head.change_date,'
                . 'tbl_member_occupation.main_occupation_oth,household_master.fk_extinct_type,tbl_member_education.year_of_education,'
                . 'tbl_member_education.fk_education_type,tbl_member_occupation.fk_main_occupation,'
                . 'fk_entry_type.code as fk_entry_type_code,fk_entry_type.name as fk_entry_type_name,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_household', $tableName . '.member_household_id_last=tbl_member_household.id', 'left');
        $this->db->join('tbl_household_head', $tableName . '.household_master_id_hh=tbl_household_head.household_master_id', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id_hh = household_master.id', 'left');
        $this->db->join('tbl_member_education', $tableName . '.fk_education_id_last=tbl_member_education.id', 'left');
        $this->db->join('tbl_member_occupation', $tableName . '.fk_occupation_id_last=tbl_member_occupation.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->join('tbl_lookup_details as fk_entry_type', 'tbl_member_household.fk_entry_type=fk_entry_type.id', 'left');
        $this->db->where($tableName . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function all_round_info($table_name) {
        $this->db->from($table_name);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_internal_in_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,'
                . 'FORMAT(' . $tableName . ".movement_date,'dd/MM/yyyy') as movement_date,"
                . $tableName . '.remarks'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_movement_type.name as fk_movement_type_name,fk_movement_type.code as fk_movement_type_code,'
                . 'fk_internal_cause.name as fk_internal_cause_name,fk_internal_cause.code as fk_internal_cause_code,'
                . 'tbl_slum.name as slumIDFrom_name,tbl_slum.code as slumIDFrom_code,'
                . 'tbl_slum_area.name as slumAreaIDFrom_name,tbl_slum_area.code as slumAreaIDFrom_code,'
                . 'fk_migration_cause.name as fk_migration_cause_name,fk_migration_cause.code as fk_migration_cause_code,'
                . 'tbl_country.name as countryIDMoveFrom_name,tbl_country.code as countryIDMoveFrom_code,'
                . 'tbl_division.name as divisionIDMoveFrom_name,tbl_division.code as divisionIDMoveFrom_code,'
                . 'tbl_district.name as districtIDMoveFrom_name,tbl_district.code as districtIDMoveFrom_code,'
                . 'tbl_thana.name as thanaIDMoveFrom_name,tbl_thana.code as thanaIDMoveFrom_code,'
                . 'household_code_move_from.household_code as household_code_move_from,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('household_master as household_code_move_from', $tableName . '.household_master_id_move_from = household_code_move_from.id', 'left');
        $this->db->join('tbl_country', $tableName . '.countryIDMoveFrom = tbl_country.id', 'left');
        $this->db->join('tbl_division', $tableName . '.divisionIDMoveFrom = tbl_division.id', 'left');
        $this->db->join('tbl_district', $tableName . '.districtIDMoveFrom = tbl_district.id', 'left');
        $this->db->join('tbl_thana', $tableName . '.thanaIDMoveFrom = tbl_thana.id', 'left');
        $this->db->join('tbl_lookup_details as fk_movement_type', $tableName . '.fk_movement_type = fk_movement_type.id', 'left');
        $this->db->join('tbl_lookup_details as fk_internal_cause', $tableName . '.fk_internal_cause = fk_internal_cause.id', 'left');
        $this->db->join('tbl_lookup_details as fk_migration_cause', $tableName . '.fk_migration_cause = fk_migration_cause.id', 'left');
        $this->db->join('tbl_slum', $tableName . '.slumIDFrom = tbl_slum.id', 'left');
        $this->db->join('tbl_slum_area', $tableName . '.slumAreaIDFrom = tbl_slum_area.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        $this->db->where($tableName . '.fk_movement_type', 134);
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_migration_in_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,'
                . 'FORMAT(' . $tableName . ".movement_date,'dd/MM/yyyy') as movement_date,"
                . $tableName . '.remarks'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_movement_type.name as fk_movement_type_name,fk_movement_type.code as fk_movement_type_code,'
                . 'fk_internal_cause.name as fk_internal_cause_name,fk_internal_cause.code as fk_internal_cause_code,'
                . 'tbl_slum.name as slumIDFrom_name,tbl_slum.code as slumIDFrom_code,'
                . 'tbl_slum_area.name as slumAreaIDFrom_name,tbl_slum_area.code as slumAreaIDFrom_code,'
                . 'fk_migration_cause.name as fk_migration_cause_name,fk_migration_cause.code as fk_migration_cause_code,'
                . 'tbl_country.name as countryIDMoveFrom_name,tbl_country.code as countryIDMoveFrom_code,'
                . 'tbl_division.name as divisionIDMoveFrom_name,tbl_division.code as divisionIDMoveFrom_code,'
                . 'tbl_district.name as districtIDMoveFrom_name,tbl_district.code as districtIDMoveFrom_code,'
                . 'tbl_thana.name as thanaIDMoveFrom_name,tbl_thana.code as thanaIDMoveFrom_code,'
                . 'household_code_move_from.household_code as household_code_move_from,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('household_master as household_code_move_from', $tableName . '.household_master_id_move_from = household_code_move_from.id', 'left');
        $this->db->join('tbl_country', $tableName . '.countryIDMoveFrom = tbl_country.id', 'left');
        $this->db->join('tbl_division', $tableName . '.divisionIDMoveFrom = tbl_division.id', 'left');
        $this->db->join('tbl_district', $tableName . '.districtIDMoveFrom = tbl_district.id', 'left');
        $this->db->join('tbl_thana', $tableName . '.thanaIDMoveFrom = tbl_thana.id', 'left');
        $this->db->join('tbl_lookup_details as fk_movement_type', $tableName . '.fk_movement_type = fk_movement_type.id', 'left');
        $this->db->join('tbl_lookup_details as fk_internal_cause', $tableName . '.fk_internal_cause = fk_internal_cause.id', 'left');
        $this->db->join('tbl_lookup_details as fk_migration_cause', $tableName . '.fk_migration_cause = fk_migration_cause.id', 'left');
        $this->db->join('tbl_slum', $tableName . '.slumIDFrom = tbl_slum.id', 'left');
        $this->db->join('tbl_slum_area', $tableName . '.slumAreaIDFrom = tbl_slum_area.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        $this->db->where($tableName . '.fk_movement_type', 22);
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_internal_out_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,'
                . 'FORMAT(' . $tableName . ".movement_date,'dd/MM/yyyy') as movement_date,"
                . $tableName . '.remarks'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_movement_type.name as fk_movement_type_name,fk_movement_type.code as fk_movement_type_code,'
                . 'fk_internal_cause.name as fk_internal_cause_name,fk_internal_cause.code as fk_internal_cause_code,'
                . 'tbl_slum.name as slumIDTo_name,tbl_slum.code as slumIDTo_code,'
                . 'tbl_slum_area.name as slumAreaIDTo_name,tbl_slum_area.code as slumAreaIDTo_code,'
                . 'fk_type_of_group.name as fk_type_of_group_name,fk_type_of_group.code as fk_type_of_group_code,'
                . 'fk_outside_cause_individual.name as fk_outside_cause_individual_name,fk_outside_cause_individual.code as fk_outside_cause_individual_code,'
                . 'fk_outside_cause_group.name as fk_outside_cause_group_name,fk_outside_cause_group.code as fk_outside_cause_group_code,'
                . 'tbl_country.name as countryIDMoveTo_name,tbl_country.code as countryIDMoveTo_code,'
                . 'tbl_division.name as divisionIDMoveTo_name,tbl_division.code as divisionIDMoveTo_code,'
                . 'tbl_district.name as districtIDMoveTo_name,tbl_district.code as districtIDMoveTo_code,'
                . 'tbl_thana.name as thanaIDMoveTo_name,tbl_thana.code as thanaIDMoveTo_code,'
                . 'household_code_move_to.household_code as household_code_move_to,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('household_master as household_code_move_to', $tableName . '.household_master_id_move_to = household_code_move_to.id', 'left');
        $this->db->join('tbl_lookup_details as fk_movement_type', $tableName . '.fk_movement_type = fk_movement_type.id', 'left');
        $this->db->join('tbl_lookup_details as fk_internal_cause', $tableName . '.fk_internal_cause = fk_internal_cause.id', 'left');
        $this->db->join('tbl_lookup_details as fk_type_of_group', $tableName . '.fk_type_of_group = fk_type_of_group.id', 'left');
        $this->db->join('tbl_lookup_details as fk_outside_cause_individual', $tableName . '.fk_outside_cause_individual = fk_outside_cause_individual.id', 'left');
        $this->db->join('tbl_lookup_details as fk_outside_cause_group', $tableName . '.fk_outside_cause_group = fk_outside_cause_group.id', 'left');
        $this->db->join('tbl_country', $tableName . '.countryIDMoveTo = tbl_country.id', 'left');
        $this->db->join('tbl_division', $tableName . '.divisionIDMoveTo = tbl_division.id', 'left');
        $this->db->join('tbl_district', $tableName . '.districtIDMoveTo = tbl_district.id', 'left');
        $this->db->join('tbl_thana', $tableName . '.thanaIDMoveTo = tbl_thana.id', 'left');
        $this->db->join('tbl_slum', $tableName . '.slumIDTo = tbl_slum.id', 'left');
        $this->db->join('tbl_slum_area', $tableName . '.slumAreaIDTo = tbl_slum_area.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        $this->db->where($tableName . '.fk_movement_type', 135);
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_migration_out_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,'
                . 'FORMAT(' . $tableName . ".movement_date,'dd/MM/yyyy') as movement_date,"
                . $tableName . '.remarks'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_movement_type.name as fk_movement_type_name,fk_movement_type.code as fk_movement_type_code,'
                . 'fk_internal_cause.name as fk_internal_cause_name,fk_internal_cause.code as fk_internal_cause_code,'
                . 'tbl_slum.name as slumIDTo_name,tbl_slum.code as slumIDTo_code,'
                . 'tbl_slum_area.name as slumAreaIDTo_name,tbl_slum_area.code as slumAreaIDTo_code,'
                . 'fk_type_of_group.name as fk_type_of_group_name,fk_type_of_group.code as fk_type_of_group_code,'
                . 'fk_outside_cause_individual.name as fk_outside_cause_individual_name,fk_outside_cause_individual.code as fk_outside_cause_individual_code,'
                . 'fk_outside_cause_group.name as fk_outside_cause_group_name,fk_outside_cause_group.code as fk_outside_cause_group_code,'
                . 'tbl_country.name as countryIDMoveTo_name,tbl_country.code as countryIDMoveTo_code,'
                . 'tbl_division.name as divisionIDMoveTo_name,tbl_division.code as divisionIDMoveTo_code,'
                . 'tbl_district.name as districtIDMoveTo_name,tbl_district.code as districtIDMoveTo_code,'
                . 'tbl_thana.name as thanaIDMoveTo_name,tbl_thana.code as thanaIDMoveTo_code,'
                . 'household_code_move_to.household_code as household_code_move_to,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('household_master as household_code_move_to', $tableName . '.household_master_id_move_to = household_code_move_to.id', 'left');
        $this->db->join('tbl_lookup_details as fk_movement_type', $tableName . '.fk_movement_type = fk_movement_type.id', 'left');
        $this->db->join('tbl_lookup_details as fk_internal_cause', $tableName . '.fk_internal_cause = fk_internal_cause.id', 'left');
        $this->db->join('tbl_lookup_details as fk_type_of_group', $tableName . '.fk_type_of_group = fk_type_of_group.id', 'left');
        $this->db->join('tbl_lookup_details as fk_outside_cause_individual', $tableName . '.fk_outside_cause_individual = fk_outside_cause_individual.id', 'left');
        $this->db->join('tbl_lookup_details as fk_outside_cause_group', $tableName . '.fk_outside_cause_group = fk_outside_cause_group.id', 'left');
        $this->db->join('tbl_country', $tableName . '.countryIDMoveTo = tbl_country.id', 'left');
        $this->db->join('tbl_division', $tableName . '.divisionIDMoveTo = tbl_division.id', 'left');
        $this->db->join('tbl_district', $tableName . '.districtIDMoveTo = tbl_district.id', 'left');
        $this->db->join('tbl_thana', $tableName . '.thanaIDMoveTo = tbl_thana.id', 'left');
        $this->db->join('tbl_slum', $tableName . '.slumIDTo = tbl_slum.id', 'left');
        $this->db->join('tbl_slum_area', $tableName . '.slumAreaIDTo = tbl_slum_area.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        $this->db->where($tableName . '.fk_movement_type', 79);
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_education_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,' . $tableName . '.is_last_education,'
                . 'FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime,"
                . "FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_religious_edu.code as fk_religious_edu_code,fk_religious_edu.name as fk_religious_edu_name,'
                . 'fk_secular_edu.code as fk_secular_edu_code,fk_secular_edu.name as fk_secular_edu_name,'
                . 'fk_education_type.code as fk_education_type_code,fk_education_type.name as fk_education_type_name,'
                . 'year_of_education.code as year_of_education_code,year_of_education.name as year_of_education_name,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as fk_religious_edu', $tableName . '.fk_religious_edu = fk_religious_edu.id', 'left');
        $this->db->join('tbl_lookup_details as fk_secular_edu', $tableName . '.fk_secular_edu = fk_secular_edu.id', 'left');
        $this->db->join('tbl_lookup_details as fk_education_type', $tableName . '.fk_education_type = fk_education_type.id', 'left');
        $this->db->join('tbl_lookup_details as year_of_education', $tableName . '.year_of_education = year_of_education.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_occupation_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,'
                . $tableName . '.main_occupation_oth,'
                . $tableName . '.is_last_occupation'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_main_occupation.name as fk_main_occupation_name,fk_main_occupation.code as fk_main_occupation_code,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');

        $this->db->join('tbl_lookup_details as fk_main_occupation', $tableName . '.fk_main_occupation = fk_main_occupation.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function occupation_info($id, $tableName) {
        $this->db->select($tableName . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,tbl_member_master.birth_date,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($tableName . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function all_relation_info($round_no, $tableName) {
        $this->db->select(
                $tableName . '.id,'
                . $tableName . '.household_master_id,'
                . $tableName . '.member_master_id,'
                . $tableName . '.round_master_id,'
                . $tableName . '.fk_relation,'
                . $tableName . '.is_last_relation'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_relation.name as fk_relation_name,fk_relation.code as fk_relation_code,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');

        $this->db->join('tbl_lookup_details as fk_relation', $tableName . '.fk_relation = fk_relation.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_asset_info($round_no, $tableName) {
        $this->db->select($tableName . '.id'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime,"
                . 'household_master.household_code,'
                . 'fk_owner_land.name as fk_owner_land_name,fk_owner_land.code as fk_owner_land_code,'
                . 'fk_owner_house.name as fk_owner_house_name,fk_owner_house.code as fk_owner_house_code,'
                . 'fk_chair.name as fk_chair_name,fk_chair.code as fk_chair_code,'
                . 'fk_dining_table.name as fk_dining_table_name,fk_dining_table.code as fk_dining_table_code,'
                . 'fk_khat.name as fk_khat_name,fk_khat.code as fk_khat_code,'
                . 'fk_chowki.name as fk_chowki_name,fk_chowki.code as fk_chowki_code,'
                . 'fk_almirah.name as fk_almirah_name,fk_almirah.code as fk_almirah_code,'
                . 'fk_sofa.name as fk_sofa_name,fk_sofa.code as fk_sofa_code,'
                . 'fk_radio.name as fk_radio_name,fk_radio.code as fk_radio_code,'
                . 'fk_tv.name as fk_tv_name,fk_tv.code as fk_tv_code,'
                . 'fk_freeze.name as fk_freeze_name,fk_freeze.code as fk_freeze_code,'
                . 'fk_mobile.name as fk_mobile_name,fk_mobile.code as fk_mobile_code,'
                . 'fk_electric_fan.name as fk_electric_fan_name,fk_electric_fan.code as fk_electric_fan_code,'
                . 'fk_hand_watch.name as fk_hand_watch_name,fk_hand_watch.code as fk_hand_watch_code,'
                . 'fk_rickshow.name as fk_rickshow_name,fk_rickshow.code as fk_rickshow_code,'
                . 'fk_computer.name as fk_computer_name,fk_computer.code as fk_computer_code,'
                . 'fk_sewing_machine.name as fk_sewing_machine_name,fk_sewing_machine.code as fk_sewing_machine_code,'
                . 'fk_cycle.name as fk_cycle_name,fk_cycle.code as fk_cycle_code,'
                . 'fk_motor_cycle.name as fk_motor_cycle_name,fk_motor_cycle.code as fk_motor_cycle_code,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');

        $this->db->join('tbl_lookup_details as fk_owner_land', $tableName . '.fk_owner_land = fk_owner_land.id', 'left');
        $this->db->join('tbl_lookup_details as fk_owner_house', $tableName . '.fk_owner_house = fk_owner_house.id', 'left');
        $this->db->join('tbl_lookup_details as fk_chair', $tableName . '.fk_chair = fk_chair.id', 'left');
        $this->db->join('tbl_lookup_details as fk_dining_table', $tableName . '.fk_dining_table = fk_dining_table.id', 'left');
        $this->db->join('tbl_lookup_details as fk_khat', $tableName . '.fk_khat = fk_khat.id', 'left');
        $this->db->join('tbl_lookup_details as fk_chowki', $tableName . '.fk_chowki = fk_chowki.id', 'left');
        $this->db->join('tbl_lookup_details as fk_almirah', $tableName . '.fk_almirah = fk_almirah.id', 'left');
        $this->db->join('tbl_lookup_details as fk_sofa', $tableName . '.fk_sofa = fk_sofa.id', 'left');
        $this->db->join('tbl_lookup_details as fk_radio', $tableName . '.fk_radio = fk_radio.id', 'left');
        $this->db->join('tbl_lookup_details as fk_tv', $tableName . '.fk_tv = fk_tv.id', 'left');
        $this->db->join('tbl_lookup_details as fk_freeze', $tableName . '.fk_freeze = fk_freeze.id', 'left');
        $this->db->join('tbl_lookup_details as fk_mobile', $tableName . '.fk_mobile = fk_mobile.id', 'left');
        $this->db->join('tbl_lookup_details as fk_electric_fan', $tableName . '.fk_electric_fan = fk_electric_fan.id', 'left');
        $this->db->join('tbl_lookup_details as fk_hand_watch', $tableName . '.fk_hand_watch = fk_hand_watch.id', 'left');
        $this->db->join('tbl_lookup_details as fk_rickshow', $tableName . '.fk_rickshow = fk_rickshow.id', 'left');
        $this->db->join('tbl_lookup_details as fk_computer', $tableName . '.fk_computer = fk_computer.id', 'left');
        $this->db->join('tbl_lookup_details as fk_sewing_machine', $tableName . '.fk_sewing_machine = fk_sewing_machine.id', 'left');
        $this->db->join('tbl_lookup_details as fk_cycle', $tableName . '.fk_cycle = fk_cycle.id', 'left');
        $this->db->join('tbl_lookup_details as fk_motor_cycle', $tableName . '.fk_motor_cycle = fk_motor_cycle.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function asset_info($id, $tableName) {
        $this->db->select($tableName . '.*,household_master.household_code');
        $this->db->from($tableName);
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');

        $this->db->where($tableName . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function all_marriage_start_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,' . $tableName . '.is_event,' . $tableName . '.remarks'
                . ',FORMAT(' . $tableName . ".marriage_date,'dd/MM/yyyy') as marriage_date"
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_bri_gem_premarital_status.name as fk_bri_gem_premarital_status_name,fk_bri_gem_premarital_status.code as fk_bri_gem_premarital_status_code,'
                . 'fk_bri_gem_marital_order.name as fk_bri_gem_marital_order_name,fk_bri_gem_marital_order.code as fk_bri_gem_marital_order_code,'
                . 'fk_kazi_registered.name as fk_kazi_registered_name,fk_kazi_registered.code as fk_kazi_registered_code,'
                . 'fk_member_premarital_status.name as fk_member_premarital_status_name,fk_member_premarital_status.code as fk_member_premarital_status_code,'
                . 'fk_member_marital_order.name as fk_member_marital_order_name,fk_member_marital_order.code as fk_member_marital_order_code,'
                . 'member_code_bride_groom.member_code as member_code_bride_groom,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_member_master as member_code_bride_groom', $tableName . '.member_master_id_bride_groom = member_code_bride_groom.id', 'left');

        $this->db->join('tbl_lookup_details as fk_bri_gem_premarital_status', $tableName . '.fk_bri_gem_premarital_status = fk_bri_gem_premarital_status.id', 'left');
        $this->db->join('tbl_lookup_details as fk_bri_gem_marital_order', $tableName . '.fk_bri_gem_marital_order = fk_bri_gem_marital_order.id', 'left');
        $this->db->join('tbl_lookup_details as fk_kazi_registered', $tableName . '.fk_kazi_registered = fk_kazi_registered.id', 'left');
        $this->db->join('tbl_lookup_details as fk_member_premarital_status', $tableName . '.fk_member_premarital_status = fk_member_premarital_status.id', 'left');
        $this->db->join('tbl_lookup_details as fk_member_marital_order', $tableName . '.fk_member_marital_order = fk_member_marital_order.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_marriage_end_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,'
                . 'FORMAT(' . $tableName . ".marriage_end_date,'dd/MM/yyyy') as marriage_end_date,"
                . $tableName . '.is_event,'
                . $tableName . '.remarks'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_marriage_end_cause_one.name as fk_marriage_end_cause_one_name,fk_marriage_end_cause_one.code as fk_marriage_end_cause_one_code,'
                . 'fk_marriage_end_cause_two.name as fk_marriage_end_cause_two_name,fk_marriage_end_cause_two.code as fk_marriage_end_cause_two_code,'
                . 'fk_marriage_end_cause_three.name as fk_marriage_end_cause_three_name,fk_marriage_end_cause_three.code as fk_marriage_end_cause_three_code,'
                . 'fk_marriage_end_type.name as fk_marriage_end_type_name,fk_marriage_end_type.code as fk_marriage_end_type_code,'
                . 'member_code_bride_groom.member_code as member_code_bride_groom,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_member_master as member_code_bride_groom', $tableName . '.member_master_id_bride_groom = member_code_bride_groom.id', 'left');

        $this->db->join('tbl_lookup_details as fk_marriage_end_cause_one', $tableName . '.fk_marriage_end_cause_one = fk_marriage_end_cause_one.id', 'left');
        $this->db->join('tbl_lookup_details as fk_marriage_end_cause_two', $tableName . '.fk_marriage_end_cause_two = fk_marriage_end_cause_two.id', 'left');
        $this->db->join('tbl_lookup_details as fk_marriage_end_cause_three', $tableName . '.fk_marriage_end_cause_three = fk_marriage_end_cause_three.id', 'left');
        $this->db->join('tbl_lookup_details as fk_marriage_end_type', $tableName . '.fk_marriage_end_type = fk_marriage_end_type.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_interview_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,'
                . $tableName . '.household_master_id,'
                . 'FORMAT(' . $tableName . ".interview_date,'dd/MM/yyyy') as interview_date,"
                . $tableName . '.respondent_code'
                . ',FORMAT(' . $tableName . ".split_date,'dd/MM/yyyy') as split_date,"
                . $tableName . '.no_of_new_household'
                . ',FORMAT(' . $tableName . ".merge_date,'dd/MM/yyyy') as merge_date,"
                . $tableName . '.remarks'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime,"
                . 'household_master.household_code,'
                . 'any_birth.name as any_birth_name,any_birth.code as any_birth_code,'
                . 'any_concepton.name as any_concepton_name,any_concepton.code as any_concepton_code,'
                . 'any_pregnancy.name as any_pregnancy_name,any_pregnancy.code as any_pregnancy_code,'
                . 'any_death.name as any_death_name,any_death.code as any_death_code,'
                . 'any_hosp.name as any_hosp_name,any_hosp.code as any_hosp_code,'
                . 'memberCheck.name as memberCheck_name,memberCheck.code as memberCheck_code,'
                . 'any_vaccin.name as any_vaccin_name,any_vaccin.code as any_vaccin_code,'
                . 'any_marriage_start.name as any_marriage_start_name,any_marriage_start.code as any_marriage_start_code,'
                . 'any_marriage_end.name as any_marriage_end_name,any_marriage_end.code as any_marriage_end_code,'
                . 'any_migration_in.name as any_migration_in_name,any_migration_in.code as any_migration_in_code,'
                . 'any_migration_out.name as any_migration_out_name,any_migration_out.code as any_migration_out_code,'
                . 'fk_interview_status.name as fk_interview_status_name,fk_interview_status.code as fk_interview_status_code,'
                . 'fk_interviewer.name as fk_interviewer_name,fk_interviewer.code as fk_interviewer_code,'
                . 'fk_responded_type.name as fk_responded_type_name,fk_responded_type.code as fk_responded_type_code,'
                . 'is_household_split.name as is_household_split_name,is_household_split.code as is_household_split_code,'
                . 'is_household_merge.name as is_household_merge_name,is_household_merge.code as is_household_merge_code,'
                . 'any_asset.name as any_asset_name,any_asset.code as any_asset_code,'
                . 'any_education.name as any_education_name,any_education.code as any_education_code,'
                . 'any_occupation.name as any_occupation_name,any_occupation.code as any_occupation_code,'
                . 'any_relation.name as any_relation_name,any_relation.code as any_relation_code,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as any_birth', $tableName . '.any_birth = any_birth.id', 'left');
        $this->db->join('tbl_lookup_details as any_concepton', $tableName . '.any_concepton = any_concepton.id', 'left');
        $this->db->join('tbl_lookup_details as any_pregnancy', $tableName . '.any_pregnancy = any_pregnancy.id', 'left');
        $this->db->join('tbl_lookup_details as any_death', $tableName . '.any_death = any_death.id', 'left');
        $this->db->join('tbl_lookup_details as any_hosp', $tableName . '.any_hosp = any_hosp.id', 'left');
        $this->db->join('tbl_lookup_details as memberCheck', $tableName . '.memberCheck = memberCheck.id', 'left');
        $this->db->join('tbl_lookup_details as any_vaccin', $tableName . '.any_vaccin = any_vaccin.id', 'left');
        $this->db->join('tbl_lookup_details as any_marriage_start', $tableName . '.any_marriage_start = any_marriage_start.id', 'left');
        $this->db->join('tbl_lookup_details as any_marriage_end', $tableName . '.any_marriage_end = any_marriage_end.id', 'left');
        $this->db->join('tbl_lookup_details as any_migration_in', $tableName . '.any_migration_in = any_migration_in.id', 'left');
        $this->db->join('tbl_lookup_details as any_migration_out', $tableName . '.any_migration_out = any_migration_out.id', 'left');
        $this->db->join('tbl_lookup_details as fk_interview_status', $tableName . '.fk_interview_status = fk_interview_status.id', 'left');
        $this->db->join('tbl_lookup_details as fk_interviewer', $tableName . '.fk_interviewer = fk_interviewer.id', 'left');
        $this->db->join('tbl_lookup_details as fk_responded_type', $tableName . '.fk_responded_type = fk_responded_type.id', 'left');
        $this->db->join('tbl_lookup_details as is_household_split', $tableName . '.is_household_split = is_household_split.id', 'left');
        $this->db->join('tbl_lookup_details as is_household_merge', $tableName . '.is_household_merge = is_household_merge.id', 'left');
        $this->db->join('tbl_lookup_details as any_asset', $tableName . '.any_asset = any_asset.id', 'left');
        $this->db->join('tbl_lookup_details as any_education', $tableName . '.any_education = any_education.id', 'left');
        $this->db->join('tbl_lookup_details as any_occupation', $tableName . '.any_occupation = any_occupation.id', 'left');
        $this->db->join('tbl_lookup_details as any_relation', $tableName . '.any_relation = any_relation.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function getMemberMasterPresentList($household_master_id) {
        $this->db->select('mm.id,member_code,member_name, birth_date,mar.name as marriageName, mar.code as marriageCode,rel.name as relationHead,mm.household_master_id_hh,mh.current_indenttification_id');
        $this->db->from('tbl_member_master mm');
        $this->db->join('household_master hm', 'hm.id = mm.household_master_id_hh', 'inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details mar', 'mar.id = mm.fk_marital_status', 'left');
        $this->db->join('tbl_lookup_details rel', 'rel.id = mm.fk_relation_with_hhh', 'left');
        $this->db->where('mh.household_master_id', $household_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get()->result();

        return $query;
    }

    function addNewList($IdInfo, $tableName) {
        $this->db->insert($tableName, $IdInfo);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    function interview_info($id, $tableName) {
        $this->db->select($tableName . '.*,household_master.household_code,household_master.contact_number,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        $this->db->where($tableName . '.id', $id);
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->row();
    }

    function all_household_master_info($district_id = "", $upazilla_id = "", $slum_id = "", $slum_area_id = "", $round_no = "", $tableName) {
        $this->db->select(
                $tableName . '.id,'
                . $tableName . '.household_code,'
                . $tableName . '.contact_number,'
                . $tableName . '.houseCount,'
                . $tableName . '.barino,'
                . $tableName . '.bariwalla_name,'
                . $tableName . '.household_head_name,'
                . $tableName . '.longlivy,'
                . $tableName . '.longlivm,'
                . $tableName . '.leftpad,'
                . 'FORMAT(' . $tableName . ".entry_date,'dd/MM/yyyy') as entry_date,"
                . $tableName . '.round_master_id_entry_round,'
                . $tableName . '.migration_reason_oth'
                . ',FORMAT(' . $tableName . ".extinct_date,'dd/MM/yyyy') as extinct_date,"
                . $tableName . '.round_master_id_extinct_round,'
                . $tableName . '.location_id,'
                . $tableName . '.location_split_id'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime,"
                . ',tbl_district.name as district_name,tbl_district.code as district_code,'
                . 'tbl_thana.name as thana_name,tbl_thana.code as thana_code,'
                . 'tbl_slum.name as slum_name,tbl_slum.code as slum_code,'
                . 'tbl_slum_area.name as slum_area_name,tbl_slum_area.code as slum_area_code,'
                . 'fk_entry_type.name as fk_entry_type_name,fk_entry_type.code as fk_entry_type_code,'
                . 'fk_migration_reason.name as fk_migration_reason_name,fk_migration_reason.code as fk_migration_reason_code,'
                . 'tbl_country.name as country_from,'
                . 'district_from.name as district_from,'
                . 'thana_from.name as thana_from,'
                . 'slum_from.name as slum_from,'
                . 'slum_area_from.name as slum_area_from,'
                . 'fk_extinct_type.name as fk_extinct_type_name,fk_extinct_type.code as fk_extinct_type_code,'
                . 'fk_contract_type.name as fk_contract_type_name,fk_contract_type.code as fk_contract_type_code,'
                . 'fk_family_type.name as fk_family_type_name,fk_family_type.code as fk_family_type_code,'
                . 'fk_study_design.name as fk_study_design_name,fk_study_design.code as fk_study_design_code,'
                . 'tbl_member_master.member_code as member_code_last_head,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_district', $tableName . '.fk_district_id = tbl_district.id', 'left');
        $this->db->join('tbl_thana', $tableName . '.fk_thana_id = tbl_thana.id', 'left');
        $this->db->join('tbl_slum', $tableName . '.fk_slum_id = tbl_slum.id', 'left');
        $this->db->join('tbl_slum_area', $tableName . '.fk_slum_area_id = tbl_slum_area.id', 'left');
        $this->db->join('tbl_lookup_details as fk_entry_type', $tableName . '.fk_entry_type = fk_entry_type.id', 'left');
        $this->db->join('tbl_lookup_details as fk_migration_reason', $tableName . '.fk_migration_reason = fk_migration_reason.id', 'left');
        $this->db->join('tbl_lookup_details as fk_extinct_type', $tableName . '.fk_extinct_type = fk_extinct_type.id', 'left');
        $this->db->join('tbl_lookup_details as fk_contract_type', $tableName . '.fk_contract_type = fk_contract_type.id', 'left');
        $this->db->join('tbl_lookup_details as fk_family_type', $tableName . '.fk_family_type = fk_family_type.id', 'left');
        $this->db->join('tbl_lookup_details as fk_study_design', $tableName . '.fk_study_design = fk_study_design.id', 'left');
        $this->db->join('tbl_country', $tableName . '.fk_country_id_from = tbl_country.id', 'left');
        $this->db->join('tbl_district as district_from', $tableName . '.fk_district_id_from = district_from.id', 'left');
        $this->db->join('tbl_thana as thana_from', $tableName . '.fk_thana_id_from = thana_from.id', 'left');
        $this->db->join('tbl_slum as slum_from', $tableName . '.fk_slum_id_from = slum_from.id', 'left'); 
        $this->db->join('tbl_slum_area as slum_area_from', $tableName . '.fk_slumArea_id_from = slum_area_from.id', 'left');
        $this->db->join('tbl_member_master', $tableName . '.member_master_id_last_head = tbl_member_master.id', 'left');
        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if (empty($district_id) == false) {
            $this->db->where($tableName . '.fk_district_id', $district_id);
        }
        if (empty($upazilla_id) == false) {
            $this->db->where($tableName . '.fk_thana_id', $upazilla_id);
        }
        if (empty($slum_id) == false) {
            $this->db->where($tableName . '.fk_slum_id', $slum_id);
        }
        if (empty($slum_area_id) == false) {
            $this->db->where($tableName . '.fk_slum_area_id', $slum_area_id);
        }
        if (empty($round_no) == false) {
            $this->db->where($tableName . '.round_master_id_entry_round', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function household_master_info($id, $tableName) {

        $this->db->select($tableName . '.*,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id_last_head = tbl_member_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($tableName . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function all_household_head_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,'
                . 'FORMAT(' . $tableName . ".change_date,'dd/MM/yyyy') as change_date,"
                . $tableName . '.is_last_head'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'tbl_lookup_details.code as fk_hhh_cause_code,tbl_lookup_details.name as fk_hhh_cause_name,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details', $tableName . '.fk_hhh_cause = tbl_lookup_details.id', 'left');

        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_death_info($round_no, $tableName) {
        $this->db->select($tableName . '.id,'
                . 'FORMAT(' . $tableName . ".death_date,'dd/MM/yyyy') as death_date,"
                . $tableName . '.death_time'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as birth_date,"
                . 'household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'fk_death_cause.name as fk_death_cause_name,fk_death_cause.code as fk_death_cause_code,'
                . 'fk_death_place.name as fk_death_place_name,fk_death_place.code as fk_death_place_code,'
                . 'fk_death_type.name as fk_death_type_name,fk_death_type.code as fk_death_type_code,'
                . 'fk_death_confirmby.name as fk_death_confirmby_name,fk_death_confirmby.code as fk_death_confirmby_code,'
                . 'insertedBy.name as insertedBy_name,updateBy.name as updateBy_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details fk_death_cause', $tableName . '.fk_death_cause = fk_death_cause.id', 'left');
        $this->db->join('tbl_lookup_details fk_death_place', $tableName . '.fk_death_place = fk_death_place.id', 'left');
        $this->db->join('tbl_lookup_details fk_death_type', $tableName . '.fk_death_type = fk_death_type.id', 'left');
        $this->db->join('tbl_lookup_details fk_death_confirmby', $tableName . '.fk_death_confirmby = fk_death_confirmby.id', 'left');

        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');
        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function death_info($id, $tableName) {
        $this->db->select($tableName . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');

        $this->db->where($tableName . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getListType($tableName) {
        $this->db->select('id, name,code');
        $this->db->from($tableName);
        $this->db->where('active', 1);
        $query = $this->db->get();

        return $query->result();
    }

    function getUpaZila($districtID) {
        $this->db->where('districtID', $districtID);
        $query = $this->db->get('tbl_thana');
        $output = '<option value="">Select Upazila</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->code . '-' . $row->name . '</option>';
        }
        return $output;
    }

    function getSlum($thanaID) {
        $this->db->where('thanaID', $thanaID);
        $query = $this->db->get('tbl_slum');
        $output = '<option value="">Select Slum</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->code . '-' . $row->name . '</option>';
        }
        return $output;
    }

    function getSlumArea($slumID) {
        $this->db->where('slumID', $slumID);
        $query = $this->db->get('tbl_slum_area');
        $output = '<option value="">Select Slum Area</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->code . '-' . $row->name . '</option>';
        }
        return $output;
    }
	
	
	function child_illness_info($id, $table) {
        $this->db->select($table . '.*,household_master.household_code,tbl_member_master.member_code,tbl_member_master.member_name,tbl_member_master.fk_followup_exit_type,tbl_member_master.followup_exit_date,tbl_member_master.folowup_exit_round,'
                . 'gender.code as gender_code,gender.name as gender_name');
        $this->db->from($table);
        $this->db->join('tbl_member_master', $table . '.member_master_id = tbl_member_master.id', 'left');
        $this->db->join('household_master', $table . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details as gender', 'tbl_member_master.fk_sex=gender.id', 'left');
        $this->db->where($table . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function all_child_illness_info($round_no, $tableName, $list_fields) {
        $this->db->select($tableName . '.id'
                . ",FORMAT(tbl_member_master.birth_date,'dd/MM/yyyy') as DOB,"
                . 'household_master.household_code as HHNO,tbl_member_master.member_code,'
                . 'breastfeeding_ever.code as breastfeeding_ever_code,'
                . 'breastfeeding_after_how_many_time_after_birth.code as breastfeeding_after_how_many_time_after_birth_code,'
                . 'breastfeeding_after_how_many_hour_after_birth,'
                . 'breastfeeding_after_how_many_day_after_birth,'
                . 'other_drink_except_breastfeeding.code as other_drink_except_breastfeeding_code,'
                . 'drink_anything_else_except_breastfeeding.code as drink_anything_else_except_breastfeeding_code,'
                . 'drink_just_water.code as drink_just_water_code,'
                . 'drink_sugar_or_glucose_water.code as drink_sugar_or_glucose_water_code,'
                . 'drink_honey.code as drink_honey_code,'
                . 'drink_pipe_water.code as drink_pipe_water_code,'
                . 'drink_sugar_or_salt_mixed_water.code as drink_sugar_or_salt_mixed_water_code,'
                . 'drink_fruit_juice.code as drink_fruit_juice_code,'
                . 'drink_baby_food.code as drink_baby_food_code,'
                . 'drink_tea_or_saline_in_vein.code as drink_tea_or_saline_in_vein_code,'
                . 'drink_coffee.code as drink_coffee_code,'
                . 'drink_dont_know.code as drink_dont_know_code,'
                . 'drink_other.code as drink_other_code,'
                . 'drink_other_value,'
                . 'breastfeeding_still_now.code as breastfeeding_still_now_code,'
                . 'breastfeeding_how_many_month.code as breastfeeding_how_many_month_code,'
                . 'breastfeeding_how_many_month_value,'
                . 'yesterday_day_night_just_water.code as yesterday_day_night_just_water_code,'
                . 'yesterday_day_night_juice.code as yesterday_day_night_juice_code,'
                . 'yesterday_day_night_soup_fruit_juice.code as yesterday_day_night_soup_fruit_juice_code,'
                . 'yesterday_day_night_tin_milk_power_milk_cow_milk.code as yesterday_day_night_tin_milk_power_milk_cow_milk_code,'
                . 'yesterday_day_night_baby_food.code as yesterday_day_night_baby_food_code,'
                . 'yesterday_day_night_other.code as yesterday_day_night_other_code,'
                . 'yesterday_day_night_other_value,'
                . 'yesterday_day_night_hard_half_hard_soft_food.code as yesterday_day_night_hard_half_hard_soft_food_code,'
                . 'hard_half_hard_soft_food_since_how_many_month.code as hard_half_hard_soft_food_since_how_many_month_code,'
                . 'hard_half_hard_soft_food_since_how_many_month_value,'
                . 'diarrhoea_happened.code as diarrhoea_happened_code,'
                . 'diarrhoea_happened_day_number,'
                . 'diarrhoea_type.code as diarrhoea_type_code,'
                . 'diarrhoea_treatment_type.code as diarrhoea_treatment_type_code,'
                . 'diarrhoea_treatment_from.code as diarrhoea_treatment_from_code,'
                . 'diarrhoea_treatment_from_other_value,'
                . ',FORMAT(' . $tableName . ".diarrhoea_start_date,'dd/MM/yyyy') as diarrhoea_start_date,"
                . 'pneumonia_symptom_no_symptom.code as pneumonia_symptom_no_symptom_code,'
                . 'pneumonia_symptom_fever.code as pneumonia_symptom_fever_code,'
                . 'pneumonia_symptom_cold_cough.code as pneumonia_symptom_cold_cough_code,'
                . 'pneumonia_symptom_breath_shortness_frequent_breathing.code as pneumonia_symptom_breath_shortness_frequent_breathing_code,'
                . 'pneumonia_symptom_chest_going_down.code as pneumonia_symptom_chest_going_down_code,'
                . 'antibiotic_for_pneumonia.code as antibiotic_for_pneumonia_code,'
                . 'pneumonia_treatment_taken_from.code as pneumonia_treatment_taken_from_code,'
                . 'pneumonia_treatment_taken_from_other_value,'
                . 'FORMAT(' . $tableName . ".pneumonia_start_date,'dd/MM/yyyy') as pneumonia_start_date,"
                . 'interview_status.code as interview_status_code,'
                . 'FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ',insertedBy.name as insertedBy_name'
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime,"
                . 'updateBy.name as updateBy_name'
        );
        $this->db->from($tableName);
        $this->db->join('tbl_member_master', $tableName . '.member_master_id = tbl_member_master.ID', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_lookup_details breastfeeding_ever', $tableName . '.breastfeeding_ever = breastfeeding_ever.id', 'left');
        $this->db->join('tbl_lookup_details breastfeeding_after_how_many_time_after_birth', $tableName . '.breastfeeding_after_how_many_time_after_birth = breastfeeding_after_how_many_time_after_birth.id', 'left');
        $this->db->join('tbl_lookup_details other_drink_except_breastfeeding', $tableName . '.other_drink_except_breastfeeding = other_drink_except_breastfeeding.id', 'left');
        $this->db->join('tbl_lookup_details drink_anything_else_except_breastfeeding', $tableName . '.drink_anything_else_except_breastfeeding = drink_anything_else_except_breastfeeding.id', 'left');
        $this->db->join('tbl_lookup_details drink_just_water', $tableName . '.drink_just_water = drink_just_water.id', 'left');
        $this->db->join('tbl_lookup_details drink_sugar_or_glucose_water', $tableName . '.drink_sugar_or_glucose_water = drink_sugar_or_glucose_water.id', 'left');
        $this->db->join('tbl_lookup_details drink_honey', $tableName . '.drink_honey = drink_honey.id', 'left');
        $this->db->join('tbl_lookup_details drink_pipe_water', $tableName . '.drink_pipe_water = drink_pipe_water.id', 'left');
        $this->db->join('tbl_lookup_details drink_sugar_or_salt_mixed_water', $tableName . '.drink_sugar_or_salt_mixed_water = drink_sugar_or_salt_mixed_water.id', 'left');
        $this->db->join('tbl_lookup_details drink_fruit_juice', $tableName . '.drink_fruit_juice = drink_fruit_juice.id', 'left');
        $this->db->join('tbl_lookup_details drink_baby_food', $tableName . '.drink_baby_food = drink_baby_food.id', 'left');
        $this->db->join('tbl_lookup_details drink_tea_or_saline_in_vein', $tableName . '.drink_tea_or_saline_in_vein = drink_tea_or_saline_in_vein.id', 'left');
        $this->db->join('tbl_lookup_details drink_coffee', $tableName . '.drink_coffee = drink_coffee.id', 'left');
        $this->db->join('tbl_lookup_details drink_dont_know', $tableName . '.drink_dont_know = drink_dont_know.id', 'left');
        $this->db->join('tbl_lookup_details drink_other', $tableName . '.drink_other = drink_other.id', 'left');
        $this->db->join('tbl_lookup_details breastfeeding_still_now', $tableName . '.breastfeeding_still_now = breastfeeding_still_now.id', 'left');
        $this->db->join('tbl_lookup_details breastfeeding_how_many_month', $tableName . '.breastfeeding_how_many_month = breastfeeding_how_many_month.id', 'left');
        $this->db->join('tbl_lookup_details yesterday_day_night_just_water', $tableName . '.yesterday_day_night_just_water = yesterday_day_night_just_water.id', 'left');
        $this->db->join('tbl_lookup_details yesterday_day_night_juice', $tableName . '.yesterday_day_night_juice = yesterday_day_night_juice.id', 'left');
        $this->db->join('tbl_lookup_details yesterday_day_night_soup_fruit_juice', $tableName . '.yesterday_day_night_soup_fruit_juice = yesterday_day_night_soup_fruit_juice.id', 'left');
        $this->db->join('tbl_lookup_details yesterday_day_night_tin_milk_power_milk_cow_milk', $tableName . '.yesterday_day_night_tin_milk_power_milk_cow_milk = yesterday_day_night_tin_milk_power_milk_cow_milk.id', 'left');
        $this->db->join('tbl_lookup_details yesterday_day_night_baby_food', $tableName . '.yesterday_day_night_baby_food = yesterday_day_night_baby_food.id', 'left');
        $this->db->join('tbl_lookup_details yesterday_day_night_other', $tableName . '.yesterday_day_night_other = yesterday_day_night_other.id', 'left');
        $this->db->join('tbl_lookup_details yesterday_day_night_hard_half_hard_soft_food', $tableName . '.yesterday_day_night_hard_half_hard_soft_food = yesterday_day_night_hard_half_hard_soft_food.id', 'left');
        $this->db->join('tbl_lookup_details hard_half_hard_soft_food_since_how_many_month', $tableName . '.hard_half_hard_soft_food_since_how_many_month = hard_half_hard_soft_food_since_how_many_month.id', 'left');
        $this->db->join('tbl_lookup_details diarrhoea_happened', $tableName . '.diarrhoea_happened = diarrhoea_happened.id', 'left');
        $this->db->join('tbl_lookup_details diarrhoea_type', $tableName . '.diarrhoea_type = diarrhoea_type.id', 'left');
        $this->db->join('tbl_lookup_details diarrhoea_treatment_type', $tableName . '.diarrhoea_treatment_type = diarrhoea_treatment_type.id', 'left');
        $this->db->join('tbl_lookup_details diarrhoea_treatment_from', $tableName . '.diarrhoea_treatment_from = diarrhoea_treatment_from.id', 'left');
        $this->db->join('tbl_lookup_details pneumonia_symptom_no_symptom', $tableName . '.pneumonia_symptom_no_symptom = pneumonia_symptom_no_symptom.id', 'left');
        $this->db->join('tbl_lookup_details pneumonia_symptom_fever', $tableName . '.pneumonia_symptom_fever = pneumonia_symptom_fever.id', 'left');
        $this->db->join('tbl_lookup_details pneumonia_symptom_cold_cough', $tableName . '.pneumonia_symptom_cold_cough = pneumonia_symptom_cold_cough.id', 'left');
        $this->db->join('tbl_lookup_details pneumonia_symptom_breath_shortness_frequent_breathing', $tableName . '.pneumonia_symptom_breath_shortness_frequent_breathing = pneumonia_symptom_breath_shortness_frequent_breathing.id', 'left');
        $this->db->join('tbl_lookup_details pneumonia_symptom_chest_going_down', $tableName . '.pneumonia_symptom_chest_going_down = pneumonia_symptom_chest_going_down.id', 'left');
        $this->db->join('tbl_lookup_details antibiotic_for_pneumonia', $tableName . '.antibiotic_for_pneumonia = antibiotic_for_pneumonia.id', 'left');
        $this->db->join('tbl_lookup_details pneumonia_treatment_taken_from', $tableName . '.pneumonia_treatment_taken_from = pneumonia_treatment_taken_from.id', 'left');
        $this->db->join('tbl_lookup_details interview_status', $tableName . '.interview_status = interview_status.id', 'left');
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

    
    
    function data_via_table_view_child_illness($view_table) {
        $this->db->select(
                'DOB',
                'HHNO',
                'member_code',
                'breastfeeding_ever_code',
                'breastfeeding_after_how_many_time_after_birth_code',
                'breastfeeding_after_how_many_hour_after_birth',
                'breastfeeding_after_how_many_day_after_birth',
                'other_drink_except_breastfeeding_code',
                'drink_anything_else_except_breastfeeding_code',
                'drink_just_water_code',
                'drink_sugar_or_glucose_water_code',
                'drink_honey_code',
                'drink_pipe_water_code',
                'drink_sugar_or_salt_mixed_water_code',
                'drink_fruit_juice_code',
                'drink_baby_food_code',
                'drink_tea_or_saline_in_vein_code',
                'drink_coffee_code',
                'drink_dont_know_code',
                'drink_other_code',
                'drink_other_value',
                'breastfeeding_still_now_code',
                'breastfeeding_how_many_month_code',
                'breastfeeding_how_many_month_value',
                'yesterday_day_night_just_water_code',
                'yesterday_day_night_juice_code',
                'yesterday_day_night_soup_fruit_juice_code',
                'yesterday_day_night_tin_milk_power_milk_cow_milk_code',
                'yesterday_day_night_baby_food_code',
                'yesterday_day_night_other_code',
                'yesterday_day_night_other_value',
                'yesterday_day_night_hard_half_hard_soft_food_code',
                'hard_half_hard_soft_food_since_how_many_month_code',
                'hard_half_hard_soft_food_since_how_many_month_value',
                'diarrhoea_happened_code',
                'diarrhoea_happened_day_number',
                'diarrhoea_type_code',
                'diarrhoea_treatment_type_code',
                'diarrhoea_treatment_from_code',
                'diarrhoea_treatment_from_other_value',
                'diarrhoea_start_date',
                'pneumonia_symptom_no_symptom_code',
                'pneumonia_symptom_fever_code',
                'pneumonia_symptom_cold_cough_code',
                'pneumonia_symptom_breath_shortness_frequent_breathing_code',
                'pneumonia_symptom_chest_going_down_code',
                'antibiotic_for_pneumonia_code',
                'pneumonia_treatment_taken_from_code',
                'pneumonia_treatment_taken_from_other_value',
                'pneumonia_start_date',
                'interview_status_code',
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
