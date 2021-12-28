<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends CI_Model
{
	
    function listingMember($tableName,$districtID, $thanaID, $slumID,$slumAreaID,$household_id)
    {
        $this->db->select('a.id, a.birth_date, a.member_name, a.member_code, a.fk_marital_status, a.fk_sex, a.fk_religion, a.fk_relation_with_hhh, a.fk_father_id, a.fk_mother_id, a.fk_spouse_id, a.father_code, a.mother_code, a.spouse_code, a.household_master_id_hh, a.member_household_id_last,  a.fk_education_id_last, a.fk_occupation_id_last, a.fk_member_relation_id_last, a.fk_mother_live_birth_order, a.national_id, a.fk_birth_registration, a.birth_registration_date, a.fk_why_not_birth_registration, a.fk_additionalChild, a.afterYear, a.transfer_complete, a.insertedBy, a.insertedOn, a.updateBy, a.updatedOn,hm.fk_extinct_type,hm.household_code,current_indenttification_id');
        $this->db->from($tableName. ' as a');
        $this->db->join('household_master hm', 'hm.id = a.household_master_id_hh', 'left');
        $this->db->join('tbl_member_household mh', 'mh.id = a.member_household_id_last', 'left');

        $this->db->join('tbl_district d', 'd.id = hm.fk_district_id', 'left');
        $this->db->join('tbl_slum s', 's.id = hm.fk_slum_id', 'left');
        $this->db->join('tbl_thana t', 't.id = hm.fk_thana_id', 'left');
        $this->db->join('tbl_slum_area sa', 'sa.id = hm.fk_slum_area_id', 'left');
        $this->db->join('tbl_lookup_details en', 'en.id = mh.fk_entry_type', 'left');
		    $this->db->where('mh.fk_exit_type', 0);
        

        if ($districtID > 0 && $thanaID > 0 && $slumID > 0)
        {
            $this->db->where('hm.fk_district_id', $districtID);
            $this->db->where('hm.fk_thana_id', $thanaID);
            $this->db->where('hm.fk_slum_id', $slumID);

            if ($slumAreaID > 0)
            {
                 $this->db->where('hm.fk_slum_area_id', $slumAreaID);
            }

            if ($household_id > 0)
            {
                 $this->db->where('hm.id', $household_id);
            }

        }

     
        

        $query = $this->db->get();
        
        return $query->result();
    }


    function getListInfo($id,$tableName)
    {
        $this->db->select('a.id, a.birth_date, a.member_name, a.member_code, a.fk_marital_status, a.fk_sex, 
		a.fk_religion, a.fk_relation_with_hhh, a.fk_father_id, a.fk_mother_id, a.fk_spouse_id, 
		a.father_code, a.mother_code, a.spouse_code, a.household_master_id_hh, a.member_household_id_last,  
		a.fk_education_id_last, a.fk_occupation_id_last, a.fk_member_relation_id_last, a.fk_mother_live_birth_order, 
		a.national_id, a.fk_birth_registration, a.birth_registration_date, a.fk_why_not_birth_registration, 
		a.fk_additionalChild, a.afterYear, a.transfer_complete, a.insertedBy, a.insertedOn, a.updateBy, 
		a.updatedOn,hm.fk_extinct_type,hm.household_code, hm.fk_district_id, hm.fk_thana_id, hm.fk_slum_id,hh.change_date, 
		hm.fk_slum_area_id,mh.fk_entry_type,mh.entry_date, fk_religious_edu,fk_secular_edu,fk_education_type,
		year_of_education,fk_main_occupation,main_occupation_oth,en.code as entryTypeCode, en.name as entryTypeName,
		sex.code as sexCode, sex.name as sexName,sp.member_name as spouseName,a.contactNoTwo,a.contactNoTwo,a.contactNoOne');
        $this->db->from($tableName. ' as a');
        $this->db->join('household_master hm', 'hm.id = a.household_master_id_hh', 'left');
        $this->db->join('tbl_member_household mh', 'mh.id = a.member_household_id_last', 'left');
        $this->db->join('tbl_household_head hh', 'hh.household_master_id = a.household_master_id_hh and hh.member_master_id=a.id', 'left');
        $this->db->join('tbl_member_education edu', 'edu.id = a.fk_education_id_last', 'left');
        $this->db->join('tbl_member_occupation ocu', 'ocu.id = a.fk_occupation_id_last', 'left');
        $this->db->join('tbl_member_relation rel', 'rel.id = a.fk_member_relation_id_last', 'left');
        $this->db->join('tbl_member_master sp', 'sp.id = a.fk_spouse_id', 'left');
        $this->db->join('tbl_lookup_details en', 'en.id = mh.fk_entry_type', 'left');
        $this->db->join('tbl_lookup_details sex', 'sex.id = a.fk_sex', 'left');

        $this->db->where('a.id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }



    function getAutocompleteMember($search)
    {

     
       $this->db->select('m.id, m.member_code, m.member_name,hm.household_code');
       $this->db->from('tbl_member_master m');
       $this->db->join('household_master hm','hm.id=m.household_master_id_hh','inner');
       $this->db->join('tbl_member_household mh','mh.id= m.member_household_id_last','inner');
       $this->db->where("m.member_code like '%".$search."%' ");
       $this->db->or_where("m.member_name like '%".$search."%' ");
       $this->db->where_not_in("mh.household_master_id",0);
       $this->db->where("m.is_died",0);
       //$this->db->where_not_in("mh.fk_exit_type",78);

       $records = $this->db->get()->result();

     return $records;
    }


    function getAutocompleteMemberInternal($search)
    {

     
       $this->db->select('m.id, m.member_code, m.member_name,hm.household_code');
       $this->db->from('tbl_member_master m');
       $this->db->join('household_master hm','hm.id=m.household_master_id_hh','inner');
       $this->db->join('tbl_member_household mh','mh.id= m.member_household_id_last','inner');
       $this->db->where("mh.fk_exit_type",135);
       $this->db->where("m.member_code like '%".$search."%' ");
       $this->db->or_where("m.member_name like '%".$search."%' ");
       //$this->db->where_not_in("mh.household_master_id",0);
       $this->db->where("m.is_died",0);
       $this->db->where_not_in("mh.fk_exit_type",0);

       $records = $this->db->get()->result();

     return $records;
    }



    function getAutocompleteMemberIn($search)
    {

     
       $this->db->select('m.id, m.member_code, m.member_name');
       $this->db->from('tbl_member_master m');
       $this->db->join('tbl_member_household mh','mh.id= m.member_household_id_last','inner');
       $this->db->where("mh.household_master_id",0);
       //$this->db->or_where("m.is_died",0);
       $this->db->or_where("mh.fk_exit_type",79);
       $this->db->or_where("m.member_name like '%".$search."%' ");
       $this->db->where("m.member_code like '%".$search."%' ");

       $records = $this->db->get()->result();

     return $records;
    }


    

    function getPrenancyListbyMother($member_master_id,$round_master_id)
     {
          $this->db->where('member_master_id', $member_master_id);
          $this->db->where('live_birth >', 0);
          $this->db->where('round_master_id',$round_master_id);
          $query = $this->db->get('tbl_member_pregnancy');
          $output = '<option value="">--- Select date ---</option>';
          foreach($query->result() as $row)
          {
           $output .= '<option value="'.$row->id.'">'. date('j F Y', strtotime($row->pregnancy_outcome_date)).'</option>';
          }
          return $output;
     }

    

    
    function getMemberMasterPresentListByHouseholdIds($household_master_id)
    {


        $this->db->select('mm.id,member_code,member_name, birth_date,mar.name as marriageName, mar.code as marriageCode,rel.name as relationHead,mm.household_master_id_hh,mh.current_indenttification_id');
        $this->db->from('tbl_member_master mm');
        $this->db->join('household_master hm', 'hm.id = mm.household_master_id_hh', 'inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details mar', 'mar.id = mm.fk_marital_status', 'left');
        $this->db->join('tbl_lookup_details rel', 'rel.id = mm.fk_relation_with_hhh', 'left');
        $this->db->where('mh.household_master_id', $household_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get()->result();
        
         return $query;
    }



    // function getMemberMasterPreviousListByHouseholdIds($household_master_id,$round_master_id)
    // {


    //     $this->db->select('mm.id,member_code,member_name, birth_date,mar.name as marriageName, mar.code as marriageCode,rel.name as relationHead,mm.household_master_id_hh,mh.exit_date,fk_exit_type,ext.code as exitTypeCode, ext.name as exitTypeName,,mh.current_indenttification_id');
    //     $this->db->from('tbl_member_master mm');
    //     $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
    //     $this->db->join('household_master hm', 'hm.id = mh.household_master_id', 'inner');
    //     $this->db->join('tbl_lookup_details mar', 'mar.id = mm.fk_marital_status', 'left');
    //     $this->db->join('tbl_lookup_details rel', 'rel.id = mm.fk_relation_with_hhh', 'left');
    //     $this->db->join('tbl_lookup_details ext', 'ext.id = mh.fk_exit_type', 'left');
    //     $this->db->where('mh.household_master_id', $household_master_id);
    //     $this->db->where('mh.round_master_id_exit_round >', 0);
    //     $this->db->where('mh.round_master_id_exit_round', $round_master_id);
    //     $this->db->order_by('mm.member_code', 'asc');
    //     $query = $this->db->get()->result();

    //     // $this->db->last_query();
        
    //      return $query;
    // }


    function getMemberMasterPreviousListByHouseholdIds($household_master_id,$round_master_id)
    {


        $this->db->select('mm.id,member_code,member_name, birth_date,mar.name as marriageName, mar.code as marriageCode,rel.name as relationHead,mm.household_master_id_hh,mh.exit_date,fk_exit_type,ext.code as exitTypeCode, ext.name as exitTypeName,mh.current_indenttification_id');
        $this->db->from('tbl_member_household mh');
        $this->db->join('tbl_member_master mm','mm.id = mh.member_master_id', 'left');
        $this->db->join('household_master hm', 'hm.id = mh.household_master_id', 'left');
        $this->db->join('tbl_lookup_details mar', 'mar.id = mm.fk_marital_status', 'left');
        $this->db->join('tbl_lookup_details rel', 'rel.id = mm.fk_relation_with_hhh', 'left');
        $this->db->join('tbl_lookup_details ext', 'ext.id = mh.fk_exit_type', 'left');
        $this->db->where('mh.household_master_id', $household_master_id);
        $this->db->where('mh.round_master_id_exit_round >', 0);
        $this->db->where('mh.round_master_id_exit_round', $round_master_id);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get()->result();

        //echo $this->db->last_query();
        
         return $query;
    }



    function getMemberMasterPresentListByHouseholdIdsnAge($household_master_id)
    {


        $this->db->select('mm.id,member_code,member_name, birth_date,mar.name as marriageName, mar.code as marriageCode,rel.name as relationHead,mm.household_master_id_hh,current_indenttification_id');
        $this->db->from('tbl_member_master mm');
        $this->db->join('household_master hm', 'hm.id = mm.household_master_id_hh', 'inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details mar', 'mar.id = mm.fk_marital_status', 'left');
        $this->db->join('tbl_lookup_details rel', 'rel.id = mm.fk_relation_with_hhh', 'left');
        $this->db->where('mm.household_master_id_hh', $household_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->where('(DATEDIFF(DAY, birth_date, GetDate()) / 365) >= 15');
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get()->result();
        
         return $query;
    }


    function getMemberMasterFemalePresentListByHouseholdIds($household_master_id,$femaleSexCode)
    {


        $this->db->select('mm.id,member_code,member_name, birth_date,mar.name as marriageName, mar.code as marriageCode,rel.name as relationHead,mm.household_master_id_hh,current_indenttification_id');
        $this->db->from('tbl_member_master mm');
        $this->db->join('household_master hm', 'hm.id = mm.household_master_id_hh', 'inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details mar', 'mar.id = mm.fk_marital_status', 'left');
        $this->db->join('tbl_lookup_details rel', 'rel.id = mm.fk_relation_with_hhh', 'left');
        $this->db->where('mm.household_master_id_hh', $household_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->where('mm.fk_sex', $femaleSexCode);
        $this->db->where('(DATEDIFF(DAY, birth_date, GetDate()) / 365) >= 15');
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get()->result();
        
         return $query;
    }


    function getMemberMasterFemaleConceptionListByHouseholdIds($household_master_id,$femaleSexCode,$conceptionFollowpID)
    {
        $this->db->select('consp.id, consp.household_master_id,consp.member_master_id,mm.member_code, consp.round_master_id,mm.member_name,
        mm.birth_date, roundNo, conception_date, fk_conception_order, fk_conception_plan, fk_conception_followup_status,mar.name as marriageName, mar.code as marriageCode,mm.household_master_id_hh,order.name as conceptOrder,current_indenttification_id');
        $this->db->from('tbl_member_conception  consp');
        $this->db->join('tbl_member_master mm','mm.id=consp.member_master_id','inner');
        $this->db->join('tbl_round_master rm','rm.id=consp.round_master_id','inner');
        $this->db->join('household_master hm', 'hm.id = mm.household_master_id_hh', 'inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details mar', 'mar.id = mm.fk_marital_status', 'left');
        $this->db->join('tbl_lookup_details order', 'order.id = consp.fk_conception_order', 'left');
        $this->db->where('mm.household_master_id_hh', $household_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->where('mm.fk_sex', $femaleSexCode);
        $this->db->where('consp.fk_conception_followup_status', $conceptionFollowpID);
        $this->db->where('(DATEDIFF(DAY, birth_date, GetDate()) / 365) >= 15');
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get();
        
        return $query->result();
    }

    function getMemberBirthListByHouseholdIdAndRoundId($household_master_id,$round_master_id)
    {


        $this->db->select('mm.id,member_code,member_name, birth_date,mar.name as marriageName, mar.code as marriageCode,rel.name as relationHead,mm.household_master_id_hh');
        $this->db->from('tbl_member_master mm');
        $this->db->join('household_master hm', 'hm.id = mm.household_master_id_hh', 'inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details mar', 'mar.id = mm.fk_marital_status', 'left');
        $this->db->join('tbl_lookup_details rel', 'rel.id = mm.fk_relation_with_hhh', 'left');
        $this->db->where('mh.household_master_id', $household_master_id);
        $this->db->where('mh.round_master_id_entry_round', $round_master_id);
        $this->db->where('mh.fk_entry_type', 21);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get()->result();
        
         return $query;
    }

    function getMemberDetailsByIdnHousehold($id,$household_master_id)
    {
        $this->db->select('a.id, a.birth_date, a.member_name, a.member_code, a.fk_marital_status, a.fk_sex, a.fk_religion, a.fk_relation_with_hhh, a.fk_father_id, a.fk_mother_id, a.fk_spouse_id, a.father_code, a.mother_code, a.spouse_code, a.household_master_id_hh, a.member_household_id_last,  a.fk_education_id_last, a.fk_occupation_id_last, a.fk_member_relation_id_last, a.fk_mother_live_birth_order, a.national_id, a.fk_birth_registration, a.birth_registration_date, a.fk_why_not_birth_registration, a.fk_additionalChild, a.afterYear, a.transfer_complete, a.insertedBy, a.insertedOn, a.updateBy, a.updatedOn,hm.fk_extinct_type,hm.household_code, hm.fk_district_id, hm.fk_thana_id, hm.fk_slum_id,hh.change_date, hm.fk_slum_area_id,mh.fk_entry_type,mh.entry_date, fk_religious_edu,fk_secular_edu,fk_education_type,year_of_education,fk_main_occupation,en.code as entryTypeCode, en.name as entryTypeName,a.birth_time,a.birth_weight, a.fk_birth_weight_size, a.keep_follow_up,pregnancy_outcome_id,fk_pnc_chkup_child_id,pnc_chkup_child_times,fk_pnc_first_visit_id,pnc_first_visit_days,fk_pnc_second_visit_id,pnc_second_visit_days');
        $this->db->from('tbl_member_master as a');
        $this->db->join('household_master hm', 'hm.id = a.household_master_id_hh', 'left');
        $this->db->join('tbl_member_household mh', 'mh.id = a.member_household_id_last', 'left');
        $this->db->join('tbl_household_head hh', 'hh.household_master_id = a.household_master_id_hh and hh.member_master_id=a.id', 'left');

        $this->db->join('tbl_member_education edu', 'edu.id = a.fk_education_id_last', 'left');
        $this->db->join('tbl_member_occupation ocu', 'ocu.id = a.fk_occupation_id_last', 'left');
        $this->db->join('tbl_member_relation rel', 'rel.id = a.fk_member_relation_id_last', 'left');
        $this->db->join('tbl_lookup_details en', 'en.id = mh.fk_entry_type', 'left');

        $this->db->where('a.id', $id);
        $this->db->where('a.household_master_id_hh', $household_master_id);
        $query = $this->db->get();
        
        return $query->result();
    }


    function getMemberMasterPresentMarriedListByHouseholdIds($household_master_id,$matiatlStatusCode)
    {


        $this->db->select('mm.id,member_code,member_name, birth_date,mar.name as marriageName, mar.code as marriageCode,rel.name as relationHead,mm.household_master_id_hh,current_indenttification_id');
        $this->db->from('tbl_member_master mm');
        $this->db->join('household_master hm', 'hm.id = mm.household_master_id_hh', 'inner');
        $this->db->join('tbl_member_household mh', 'mh.id = mm.member_household_id_last', 'inner');
        $this->db->join('tbl_lookup_details mar', 'mar.id = mm.fk_marital_status', 'left');
        $this->db->join('tbl_lookup_details rel', 'rel.id = mm.fk_relation_with_hhh', 'left');
        $this->db->where('mm.household_master_id_hh', $household_master_id);
        $this->db->where('mh.round_master_id_exit_round', 0);
        $this->db->where('mm.fk_marital_status', $matiatlStatusCode);
        $this->db->order_by('mm.member_code', 'asc');
        $query = $this->db->get()->result();
        
         return $query;
    }

    
    
    
 
}

  