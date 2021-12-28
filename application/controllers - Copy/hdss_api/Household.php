<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Household extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
	
	public function index_get($slumAreaID = 0)
	{
        if(!empty($slumAreaID)){
			

            $data = $this->db->select('id,household_code,household_head_name as head_name')->get_where("household_master", ['fk_slum_area_id' => $slumAreaID])->result_array();
			
			
        }else{
            $data = array();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}

      
    	
}