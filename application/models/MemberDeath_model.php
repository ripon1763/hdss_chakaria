<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MemberDeath_model extends CI_Model
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
        $this->db->update('tbl_member_death', $IDInfo);
        
        return TRUE;
    }

    function getRoundwiseDeath($household_master_id,$round_master_id)
    {
        $this->db->select('det.id,det.member_master_id, det.household_master_id,mm.member_code, mm.member_name,mm.birth_date,household_master_id_hh,death_date');
        $this->db->from('tbl_member_death  det');
        $this->db->join('tbl_member_master mm','mm.id=det.member_master_id','inner');
        $this->db->where('det.household_master_id', $household_master_id);
        $this->db->where('det.round_master_id', $round_master_id);
        $this->db->order_by('mm.member_code', 'asc');
        //$this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getDeathDetailsByIdnHousehold($id,$household_master_id,$round_master_id)
    {
        $this->db->select('det.id, det.household_master_id,det.member_master_id,mm.member_code, det.round_master_id,mm.member_name,
		mm.birth_date, roundNo,death_date, death_time, fk_death_cause, fk_death_place, fk_death_type, fk_death_confirmby');
        $this->db->from('tbl_member_death  det');
        $this->db->join('tbl_member_master mm','mm.id=det.member_master_id','inner');
        $this->db->join('tbl_round_master rm','rm.id=det.round_master_id','inner');
        $this->db->where('det.household_master_id', $household_master_id);
        $this->db->where('det.round_master_id', $round_master_id);
        $this->db->where('det.id', $id);
        $this->db->order_by('mm.member_code', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }



    

  


  



    
    
    
 
}

  