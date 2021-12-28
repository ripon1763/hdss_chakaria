<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Upazilla extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
	
	public function index_get($districtID = 0)
	{
        if(!empty($districtID)){
			

            $data = $this->db->select('id,code,name')->get_where("tbl_thana", ['districtID' => $districtID,'active'=> 1])->result_array();
			
			
        }else{
            $data = array();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}
      
    	
}