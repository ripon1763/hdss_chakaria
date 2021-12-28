<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MemberEducation_model extends CI_Model
{
	
    function addNew($IdInfo,$tableName)
    {
        $this->db->trans_start();
        $this->db->insert($tableName, $IdInfo);
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function edit($IdInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_member_education', $IdInfo);

        //echo $this->db->last_query();
        
        return TRUE;
    }

    function getRoundwiseEducation($household_master_id,$round_master_id)
    {
        $this->db->select('edu.id, edu.fk_education_type, edu.year_of_education, edu.household_master_id,edu.member_master_id,mm.member_code, mm.member_name,mm.birth_date,en.name as eduType');
        $this->db->from('tbl_member_education  edu');
        $this->db->join('tbl_member_master mm','mm.id=edu.member_master_id','inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details en', 'en.id = edu.fk_education_type', 'left');
        $this->db->where('edu.household_master_id', $household_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->where('edu.round_master_id', $round_master_id);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get();
        
        return $query->result();
    }

    function getEducationDetailsByIdnHousehold($id,$household_master_id,$round_master_id)
    {
        $this->db->select('edu.id, edu.fk_religious_edu, edu.fk_secular_edu, edu.household_master_id,edu.member_master_id,mm.member_code, fk_education_type, year_of_education,edu.round_master_id,mm.member_name,mm.birth_date,roundNo');
        $this->db->from('tbl_member_education  edu');
        $this->db->join('tbl_member_master mm','mm.id=edu.member_master_id','inner');
        $this->db->join('tbl_round_master rm','rm.id=edu.round_master_id','inner');
        $this->db->where('edu.household_master_id', $household_master_id);
        $this->db->where('edu.round_master_id', $round_master_id);
        $this->db->where('edu.id', $id);
        $this->db->order_by('mm.member_code', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }




    

  


  



    
    
    
 
}

  