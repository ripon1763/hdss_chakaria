<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Country extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
	
	public function index_get($request = null)
	{
        $data = array();
		if ($request == 'all')
		{
          $data = $this->db->select('id,code,name,active,insertedBy,insertedOn')->get_where("tbl_country")->result_array();
		}
		
		if (!empty($data))
		{
			
			$data = $data;
		
        }else{
            $data = array();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}
      
    	
}