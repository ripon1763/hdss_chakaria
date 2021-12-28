<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MemberMigration_model extends CI_Model
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
        $this->db->update('tbl_member_migration_in', $IDInfo);
        
        return TRUE;
    }
	
	function editMigrationOut($IDInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_member_migration_out', $IDInfo);
        
        return TRUE;
    }


    function editMigrationIn($IDInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_member_migration_in', $IDInfo);
        
        return TRUE;
    }

    function getRoundwiseMarriageStart($household_master_id,$round_master_id)
    {
        $this->db->select('mar.id,mar.member_master_id, mar.household_master_id,mm.member_code, mm.member_name,mm.birth_date,fk_marital_status,en.code as marriageCode,
		en.name as maritalStatus,household_master_id_hh, marriage_date,mm.spouse_code');
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
	
	
	function getRoundwiseMigrationOut($household_master_id,$round_master_id)
    {
        $this->db->select('mar.id,mar.member_master_id, mar.household_master_id,mm.member_code, mm.member_name,
		mm.birth_date,household_master_id_hh, mar.movement_date,mar.fk_movement_type, en.code as moveTypeCode, en.name as moveTypeName,current_indenttification_id');
        $this->db->from('tbl_member_migration_out mar');
        $this->db->join('tbl_member_master mm','mm.id=mar.member_master_id','inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details en', 'en.id = mar.fk_movement_type', 'left');
        $this->db->where('mar.household_master_id', $household_master_id);
        $this->db->where('mar.round_master_id', $round_master_id);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get();
        
        return $query->result();
    }


    function getRoundwiseMigrationIn($household_master_id,$round_master_id)
    {
        $this->db->select('mar.id,mar.member_master_id, mar.household_master_id,mm.member_code, mm.member_name,
        mm.birth_date,household_master_id_hh, mar.movement_date,mar.fk_movement_type, en.code as moveTypeCode, en.name as moveTypeName,current_indenttification_id');
        $this->db->from('tbl_member_migration_in mar');
        $this->db->join('tbl_member_master mm','mm.id=mar.member_master_id','inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details en', 'en.id = mar.fk_movement_type', 'left');
        $this->db->where('mar.household_master_id', $household_master_id);
        $this->db->where('mar.round_master_id', $round_master_id);
      //  $this->db->where('mar.fk_movement_type', $fk_movement_type);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getMigrationOutDetailsByIdnHousehold($id,$household_master_id,$round_master_id)
    {
        $this->db->select('mar.id, mar.household_master_id,mar.member_master_id,mm.member_code, mar.round_master_id,mm.member_name,mm.birth_date, roundNo,mm.fk_sex,en.code as sexCode,en.name as sexName, movement_date,fk_movement_type, fk_internal_cause, slumIDTo, slumAreaIDTo, household_master_id_move_to, fk_type_of_group, fk_outside_cause_individual, fk_outside_cause_group, countryIDMoveTo, divisionIDMoveTo, districtIDMoveTo, thanaIDMoveTo, remarks');
        $this->db->from('tbl_member_migration_out  mar');
        $this->db->join('tbl_member_master mm','mm.id=mar.member_master_id','inner');
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


    function getMigrationInDetailsByIdnHousehold($id,$household_master_id,$round_master_id)
    {
        $this->db->select('mar.id, mar.household_master_id,mar.member_master_id,mm.member_code, mar.round_master_id,mm.member_name,mm.birth_date, roundNo,mm.fk_sex,en.code as sexCode,en.name as sexName, movement_date,fk_movement_type, fk_internal_cause, slumIDFrom, slumAreaIDFrom,household_master_id_move_from, fk_migration_cause, countryIDMoveFrom, divisionIDMoveFrom, districtIDMoveFrom,thanaIDMoveFrom,remarks');
        $this->db->from('tbl_member_migration_in  mar');
        $this->db->join('tbl_member_master mm','mm.id=mar.member_master_id','inner');
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

  