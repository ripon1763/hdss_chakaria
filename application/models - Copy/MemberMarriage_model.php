<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MemberMarriage_model extends CI_Model
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
        $this->db->update('tbl_member_marriage_start', $IDInfo);
        
        return TRUE;
    }
	
	function editEnd($IDInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_member_marriage_end', $IDInfo);
        
        return TRUE;
    }

    function getRoundwiseMarriageStart($household_master_id,$round_master_id)
    {
        $this->db->select('mar.id,mar.member_master_id, mar.household_master_id,mm.member_code, mm.member_name,mm.birth_date,fk_marital_status,en.code as marriageCode,
		en.name as maritalStatus,household_master_id_hh, marriage_date,mm.spouse_code,current_indenttification_id');
        $this->db->from('tbl_member_marriage_start  mar');
        $this->db->join('tbl_member_master mm','mm.id=mar.member_master_id','inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details en', 'en.id = mm.fk_marital_status', 'left');
        $this->db->where('mar.household_master_id', $household_master_id);
        $this->db->where('mar.round_master_id', $round_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->order_by('mm.member_code', 'asc');
        //$this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }



    function getMarriageStartDetailsByIdnHousehold($id,$household_master_id,$round_master_id)
    {
        $this->db->select('mar.id, mar.household_master_id,mar.member_master_id,mm.member_code, mar.round_master_id,mm.member_name,mm.birth_date, roundNo,
		marriage_date, fk_bri_gem_premarital_status, fk_bri_gem_marital_order, fk_kazi_registered, fk_member_premarital_status, 
		fk_member_marital_order,member_master_id_bride_groom, is_event, remarks,mm.fk_sex,en.code as sexCode,en.name as sexName,mm.spouse_code, sp.member_name as spauseName');
        $this->db->from('tbl_member_marriage_start  mar');
        $this->db->join('tbl_member_master mm','mm.id=mar.member_master_id','inner');
        $this->db->join('tbl_member_master sp','sp.id=mm.fk_spouse_id','left');
        $this->db->join('tbl_round_master rm','rm.id=mar.round_master_id','inner');
		$this->db->join('tbl_lookup_details en', 'en.id = mm.fk_sex', 'left');
        $this->db->where('mar.household_master_id', $household_master_id);
        $this->db->where('mar.round_master_id', $round_master_id);
        $this->db->where('mar.id', $id);
        $this->db->order_by('mm.member_code', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	
	function getRoundwiseMarriageEnd($household_master_id,$round_master_id)
    {
        $this->db->select('mar.id,mar.member_master_id, mar.household_master_id,mm.member_code, mm.member_name,mm.birth_date,fk_marital_status,en.code as marriageCode,
		en.name as maritalStatus,household_master_id_hh, marriage_end_date,mm.spouse_code,current_indenttification_id');
        $this->db->from('tbl_member_marriage_end mar');
        $this->db->join('tbl_member_master mm','mm.id=mar.member_master_id','inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details en', 'en.id = mar.fk_marriage_end_type', 'left');
        $this->db->where('mar.household_master_id', $household_master_id);
        $this->db->where('mar.round_master_id', $round_master_id);
        $this->db->order_by('mm.member_code', 'asc');
        //$this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getMarriageEndDetailsByIdnHousehold($id,$household_master_id,$round_master_id)
    {
        $this->db->select('mar.id, mar.household_master_id,mar.member_master_id,mm.member_code, mar.round_master_id,mm.member_name,mm.birth_date, roundNo,
		 marriage_end_date, fk_marriage_end_cause_one, fk_marriage_end_cause_two, fk_marriage_end_cause_three, fk_marriage_end_type, 
		 member_master_id_bride_groom, is_event, remarks,mm.fk_sex,en.code as sexCode,en.name as sexName,sp.member_code as spauseCode, sp.member_name as spauseName');
        $this->db->from('tbl_member_marriage_end  mar');
        $this->db->join('tbl_member_master mm','mm.id=mar.member_master_id','inner');
        $this->db->join('tbl_member_master sp','sp.id=mar.member_master_id_bride_groom','left');
        $this->db->join('tbl_round_master rm','rm.id=mar.round_master_id','inner');
		$this->db->join('tbl_lookup_details en', 'en.id = mm.fk_sex', 'left');
        $this->db->where('mar.household_master_id', $household_master_id);
        $this->db->where('mar.round_master_id', $round_master_id);
        $this->db->where('mar.id', $id);
        $this->db->order_by('mm.member_code', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }



    

  


  



    
    
    
 
}

  