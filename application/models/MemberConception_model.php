<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MemberConception_model extends CI_Model
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
        $this->db->update('tbl_member_conception', $IDInfo);
        
        return TRUE;
    }

    function getRoundwiseConception($household_master_id,$round_master_id)
    {
        $this->db->select('consp.id,consp.member_master_id, consp.household_master_id,mm.member_code, mm.member_name,mm.birth_date,household_master_id_hh,conception_date,order.name as conceptionOrder');
        $this->db->from('tbl_member_conception  consp');
        $this->db->join('tbl_member_master mm','mm.id=consp.member_master_id','inner');
        $this->db->join('tbl_lookup_details order','order.id=consp.fk_conception_order','inner');
        $this->db->where('consp.household_master_id', $household_master_id);
        $this->db->where('consp.round_master_id', $round_master_id);
        $this->db->order_by('mm.member_code', 'asc');
        //$this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getConceptionDetailsByIdnHousehold($id,$household_master_id,$round_master_id)
    {
        $this->db->select('consp.id, consp.household_master_id,consp.member_master_id,mm.member_code, consp.round_master_id,mm.member_name,
		mm.birth_date, roundNo, conception_date, fk_conception_order, fk_conception_plan, fk_conception_followup_status');
        $this->db->from('tbl_member_conception  consp');
        $this->db->join('tbl_member_master mm','mm.id=consp.member_master_id','inner');
        $this->db->join('tbl_round_master rm','rm.id=consp.round_master_id','inner');
        $this->db->where('consp.household_master_id', $household_master_id);
        $this->db->where('consp.round_master_id', $round_master_id);
        $this->db->where('consp.id', $id);
        $this->db->order_by('mm.member_code', 'asc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }


    function getmemberConception($member_master_id)
    {
        $this->db->select('consp.id,consp.member_master_id, consp.household_master_id,mm.member_code, 
        mm.member_name,mm.birth_date,household_master_id_hh,conception_date,order.code as conceptionOrderCode,
        order.name as conceptionOrder,household_code,result.code as conceptionresultCode,
        result.name as conceptionresult');
        $this->db->from('tbl_member_conception  consp');
        $this->db->join('tbl_member_master mm','mm.id=consp.member_master_id','inner');
        $this->db->join('household_master hm','hm.id=consp.household_master_id','inner');
        $this->db->join('tbl_lookup_details order','order.id=consp.fk_conception_order','left');
        $this->db->join('tbl_lookup_details result','result.id=consp.fk_conception_result','left');
        $this->db->where('consp.member_master_id', $member_master_id);
        $this->db->order_by('consp.id', 'desc');
        $query = $this->db->get();
        
        return $query->result();
    }
	
	
	
	
	



    

  


  



    
    
    
 
}

  