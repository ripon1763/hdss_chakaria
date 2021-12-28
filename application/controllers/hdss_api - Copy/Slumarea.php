<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Slumarea extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
	
	public function index_get($slumID = 0)
	{
        if(!empty($slumID)){
			

            $data = $this->db->select('id,code,name')->get_where("tbl_slum_area", ['slumID' => $slumID,'active'=> 1])->result_array();
			
			
        }else{
            $data = array();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}
      
    	
}