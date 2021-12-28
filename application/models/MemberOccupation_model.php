<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MemberOccupation_model extends CI_Model
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
        $this->db->update('tbl_member_occupation', $IDInfo);
        
        return TRUE;
    }

    function getRoundwiseOccupation($household_master_id,$round_master_id)
    {
        $this->db->select('occu.id,fk_main_occupation, occu.member_master_id, occu.household_master_id,mm.member_code, mm.member_name,mm.birth_date,en.name as occupationName,household_master_id_hh,main_occupation_oth');
        $this->db->from('tbl_member_occupation  occu');
        $this->db->join('tbl_member_master mm','mm.id=occu.member_master_id','inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details en', 'en.id = occu.fk_main_occupation', 'left');
        $this->db->where('occu.household_master_id', $household_master_id);
        $this->db->where('occu.round_master_id', $round_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->order_by('mm.member_code', 'asc');
        //$this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }



    function getOccupationDetailsByIdnHousehold($id,$household_master_id,$round_master_id)
    {
        $this->db->select('occu.id, occu.household_master_id,occu.member_master_id,mm.member_code, occu.round_master_id,mm.member_name,mm.birth_date, roundNo,fk_main_occupation,main_occupation_oth');
        $this->db->from('tbl_member_occupation  occu');
        $this->db->join('tbl_member_master mm','mm.id=occu.member_master_id','inner');
        $this->db->join('tbl_round_master rm','rm.id=occu.round_master_id','inner');
        $this->db->where('occu.household_master_id', $household_master_id);
        $this->db->where('occu.round_master_id', $round_master_id);
        $this->db->where('occu.id', $id);
        $this->db->order_by('mm.member_code', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }



    

  


  



    
    
    
 
}

  