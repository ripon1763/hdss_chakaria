<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Master_model extends CI_Model
{
	
	function lookupMasterList($tableName)
    {
        $this->db->select('id,name');
        $this->db->from($tableName);
		$this->db->where('active', 1);
        $query = $this->db->get();
        
        return $query->result();
    }
	
    function getListType($tableName)
    {
        $this->db->select('id, name,code');
        $this->db->from($tableName);
        $this->db->where('active', 1);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getDivisionList($tableName)
    {
        $this->db->select('id, name');
        $this->db->from($tableName);
        $this->db->where('active', 1);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getSlumList($tableName)
    {
        $this->db->select('id, name');
        $this->db->from($tableName);
        $this->db->where('active', 1);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getDistrictList($tableName)
    {
        $this->db->select('id, name');
        $this->db->from($tableName);
        $this->db->where('active', 1);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getSlumRoundList($tableName)
    {
        $this->db->select('roundID, slumID');
        $this->db->from($tableName);
        $query = $this->db->get();
        
        return $query->result();
    }
	

    function listingRound($tableName)
    {
        $this->db->select('id, roundNo, startDate, endDate, active, insertedOn, insertedBy, updatedOn, updatedBy');
        $this->db->from($tableName);
        $query = $this->db->get();
        
        return $query->result();
    }

	function listingdiv($tableName)
    {
        $this->db->select('id ,active, code,insertedOn, insertedBy,name');
        $this->db->from($tableName);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function listingdist($tableName)
    {
        $this->db->select('a.id ,a.active, a.code,a.insertedOn, a.insertedBy,a.name,a.divisionID, b.name as divisionName');
        $this->db->from($tableName. ' as a');
		$this->db->join('tbl_division b', 'b.id = a.divisionID', 'left');
        $query = $this->db->get();
        
        return $query->result();
    }
	
		
	function listingUpa($tableName)
    {
        $this->db->select('a.id ,a.active, a.code,a.insertedOn, a.insertedBy,a.name,a.districtID, b.name as districtName');
        $this->db->from($tableName. ' as a');
		$this->db->join('tbl_district b', 'b.id = a.districtID', 'left');
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function listingSlum($tableName)
    {
        $this->db->select('a.id ,a.active, a.code,a.insertedOn, a.insertedBy,a.name,a.thanaID, b.name as thanaName');
        $this->db->from($tableName. ' as a');
		$this->db->join('tbl_thana b', 'b.id = a.thanaID', 'left');
        $query = $this->db->get();
        
        return $query->result();
    }

    function listingSlumArea($tableName)
    {
        $this->db->select('a.id ,a.active, a.code,a.insertedOn, a.insertedBy,a.name,a.slumID, b.name as slumName');
        $this->db->from($tableName. ' as a');
        $this->db->join('tbl_slum b', 'b.id = a.slumID', 'left');
        $query = $this->db->get();
        
        return $query->result();
    }
    
	
	
	function listing($tableName)
    {
        $this->db->select('id,active, code,insertedOn, insertedBy,name,description');
        $this->db->from($tableName);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function listingDetails($tableName,$lookup_master_id)
    {
        $this->db->select('a.id, a.active, a.code, a.insertedOn, a.insertedBy, a.description, 
		a.name, a.display_order,a.internal_code, a.lookup_master_id, b.name as lookup_master_name');
        $this->db->from($tableName. ' as a');
		$this->db->join('tbl_lookup_master b', 'b.id = a.lookup_master_id', 'left');
		
		if ($lookup_master_id > 0)
		{
		     $this->db->where('b.ID', $lookup_master_id);
		}
		
        $query = $this->db->get();
        
        return $query->result();
    }
	

    
    function addNewList($IdInfo,$tableName)
    {
        $this->db->trans_start();
        $this->db->insert($tableName, $IdInfo);
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    function getListInfo($id,$tableName)
    {
        $this->db->select('id, active, code, insertedOn, insertedBy, description, name');
        $this->db->from($tableName);
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getRoundListInfo($id,$tableName)
    {
        $this->db->select('id, roundNo, startDate, endDate, active, insertedOn, insertedBy, updatedOn, updatedBy');
        $this->db->from($tableName);
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getListInfoDiv($id,$tableName)
    {
        $this->db->select('id, active, code, insertedOn, insertedBy, name');
        $this->db->from($tableName);
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getListInfoDist($id,$tableName)
    {
        $this->db->select('id, active, code, insertedOn, insertedBy, name,divisionID');
        $this->db->from($tableName);
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getListInfoUpa($id,$tableName)
    {
        $this->db->select('id, active, code, insertedOn, insertedBy, name,districtID');
        $this->db->from($tableName);
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }

    function getListInfoSlum($id,$tableName)
    {
        $this->db->select('id, active, code, insertedOn, insertedBy, name,thanaID');
        $this->db->from($tableName);
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getListInfoSlumArea($id,$tableName)
    {
        $this->db->select('id, active, code, insertedOn, insertedBy, name,slumID');
        $this->db->from($tableName);
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	
	function getListDetailsInfo($id,$tableName)
    {
        $this->db->select('id, active, code, description, display_order, internal_code, lookup_master_id, name');
        $this->db->from($tableName);
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	 
    function editList($IDInfo, $id,$tableName)
    {
        $this->db->where('id', $id);
        $this->db->update($tableName, $IDInfo);
        
        return TRUE;
    }


    function deleteSlumFromRound($roundID,$tableName)
    {
        
        $this->db->where('roundID', $roundID);
        $this->db->delete($tableName);
        
        return TRUE;
    }
   

	function getDistrict($divisionID)
     {
          $this->db->where('divisionID', $divisionID);
          $this->db->where('active',1);
     // $this->db->order_by('state_name', 'ASC');
          $query = $this->db->get('tbl_district');
          $output = '<option value="">--- Select District ---</option>';
          foreach($query->result() as $row)
          {
           $output .= '<option value="'.$row->id.'">'.$row->code .'-'. $row->name.'</option>';
          }
          return $output;
     }
         

    function getUpaZila($districtID)
     {
          $this->db->where('districtID', $districtID);
          $this->db->where('active',1);
          $query = $this->db->get('tbl_thana');
          $output = '<option value="">--- Select City area ---</option>';
          foreach($query->result() as $row)
          {
           $output .= '<option value="'.$row->id.'">'.$row->code .'-'. $row->name.'</option>';
          }
          return $output;
     }
        
        

    function getSlum($thanaID)
     {
          $this->db->where('thanaID', $thanaID);
          $this->db->where('active',1);
          $query = $this->db->get('tbl_slum');
          $output = '<option value="">--- Select Slum name---</option>';
          foreach($query->result() as $row)
          {
           $output .= '<option value="'.$row->id.'">'.$row->code .'-'.$row->name.'</option>';
          }
          return $output;
     }

     function getSlumArea($slumID)
     {
          $this->db->where('slumID', $slumID);
          $this->db->where('active',1);
          $query = $this->db->get('tbl_slum_area');
          $output = '<option value="">--- Select Slum Area ---</option>';
          foreach($query->result() as $row)
          {
           $output .= '<option value="'.$row->id.'">'.$row->code .'-'.$row->name.'</option>';
          }
          return $output;
     }


     


     function getBariNumber($slumAreaID)
     {
          $this->db->distinct('upper(barino),');
          $this->db->select('upper(barino) as barino, barino as barino_exact');
          $this->db->where('fk_slum_area_id', $slumAreaID);
          $query = $this->db->get('household_master');
          $output = '<option value="">--- Select Bari Number ---</option>';
          foreach($query->result() as $row)
          {
           $output .= '<option value="'.$row->barino.'">'.$row->barino.'</option>';
          }
          return $output;
     }

     function getHousehold($slumAreaID)
     {
          $this->db->where('fk_slum_area_id', $slumAreaID);
          $query = $this->db->get('household_master');
          $output = '<option value="">--- Select Household ---</option>';
          foreach($query->result() as $row)
          {
           $output .= '<option value="'.$row->id.'">'.$row->household_code .'-'.$row->household_head_name.'</option>';
          }
          return $output;
     }


     
     function getHouseholdBari($barinumber,$slumAreaID)
     {
          $this->db->where('fk_slum_area_id', $slumAreaID);
          $this->db->where('upper(barino)', $barinumber);
          $query = $this->db->get('household_master');
          $output = '<option value="">--- Select Household ---</option>';
          foreach($query->result() as $row)
          {
           $output .= '<option value="'.$row->id.'">'.$row->household_code .'-'.$row->household_head_name.'</option>';
          }
          return $output;
     }

     



    function getLookUpList($lookup_master_code)
    {
        $this->db->select('a.id, a.code, a.name');
        $this->db->from('tbl_lookup_details as a');
        $this->db->join('tbl_lookup_master b', 'b.id = a.lookup_master_id', 'inner');
        $this->db->where('b.code', $lookup_master_code);
        $this->db->where('a.active', 1);
        $this->db->order_by('a.display_order', 'asc');
       
        $query = $this->db->get();
        return $query->result();
    }

    function getLookUpListSpecific($lookup_master_code,$array)
    {
        $this->db->select('a.id, a.code, a.name');
        $this->db->from('tbl_lookup_details as a');
        $this->db->join('tbl_lookup_master b', 'b.id = a.lookup_master_id', 'inner');
        $this->db->where('b.code', $lookup_master_code);
        $this->db->where_in('a.code', $array);
        $this->db->where('a.active', 1);
        $this->db->order_by('a.display_order', 'asc');
       
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getLookUpListNotSpecific($lookup_master_code,$array)
    {
        $this->db->select('a.id, a.code, a.name');
        $this->db->from('tbl_lookup_details as a');
        $this->db->join('tbl_lookup_master b', 'b.id = a.lookup_master_id', 'inner');
        $this->db->where('b.code', $lookup_master_code);
        $this->db->where_not_in('a.code', $array);
        $this->db->where('a.active', 1);
        $this->db->order_by('a.display_order', 'asc');
       
        $query = $this->db->get();
        
        return $query->result();
    }

    function getSlumListNew()
    {
        $this->db->select('id, code,name');
        $this->db->from('tbl_slum');
        $this->db->where('active',1);
        $query = $this->db->get();
        
         return $query->result();
    }


    


    function getAutocompleteHousehold($search)
    {

     
       $this->db->select('id, household_code, household_head_name');
       $this->db->where("household_code like '%".$search."%' ");

       $records = $this->db->get('household_master')->result();

     return $records;
    }




    
    
    


 
}

  