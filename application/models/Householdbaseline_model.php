<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Householdbaseline_model extends CI_Model {

    function addNew($IdInfo, $tableName) {
        $this->db->trans_start();
        $this->db->insert($tableName, $IdInfo);
        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }
    
    function getCurrentRound() {
        $this->db->select('*');
        $this->db->from('tbl_round_master');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->row();
    }

    function edit($IDInfo, $id, $tableName) {
        $this->db->where('id', $id);
        $this->db->update($tableName, $IDInfo);

        return TRUE;
    }

    function getHouseholdbaselineHistory($tableName, $household_master_id) {
        $this->db->select('a.id,roundNo, household_master_id,tbl_division.name as division_name,a.upazilla_name');
        $this->db->from($tableName . ' as a');

        $this->db->join('tbl_round_master as r', 'a.round_master_id = r.id', 'left');
        $this->db->join('tbl_division', 'a.division_id = tbl_division.id', 'left');
        $this->db->where('a.household_master_id', $household_master_id);
        $this->db->order_by('a.id', 'asc');
        $query = $this->db->get();

        return $query->result();
    }

    function getBaselineDetails($tableName,$id) {
        $this->db->select('*');
        $this->db->from($tableName);
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    function all_round_info($table_name) {
        $this->db->from($table_name);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function all_baseline_census_info($round_no, $tableName,$list_fields) {
        $this->db->select($tableName . '.id,'
                . 'household_master.household_code,'
                . $tableName . '.upazilla_name,'
                . 'tbl_division.code as division_code,'
                . 'looking_for_work,'
                . 'for_earning_more_money,'
                . 'river_erosion,'
                . 'for_family,'
                . 'for_children_education,'
                . 'for_own_education,'
                . 'for_marriage,'
                . 'na_as_birth_here,'
                . 'coming_reason_other,'
                . $tableName . '.coming_reason_other_specify,'
                . 'pregnancy_status.code as pregnancy_status_code,'
                . 'FORMAT(' . $tableName . ".pregnancy_status_since_when,'dd/MM/yyyy') as pregnancy_status_since_when,"
                . 'roof.code as roof_code,'
                . $tableName . '.roof_other,'
                . 'wall.code as wall_code,'
                . $tableName . '.wall_other,'
                . 'floor.code as floor_code,'
                . $tableName . '.room,'
                . $tableName . '.room1l,'
                . $tableName . '.room1b,'
                . $tableName . '.room2l,'
                . $tableName . '.room2b,'
                . $tableName . '.room3l,'
                . $tableName . '.room3b,'
                . $tableName . '.Q42A,'
                . $tableName . '.Q42B,'
                . 'water.code as water_code,'
                . 'winside.code as winside_code,'
                . $tableName . '.wcol_time,'
                . $tableName . '.wait_time,'
                . 'wat_coll.code as wat_coll_code,'
                . $tableName . '.watcoloth,'
                . 'wshare.code as wshare_code,'
                . $tableName . '.wsharef,'
                . 'wat_supp.code as wat_supp_code,'
                . $tableName . '.w_suppoth,'
                . 'w_safe.code as w_safe_code,'
                . 'w_suff.code as w_suff_code,'
                . 'toilet.code as toilet_code,'
                . 'toilet_ct.code as toilet_ct_code,'
                . $tableName . '.toilet_ct_ot,'
                . 'toilte_mf.code as toilte_mf_code,'
                . 'tmf_usep.code as tmf_usep_code,'
                . 'toilet_cl.code as toilet_cl_code,'
                . $tableName . '.toilet_coth,'
                . 'toilet_dis.code as toilet_dis_code,'
                . $tableName . '.toilet_dot,'
                . 'tinside.code as tinside_code,'
                . 'tshare.code as tshare_code,'
                . $tableName . '.tsharef,'
                . 'light.code as light_code,'
                 . $tableName . '.light_oth,'
                . 'Q61.code as Q61_code,'
                . 'Q62.code as Q62_code,'
                . $tableName . '.Q62oth,'
                . 'Q63.code as Q63_code,'
                . $tableName . '.Q63oth,'
                . 'Q65A.code as Q65A_code,'
                . 'Q65B.code as Q65B_code,'
                . 'Q65C.code as Q65C_code,'
                . 'Q65D.code as Q65D_code,'
                . 'Q65E.code as Q65E_code,'
                . 'Q65F.code as Q65F_code,'
                . 'cook.code as cook_code,'
                . $tableName . '.cookoth,'
                . 'cinside.code as cinside_code,'
                . 'cshare.code as cshare_code,'
                . $tableName . '.csharef,'
                . 'garbage.code as garbage_code,'
                . $tableName . '.garbageoth,'
                . 'gcollect.code as gcollect_code,'
                . 'voterid.code as voterid_code,'
                . $tableName . '.resp_ind,'
                . $tableName . '.imobile,'
                . $tableName . '.remarks,'
                
                . 'fk_owner_land.code as fk_owner_land_code,'
                . 'fk_owner_house.code as fk_owner_house_code,'
                . 'fk_chair.code as fk_chair_code,'
                . 'fk_dining_table.code as fk_dining_table_code,'
                . 'fk_khat.code as fk_khat_code,'
                . 'fk_chowki.code as fk_chowki_code,'
                . 'fk_almirah.code as fk_almirah_code,'
                . 'fk_sofa.code as fk_sofa_code,'
                . 'fk_radio.code as fk_radio_code,'
                . 'fk_tv.code as fk_tv_code,'
                . 'fk_freeze.code as fk_freeze_code,'
                . 'fk_mobile.code as fk_mobile_code,'
                . 'fk_electric_fan.code as fk_electric_fan_code,'
                . 'fk_hand_watch.code as fk_hand_watch_code,'
                . 'fk_rickshow.code as fk_rickshow_code,'
                . 'fk_computer.code as fk_computer_code,'
                . 'fk_sewing_machine.code as fk_sewing_machine_code,'
                . 'fk_cycle.code as fk_cycle_code,'
                . 'fk_motor_cycle.code as fk_motor_cycle_code'
                . ',FORMAT(' . $tableName . ".insertedOn,'dd/MM/yyyy') as insertedDate"
                . ",FORMAT(" . $tableName . ".insertedOn,'HH:mm:ss') as insertedTime"
                . ',insertedBy.name as insertedBy_name'
                . ",FORMAT(" . $tableName . ".updatedOn,'dd/MM/yyyy') as updatedDate"
                . ",FORMAT(" . $tableName . ".updatedOn,'HH:mm:ss') as updatedTime"
                . ',updateBy.name as updateBy_name'
        );
        $this->db->from($tableName);

        $this->db->join('tbl_household_assets', $tableName . '.household_master_id =tbl_household_assets.household_master_id and ' . $tableName . '.round_master_id =tbl_household_assets.round_master_id and tbl_household_assets.baseline=1', 'left');
        $this->db->join('household_master', $tableName . '.household_master_id = household_master.id', 'left');
        $this->db->join('tbl_division', $tableName . '.division_id = tbl_division.id', 'left');
        $this->db->join('tbl_lookup_details as pregnancy_status', $tableName . '.pregnancy_status = pregnancy_status.id', 'left');
        $this->db->join('tbl_lookup_details as roof', $tableName . '.roof = roof.id', 'left');
        $this->db->join('tbl_lookup_details as wall', $tableName . '.wall = wall.id', 'left');
        $this->db->join('tbl_lookup_details as floor', $tableName . '.floor = floor.id', 'left');
        $this->db->join('tbl_lookup_details as water', $tableName . '.water = water.id', 'left');
        $this->db->join('tbl_lookup_details as winside', $tableName . '.winside = winside.id', 'left');
        $this->db->join('tbl_lookup_details as wat_coll', $tableName . '.wat_coll = wat_coll.id', 'left');
        $this->db->join('tbl_lookup_details as wshare', $tableName . '.wshare = wshare.id', 'left');
        $this->db->join('tbl_lookup_details as wat_supp', $tableName . '.wat_supp = wat_supp.id', 'left');
        $this->db->join('tbl_lookup_details as w_safe', $tableName . '.w_safe = w_safe.id', 'left');
        $this->db->join('tbl_lookup_details as w_suff', $tableName . '.w_safe = w_suff.id', 'left');
        $this->db->join('tbl_lookup_details as toilet', $tableName . '.toilet = toilet.id', 'left');
        $this->db->join('tbl_lookup_details as toilet_ct', $tableName . '.toilet_ct = toilet_ct.id', 'left');
        $this->db->join('tbl_lookup_details as toilte_mf', $tableName . '.toilte_mf = toilte_mf.id', 'left');
        $this->db->join('tbl_lookup_details as tmf_usep', $tableName . '.tmf_usep = tmf_usep.id', 'left');
        $this->db->join('tbl_lookup_details as toilet_cl', $tableName . '.toilet_cl = toilet_cl.id', 'left');
        $this->db->join('tbl_lookup_details as toilet_dis', $tableName . '.toilet_dis = toilet_dis.id', 'left');
        $this->db->join('tbl_lookup_details as tinside', $tableName . '.tinside = tinside.id', 'left');
        $this->db->join('tbl_lookup_details as tshare', $tableName . '.tshare = tshare.id', 'left');
        $this->db->join('tbl_lookup_details as light', $tableName . '.light = light.id', 'left');
        $this->db->join('tbl_lookup_details as Q61', $tableName . '.Q61 = Q61.id', 'left');
        $this->db->join('tbl_lookup_details as Q62', $tableName . '.Q62 = Q62.id', 'left');
        $this->db->join('tbl_lookup_details as Q63', $tableName . '.Q63 = Q63.id', 'left');
        $this->db->join('tbl_lookup_details as Q65A', $tableName . '.Q65A = Q65A.id', 'left');
        $this->db->join('tbl_lookup_details as Q65B', $tableName . '.Q65B = Q65B.id', 'left');
        $this->db->join('tbl_lookup_details as Q65C', $tableName . '.Q65C = Q65C.id', 'left');
        $this->db->join('tbl_lookup_details as Q65D', $tableName . '.Q65D = Q65D.id', 'left');
        $this->db->join('tbl_lookup_details as Q65E', $tableName . '.Q65E = Q65E.id', 'left');
        $this->db->join('tbl_lookup_details as Q65F', $tableName . '.Q65F = Q65F.id', 'left');
        $this->db->join('tbl_lookup_details as cook', $tableName . '.cook = cook.id', 'left');
        $this->db->join('tbl_lookup_details as cinside', $tableName . '.cinside = cinside.id', 'left');
        $this->db->join('tbl_lookup_details as cshare', $tableName . '.cshare = cshare.id', 'left');
        $this->db->join('tbl_lookup_details as garbage', $tableName . '.garbage = garbage.id', 'left');
        $this->db->join('tbl_lookup_details as gcollect', $tableName . '.gcollect = gcollect.id', 'left');
        $this->db->join('tbl_lookup_details as voterid', $tableName . '.voterid = voterid.id', 'left');

        $this->db->join('tbl_users as insertedBy', 'insertedBy.userId=' . $tableName . '.insertedBy', 'left');
        $this->db->join('tbl_users as updateBy', 'updateBy.userId=' . $tableName . '.updateBy', 'left');

        $this->db->join('tbl_lookup_details as fk_owner_land', 'tbl_household_assets.fk_owner_land = fk_owner_land.id', 'left');
        $this->db->join('tbl_lookup_details as fk_owner_house', 'tbl_household_assets.fk_owner_house = fk_owner_house.id', 'left');
        $this->db->join('tbl_lookup_details as fk_chair', 'tbl_household_assets.fk_chair = fk_chair.id', 'left');
        $this->db->join('tbl_lookup_details as fk_dining_table', 'tbl_household_assets.fk_dining_table = fk_dining_table.id', 'left');
        $this->db->join('tbl_lookup_details as fk_khat', 'tbl_household_assets.fk_khat = fk_khat.id', 'left');
        $this->db->join('tbl_lookup_details as fk_chowki', 'tbl_household_assets.fk_chowki = fk_chowki.id', 'left');
        $this->db->join('tbl_lookup_details as fk_almirah', 'tbl_household_assets.fk_almirah = fk_almirah.id', 'left');
        $this->db->join('tbl_lookup_details as fk_sofa', 'tbl_household_assets.fk_sofa = fk_sofa.id', 'left');
        $this->db->join('tbl_lookup_details as fk_radio', 'tbl_household_assets.fk_radio = fk_radio.id', 'left');
        $this->db->join('tbl_lookup_details as fk_tv', 'tbl_household_assets.fk_tv = fk_tv.id', 'left');
        $this->db->join('tbl_lookup_details as fk_freeze', 'tbl_household_assets.fk_freeze = fk_freeze.id', 'left');
        $this->db->join('tbl_lookup_details as fk_mobile', 'tbl_household_assets.fk_mobile = fk_mobile.id', 'left');
        $this->db->join('tbl_lookup_details as fk_electric_fan', 'tbl_household_assets.fk_electric_fan = fk_electric_fan.id', 'left');
        $this->db->join('tbl_lookup_details as fk_hand_watch', 'tbl_household_assets.fk_hand_watch = fk_hand_watch.id', 'left');
        $this->db->join('tbl_lookup_details as fk_rickshow', 'tbl_household_assets.fk_rickshow = fk_rickshow.id', 'left');
        $this->db->join('tbl_lookup_details as fk_computer', 'tbl_household_assets.fk_computer = fk_computer.id', 'left');
        $this->db->join('tbl_lookup_details as fk_sewing_machine', 'tbl_household_assets.fk_sewing_machine = fk_sewing_machine.id', 'left');
        $this->db->join('tbl_lookup_details as fk_cycle', 'tbl_household_assets.fk_cycle = fk_cycle.id', 'left');
        $this->db->join('tbl_lookup_details as fk_motor_cycle', 'tbl_household_assets.fk_motor_cycle = fk_motor_cycle.id', 'left');


        if ($round_no > 0) {
            $this->db->where($tableName . '.round_master_id', $round_no);
        }
        $this->db->order_by($tableName . '.id', 'DESC');
        $query = $this->db->get();
        if($list_fields==0) return $query->result(); 
        if($list_fields==1) return $query->list_fields();
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
	
	function getMemberMasterPresentListByHouseholdIds($household_master_id)
    {


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

}
