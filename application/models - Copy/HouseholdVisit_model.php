<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class HouseholdVisit_model extends CI_Model
{
	
    function listingHousehold($tableName,$districtID, $thanaID, $slumID,$slumAreaID)
    {
        $this->db->select('a.id, a.contact_number, a.fk_district_id, a.fk_thana_id, a.fk_slum_id, a.fk_slum_area_id, a.barino, 
		a.bariwalla_name, a.household_code, a.household_head_name, a.longlivy, a.longlivm, a.leftpad, a.fk_entry_type, 
		a.entry_date, a.round_master_id_entry_round, a.fk_migration_reason, a.migration_reason_oth, a.fk_country_id_from, 
		a.fk_district_id_from, a.fk_thana_id_from, a.fk_extinct_type, a.extinct_date, a.round_master_id_extinct_round, 
		a.fk_contract_type, a.member_master_id_last_head, a.transfer_complete, a.insertedBy, a.insertedOn, a.updateBy, a.updatedOn');
        $this->db->from($tableName. ' as a');
        $this->db->join('tbl_district d', 'd.id = a.fk_district_id', 'left');
        $this->db->join('tbl_slum s', 's.id = a.fk_slum_id', 'left');
        $this->db->join('tbl_thana t', 't.id = a.fk_thana_id', 'left');
        $this->db->join('tbl_slum_area sa', 'sa.id = a.fk_slum_area_id', 'left');
        $this->db->join('tbl_lookup_details en', 'en.id = a.fk_entry_type', 'left');
        $this->db->join('tbl_lookup_details mr', 'mr.id = a.fk_migration_reason', 'left');
        $this->db->join('tbl_country c', 'c.id = a.fk_country_id_from', 'left');
        $this->db->join('tbl_district dt', 'dt.id = a.fk_district_id_from', 'left');
        $this->db->join('tbl_thana tt', 'tt.id = a.fk_thana_id_from', 'left');
        $this->db->join('tbl_lookup_details ex', 'ex.id = a.fk_extinct_type', 'left');
        $this->db->join('tbl_lookup_details ct', 'ct.id = a.fk_contract_type', 'left');

        if ($districtID > 0 && $thanaID > 0 && $slumID > 0)
        {
            $this->db->where('a.fk_district_id', $districtID);
            $this->db->where('a.fk_thana_id', $thanaID);
            $this->db->where('a.fk_slum_id', $slumID);

            if ($slumAreaID > 0)
            {
                 $this->db->where('a.fk_slum_area_id', $slumAreaID);
            }

        }

     
        

        $query = $this->db->get();
        
        return $query->result();
    }

    function getListInfo($id,$tableName)
    {
        $this->db->select('id, contact_number, fk_district_id, fk_thana_id, fk_slum_id, fk_slum_area_id, barino, bariwalla_name, household_code, household_head_name, longlivy, longlivm, leftpad, fk_entry_type, entry_date, round_master_id_entry_round, fk_migration_reason, migration_reason_oth, fk_country_id_from, fk_district_id_from, fk_thana_id_from, fk_extinct_type, extinct_date, round_master_id_extinct_round, fk_contract_type, fk_family_type, fk_study_design, location_id, location_split_id, member_master_id_last_head, transfer_complete, insertedBy, insertedOn, updateBy, updatedOn');
        $this->db->from($tableName);
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getHouseholdVisitDet($tableName,$household_master_id,$round_master_id)
    {
        $this->db->select('a.id, a.interview_date, a.any_birth, a.any_concepton, a.any_death,a.any_pregnancy, a.any_hosp, a.any_vaccin, a.any_marriage_start, a.any_marriage_end, a.any_migration_in, a.any_migration_out, a.household_master_id, a.round_master_id, a.household_master_id_merge, a.fk_interview_status, a.fk_interviewer, a.fk_responded_type, a.respondent_code, a.is_household_split, a.is_household_merge, a.split_date, a.no_of_new_household, a.merge_date, a.any_asset, a.any_education, a.any_occupation, a.any_relation, a.transfer_complete, a.insertedBy, a.insertedOn, a.updateBy, a.updatedOn,hm.household_code,hm.contact_number,a.remarks');
        $this->db->from($tableName. ' as a');
        $this->db->join('household_master hm','hm.id=a.household_master_id','inner');
        $this->db->where('a.household_master_id', $household_master_id);
        $this->db->where('a.round_master_id', $round_master_id);
        $this->db->order_by('a.id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        
        return $query->result();
    }

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

   

    

  


  



    
    
    
 
}

  