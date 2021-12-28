<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MemberRelation_model extends CI_Model
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
        $this->db->update('tbl_member_relation', $IDInfo);
        
        return TRUE;
    }

    function getRoundwiseRelation($household_master_id,$round_master_id)
    {
        $this->db->select('rel.id,rel.member_master_id, rel.household_master_id,mm.member_code, mm.member_name,mm.birth_date,
		en.name as relationName,household_master_id_hh');
        $this->db->from('tbl_member_relation  rel');
        $this->db->join('tbl_member_master mm','mm.id=rel.member_master_id','inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details en', 'en.id = rel.fk_relation', 'left');
        $this->db->where('rel.household_master_id', $household_master_id);
        $this->db->where('rel.round_master_id', $round_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->order_by('mm.member_code', 'asc');
        //$this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }


    function getRelationDetailsByIdnHousehold($id,$household_master_id,$round_master_id)
    {
        $this->db->select('rel.id, rel.household_master_id,rel.member_master_id,mm.member_code, rel.round_master_id,mm.member_name,
		mm.birth_date, roundNo,fk_relation');
        $this->db->from('tbl_member_relation  rel');
        $this->db->join('tbl_member_master mm','mm.id=rel.member_master_id','inner');
        $this->db->join('tbl_round_master rm','rm.id=rel.round_master_id','inner');
        $this->db->where('rel.household_master_id', $household_master_id);
        $this->db->where('rel.round_master_id', $round_master_id);
        $this->db->where('rel.id', $id);
        $this->db->order_by('mm.member_code', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }



    

  


  



    
    
    
 
}

  