<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pregnancy_model extends CI_Model {

    function listing($tableName,$round_master_id) {
        $this->db->select('a.id,a.still_birth,a.pregnancy_outcome_date, a.household_master_id, a.member_master_id, a.round_master_id,
		member_code,member_name, birth_date, household_code');
        $this->db->from($tableName . ' as a');
        $this->db->join('tbl_member_master as m', 'm.id= a.member_master_id');
        $this->db->join('household_master as h', 'h.id= a.household_master_id');
        $this->db->where('a.still_birth >',0);
        $this->db->where('a.round_master_id', $round_master_id);
        $query = $this->db->get();

        return $query->result();
    }
	
	
	function get_member_info($tableName,$member_id) 
	{
        $this->db->select('a.ID,a.still_birth,a.pregnancy_outcome_date, a.household_master_id, a.member_master_id, a.round_master_id,
		member_code,member_name, birth_date, household_code');
        $this->db->from($tableName . ' as a');
        $this->db->join('tbl_member_master as m', 'm.id= a.member_master_id');
        $this->db->join('household_master as h', 'h.id= a.household_master_id');
        $this->db->where('a.ID', $member_id);
        $query = $this->db->get();

        return $query->row();
    }
	
    
    function InsertInfo($IDInfo, $table) {
        //return $this->db->insert($table, $IDInfo);
		
		$this->db->trans_start();
        $this->db->insert($table, $IDInfo);
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
		
		
		
    }
    
    function getLookUpList($lookup_master_code)
    {
        $this->db->select('a.ID as id, a.CODE as code, a.NAME as name');
        $this->db->from('lookup_details_va as a');
        $this->db->join('lookup_master_va b', 'b.ID = a.LOOKUP_MASTER_ID', 'inner');
        $this->db->where('b.CODE', $lookup_master_code);
        $this->db->where('a.ACTIVE', 'Yes');
        $this->db->order_by('a.DISPLAY_ORDER', 'asc');
       
        $query = $this->db->get();
		
        return $query->result();
    }
	
	function getRoundListList()
    {
        $this->db->select('ID as id, roundNo as round_no');
        $this->db->from('tbl_round_master');
        $this->db->order_by('ID', 'desc');
       
        $query = $this->db->get();
		
        return $query->result();
    }

}
