<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Householdasset_model extends CI_Model
{
	
    function addNew($IdInfo,$tableName)
    {
        $this->db->trans_start();
        $this->db->insert($tableName, $IdInfo);
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function edit($IDInfo, $id,$tableName)
    {
        $this->db->where('id', $id);
        $this->db->update($tableName, $IDInfo);
        
        return TRUE;
    }


    function getHouseholdAssetHistory($tableName,$household_master_id)
    {
        $this->db->select('a.id,roundNo, household_master_id, lan.name as ownerland_name, h.name as ownerhouse_name');
        $this->db->from($tableName .' as a');

        $this->db->join('tbl_round_master as r','a.round_master_id = r.id','left');
        $this->db->join('tbl_lookup_details as lan','a.fk_owner_land = lan.id','left');
        $this->db->join('tbl_lookup_details as h','a.fk_owner_house = h.id','left');
        $this->db->where('a.household_master_id', $household_master_id);
        $this->db->order_by('a.id', 'asc');
        $query = $this->db->get();
        
        return $query->result();
    }

    function getAssetDetails($tableName,$household_master_id,$id)
    {
        $this->db->select('id, household_master_id, round_master_id, fk_owner_land, fk_owner_house, fk_chair, fk_dining_table, fk_khat, fk_chowki, fk_almirah, fk_sofa, fk_radio, fk_tv, fk_freeze, fk_mobile, fk_electric_fan, fk_hand_watch, fk_rickshow, fk_computer, fk_sewing_machine, fk_cycle, fk_motor_cycle, transfer_complete, insertedBy, insertedOn, updateBy, updatedOn');
        $this->db->from($tableName);
        $this->db->where('household_master_id', $household_master_id);
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }


    


    
    
    
 
}

  