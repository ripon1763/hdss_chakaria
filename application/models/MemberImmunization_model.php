<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MemberImmunization_model extends CI_Model
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
        $this->db->update('tbl_member_immunization', $IDInfo);
        
        return TRUE;
    }

    function getRoundwiseImmunization($household_master_id,$round_master_id)
    {
        $this->db->select('det.id,det.member_master_id, det.household_master_id,CH1.name as CH1_name,mm.member_code, mm.member_name,mm.birth_date,household_master_id_hh');
        $this->db->from('tbl_member_immunization  det');
        $this->db->join('tbl_member_master mm','mm.id=det.member_master_id','inner');
        $this->db->join('tbl_lookup_details CH1','CH1.id=det.CH1','inner');
        $this->db->where('det.household_master_id', $household_master_id);
        $this->db->where('det.round_master_id', $round_master_id);
        $this->db->order_by('mm.member_code', 'asc');
        //$this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getImmunizationDetailsByIdnHousehold($id,$household_master_id,$round_master_id)
    {
        $this->db->select('det.*,mm.member_code,mm.member_name,mm.birth_date,mm.fk_followup_exit_type,mm.followup_exit_date,mm.folowup_exit_round');
        $this->db->from('tbl_member_immunization  det');
        $this->db->join('tbl_member_master mm','mm.id=det.member_master_id','inner');
        $this->db->join('tbl_round_master rm','rm.id=det.round_master_id','inner');
        $this->db->where('det.household_master_id', $household_master_id);
        $this->db->where('det.round_master_id', $round_master_id);
        $this->db->where('det.id', $id);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get();
        
        return $query->row();
    }



    

  


  



    
    
    
 
}

  