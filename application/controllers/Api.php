<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Api extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
		$this->load->library('pagination');
		$this->load->model('master_model');
		$this->load->model('member_model');
        $this->isLoggedIn();
    }

     public function getUpaZila()
	 {
		  if($this->input->post('districtID'))
		  {
		   echo $this->master_model->getUpaZila($this->input->post('districtID'));
		  }
	 }
	 
	 public function getDistrict()
	 {
		  if($this->input->post('divisionID'))
		  {
		   echo $this->master_model->getDistrict($this->input->post('divisionID'));
		  }
	 }
	 
	 
	 public function getPrenancyListbyMother()
	 {
		  if($this->input->post('motherCode'))
		  {
		   echo $this->member_model->getPrenancyListbyMother($this->input->post('motherCode'),$this->getCurrentRound()[0]->id);
		  }
	 }
	 
	 
	 

	 public function getMigUpaZila()
	 {
		  if($this->input->post('migDistrictID'))
		  {
		   echo $this->master_model->getUpaZila($this->input->post('migDistrictID'));
		  }
	 }

	 

	 public function getSlum()
	 {
		  if($this->input->post('thanaID'))
		  {
		   echo $this->master_model->getSlum($this->input->post('thanaID'));
		  }
	 }

	 public function getSlumArea()
	 {
		  if($this->input->post('slumID'))
		  {
		   echo $this->master_model->getSlumArea($this->input->post('slumID'));
		  }
	 }


	  public function getHousehold()
	  {
		  if($this->input->post('slumAreaID'))
		  {
		   echo $this->master_model->getHousehold($this->input->post('slumAreaID'));
		  }
      }



      public function getHouseHoldBari()
	  {
		  if($this->input->post('barinumber'))
		  {
		   echo $this->master_model->getHouseholdBari($this->input->post('barinumber'), $this->input->post('slumAreaID'));
		  }
      }


      



    public function getBariNumber()
	 {
		  if($this->input->post('slumAreaID'))
		  {
		   echo $this->master_model->getBariNumber($this->input->post('slumAreaID'));
		  }
	 }
      

      public function getFather()
	  {
		  if($this->input->post('househodID'))
		  {
		   echo $this->member_model->getMemberMasterPresentListByHouseholdIdnSex($this->input->post('househodID'));
		  }
      }
      
      public function getMother()
	  {
		  if($this->input->post('househodID'))
		  {
		   echo $this->master_model->getHousehold($this->input->post('househodID'));
		  }
      }
    


	function get_autocomplete(){
        if (isset($_GET['term'])) {
            $result = $this->master_model->getAutocompleteHousehold($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->household_code.' - '. $row->household_head_name,
                    'house' => $row->household_code,
                    'value' => $row->id,
                );
                echo json_encode($arr_result);
            }
        }
    }
	
	function get_autocomplete_member(){
        if (isset($_GET['term'])) {
            $result = $this->member_model->getAutocompleteMember($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->member_code.' - '. $row->member_name.' - '. $row->household_code,
                    'house' => $row->member_code,
                    'member' => $row->member_name,
                    'value' => $row->id,
                );
                echo json_encode($arr_result);
            }
        }
    }


    function get_autocomplete_member_internal(){
        if (isset($_GET['term'])) {
            $result = $this->member_model->getAutocompleteMemberInternal($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->member_code.' - '. $row->member_name.' - '. $row->household_code,
                    'house' => $row->member_code,
                    'member' => $row->member_name,
                    'value' => $row->id,
                );
                echo json_encode($arr_result);
            }
        }
    }
	
	
	function get_autocomplete_member_in(){
        if (isset($_GET['term'])) {
            $result = $this->member_model->getAutocompleteMemberIn($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->member_code.' - '. $row->member_name,
                    'house' => $row->member_code,
                    'member' => $row->member_name,
                    'value' => $row->id,
                );
                echo json_encode($arr_result);
            }
        }
	}
	

public function conceptionCheck()
{
	
	$conceptionDate=$this->input->post('conceptionDate');
	$conceptionID=$this->input->post('conceptionID');
	
	$result=$this->member_model->checkuser($email);
	if($result)
	{
	echo  1;	
	}
	else
	{
	echo  0;	
	}
}	
	
	
	

}